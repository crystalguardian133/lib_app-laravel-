/**
 * Christmas Effects JavaScript
 * Creates festive holiday animations and decorations for the webpage
 */

class ChristmasEffects {
    constructor() {
        this.isActive = false;
        this.snowflakes = [];
        this.lights = [];
        this.music = null;
        this.elements = new Set();

        // Christmas configuration
        this.config = {
            snowflakeCount: 50,
            lightCount: 20,
            snowSpeed: 2,
            lightBlinkSpeed: 1000,
            musicVolume: 0.3,
            colors: {
                primary: '#dc2626',    // Christmas red
                secondary: '#16a34a',  // Christmas green
                accent: '#fbbf24',     // Christmas gold
                snow: '#ffffff',
                lights: ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff']
            }
        };

        this.init();
    }

    init() {
        // Check if Christmas effects should be active
        this.checkAutoActivate();
        this.loadPreference();

        // Set up event listeners
        this.setupEventListeners();

        // Apply effects if active
        if (this.isActive) {
            this.startChristmasEffects();
        }
    }

    checkAutoActivate() {
        // Auto-activate during Christmas season (December)
        const now = new Date();
        const month = now.getMonth() + 1; // getMonth() returns 0-11
        const day = now.getDate();

        // Auto-activate from Dec 1st to Jan 6th (Epiphany)
        if ((month === 12) || (month === 1 && day <= 6)) {
            // Only auto-activate if no preference is set
            if (!localStorage.getItem('christmasEffects')) {
                this.isActive = true;
                localStorage.setItem('christmasEffects', 'true');
            }
        }
    }

    loadPreference() {
        const saved = localStorage.getItem('christmasEffects');
        if (saved !== null) {
            this.isActive = saved === 'true';
        }
    }

    savePreference() {
        localStorage.setItem('christmasEffects', this.isActive.toString());
    }

    setupEventListeners() {
        // Listen for toggle events
        document.addEventListener('christmas-toggle', (e) => {
            this.toggle(e.detail?.silent || false);
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (this.isActive) {
                this.updateDimensions();
            }
        });

        // Handle user interaction for music playback
        document.addEventListener('click', () => {
            if (this.isActive && this.music && this.music.paused) {
                this.music.play().catch(e => console.log('Could not play music after user interaction:', e));
            }
        }, { once: true }); // Only listen once
    }

    toggle(silent = false) {
        this.isActive = !this.isActive;

        if (this.isActive) {
            this.startChristmasEffects();
        } else {
            this.stopChristmasEffects();
        }

        this.savePreference();

        if (!silent) {
            this.showToggleNotification();
        }

        // Dispatch event for other components
        document.dispatchEvent(new CustomEvent('christmas-state-changed', {
            detail: { active: this.isActive }
        }));
    }

    startChristmasEffects() {
        if (this.isActive) return; // Already active

        this.isActive = true;

        // Start all effect systems
        this.createSnowEffect();
        this.createLightEffect();
        this.createDecorationEffect();
        this.applyColorTheme();
        this.addSantaHats();
        this.startMusic();

        console.log('🎄 Christmas effects started!');
    }

    stopChristmasEffects() {
        if (!this.isActive) return; // Already inactive

        this.isActive = false;

        // Stop all effect systems
        this.removeSnowEffect();
        this.removeLightEffect();
        this.removeDecorationEffect();
        this.removeColorTheme();
        this.removeSantaHats();
        this.stopMusic();

        console.log('❌ Christmas effects stopped!');
    }

    // Snow Effect System
    createSnowEffect() {
        const container = document.createElement('div');
        container.id = 'christmas-snow-container';
        container.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 999;
            overflow: hidden;
        `;
        document.body.appendChild(container);

        this.createSnowflakes();
        this.animateSnowflakes();
    }

    createSnowflakes() {
        const container = document.getElementById('christmas-snow-container');
        if (!container) return;

        container.innerHTML = '';

        for (let i = 0; i < this.config.snowflakeCount; i++) {
            const snowflake = document.createElement('div');
            snowflake.className = 'christmas-snowflake';
            snowflake.style.cssText = `
                position: absolute;
                color: ${this.config.colors.snow};
                font-size: ${Math.random() * 10 + 10}px;
                opacity: ${Math.random() * 0.8 + 0.2};
                user-select: none;
                z-index: 1000;
            `;
            snowflake.textContent = '❄';
            snowflake.style.left = Math.random() * 100 + '%';
            snowflake.style.top = -20 + 'px';

            container.appendChild(snowflake);
            this.snowflakes.push(snowflake);
        }
    }

    animateSnowflakes() {
        const animate = () => {
            if (!this.isActive) return;

            this.snowflakes.forEach((snowflake, index) => {
                const top = parseFloat(snowflake.style.top) || -20;
                const left = parseFloat(snowflake.style.left) || Math.random() * window.innerWidth;

                snowflake.style.top = top + this.config.snowSpeed + 'px';
                snowflake.style.left = left + Math.sin(index * 0.1) * 0.5 + 'px';

                // Reset snowflake when it goes off screen
                if (top > window.innerHeight) {
                    snowflake.style.top = -20 + 'px';
                    snowflake.style.left = Math.random() * 100 + '%';
                }
            });

            requestAnimationFrame(animate);
        };

        animate();
    }

    removeSnowEffect() {
        const container = document.getElementById('christmas-snow-container');
        if (container) {
            container.remove();
        }
        this.snowflakes = [];
    }

    // Christmas Lights Effect
    createLightEffect() {
        const container = document.createElement('div');
        container.id = 'christmas-lights-container';
        container.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 998;
            overflow: hidden;
        `;
        document.body.appendChild(container);

        this.createLights();
        this.animateLights();
    }

    createLights() {
        const container = document.getElementById('christmas-lights-container');
        if (!container) return;

        container.innerHTML = '';

        for (let i = 0; i < this.config.lightCount; i++) {
            const light = document.createElement('div');
            light.className = 'christmas-light';
            light.style.cssText = `
                position: absolute;
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: ${this.config.colors.lights[i % this.config.colors.lights.length]};
                box-shadow: 0 0 10px ${this.config.colors.lights[i % this.config.colors.lights.length]};
                opacity: 0.8;
                z-index: 999;
            `;

            // Position lights around the screen edges
            const positions = [
                { top: '5px', left: `${(i / this.config.lightCount) * 100}%` }, // Top
                { bottom: '5px', left: `${(i / this.config.lightCount) * 100}%` }, // Bottom
                { top: `${(i / this.config.lightCount) * 100}%`, left: '5px' }, // Left
                { top: `${(i / this.config.lightCount) * 100}%`, right: '5px' } // Right
            ];

            const pos = positions[i % positions.length];
            Object.assign(light.style, pos);

            container.appendChild(light);
            this.lights.push(light);
        }
    }

    animateLights() {
        let blinkState = 0;

        const animate = () => {
            if (!this.isActive) return;

            blinkState++;

            this.lights.forEach((light, index) => {
                const shouldBlink = Math.sin(blinkState * 0.1 + index) > 0.5;
                light.style.opacity = shouldBlink ? '0.9' : '0.3';
                light.style.transform = `scale(${shouldBlink ? 1.2 : 1})`;
            });

            setTimeout(animate, this.config.lightBlinkSpeed);
        };

        animate();
    }

    removeLightEffect() {
        const container = document.getElementById('christmas-lights-container');
        if (container) {
            container.remove();
        }
        this.lights = [];
    }

    // Decoration Effects
    createDecorationEffect() {
        this.addChristmasTree();
        this.addGarlands();
        this.addOrnaments();
    }

    addChristmasTree() {
        const tree = document.createElement('div');
        tree.id = 'christmas-tree';
        tree.style.cssText = `
            position: fixed;
            bottom: 0;
            right: 20px;
            width: 0;
            height: 0;
            border-left: 30px solid transparent;
            border-right: 30px solid transparent;
            border-bottom: 150px solid ${this.config.colors.secondary};
            z-index: 997;
        `;

        // Add tree trunk
        const trunk = document.createElement('div');
        trunk.style.cssText = `
            position: absolute;
            bottom: -20px;
            left: -8px;
            width: 16px;
            height: 20px;
            background: #8B4513;
            border-radius: 0 0 8px 8px;
        `;
        tree.appendChild(trunk);

        // Add tree decorations
        for (let i = 0; i < 10; i++) {
            const ornament = document.createElement('div');
            ornament.style.cssText = `
                position: absolute;
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: ${this.config.colors.lights[i % this.config.colors.lights.length]};
                box-shadow: 0 0 5px ${this.config.colors.lights[i % this.config.colors.lights.length]};
                top: ${Math.random() * 140 + 10}px;
                left: ${Math.random() * 50 - 25}px;
            `;
            tree.appendChild(ornament);
        }

        document.body.appendChild(tree);
    }

    addGarlands() {
        const garland = document.createElement('div');
        garland.id = 'christmas-garland';
        garland.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 20px;
            background: linear-gradient(90deg,
                ${this.config.colors.primary} 0%,
                ${this.config.colors.secondary} 25%,
                ${this.config.colors.accent} 50%,
                ${this.config.colors.secondary} 75%,
                ${this.config.colors.primary} 100%);
            background-size: 200px 100%;
            animation: garlandMove 3s linear infinite;
            z-index: 996;
            pointer-events: none;
        `;

        // Add CSS animation
        if (!document.getElementById('christmas-animations')) {
            const style = document.createElement('style');
            style.id = 'christmas-animations';
            style.textContent = `
                @keyframes garlandMove {
                    0% { background-position: 0 0; }
                    100% { background-position: 200px 0; }
                }
                @keyframes santaHat {
                    0% { transform: rotate(-2deg); }
                    50% { transform: rotate(2deg); }
                    100% { transform: rotate(-2deg); }
                }
                @keyframes twinkle {
                    0%, 100% { opacity: 0.5; transform: scale(1); }
                    50% { opacity: 1; transform: scale(1.1); }
                }
            `;
            document.head.appendChild(style);
        }

        document.body.appendChild(garland);
    }

    addOrnaments() {
        const ornaments = ['🎄', '⭐', '🔔', '🎁'];
        ornaments.forEach((ornament, index) => {
            const element = document.createElement('div');
            element.className = 'christmas-ornament';
            element.textContent = ornament;
            element.style.cssText = `
                position: fixed;
                font-size: 24px;
                z-index: 997;
                pointer-events: none;
                animation: twinkle 2s ease-in-out infinite;
                animation-delay: ${index * 0.5}s;
                top: ${20 + (index * 15)}%;
                right: ${80 + (index * 5)}px;
            `;
            document.body.appendChild(element);
        });
    }

    removeDecorationEffect() {
        const elements = ['christmas-tree', 'christmas-garland'];
        elements.forEach(id => {
            const element = document.getElementById(id);
            if (element) element.remove();
        });

        document.querySelectorAll('.christmas-ornament').forEach(el => el.remove());
    }

    // Color Theme Application
    applyColorTheme() {
        // Apply Christmas colors to CSS custom properties
        const root = document.documentElement;
        root.style.setProperty('--christmas-primary', this.config.colors.primary);
        root.style.setProperty('--christmas-secondary', this.config.colors.secondary);
        root.style.setProperty('--christmas-accent', this.config.colors.accent);

        // Add Christmas class to body for theme-specific styles
        document.body.classList.add('christmas-theme');

        // Apply Christmas colors to existing elements
        this.applyChristmasColorsToElements();
    }

    applyChristmasColorsToElements() {
        // Apply Christmas colors to cards and UI elements
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            const originalBorder = card.style.borderColor;
            card.style.borderColor = this.config.colors.primary;
            card.style.boxShadow = `0 4px 15px rgba(220, 38, 38, 0.2)`;
            this.elements.add({ element: card, originalBorder });
        });

        // Apply to buttons
        const buttons = document.querySelectorAll('.btn-primary');
        buttons.forEach(button => {
            const originalBg = button.style.background;
            button.style.background = `linear-gradient(135deg, ${this.config.colors.primary}, ${this.config.colors.accent})`;
            this.elements.add({ element: button, originalBg });
        });
    }

    removeColorTheme() {
        // Remove Christmas class
        document.body.classList.remove('christmas-theme');

        // Restore original colors
        this.elements.forEach(({ element, originalBorder, originalBg }) => {
            if (originalBorder !== undefined) {
                element.style.borderColor = originalBorder;
            }
            if (originalBg !== undefined) {
                element.style.background = originalBg;
            }
            element.style.boxShadow = '';
        });

        this.elements.clear();
    }

    // Santa Hats
    addSantaHats() {
        const avatars = document.querySelectorAll('img.logo, .sidebar-header img');
        avatars.forEach(img => {
            if (img.complete) {
                this.addSantaHatToImage(img);
            } else {
                img.addEventListener('load', () => this.addSantaHatToImage(img));
            }
        });

        // Add to cards and other elements
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            const hat = document.createElement('div');
            hat.className = 'santa-hat';
            hat.style.cssText = `
                position: absolute;
                top: -10px;
                right: 10px;
                width: 0;
                height: 0;
                border-left: 15px solid transparent;
                border-right: 15px solid transparent;
                border-bottom: 30px solid #dc2626;
                z-index: 1001;
            `;

            // Add white brim
            const brim = document.createElement('div');
            brim.style.cssText = `
                position: absolute;
                top: 22px;
                left: -17px;
                width: 34px;
                height: 8px;
                background: white;
                border-radius: 4px;
                border: 1px solid #ccc;
            `;
            hat.appendChild(brim);

            // Add pom-pom
            const pom = document.createElement('div');
            pom.style.cssText = `
                position: absolute;
                top: -5px;
                left: 10px;
                width: 10px;
                height: 10px;
                background: white;
                border-radius: 50%;
                border: 1px solid #ccc;
            `;
            hat.appendChild(pom);

            card.style.position = 'relative';
            card.appendChild(hat);
        });
    }

    addSantaHatToImage(img) {
        const container = img.parentElement;
        if (!container) return;

        const hat = document.createElement('div');
        hat.className = 'santa-hat-image';
        hat.style.cssText = `
            position: absolute;
            top: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 12px solid transparent;
            border-right: 12px solid transparent;
            border-bottom: 25px solid #dc2626;
            z-index: 1001;
            animation: santaHat 2s ease-in-out infinite;
        `;

        // Add white brim
        const brim = document.createElement('div');
        brim.style.cssText = `
            position: absolute;
            top: 18px;
            left: -14px;
            width: 28px;
            height: 6px;
            background: white;
            border-radius: 3px;
        `;
        hat.appendChild(brim);

        // Add pom-pom
        const pom = document.createElement('div');
        pom.style.cssText = `
            position: absolute;
            top: -4px;
            left: 8px;
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
        `;
        hat.appendChild(pom);

        container.style.position = 'relative';
        container.appendChild(hat);
    }

    removeSantaHats() {
        document.querySelectorAll('.santa-hat, .santa-hat-image').forEach(hat => hat.remove());
    }

    // Music System
    startMusic() {
        if (this.music) return; // Already playing

        try {
            this.music = new Audio('/audio/nekodex - Little Drummer Girl (osu! xmas 2020).mp3');
            this.music.volume = this.config.musicVolume;
            this.music.loop = true;

            // Wait for user interaction before playing
            const playPromise = this.music.play();
            if (playPromise !== undefined) {
                playPromise.then(() => {
                    console.log('🎵 Christmas music started!');
                }).catch(error => {
                    console.log('Could not play Christmas music:', error);
                    // Show user-friendly message
                    this.showToast('info', 'Click anywhere to enable Christmas music! 🎵');
                });
            }
        } catch (error) {
            console.log('Error creating audio:', error);
        }
    }

    stopMusic() {
        if (this.music) {
            this.music.pause();
            this.music.currentTime = 0; // Reset to beginning
            this.music = null;
        }
    }

    // Utility Functions
    updateDimensions() {
        // Update positions when window resizes
        if (this.isActive) {
            this.snowflakes.forEach(snowflake => {
                if (parseFloat(snowflake.style.top) > window.innerHeight) {
                    snowflake.style.top = -20 + 'px';
                    snowflake.style.left = Math.random() * 100 + '%';
                }
            });
        }
    }

    showToggleNotification() {
        const message = this.isActive ? '🎄 Christmas effects activated!' : '❌ Christmas effects deactivated!';
        this.showToast('info', message);
    }

    showToast(type, message) {
        // Use existing toast system if available, otherwise create simple notification
        if (typeof showToast === 'function') {
            showToast(type, message);
        } else {
            // Create simple notification
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${this.config.colors.primary};
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                z-index: 10000;
                font-weight: 600;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            `;
            toast.textContent = message;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    }

    // Public API
    getState() {
        return {
            active: this.isActive,
            snowflakeCount: this.snowflakes.length,
            lightCount: this.lights.length
        };
    }

    setConfig(newConfig) {
        this.config = { ...this.config, ...newConfig };
        if (this.isActive) {
            this.stopChristmasEffects();
            this.startChristmasEffects();
        }
    }
}

// Global instance
let christmasEffects;

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    christmasEffects = new ChristmasEffects();

    // Make globally available for debugging
    window.christmasEffects = christmasEffects;

    // Add to window for external access
    window.toggleChristmasEffects = () => christmasEffects.toggle();
    window.getChristmasState = () => christmasEffects.getState();

    console.log('🎄 Christmas effects system loaded and ready!');
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ChristmasEffects;
}