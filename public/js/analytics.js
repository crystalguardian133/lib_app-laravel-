// Analytics Charts for Library Dashboard
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all analytics charts
    initializeBookPopularityChart();
    initializeDemographicsCharts();
    initializeAgeDistributionChart();

    // Update charts with real data after initialization
    setTimeout(updateAnalyticsCharts, 100);
});

// Book Popularity Pie Chart
function initializeBookPopularityChart() {
    const ctx = document.getElementById('bookPopularityChart');
    if (!ctx) return;

    // Use the original dashboard color palette
    const generateRandomColors = (count) => {
        const colors = [];
        const baseColors = [
            '#2fb9eb', // Primary
            '#8b5cf6', // Secondary
            '#06b6d4', // Accent
            '#10b981', // Success
            '#f59e0b', // Warning
            '#ef4444', // Danger
            '#6366f1', // Indigo
            '#ec4899', // Pink
            '#84cc16', // Lime
            '#f97316', // Orange
            '#06b6d4', // Cyan
            '#a855f7', // Violet
            '#14b8a6', // Teal
            '#f59e0b', // Amber
            '#ef4444', // Red
            '#8b5cf6', // Purple
            '#10b981', // Emerald
            '#3b82f6', // Blue
            '#f97316', // Orange
            '#84cc16', // Lime
            '#ec4899', // Pink
            '#6366f1', // Indigo
            '#14b8a6', // Teal
            '#f59e0b', // Amber
            '#10b981', // Emerald
            '#3b82f6', // Blue
            '#8b5cf6', // Purple
            '#ef4444', // Red
            '#06b6d4', // Cyan
            '#a855f7'  // Violet
        ];

        for (let i = 0; i < count; i++) {
            if (i < baseColors.length) {
                colors.push(baseColors[i]);
            } else {
                // Cycle through colors if more genres than available
                colors.push(baseColors[i % baseColors.length]);
            }
        }
        return colors;
    };

    // Initialize with empty data, will be updated with real data
    const data = {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: generateRandomColors(30), // Support up to 30 genres
            borderWidth: 2,
            borderColor: 'rgba(255, 255, 255, 0.9)',
            hoverBorderWidth: 3,
            hoverBorderColor: 'rgba(255, 255, 255, 1)'
        }]
    };

    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} books (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                onComplete: function() {
                    createCustomLegend();
                }
            }
        }
    };

    // Store chart reference for updates
    ctx.chart = new Chart(ctx, config);
}

// Demographics Charts
function initializeDemographicsCharts() {
    // Julita Residents - Barangay Map
    initializeBarangayMap();

    // Non-Julita Residents - Municipality Pie Chart
    initializeMunicipalityChart();
}

function initializeBarangayMap() {
    const mapContainer = document.getElementById('barangayMap');
    if (!mapContainer) return;

    // Initialize Leaflet map centered on Julita, Leyte
    const map = L.map('barangayMap').setView([10.9729775, 124.9621713], 40);

    // Add OpenStreetMap tiles without attribution controls
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: false
    }).addTo(map);

    // Remove default controls
    map.zoomControl.remove();
    map.attributionControl.remove();

    // Store map reference for updates
    mapContainer.map = map;

    // Update map with real data
    updateBarangayMap();
}

function updateBarangayMap() {
    const mapContainer = document.getElementById('barangayMap');
    if (!mapContainer || !mapContainer.map) return;

    const map = mapContainer.map;

    // Clear existing markers
    map.eachLayer(function(layer) {
        if (layer instanceof L.Marker) {
            map.removeLayer(layer);
        }
    });

    // Add markers for each barangay with member data
    if (typeof analyticsData !== 'undefined' && analyticsData.julitaBarangays) {
        analyticsData.julitaBarangays.forEach(function(barangay) {
            const marker = L.circleMarker([barangay.lat, barangay.lng], {
                color: '#4285f4',
                fillColor: '#4285f4',
                fillOpacity: 0.8,
                radius: Math.max(5, Math.min(15, barangay.count * 1.5)) // Smaller, dynamic size based on member count
            }).addTo(map);

            // Create tooltip with member info
            const tooltipContent = `
                <div style="text-align: center; padding: 12px 20px; font-family: 'Outfit', sans-serif; min-width: 180px; background: rgba(255, 255, 255, 0.95); border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <strong style="color: #4285f4; font-size: 14px; display: block; margin-bottom: 4px;">${barangay.barangay}</strong>
                    <span style="color: #666; font-size: 12px; display: block; margin-bottom: 2px;">${barangay.count} registered members</span>
                    <span style="color: #888; font-size: 11px;">Click for details</span>
                </div>
            `;

            marker.bindTooltip(tooltipContent, {
                permanent: false,
                direction: 'top',
                offset: [0, -15],
                opacity: 1
            });

            // Create detailed member list popup
            const memberList = barangay.members ? barangay.members.map(member =>
                `<div style="display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px solid #f0f0f0;">
                    <span style="font-weight: 500; color: #333;">${member.name}</span>
                    <span style="color: #666; font-size: 12px;">${member.age} yrs</span>
                </div>`
            ).join('') : '<div style="text-align: center; color: #666; padding: 20px; font-style: italic;">Member details loading...</div>';

            marker.bindPopup(`
                <div style="font-family: 'Outfit', sans-serif; min-width: 450px; max-width: 500px; background: linear-gradient(135deg, #ffffff, #f8f9fa); border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                    <div style="background: linear-gradient(135deg, #4285f4, #3367d6); color: white; padding: 20px; border-radius: 12px 12px 0 0;">
                        <h3 style="margin: 0; font-size: 18px; text-align: center;">🏘️ ${barangay.barangay}</h3>
                        <div style="text-align: center; margin-top: 8px;">
                            <span style="background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                                ${barangay.count} registered members
                            </span>
                        </div>
                    </div>

                    <div style="padding: 20px;">
                        <h4 style="margin: 0 0 15px 0; color: #333; font-size: 16px; border-bottom: 2px solid #4285f4; padding-bottom: 8px;">
                            👥 Registered Members
                        </h4>

                        <div style="max-height: 300px; overflow-y: auto; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                            ${memberList}
                        </div>

                        <div style="margin-top: 15px; padding: 12px; background: rgba(66, 133, 244, 0.1); border-radius: 8px; border: 1px solid rgba(66, 133, 244, 0.2);">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <small style="color: #4285f4; font-weight: 500;">
                                    📍 Coordinates: ${barangay.lat.toFixed(4)}, ${barangay.lng.toFixed(4)}
                                </small>
                                <small style="color: #666; font-style: italic;">
                                    Click outside to close
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            `, {
                maxWidth: 500,
                minWidth: 450
            });

            // Add hover effect
            marker.on('mouseover', function() {
                this.setStyle({fillOpacity: 1, radius: this.options.radius + 3});
            });

            marker.on('mouseout', function() {
                this.setStyle({fillOpacity: 0.8, radius: this.options.radius});
            });
        });
    }
}

function initializeMunicipalityChart() {
    const ctx = document.getElementById('municipalityChart');
    if (!ctx) return;

    // Initialize with empty data, will be updated with real data
    const data = {
        labels: [],
        datasets: [{
            label: 'Members',
            data: [],
            backgroundColor: [
                '#34a853', // Green
                '#fbbc04', // Yellow
                '#ea4335', // Red
                '#8b5cf6', // Purple
                '#06b6d4', // Cyan
                '#4285f4', // Blue
                '#ff6b6b', // Coral
                '#4ecdc4', // Teal
                '#45b7d1', // Sky Blue
                '#f9ca24'  // Gold
            ],
            borderColor: 'rgba(255, 255, 255, 0.8)',
            borderWidth: 1,
            borderRadius: 4,
            borderSkipped: false,
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.parsed.y} members`;
                        }
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: 'var(--text-primary, #333)',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: function(value) {
                        return value > 0 ? value : '';
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            indexAxis: 'x', // Vertical bars
            barThickness: function(context) {
                // Dynamic bar width based on number of bars
                const dataLength = context.chart.data.labels.length;
                if (dataLength === 1) {
                    return 60; // Narrow bar for single data point
                } else if (dataLength <= 3) {
                    return 40; // Medium width for few bars
                } else {
                    return undefined; // Let Chart.js auto-calculate for many bars
                }
            },
            maxBarThickness: 50 // Maximum bar width
        }
    };

    // Store chart reference for updates
    ctx.chart = new Chart(ctx, config);
}

// Age Distribution Bar Chart
function initializeAgeDistributionChart() {
    const ctx = document.getElementById('ageDistributionChart');
    if (!ctx) return;

    // Initialize with empty data, will be updated with real data
    const data = {
        labels: [],
        datasets: [{
            label: 'Members',
            data: [],
            backgroundColor: 'rgba(52, 168, 83, 0.8)',
            borderColor: '#34a853',
            borderWidth: 1,
            borderRadius: 4,
            borderSkipped: false,
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label} years: ${context.parsed.y} members`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5
                    }
                }
            }
        }
    };

    // Store chart reference for updates
    ctx.chart = new Chart(ctx, config);
}

// Function to create custom legend with enhanced styling
function createCustomLegend() {
    const legendContainer = document.getElementById('legendItems');
    if (!legendContainer) return;

    const bookCtx = document.getElementById('bookPopularityChart');
    if (!bookCtx || !bookCtx.chart) return;

    const data = bookCtx.chart.data;
    legendContainer.innerHTML = '';

    // Sort by value (descending) for better visualization
    const sortedIndices = data.labels.map((label, index) => ({ label, index, value: data.datasets[0].data[index] }))
        .sort((a, b) => b.value - a.value);

    // Create legend items
    sortedIndices.forEach(({ label, index, value }) => {
        const item = document.createElement('div');
        item.style.cssText = `
            display: flex;
            align-items: center;
            padding: 8px 12px;
            background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(255,255,255,0.04));
            border-radius: 10px;
            border: 1px solid var(--border-light);
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        `;

        // Add subtle background pattern
        item.innerHTML += `<div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 80%, rgba(99,102,241,0.1) 0%, transparent 50%); opacity: 0; transition: opacity 0.3s ease;"></div>`;

        const colorIndicator = document.createElement('div');
        colorIndicator.style.cssText = `
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: ${data.datasets[0].backgroundColor[index]};
            margin-right: 10px;
            border: 2px solid rgba(255,255,255,0.4);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            flex-shrink: 0;
            position: relative;
            z-index: 2;
        `;

        const textContainer = document.createElement('div');
        textContainer.style.cssText = `
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 2;
        `;

        const genreName = document.createElement('span');
        genreName.textContent = label;
        genreName.style.cssText = `
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
        `;

        const stats = document.createElement('span');
        stats.textContent = `${value} books`;
        stats.style.cssText = `
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 400;
        `;

        textContainer.appendChild(genreName);
        textContainer.appendChild(stats);

        item.appendChild(colorIndicator);
        item.appendChild(textContainer);

        // Enhanced hover effects
        item.addEventListener('mouseenter', () => {
            item.style.transform = 'translateY(-2px) scale(1.02)';
            item.style.boxShadow = '0 8px 25px rgba(99, 102, 241, 0.15)';
            item.style.borderColor = 'var(--primary)';
            item.querySelector('div').style.opacity = '1';
            colorIndicator.style.transform = 'scale(1.1)';
            colorIndicator.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
        });

        item.addEventListener('mouseleave', () => {
            item.style.transform = '';
            item.style.boxShadow = '';
            item.style.borderColor = 'var(--border-light)';
            item.querySelector('div').style.opacity = '0';
            colorIndicator.style.transform = '';
            colorIndicator.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
        });

        legendContainer.appendChild(item);
    });
}

// Function to update charts with real data from backend
function updateAnalyticsCharts() {
    if (typeof analyticsData !== 'undefined') {
        // Update book popularity chart
        if (analyticsData.bookGenres && analyticsData.bookGenres.length > 0) {
            const bookCtx = document.getElementById('bookPopularityChart');
            if (bookCtx && bookCtx.chart) {
                const genres = analyticsData.bookGenres.map(item => item.genre);
                const counts = analyticsData.bookGenres.map(item => item.count);

                bookCtx.chart.data.labels = genres;
                bookCtx.chart.data.datasets[0].data = counts;
                bookCtx.chart.update();
                // Create custom legend after update
                setTimeout(createCustomLegend, 100);
            }
        }

        // Update barangay map
        updateBarangayMap();

        // Update municipality chart
        if (analyticsData.otherMunicipalities && analyticsData.otherMunicipalities.length > 0) {
            const municipalityCtx = document.getElementById('municipalityChart');
            if (municipalityCtx && municipalityCtx.chart) {
                const municipalities = analyticsData.otherMunicipalities.map(item => item.municipality);
                const counts = analyticsData.otherMunicipalities.map(item => item.count);

                municipalityCtx.chart.data.labels = municipalities;
                municipalityCtx.chart.data.datasets[0].data = counts;
                municipalityCtx.chart.update();
            }
        }

        // Update age distribution chart
        if (analyticsData.ageDistribution && analyticsData.ageDistribution.length > 0) {
            const ageCtx = document.getElementById('ageDistributionChart');
            if (ageCtx && ageCtx.chart) {
                const ageGroups = analyticsData.ageDistribution.map(item => item.age_group);
                const counts = analyticsData.ageDistribution.map(item => item.count);

                ageCtx.chart.data.labels = ageGroups;
                ageCtx.chart.data.datasets[0].data = counts;
                ageCtx.chart.update();
            }
        }
    }
}