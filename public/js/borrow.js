<<<<<<< Updated upstream
// Helper: Calculate Easter Sunday (Meeus algorithm)
function calculateEasterDate(year) {
  const a = year % 19;
  const b = Math.floor(year / 100);
  const c = year % 100;
  const d = Math.floor(b / 4);
  const e = b % 4;
  const f = Math.floor((b + 8) / 25);
  const g = Math.floor((b - f + 1) / 3);
  const h = (19 * a + b - d - g + 15) % 30;
  const i = Math.floor(c / 4);
  const k = c % 4;
  const l = (32 + 2 * e + 2 * i - h - k) % 7;
  const m = Math.floor((a + 11 * h + 22 * l) / 451);
  const month = Math.floor((h + l - 7 * m + 114) / 31) - 1;
  const day = ((h + l - 7 * m + 114) % 31) + 1;
  return new Date(year, month, day);
=======
// ======================
// BORROW.JS - COMPLETE IMPLEMENTATION
// ======================

// Global variables
let selectedBooks = [];
let selectionMode = false;

// DEBUG: Log when borrow.js is loaded
console.log('🚀 BORROW.JS LOADED - Version with Philippine business days and z-index fixes');
console.log('📅 Current time in Philippine timezone:', new Date().toLocaleString('en-US', {timeZone: 'Asia/Manila'}));

// Initialize borrow system when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Initializing borrow system...');

    // Ensure all functions are properly exported
    if (typeof window.updateConfirmButtonState !== 'function') {
        console.error('❌ updateConfirmButtonState not exported properly');
    } else {
        console.log('✅ updateConfirmButtonState exported successfully');
    }

    // Initialize confirm button state after a short delay
    setTimeout(() => {
        console.log('🔧 Running initial button state setup...');
        if (typeof updateConfirmButtonState === 'function') {
            updateConfirmButtonState();
        } else if (typeof window.updateConfirmButtonState === 'function') {
            window.updateConfirmButtonState();
        }

        // Also check if button exists and log its state
        const confirmBtn = document.getElementById('confirmBorrowBtn');
        if (confirmBtn) {
            console.log('✅ Confirm button found during initialization');
            console.log('  - Button text:', confirmBtn.innerHTML);
            console.log('  - Button disabled:', confirmBtn.disabled);
            console.log('  - Has onclick handler:', !!confirmBtn.onclick);
        } else {
            console.error('❌ Confirm button not found during initialization');
        }
    }, 100);

    // Add a fallback check after 1 second
    setTimeout(() => {
        console.log('🔧 Running fallback button state setup...');
        const confirmBtn = document.getElementById('confirmBorrowBtn');
        if (confirmBtn && !confirmBtn.onclick) {
            console.log('⚠️ Button found but no onclick handler - adding fallback');
            confirmBtn.addEventListener('click', function(e) {
                console.log('🔘 Confirm button clicked via fallback event listener!');
                if (typeof confirmBorrow === 'function') {
                    confirmBorrow();
                } else {
                    console.error('❌ confirmBorrow function not found');
                    showToast('Borrow function not available. Please refresh the page.', 'error');
                }
            });
        }
    }, 1000);
});

// Immediately export basic functions for testing and ensure they're available
window.checkBorrowSystem = function() {
    console.log('🔍 BORROW SYSTEM CHECK');
    console.log('=====================');
    console.log('📋 confirmBorrow function:', typeof confirmBorrow);
    console.log('📋 window.confirmBorrow:', typeof window.confirmBorrow);
    console.log('📋 testConfirmBorrow:', typeof window.testConfirmBorrow);
    console.log('📋 forceTestConfirmButton:', typeof window.forceTestConfirmButton);
    console.log('📋 updateConfirmButtonState:', typeof window.updateConfirmButtonState);

    const confirmBtn = document.getElementById('confirmBorrowBtn');
    console.log('📋 Confirm button found:', !!confirmBtn);
    if (confirmBtn) {
        console.log('  - Button ID:', confirmBtn.id);
        console.log('  - Button disabled:', confirmBtn.disabled);
        console.log('  - Button text:', confirmBtn.innerHTML);
        console.log('  - Has onclick:', !!confirmBtn.onclick);
        console.log('  - Button style:', confirmBtn.style.backgroundColor);
    }

    console.log('');
    console.log('💡 Available functions:');
    console.log('   - checkBorrowSystem() ✅');
    console.log('   - testConfirmBorrow()');
    console.log('   - forceTestConfirmButton()');
    console.log('   - updateConfirmButtonState()');

    // Check if all required elements exist
    const memberName = document.getElementById('memberName');
    const selectedBooksList = document.getElementById('selectedBooksList');
    console.log('');
    console.log('🔍 Required elements:');
    console.log('  - memberName field:', !!memberName);
    console.log('  - selectedBooksList:', !!selectedBooksList);
    console.log('  - borrowModal:', !!document.getElementById('borrowModal'));
};

// Test function to manually trigger confirm borrow (for debugging)
window.testConfirmBorrow = function() {
    console.log('🧪 Manual test of confirmBorrow function');
    console.log('🔍 confirmBorrow function exists:', typeof confirmBorrow);
    console.log('🔍 window.confirmBorrow exists:', typeof window.confirmBorrow);

    // First check if required elements exist
    const memberName = document.getElementById('memberName');
    const memberId = document.getElementById('memberId');
    const dueDate = document.getElementById('dueDate');
    const dueTime = document.getElementById('dueTime');
    const selectedBooksList = document.getElementById('selectedBooksList');

    console.log('🔍 Required elements:', {
        memberName: !!memberName && memberName.value.trim() !== '',
        memberId: !!memberId && memberId.value.trim() !== '',
        dueDate: !!dueDate && dueDate.value !== '',
        dueTime: !!dueTime && dueTime.value !== '',
        selectedBooksList: !!selectedBooksList && selectedBooksList.children.length > 0
    });

    if (memberName) console.log('  - Member name value:', memberName.value);
    if (memberId) console.log('  - Member ID value:', memberId.value);
    if (dueDate) console.log('  - Due date value:', dueDate.value);
    if (dueTime) console.log('  - Due time value:', dueTime.value);
    if (selectedBooksList) console.log('  - Books count:', selectedBooksList.children.length);

    if (typeof confirmBorrow === 'function') {
        console.log('✅ Calling confirmBorrow directly');
        confirmBorrow();
    } else if (typeof window.confirmBorrow === 'function') {
        console.log('✅ Calling window.confirmBorrow');
        window.confirmBorrow();
    } else {
        console.error('❌ confirmBorrow function not found');
        showToast('confirmBorrow function not found!', 'error');
    }
};

// Direct button test function
window.testConfirmButton = function() {
    console.log('🔧 Testing confirm button directly...');

    const confirmBtn = document.getElementById('confirmBorrowBtn');
    if (confirmBtn) {
        console.log('✅ Button found, simulating click...');
        console.log('📋 Button properties:', {
            id: confirmBtn.id,
            disabled: confirmBtn.disabled,
            hasOnclick: !!confirmBtn.onclick,
            innerHTML: confirmBtn.innerHTML
        });

        // Try to click it programmatically
        confirmBtn.click();
    } else {
        console.error('❌ Button not found!');

        // Try to find buttons with similar patterns
        const possibleButtons = document.querySelectorAll('button[id*="confirm"], button[class*="confirm"]');
        console.log('🔍 Found potential confirm buttons:', possibleButtons.length);

        possibleButtons.forEach((btn, index) => {
            console.log(`${index + 1}.`, {
                id: btn.id,
                className: btn.className,
                innerHTML: btn.innerHTML,
                disabled: btn.disabled
            });
        });
    }
};


// Force test confirm button function (global access)
window.forceTestConfirmButton = function() {
    console.log('🔧 Force testing confirm button');

    const confirmBtn = document.getElementById('confirmBorrowBtn');
    if (confirmBtn) {
        console.log('✅ Found confirm button, simulating click');
        console.log('📋 Button details:', {
            id: confirmBtn.id,
            disabled: confirmBtn.disabled,
            textContent: confirmBtn.textContent,
            hasOnclick: !!confirmBtn.onclick,
            backgroundColor: confirmBtn.style.backgroundColor
        });
        confirmBtn.click();
    } else {
        console.error('❌ Confirm button not found');

        // Try to find any button with confirm in the ID or class
        const allButtons = document.querySelectorAll('button');
        const confirmButtons = Array.from(allButtons).filter(btn =>
            btn.id?.toLowerCase().includes('confirm') ||
            btn.className?.toLowerCase().includes('confirm') ||
            btn.textContent?.toLowerCase().includes('confirm')
        );

        console.log('🔍 Found potential confirm buttons:', confirmButtons.length);
        confirmButtons.forEach((btn, index) => {
            console.log(`${index + 1}.`, {
                id: btn.id,
                className: btn.className,
                textContent: btn.textContent.trim(),
                disabled: btn.disabled,
                hasOnclick: !!btn.onclick
            });
        });

        if (confirmButtons.length > 0) {
            console.log('✅ Clicking first potential confirm button');
            confirmButtons[0].click();
        }
    }
};

// ======================
// TOAST NOTIFICATIONS
// ======================

function showToast(message, type = 'info') {
    const existingToasts = document.querySelectorAll('.toast-notification');
    existingToasts.forEach(toast => toast.remove());

    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
>>>>>>> Stashed changes
}

// Get Philippine holidays as YYYY-MM-DD strings
function getPhilippineHolidays(year) {
  const fixedHolidays = [
    { month: 0,   day: 1 },   // Jan 1 – New Year
    { month: 3,   day: 9 },   // Apr 9 – Araw ng Kagitingan
    { month: 4,   day: 1 },   // May 1 – Labor Day
    { month: 5,   day: 12 },  // Jun 12 – Independence Day
    { month: 8,   day: 30 },  // Aug 30 – Ninoy Aquino Day
    { month: 10,  day: 30 },  // Nov 30 – Bonifacio Day
    { month: 11,  day: 25 },  // Dec 25 – Christmas
    { month: 11,  day: 26 },  // Dec 26 – Special Non-Working
    { month: 11,  day: 30 },  // Dec 30 – Rizal Day
  ];

  const easter = calculateEasterDate(year);
  const goodFriday = new Date(easter);
  goodFriday.setDate(goodFriday.getDate() - 2);

  const holidayStrings = fixedHolidays.map(h =>
    `${year}-${String(h.month + 1).padStart(2, '0')}-${String(h.day).padStart(2, '0')}`
  );
  holidayStrings.push(goodFriday.toISOString().split('T')[0]);

  return holidayStrings;
}

// Add n business days (skip weekends & PH holidays)
function addBusinessDays(date, days) {
  const result = new Date(date);
  let added = 0;
  const currentYear = result.getFullYear();
  const nextYear = currentYear + 1;

  const holidaySet = new Set([
    ...getPhilippineHolidays(currentYear),
    ...getPhilippineHolidays(nextYear)
  ]);

  while (added < days) {
    result.setDate(result.getDate() + 1);
    const dayOfWeek = result.getDay(); // 0=Sun, 6=Sat
    const dateString = result.toISOString().split('T')[0];

    if (dayOfWeek !== 0 && dayOfWeek !== 6 && !holidaySet.has(dateString)) {
      added++;
    }
  }
  return result;
}

// Format date for input[type="date"] (YYYY-MM-DD)
function formatDateForInput(date) {
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, '0');
  const d = String(date.getDate()).padStart(2, '0');
  return `${y}-${m}-${d}`;
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

// Format time to 12-hour with AM/PM
function formatTimeWithAMPM(date) {
  let h = date.getHours();
  const m = date.getMinutes();
  const ampm = h >= 12 ? 'PM' : 'AM';
  h = h % 12 || 12;
  const timeStr = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
  return { time: timeStr, ampm };
}

<<<<<<< Updated upstream
// Corner popup (auto-dismiss)
function showCornerPopup(message) {
  let popup = document.getElementById('corner-popup');
  if (!popup) {
    popup = document.createElement('div');
    popup.id = 'corner-popup';
    popup.style.position = 'fixed';
    popup.style.bottom = '20px';
    popup.style.right = '20px';
    popup.style.background = '#222';
    popup.style.color = '#fff';
    popup.style.padding = '12px 20px';
    popup.style.borderRadius = '6px';
    popup.style.zIndex = '9999';
    popup.style.boxShadow = '0 4px 12px rgba(0,0,0,0.2)';
    popup.style.fontSize = '0.95rem';
    popup.style.maxWidth = '300px';
    popup.style.textAlign = 'center';
    document.body.appendChild(popup);
  }
  popup.innerText = message;
  popup.style.display = 'block';
  setTimeout(() => popup.style.display = 'none', 3000);
=======

// ======================
// BORROW MODAL FUNCTIONS
// ======================

function openBorrowModal() {
    console.log('🚪 Borrow modal opening...');
    console.log('🌐 Current timestamp when modal opened:', new Date().toISOString());

    const selectedRows = document.querySelectorAll('#booksTableBody tr.selected');
    console.log('📚 Selected books for borrowing:', selectedRows.length);

    if (selectedRows.length === 0) {
        showToast("No books selected for borrowing", 'warning');
        return;
    }

    const list = document.getElementById('selectedBooksList');
    if (list) {
        list.innerHTML = '';
        selectedRows.forEach(row => {
            const li = document.createElement('li');
            li.textContent = row.dataset.title || 'Unknown Title';
            li.setAttribute('data-id', row.dataset.id);
            li.style.padding = '8px 0';
            li.style.borderBottom = '1px solid var(--border-light)';
            list.appendChild(li);
        });
    }

    // Philippine holidays for 2025 (you can expand this for other years)
    const philippineHolidays = [
        '2025-01-01', // New Year
        '2025-02-25', // EDSA Revolution
        '2025-04-17', // Maundy Thursday
        '2025-04-18', // Good Friday
        '2025-04-19', // Black Saturday
        '2025-05-01', // Labor Day
        '2025-06-12', // Independence Day
        '2025-08-25', // National Heroes Day
        '2025-11-01', // All Saints Day
        '2025-11-30', // Bonifacio Day
        '2025-12-25', // Christmas
        '2025-12-30', // Rizal Day
        '2025-12-31'  // New Year's Eve
    ];

    console.log('🏖️  Philippine holidays loaded:', philippineHolidays.length, 'holidays');
    console.log('🏖️  Holiday list:', philippineHolidays);

    // Check if a date is a Philippine holiday
    function isPhilippineHoliday(dateString) {
        const isHoliday = philippineHolidays.includes(dateString);
        if (isHoliday) {
            console.log(`🏖️  Philippine holiday detected: ${dateString}`);
        }
        return isHoliday;
    }

    // Calculate Philippine business days (10 working days) excluding holidays
    function calculatePhilippineBusinessDueDate() {
        console.log('🔄 Calculating Philippine business due date (excluding holidays)...');

        // DEBUG: Show current UTC time
        const now = new Date();
        console.log('🌐 Current UTC time:', now.toISOString());
        console.log('🌐 Current UTC time (local):', now.toLocaleString());

        // Use Philippine timezone directly (more reliable than manual offset calculation)
        // This ensures we get the correct local time in Manila timezone
        const philippineTime = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Manila"}));

        console.log('🇵🇭 Current Philippine time (calculated):', philippineTime.toISOString());
        console.log('🇵🇭 Current Philippine time (local):', philippineTime.toLocaleString('en-US', {timeZone: 'Asia/Manila'}));

        // Verify the time calculation is correct
        const utcTime = now.getTime();
        const philippineTimeInMs = philippineTime.getTime();
        const timeDifference = philippineTimeInMs - utcTime;
        const hoursDifference = timeDifference / (1000 * 60 * 60);
        console.log(`⏰ Time difference: ${hoursDifference.toFixed(2)} hours (should be +8 for Philippine time)`);
        console.log('🇵🇭 Philippine time components:', {
            year: philippineTime.getFullYear(),
            month: philippineTime.getMonth() + 1,
            day: philippineTime.getDate(),
            hour: philippineTime.getHours(),
            minute: philippineTime.getMinutes(),
            second: philippineTime.getSeconds(),
            dayOfWeek: philippineTime.getDay()
        });

        // Start from current date for due date calculation (including today)
        const startDate = new Date(philippineTime);

        console.log('📅 Starting calculation from current date:', startDate.toLocaleDateString());
        console.log('📅 Start date components:', {
            year: startDate.getFullYear(),
            month: startDate.getMonth() + 1,
            day: startDate.getDate(),
            dayOfWeek: startDate.getDay()
        });

        // Calculate 10 working days (Monday to Friday, excluding weekends and holidays)
        // Include today if it's a working day
        let workingDaysCount = 0;
        let currentDate = new Date(startDate);
        const workingDates = [];
        let totalDaysChecked = 0;

        console.log('🔍 Starting working days calculation (including today if it\'s a working day)...');

        while (workingDaysCount < 10 && totalDaysChecked < 50) { // Safety limit to prevent infinite loop
            // Check if it's a weekday (Monday = 1, Friday = 5)
            const dayOfWeek = currentDate.getDay();
            const dateString = currentDate.toISOString().split('T')[0];

            console.log(`📊 Checking ${currentDate.toLocaleDateString()} (Day ${dayOfWeek}, ${dateString})`);

            if (dayOfWeek >= 1 && dayOfWeek <= 5 && !isPhilippineHoliday(dateString)) {
                workingDaysCount++;
                workingDates.push(new Date(currentDate));
                console.log(`✅ Working day ${workingDaysCount} found:`, currentDate.toLocaleDateString(), `(not a holiday)`);
            } else {
                if (dayOfWeek < 1 || dayOfWeek > 5) {
                    console.log(`❌ Weekend skipped:`, currentDate.toLocaleDateString(), `(Day ${dayOfWeek})`);
                } else if (isPhilippineHoliday(dateString)) {
                    console.log(`❌ Holiday skipped:`, currentDate.toLocaleDateString(), `(${dateString})`);
                }
            }

            // Move to next day
            currentDate.setDate(currentDate.getDate() + 1);
            totalDaysChecked++;
        }

        console.log(`📈 Calculation completed: ${workingDaysCount} working days found after checking ${totalDaysChecked} total days`);

        console.log('🎯 Final due date calculated:', currentDate.toLocaleDateString());
        console.log('🎯 Final due date (ISO):', currentDate.toISOString());
        console.log('📅 All working dates:', workingDates.map(d => d.toLocaleDateString()));
        console.log('📅 All working dates (ISO):', workingDates.map(d => d.toISOString().split('T')[0]));

        const result = {
            finalDate: currentDate,
            workingDates: workingDates
        };

        console.log('📋 Function result:', {
            finalDate: result.finalDate.toISOString(),
            finalDateLocal: result.finalDate.toLocaleDateString(),
            workingDatesCount: result.workingDates.length,
            firstWorkingDate: result.workingDates[0]?.toISOString().split('T')[0],
            lastWorkingDate: result.workingDates[result.workingDates.length - 1]?.toISOString().split('T')[0]
        });

        return result;
    }

    const dueDateResult = calculatePhilippineBusinessDueDate();
    const dueDate = dueDateResult.finalDate;
    const workingDates = dueDateResult.workingDates;

    console.log('📋 Due date set to:', dueDate.toISOString().split('T')[0]);

    const dueDateInput = document.getElementById('dueDate');
    if (dueDateInput) {
        const dateValue = dueDate.toISOString().split('T')[0];
        dueDateInput.value = dateValue;

        // Restrict date picker to only allow the calculated working days
        const minDate = workingDates[0].toISOString().split('T')[0];
        const maxDate = dueDate.toISOString().split('T')[0];

        dueDateInput.setAttribute('min', minDate);
        dueDateInput.setAttribute('max', maxDate);

        console.log('📅 Date picker setup:');
        console.log('  - Default value:', dateValue);
        console.log('  - Min date (first working day):', minDate);
        console.log('  - Max date (final due date):', maxDate);
        console.log('  - Date picker attributes set successfully');

        // Set up validation for working days only
        dueDateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const dayOfWeek = selectedDate.getDay();
            const dateString = this.value;

            if (dayOfWeek === 0 || dayOfWeek === 6) {
                showToast('Please select a weekday (Monday to Friday) from the available dates', 'warning');
                this.value = dueDate.toISOString().split('T')[0];
                return;
            }

            if (isPhilippineHoliday(dateString)) {
                showToast('Selected date is a Philippine holiday. Please choose another working day from the available dates.', 'warning');
                this.value = dueDate.toISOString().split('T')[0];
                return;
            }

            // Check if selected date is one of the calculated working days (starting from current date + 10 days)
            const isValidWorkingDay = workingDates.some(wd =>
                wd.toISOString().split('T')[0] === dateString
            );
    
            if (!isValidWorkingDay) {
                showToast('Please select one of the available working days', 'warning');
                this.value = dueDate.toISOString().split('T')[0];
            }
        });

        // Create a custom date picker experience by showing available dates
        console.log('📅 Available working dates for selection:');
        workingDates.forEach((date, index) => {
            console.log(`${index + 1}. ${date.toLocaleDateString()} (${date.toLocaleDateString('en-US', {weekday: 'long'})})`);
        });

    }

    // Initialize custom time picker
    initializeCustomTimePicker();

    const memberNameInput = document.getElementById('memberName');
    const memberIdInput = document.getElementById('memberId');
    if (memberNameInput) memberNameInput.value = '';
    if (memberIdInput) memberIdInput.value = '';

    const modal = document.getElementById('borrowModal');
    if (modal) {
        modal.classList.add('show');
        modal.style.display = 'flex';
    }

    updateConfirmButtonState();
>>>>>>> Stashed changes
}

// DOM Ready
document.addEventListener('DOMContentLoaded', () => {
  const memberInput = document.getElementById('memberName');
  const suggestionBox = document.getElementById('suggestionBox');

<<<<<<< Updated upstream
  // Autocomplete member name
  if (memberInput && suggestionBox) {
    memberInput.addEventListener('input', () => {
      const query = memberInput.value.trim();
      if (query.length < 2) {
        suggestionBox.innerHTML = '';
=======
    document.querySelectorAll('#booksTableBody tr.selected').forEach(row => {
        row.classList.remove('selected');
    });

    const fieldsToReset = ['memberName', 'memberId', 'dueDate', 'dueTime'];
    fieldsToReset.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) field.value = '';
    });

    // Reset custom time picker
    const dueHour = document.getElementById('dueHour');
    const dueMinute = document.getElementById('dueMinute');
    const dueAmPm = document.getElementById('dueAmPm');

    if (dueHour) dueHour.value = '5'; // 5 PM
    if (dueMinute) dueMinute.value = '59';
    if (dueAmPm) dueAmPm.value = 'PM';

    const list = document.getElementById('selectedBooksList');
    if (list) list.innerHTML = '';

    selectedBooks = [];

    const memberNameField = document.getElementById('memberName');
    if (memberNameField) {
        memberNameField.style.backgroundColor = 'var(--surface-elevated)';
        memberNameField.style.cursor = 'not-allowed';
    }

    updateConfirmButtonState();

    // Ensure button has proper event listener after a short delay
    setTimeout(() => {
        const confirmBtn = document.getElementById('confirmBorrowBtn');
        if (confirmBtn && !confirmBtn.onclick) {
            console.log('🔧 Adding fallback event listener to confirm button');
            confirmBtn.addEventListener('click', function(e) {
                console.log('🔘 Confirm button clicked via fallback event listener!');
                if (typeof confirmBorrow === 'function') {
                    confirmBorrow();
                } else {
                    console.error('❌ confirmBorrow function not found');
                    showToast('Borrow function not available. Please refresh the page.', 'error');
                }
            });
        }
    }, 100);
}

function confirmBorrow() {
    const memberName = document.getElementById('memberName').value.trim();
    const memberId = document.getElementById('memberId').value.trim();
    const dueDate = document.getElementById('dueDate').value;
    const dueTimeHidden = document.getElementById('dueTime');
    const dueTime = dueTimeHidden ? dueTimeHidden.value : '';

    if (!memberName || !memberId) {
        showToast('Please scan member QR code', 'warning');
>>>>>>> Stashed changes
        return;
      }

<<<<<<< Updated upstream
      fetch(`/members/search?query=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
          if (!Array.isArray(data)) return;
          if (data.length === 0) {
            suggestionBox.innerHTML = `<div class="suggestion">No matches found.</div>`;
            return;
          }

          suggestionBox.innerHTML = data.map(name =>
            `<div class="suggestion" onclick="selectMember('${escapeHtml(name)}')">${escapeHtml(name)}</div>`
          ).join('');
        })
        .catch(() => {
          suggestionBox.innerHTML = `<div class="suggestion">Error fetching suggestions</div>`;
=======
    if (!dueDate || !dueTime) {
        showToast('Please set due date and time', 'warning');
        return;
    }

    const selectedRows = document.querySelectorAll('#booksTableBody tr.selected');
    if (selectedRows.length === 0) {
        showToast('No books selected', 'warning');
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]').content;
    if (!token) {
        showToast('Security token missing. Please refresh the page.', 'error');
        return;
    }

    const bookIds = Array.from(selectedRows).map(row => parseInt(row.dataset.id));
    const borrowData = {
        member_name: memberName,
        due_date: dueDate,
        book_ids: bookIds
    };

    const confirmButton = document.querySelector('#borrowModal .btn-primary');
    if (confirmButton) {
        const originalText = confirmButton.innerHTML;
        confirmButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        confirmButton.disabled = true;

        console.log('🚀 Sending borrow request...');
        console.log('📋 Request data:', borrowData);
        console.log('🔑 CSRF token:', token);

        fetch('/borrow/process', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(borrowData)
        })
        .then(response => {
            console.log('📡 Response object:', response);
            console.log('📡 Response type:', typeof response);
            console.log('📡 Response status:', response.status);
            console.log('📡 Response ok:', response.ok);

            if (!response) {
                throw new Error('No response received from server');
            }

            // Handle empty response (204 No Content)
            if (response.status === 204) {
                console.log('✅ Borrow completed successfully (no content response)');
                return { success: true, message: 'Books borrowed successfully!' };
            }

            // For error responses, get the text first
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('❌ Server error response:', text);
                    const status = response.status || 'Unknown';
                    throw new Error(`HTTP ${status}: ${text}`);
                });
            }

            // For successful responses, try to parse JSON
            return response.json().then(data => {
                console.log('✅ JSON parsed successfully:', data);
                return data;
            }).catch(jsonError => {
                console.error('❌ JSON parse error:', jsonError);
                // If JSON parsing fails, return a generic success response
                console.log('📝 Returning generic success response due to JSON parse error');
                return { success: true, message: 'Books borrowed successfully!' };
            });
        })
        .then(data => {
            console.log('✅ Borrow response data:', data);
            console.log('✅ Data type:', typeof data);

            if (data && typeof data === 'object' && data.message) {
                showToast(data.message, 'success');
            } else {
                showToast('Books borrowed successfully!', 'success');
            }

            closeBorrowModal();
            setTimeout(() => {
                location.reload();
            }, 1500);
        })
        .catch(error => {
            console.error('❌ Borrow error caught:', error);
            console.error('❌ Error type:', error.constructor.name);
            console.error('❌ Error message:', error.message);
            console.error('❌ Error stack:', error.stack);

            // Handle different types of errors
            if (error.message && error.message.includes('HTTP')) {
                showToast('Server error occurred. Check console for details.', 'error');
            } else if (error.message && error.message.includes('JSON')) {
                showToast('Invalid server response format.', 'error');
            } else {
                showToast('Failed to process borrowing. Check console for details.', 'error');
            }
        })
        .finally(() => {
            confirmButton.innerHTML = originalText;
            confirmButton.disabled = false;
>>>>>>> Stashed changes
        });
    });
  }

  // Book card selection
  document.querySelectorAll('.book-card').forEach(card => {
    card.addEventListener('click', (e) => {
      if (['BUTTON', 'IMG'].includes(e.target.tagName)) return;
      card.classList.toggle('selected');
    });
  });
});

// Select member from autocomplete
function selectMember(name) {
  document.getElementById('memberName').value = name;
  document.getElementById('suggestionBox').innerHTML = '';
  document.getElementById('dueDate').focus();
}

// Open borrow modal
function openBorrowModal() {
  const selectedCards = document.querySelectorAll('.book-card.selected');
  if (selectedCards.length === 0) {
    showCornerPopup("❗ No books selected.");
    return;
  }

  // Populate selected books
  const list = document.getElementById('selectedBooksList');
  list.innerHTML = '';
  selectedCards.forEach(card => {
    const li = document.createElement('li');
    li.textContent = card.getAttribute('data-title');
    li.setAttribute('data-id', card.getAttribute('data-id'));
    list.appendChild(li);
  });

  // Set current time
  const now = new Date();
  const { time, ampm } = formatTimeWithAMPM(now);
  const timeInput = document.getElementById('dueTime');
  timeInput.value = time;

  // Add AM/PM indicator
  let ampmIndicator = document.getElementById('ampmIndicator');
  if (!ampmIndicator) {
    ampmIndicator = document.createElement('span');
    ampmIndicator.id = 'ampmIndicator';
    ampmIndicator.style.marginLeft = '5px';
    ampmIndicator.style.color = 'var(--gray)';
    ampmIndicator.style.fontSize = '0.85rem';
    timeInput.parentNode.insertBefore(ampmIndicator, timeInput.nextSibling);
  }
  ampmIndicator.textContent = ampm;

  // 🔹 Calculate: min = today, max = 10 business days from today
  const today = new Date();
  const minDueDate = today;                    // ✅ Same-day allowed
  const maxDueDate = addBusinessDays(today, 10); // 10 business days ahead

  const dueDateInput = document.getElementById('dueDate');
  dueDateInput.min = formatDateForInput(minDueDate);
  dueDateInput.max = formatDateForInput(maxDueDate);
  dueDateInput.value = formatDateForInput(minDueDate); // ✅ Auto-fill with TODAY

  // Add hint
  let dueHint = document.getElementById('due-date-hint');
  if (!dueHint) {
    dueHint = document.createElement('small');
    dueHint.id = 'due-date-hint';
    dueHint.style.display = 'block';
    dueHint.style.color = 'var(--gray)';
    dueHint.style.fontSize = '0.85rem';
    dueHint.style.marginTop = '4px';
    dueDateInput.parentNode.appendChild(dueHint);
  }
  dueHint.textContent = `Auto-filled: Today. You can extend up to ${formatDateForInput(maxDueDate)}.`;

  // Validate on change
  dueDateInput.onchange = function () {
    const selected = new Date(this.value);
    const day = selected.getDay();
    const dateString = selected.toISOString().split('T')[0];
    const year = selected.getFullYear();
    const holidays = getPhilippineHolidays(year);

    if (day === 0 || day === 6) {
      showCornerPopup("📅 Please select a weekday (Mon–Fri).");
      this.value = formatDateForInput(minDueDate); // fallback to today
    } else if (holidays.includes(dateString)) {
      showCornerPopup("🚫 Selected date is a national holiday.");
      this.value = formatDateForInput(minDueDate);
    }
  };

  // Show modal
  document.getElementById('borrowModal').style.display = 'flex';
}

// Close borrow modal
function closeBorrowModal() {
  const modal = document.getElementById('borrowModal');
  if (modal) modal.style.display = 'none';

  const list = document.getElementById('selectedBooksList');
  if (list) list.innerHTML = '';

  ['memberName', 'memberId', 'dueDate', 'dueTime'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.value = '';
  });

  const ampmIndicator = document.getElementById('ampmIndicator');
  if (ampmIndicator) ampmIndicator.remove();

  const dueHint = document.getElementById('due-date-hint');
  if (dueHint) dueHint.remove();

  const dueDateInput = document.getElementById('dueDate');
  if (dueDateInput) dueDateInput.onchange = null;

  document.querySelectorAll('.book-card.selected').forEach(c => c.classList.remove('selected'));
}

// Confirm borrow
function confirmBorrow() {
  const memberId = document.getElementById('memberId').value;
  const dueDate = document.getElementById('dueDate').value;
  const dueTime = document.getElementById('dueTime').value;

  const selectedCards = document.querySelectorAll('.book-card.selected');
  if (!memberId || !dueDate || !dueTime) {
    alert("⚠️ Please fill in all fields.");
    return;
  }
  if (selectedCards.length === 0) {
    alert("❗ No books selected.");
    return;
  }

  const bookIds = Array.from(selectedCards).map(c => c.getAttribute('data-id'));
  const dueDateTime = `${dueDate}T${dueTime}:00`;

  fetch("/borrow", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      member_id: memberId,
      due_date: dueDateTime,
      book_ids: bookIds
    })
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message || "✅ Borrow successful!");
    setTimeout(() => location.reload(), 500);
  })
  .catch(err => {
    console.error("Error:", err);
    alert("🚫 Network error. Check console.");
  });
}

// Borrow single book
function borrowOne(bookId) {
  const card = document.querySelector(`.book-card[data-id="${bookId}"]`);
  if (!card) return showCornerPopup("❌ Book not found.");

  const availableText = card.querySelector('.book-meta div:nth-child(3)').innerText;
  if (!availableText.includes('Yes')) return showCornerPopup("⚠️ No copies available.");

  // Reset selection
  document.querySelectorAll('.book-card.selected').forEach(c => c.classList.remove('selected'));
  card.classList.add('selected');

  // Populate list
  const list = document.getElementById('selectedBooksList');
  list.innerHTML = '';
  const li = document.createElement('li');
  li.textContent = card.getAttribute('data-title');
  li.setAttribute('data-id', bookId);
  list.appendChild(li);

  // Time
  const now = new Date();
  const { time, ampm } = formatTimeWithAMPM(now);
  const timeInput = document.getElementById('dueTime');
  timeInput.value = time;

  let ampmIndicator = document.getElementById('ampmIndicator');
  if (!ampmIndicator) {
    ampmIndicator = document.createElement('span');
    ampmIndicator.id = 'ampmIndicator';
    ampmIndicator.style.marginLeft = '5px';
    ampmIndicator.style.color = 'var(--gray)';
    ampmIndicator.style.fontSize = '0.85rem';
    timeInput.parentNode.insertBefore(ampmIndicator, timeInput.nextSibling);
  }
  ampmIndicator.textContent = ampm;

  // Calculate range
  const today = new Date();
  const minDue = today;
  const maxDue = addBusinessDays(today, 10);

  const dueDateInput = document.getElementById('dueDate');
  dueDateInput.min = formatDateForInput(minDue);
  dueDateInput.max = formatDateForInput(maxDue);
  dueDateInput.value = formatDateForInput(minDue); // ✅ Auto-fill with today

  let dueHint = document.getElementById('due-date-hint');
  if (!dueHint) {
    dueHint = document.createElement('small');
    dueHint.id = 'due-date-hint';
    dueHint.style.display = 'block';
    dueHint.style.color = 'var(--gray)';
    dueHint.style.fontSize = '0.85rem';
    dueHint.style.marginTop = '4px';
    dueDateInput.parentNode.appendChild(dueHint);
  }
  dueHint.textContent = `Auto-filled: Today. Max: ${formatDateForInput(maxDue)}.`;

  // Validate
  dueDateInput.onchange = function () {
    const selected = new Date(this.value);
    const day = selected.getDay();
    const dateString = selected.toISOString().split('T')[0];
    const year = selected.getFullYear();
    const holidays = getPhilippineHolidays(year);

    if (day === 0 || day === 6) {
      showCornerPopup("📅 Weekends not allowed.");
      this.value = formatDateForInput(minDue);
    } else if (holidays.includes(dateString)) {
      showCornerPopup("🚫 Holiday. Pick another day.");
      this.value = formatDateForInput(minDue);
    }
  };

<<<<<<< Updated upstream
  document.getElementById('borrowModal').style.display = 'flex';
}
=======
    const availability = parseInt(row.dataset.availability);
    if (availability <= 0) {
        showToast("This book is currently not available", 'warning');
        return;
    }

    document.querySelectorAll('#booksTableBody tr.selected').forEach(r => {
        r.classList.remove('selected');
    });

    row.classList.add('selected');
    openBorrowModal();
}

// Update confirm button state for borrow modal - Enhanced version from bookadd.js
function updateConfirmButtonState() {
    console.log('🔄 updateConfirmButtonState called');

    const memberName = document.getElementById('memberName');
    const confirmBtn = document.getElementById('confirmBorrowBtn');
    const selectedBooksList = document.getElementById('selectedBooksList');

    console.log('🔍 Elements found:', {
        memberName: !!memberName,
        confirmBtn: !!confirmBtn,
        selectedBooksList: !!selectedBooksList,
        confirmBtnId: confirmBtn ? confirmBtn.id : 'not found'
    });

    // Additional debugging for button state
    if (confirmBtn) {
        console.log('🔍 Button details:', {
            tagName: confirmBtn.tagName,
            type: confirmBtn.type,
            disabled: confirmBtn.disabled,
            style: confirmBtn.style.cssText,
            className: confirmBtn.className,
            innerHTML: confirmBtn.innerHTML,
            hasOnclick: !!confirmBtn.onclick
        });
    } else {
        console.error('❌ confirmBorrowBtn element not found!');
        // Try to find any button with similar ID
        const allButtons = document.querySelectorAll('button');
        console.log('🔍 All buttons on page:', allButtons.length);
        allButtons.forEach((btn, index) => {
            console.log(`${index + 1}. Button ID: "${btn.id}", Class: "${btn.className}", Text: "${btn.textContent.trim()}"`);
        });
    }

    if (memberName && confirmBtn && selectedBooksList) {
        const hasMember = memberName.value.trim() !== '';
        const hasBooks = selectedBooksList.children.length > 0;

        confirmBtn.disabled = !hasMember || !hasBooks;

        // Remove any existing onclick handlers first
        confirmBtn.onclick = null;

        if (!hasMember) {
            confirmBtn.innerHTML = '<i class="fas fa-qrcode"></i> Scan Member';
            confirmBtn.style.backgroundColor = '#9ca3af';
            confirmBtn.style.cursor = 'pointer';
            confirmBtn.style.opacity = '1';
            confirmBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('🔘 Scan Member button clicked - opening QR scanner');
                if (typeof showQRScannerModal === 'function') {
                    showQRScannerModal('member');
                } else if (window.showQRScannerModal) {
                    window.showQRScannerModal('member');
                } else {
                    showToast('QR Scanner not available', 'error');
                }
            };
        } else if (!hasBooks) {
            confirmBtn.innerHTML = '<i class="fas fa-book"></i> Add Books to Borrow';
            confirmBtn.style.backgroundColor = '#9ca3af';
            confirmBtn.style.cursor = 'pointer';
            confirmBtn.style.opacity = '1';
            confirmBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('🔘 Add Books button clicked - opening QR scanner for books');
                if (typeof showQRScannerModal === 'function') {
                    showQRScannerModal('book');
                } else if (window.showQRScannerModal) {
                    window.showQRScannerModal('book');
                } else {
                    showToast('Please select books to borrow first', 'warning');
                }
            };
        } else {
            confirmBtn.innerHTML = '<i class="fas fa-check"></i> Confirm';
            confirmBtn.style.backgroundColor = '#10b981';
            confirmBtn.style.cursor = 'pointer';
            confirmBtn.style.opacity = '1';

            // Set the click handler for final confirmation
            confirmBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('hello'); // Sanity check console output
                console.log('🔘 Confirm button clicked!');
                console.log('📋 Button state:', {
                    hasMember: memberName.value.trim() !== '',
                    hasBooks: selectedBooksList.children.length > 0,
                    memberName: memberName.value,
                    booksCount: selectedBooksList.children.length
                });

                // Call confirmBorrow directly
                if (typeof confirmBorrow === 'function') {
                    console.log('✅ Calling confirmBorrow');
                    confirmBorrow();
                } else if (window.confirmBorrow && typeof window.confirmBorrow === 'function') {
                    console.log('✅ Calling window.confirmBorrow');
                    window.confirmBorrow();
                } else {
                    console.error('❌ confirmBorrow function not found in any scope');
                    showToast('Error: Borrow function not available. Please refresh the page.', 'error');
                }
            };
        }

        console.log('✅ Click handler attached to confirm button');
        console.log('📋 Final button state:', {
            text: confirmBtn.innerHTML,
            disabled: confirmBtn.disabled,
            backgroundColor: confirmBtn.style.backgroundColor,
            hasOnclick: !!confirmBtn.onclick
        });
    } else {
        console.error('❌ Required elements not found for confirm button setup');
        console.log('🔍 Missing elements:', {
            memberName: !memberName,
            confirmBtn: !confirmBtn,
            selectedBooksList: !selectedBooksList
        });
    }
}

function clearMemberInfo() {
    const memberNameField = document.getElementById('memberName');
    const memberIdField = document.getElementById('memberId');

    if (memberNameField) {
        memberNameField.value = '';
        memberNameField.style.backgroundColor = 'var(--surface-elevated)';
        memberNameField.style.cursor = 'not-allowed';
    }

    if (memberIdField) {
        memberIdField.value = '';
    }

    updateConfirmButtonState();
    showToast('Member information cleared', 'info');
}

function removeBookFromSelection(bookId) {
    selectedBooks = selectedBooks.filter(book => book.id != bookId);

    const row = document.querySelector(`tr[data-id="${bookId}"]`);
    if (row) {
        row.classList.remove('selected');
    }

    const listItem = document.querySelector(`#selectedBooksList li[data-id="${bookId}"]`);
    if (listItem) {
        listItem.remove();
    }

    updateConfirmButtonState();
    showToast('Book removed from selection', 'info');
}

// ======================
// SELECTION MODE FUNCTIONS
// ======================

function enterSelectionMode() {
    selectionMode = true;
    document.getElementById('selectionBar')?.style.setProperty('display', 'flex');
    document.body.style.paddingTop = '80px';

    document.querySelectorAll('#booksTableBody tr[data-id]').forEach(row => {
        row.onclick = (e) => {
            if (e.target.closest('.action-buttons') || e.target.closest('.btn')) {
                return;
            }
            toggleRowSelection(row);
        };
        row.style.cursor = 'pointer';
    });
}

function exitSelectionMode() {
    selectionMode = false;
    const bar = document.getElementById('selectionBar');
    if (bar) bar.style.display = 'none';
    document.body.style.paddingTop = '0';

    document.querySelectorAll('#booksTableBody tr[data-id]').forEach(row => {
        row.onclick = null;
        row.style.cursor = '';
    });

    document.querySelectorAll('tr.selected').forEach(row => {
        row.classList.remove('selected');
    });
    selectedBooks = [];
}

function toggleRowSelection(row) {
    const bookId = row.dataset.id;
    const bookTitle = row.dataset.title;

    let parsedBookId;
    try {
        parsedBookId = bookId ? parseInt(bookId, 10) : null;
    } catch (e) {
        console.error('Error parsing book ID:', bookId, e);
        return;
    }

    if (!parsedBookId || isNaN(parsedBookId)) {
        showToast('Error: Invalid book data', 'error');
        return;
    }

    const index = selectedBooks.findIndex(b => b.id === parsedBookId);

    if (index === -1) {
        selectedBooks.push({ id: parsedBookId, title: bookTitle || 'Unknown Title' });
        row.classList.add('selected');
    } else {
        selectedBooks.splice(index, 1);
        row.classList.remove('selected');
    }
}

function selectAllBooks() {
    const visibleRows = document.querySelectorAll('#booksTableBody tr[data-id]:not([style*="display: none"])');
    let newSelections = 0;

    visibleRows.forEach(row => {
        const bookId = row.dataset.id;
        const bookTitle = row.dataset.title;

        let parsedBookId;
        try {
            parsedBookId = bookId ? parseInt(bookId, 10) : null;
        } catch (e) {
            return;
        }

        if (!parsedBookId || isNaN(parsedBookId)) {
            return;
        }

        if (!selectedBooks.find(b => b.id === parsedBookId)) {
            selectedBooks.push({ id: parsedBookId, title: bookTitle || 'Unknown Title' });
            row.classList.add('selected');
            newSelections++;
        }
    });

    if (newSelections > 0) {
        showToast(`Selected ${newSelections} additional book(s)`, 'success');
    } else {
        showToast('All visible books are already selected', 'info');
    }
}

function unselectAllBooks() {
    if (selectedBooks.length === 0) {
        showToast('No books are currently selected', 'info');
        return;
    }

    const previousCount = selectedBooks.length;

    document.querySelectorAll('#booksTableBody tr.selected').forEach(row => {
        row.classList.remove('selected');
    });

    selectedBooks = [];
    showToast(`Unselected ${previousCount} book(s)`, 'info');
}

function deleteSelected() {
    if (selectedBooks.length === 0) {
        showToast('No books selected', 'warning');
        return;
    }

    let booksToProcess = selectedBooks;
    if (selectedBooks.length > 0 && (typeof selectedBooks[0] === 'number' || typeof selectedBooks[0] === 'string')) {
        booksToProcess = selectedBooks.map(id => {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const title = row ? row.dataset.title : 'Unknown Title';
            return { id: id, title: title };
        });
    }

    const validBooks = booksToProcess.filter(book => {
        return book.id && book.id !== 'undefined' && book.id !== '' && !isNaN(book.id);
    });

    if (validBooks.length === 0) {
        showToast('No valid books selected for deletion', 'error');
        return;
    }

    if (validBooks.length === 1) {
        if (typeof window.deleteBook === 'function') {
            window.deleteBook(validBooks[0].id);
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showToast('Delete functionality not available', 'error');
        }
    } else {
        if (confirm(`Delete ${validBooks.length} selected book(s)?`)) {
            selectedBooks.length = 0;
            validBooks.forEach(book => selectedBooks.push(book));
            deleteMultipleBooks();
        }
    }
}

function deleteMultipleBooks() {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    if (!token) {
        showToast('CSRF token missing', 'error');
        return;
    }

    let completed = 0;
    let failed = 0;

    selectedBooks.forEach(book => {
        fetch(`/books/${book.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                completed++;
                const row = document.querySelector(`tr[data-id="${book.id}"]`);
                if (row) row.remove();
            } else {
                failed++;
            }
        })
        .catch(error => {
            console.error(`Delete error for book ${book.id}:`, error);
            failed++;
        });
    });

    setTimeout(() => {
        let message = '';
        if (completed > 0) message += `${completed} book(s) deleted successfully`;
        if (failed > 0) message += `${failed} book(s) failed to delete`;

        showToast(message || 'No books were deleted', completed > 0 ? 'success' : 'error');

        selectedBooks = [];

        if (completed > 0) {
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    }, 1000);
}

function editBook(bookId) {
    if (typeof window.manageBooks === 'function') {
        document.querySelectorAll('tr.selected').forEach(r => r.classList.remove('selected'));
        selectedBooks = [];

        const row = document.querySelector(`tr[data-id="${bookId}"]`);
        if (row) {
            row.classList.add('selected');
            selectedBooks.push({ id: bookId, title: row.dataset.title });
            window.manageBooks();
        } else {
            showToast('Book not found', 'error');
        }
    } else {
        showToast('Edit functionality not available', 'error');
    }
}

// ======================
// QR SCANNER - INTEGRATED IMPLEMENTATION
// ======================

// Global variables for QR scanner
let currentBorrowScanType = null;
let qrScannerInstance = null;
let isQRScanning = false;

// ======================
// QR SCANNER FUNCTIONS - INTEGRATED
// ======================

function initializeQRModalElements() {
    console.log('Initializing QR modal elements...');

    const modal = document.getElementById('qrScannerModal');
    const qrReader = document.getElementById('qr-reader');
    const qrInstruction = document.getElementById('qr-instruction');
    const qrButtons = document.getElementById('qr-buttons');

    if (!modal) {
        console.error('QR Scanner modal not found');
        return false;
    }

    if (!qrReader) {
        console.error('QR reader element not found');
        return false;
    }

    // Initialize modal content if elements are missing
    if (!qrInstruction) {
        const instruction = document.createElement('p');
        instruction.id = 'qr-instruction';
        instruction.style.cssText = 'margin-top: 15px; color: var(--text-secondary); font-size: 0.9rem; text-align: center;';
        instruction.textContent = 'Point your camera at a QR code to scan';
        qrReader.parentNode.appendChild(instruction);
    }

    if (!qrButtons) {
        const buttonsDiv = document.createElement('div');
        buttonsDiv.id = 'qr-buttons';
        buttonsDiv.style.cssText = 'display: flex; gap: 10px; margin-top: 20px; justify-content: center;';

        const cancelBtn = document.createElement('button');
        cancelBtn.type = 'button';
        cancelBtn.className = 'btn btn-outline';
        cancelBtn.style.minWidth = '120px';
        cancelBtn.innerHTML = '<i class="fas fa-times"></i> Cancel';
        cancelBtn.onclick = () => closeQRScanner();

        buttonsDiv.appendChild(cancelBtn);
        qrReader.parentNode.appendChild(buttonsDiv);
    }

    console.log('QR modal elements initialized successfully');
    return true;
}

function startQRScan(type) {
    console.log(`startQRScan called with type: ${type}`);

    if (typeof Html5Qrcode === 'undefined') {
        showToast('QR Scanner library not loaded. Please refresh the page.', 'error');
        return false;
    }

    if (isQRScanning) {
        console.log('QR Scanner already active');
        return false;
    }

    currentBorrowScanType = type;

    try {
        // Initialize modal elements first
        if (!initializeQRModalElements()) {
            showToast('QR Scanner modal not properly initialized', 'error');
            return false;
        }

        const modal = document.getElementById('qrScannerModal');
        const qrReader = document.getElementById('qr-reader');

        if (!modal || !qrReader) {
            showToast('QR Scanner elements not found', 'error');
            return false;
        }

        // Clear previous content
        qrReader.innerHTML = '';

        // Show modal
        modal.classList.add('show');
        modal.style.display = 'flex';
        modal.style.zIndex = '999999';

        // Initialize scanner
        qrScannerInstance = new Html5Qrcode("qr-reader");
        isQRScanning = true;

        updateQRStatus(`Scanning for ${type === 'member' ? 'member' : 'book'}...`);

        qrScannerInstance.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            (decodedText) => onScanSuccess(decodedText),
            (error) => onScanError(error)
        ).catch(handleCameraError);

        console.log('QR Scanner started successfully');
        return true;

    } catch (error) {
        console.error('Error starting QR scanner:', error);
        showToast('Failed to start QR scanner: ' + error.message, 'error');
        return false;
    }
}

function onScanSuccess(decodedText) {
    console.log('QR Code detected:', decodedText);

    if (qrScannerInstance) {
        // Stop the scanner first, then clear after a short delay
        qrScannerInstance.stop()
            .then(() => {
                console.log('Scanner stopped after successful detection');
            })
            .catch(err => {
                console.error('Error stopping scanner after detection:', err);
            })
            .finally(() => {
                // Clear after stopping
                try {
                    qrScannerInstance.clear();
                    console.log('Scanner cleared after successful detection');
                } catch (e) {
                    console.error('Error clearing scanner after detection:', e);
                }
                qrScannerInstance = null;
                isQRScanning = false;
            });
    } else {
        isQRScanning = false;
    }

    if (currentBorrowScanType === 'member') {
        processMemberQR(decodedText);
    } else if (currentBorrowScanType === 'book') {
        processBookQR(decodedText);
    }

    closeQRScannerModal();
}

function onScanError(error) {
    if (error && !error.includes('NotFoundException')) {
        console.debug('QR Scan error:', error);
    }
}

function handleCameraError(error) {
    console.error('Camera error:', error);

    let errorMessage = 'Unable to access camera. ';

    if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
        errorMessage += 'Please allow camera access in your browser settings.';
    } else if (error.name === 'NotFoundError') {
        errorMessage += 'No camera found on this device.';
    } else if (error.name === 'NotReadableError') {
        errorMessage += 'Camera is being used by another application.';
    } else {
        errorMessage += error.message || 'Unknown error occurred.';
    }

    showQRError(errorMessage);
}

function stopQRScan() {
    console.log('Stopping QR scanner...');

    if (qrScannerInstance && isQRScanning) {
        qrScannerInstance.stop()
            .then(() => {
                console.log('QR Scanner stopped successfully');
            })
            .catch(err => {
                console.error('Error stopping QR scanner:', err);
            })
            .finally(() => {
                // Clear after stopping
                try {
                    qrScannerInstance.clear();
                    console.log('Scanner cleared after stopping');
                } catch (e) {
                    console.error('Error clearing scanner after stopping:', e);
                }
                qrScannerInstance = null;
                isQRScanning = false;
                closeQRScannerModal();
            });
    } else {
        isQRScanning = false;
        closeQRScannerModal();
    }
}

function cleanupScannerInstance() {
    console.log('Cleaning up scanner instance...');

    if (qrScannerInstance) {
        try {
            // First stop the scanner if it's still running
            if (isQRScanning) {
                console.log('Stopping scanner before clearing...');
                qrScannerInstance.stop()
                    .then(() => {
                        console.log('Scanner stopped successfully during cleanup');
                    })
                    .catch(err => {
                        console.error('Error stopping scanner during cleanup:', err);
                    })
                    .finally(() => {
                        // Now clear after stopping
                        try {
                            qrScannerInstance.clear();
                            console.log('Scanner instance cleared');
                        } catch (e) {
                            console.error('Error clearing scanner:', e);
                        }
                        qrScannerInstance = null;
                        console.log('Scanner instance set to null');
                        isQRScanning = false;
                        currentBorrowScanType = null;
                    });
            } else {
                // If not scanning, just clear
                qrScannerInstance.clear();
                console.log('Scanner instance cleared');
                qrScannerInstance = null;
                console.log('Scanner instance set to null');
                isQRScanning = false;
                currentBorrowScanType = null;
            }
        } catch (e) {
            console.error('Error during scanner cleanup:', e);
            qrScannerInstance = null;
            isQRScanning = false;
            currentBorrowScanType = null;
        }
    } else {
        // No scanner instance, just reset flags
        isQRScanning = false;
        currentBorrowScanType = null;
    }

    console.log('Scanner cleanup completed');
}

function stopAllMediaTracks() {
    console.log('Stopping all media tracks...');

    // Get all video elements and stop their tracks
    const videos = document.querySelectorAll('video');
    videos.forEach(video => {
        if (video.srcObject) {
            const stream = video.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => {
                console.log('Stopping track:', track.kind, track.label);
                track.stop();
            });
            video.srcObject = null;
        }
    });

    // Also check for any active getUserMedia streams
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        try {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    stream.getTracks().forEach(track => track.stop());
                    console.log('Dummy stream stopped');
                })
                .catch(err => {
                    console.log('Dummy stream approach not needed or failed:', err.message);
                });
        } catch (e) {
            console.error('Error with dummy stream approach:', e);
        }
    }

    console.log('Media tracks cleanup completed');
}

function showQRScannerModal(type) {
    console.log('🔍 Opening QR scanner modal for:', type);
    console.log('🎯 Current z-index values check...');

    const modal = document.getElementById('qrScannerModal');
    if (!modal) {
        console.error('❌ QR Scanner modal not found');
        showToast('QR Scanner modal not found', 'error');
        return;
    }

    // Check current z-index values
    const computedStyle = window.getComputedStyle(modal);
    console.log('📊 Current modal z-index:', computedStyle.zIndex);
    console.log('📊 Current modal display:', computedStyle.display);

    // Store reference to current modal (borrow modal)
    window.previousModal = document.getElementById('borrowModal');

    // Initialize modal elements
    initializeQRModalElements();

    // Clear previous content
    const qrReader = document.getElementById('qr-reader');
    if (qrReader) {
        qrReader.innerHTML = '';
    }

    updateQRStatus('Initializing camera...');

    // Show modal with extreme z-index and proper positioning (ABOVE borrow modal)
    modal.classList.add('show');
    modal.style.display = 'flex';
    modal.style.zIndex = '999999999'; // HIGHEST z-index for QR scanner
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.justifyContent = 'center';
    modal.style.alignItems = 'center';

    // Ensure modal content is also properly positioned
    const modalContent = modal.querySelector('.modal-content');
    if (modalContent) {
        modalContent.style.position = 'relative';
        modalContent.style.zIndex = '999999998';
        modalContent.style.margin = 'auto';
    }

    // Ensure borrow modal has lower z-index
    const borrowModal = document.getElementById('borrowModal');
    if (borrowModal) {
        borrowModal.style.zIndex = '999999900'; // Lower than QR scanner
        console.log('📉 Borrow modal z-index set to:', borrowModal.style.zIndex);
    }

    console.log('✅ QR Scanner modal opened with z-index:', modal.style.zIndex);
    console.log('📍 Modal position:', modal.style.position, modal.style.top, modal.style.left);

    // Start scanning after a short delay
    setTimeout(() => {
        startQRScan(type);
    }, 300);
}

function closeQRScannerModal() {
    console.log('Closing QR scanner modal');

    const modal = document.getElementById('qrScannerModal');
    if (!modal) return;

    // 1. First, ensure scanner is properly stopped (aggressive cleanup)
    if (qrScannerInstance) {
        console.log('Force stopping scanner instance...');
        qrScannerInstance.stop()
            .then(() => {
                console.log('Scanner stopped successfully');
            })
            .catch(err => {
                console.error('Error stopping scanner:', err);
            })
            .finally(() => {
                cleanupScannerInstance();
            });
    } else {
        cleanupScannerInstance();
    }

    // 2. Stop all media tracks
    stopAllMediaTracks();

    // 3. Hide modal immediately
    modal.classList.remove('show');
    modal.style.display = 'none';

    // 4. Clear modal content immediately
    const qrReader = document.getElementById('qr-reader');
    if (qrReader) {
        qrReader.innerHTML = '';
    }

    // 5. Restore previous modal if it was open
    if (window.previousModal && window.previousModal.classList.contains('show')) {
        window.previousModal.style.display = 'flex';
    }

    currentBorrowScanType = null;
    window.previousModal = null;
}

function closeQRScanner() {
    console.log('closeQRScanner called - ensuring proper cleanup');

    // 1. Stop the scanner instance
    if (qrScannerInstance) {
        console.log('Force stopping scanner instance...');
        qrScannerInstance.stop()
            .then(() => {
                console.log('Scanner stopped successfully');
            })
            .catch(err => {
                console.error('Error stopping scanner:', err);
            })
            .finally(() => {
                cleanupScannerInstance();
            });
    } else {
        cleanupScannerInstance();
    }

    // 2. Also aggressively cleanup any running media tracks
    stopAllMediaTracks();

    // 3. Close modal
    closeQRScannerModal();
}

// ======================
// QR SCANNER UTILITY FUNCTIONS
// ======================

function updateQRStatus(message) {
    let status = document.getElementById('qr-status');
    if (!status) {
        // Create status element if it doesn't exist
        const qrReader = document.getElementById('qr-reader');
        if (qrReader) {
            status = document.createElement('p');
            status.id = 'qr-status';
            status.style.cssText = 'text-align: center; color: var(--text-secondary); font-size: 0.9rem; margin-top: 10px;';
            qrReader.parentNode.appendChild(status);
        }
    }

    if (status) {
        status.textContent = message;
        status.style.color = 'var(--text-secondary)';
    }
}

function showQRError(message) {
    const qrReader = document.getElementById('qr-reader');
    const status = document.getElementById('qr-status');

    if (qrReader) {
        qrReader.innerHTML = `
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 300px; padding: 40px;">
                <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: var(--danger); margin-bottom: 20px;"></i>
                <h4 style="color: var(--text-primary); margin-bottom: 10px;">Camera Error</h4>
                <p style="color: var(--text-secondary); text-align: center; max-width: 300px;">${message}</p>
            </div>
        `;
    }

    if (status) {
        status.textContent = 'Camera access failed';
        status.style.color = 'var(--danger)';
    }

    showToast(message, 'error');
    isQRScanning = false;
}

// Force cleanup function for emergency situations
function forceCleanupScanners() {
    console.log('Force cleanup of all scanners...');

    // Reset all global variables
    if (qrScannerInstance) {
        try {
            qrScannerInstance.stop();
            qrScannerInstance.clear();
        } catch (e) {
            console.error('Error during force cleanup:', e);
        }
        qrScannerInstance = null;
    }

    isQRScanning = false;
    currentBorrowScanType = null;

    // Close any open QR scanner modals
    const modal = document.getElementById('qrScannerModal');
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';

        const qrReader = document.getElementById('qr-reader');
        if (qrReader) {
            qrReader.innerHTML = '';
        }
    }

    // Stop all media tracks
    stopAllMediaTracks();

    console.log('Force cleanup completed');
}

// Test function for debugging
function testQRScanner() {
    console.log('Testing QR Scanner...');

    if (typeof Html5Qrcode === 'undefined') {
        showToast('Html5Qrcode library not loaded', 'error');
        return;
    }

    showToast('QR Scanner library is loaded', 'success');

    // Test modal elements
    if (initializeQRModalElements()) {
        showToast('QR Modal elements initialized successfully', 'success');
    } else {
        showToast('Failed to initialize QR modal elements', 'error');
    }
}

function processMemberQR(qrData) {
    console.log('🔍 Processing member QR:', qrData);

    let memberId = null;

    try {
        const url = new URL(qrData);
        const parts = url.pathname.split('/');
        if (parts[1] === 'members' && parts[2]) {
            memberId = parts[2];
        }
    } catch {
        memberId = qrData.split('/').pop();
    }

    console.log('📋 Extracted member ID:', memberId);

    if (!memberId || isNaN(memberId)) {
        showToast('Invalid member QR code format', 'error');
        closeQRScannerModal();
        return;
    }

    fetch(`/members/${memberId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Member not found');
            }
            return response.json();
        })
        .then(member => {
            const nameParts = [
                member.first_name,
                (member.middle_name && member.middle_name !== 'null') ? member.middle_name : null,
                (member.last_name && member.last_name !== 'null') ? member.last_name : null
            ].filter(Boolean);

            const fullName = nameParts.join(' ');

            const memberNameInput = document.getElementById('memberName');
            const memberIdInput = document.getElementById('memberId');

            if (memberNameInput) {
                memberNameInput.value = fullName;
                memberNameInput.style.backgroundColor = 'rgba(16, 185, 129, 0.1)';
                memberNameInput.style.cursor = 'default';
                // Trigger change event to update button state
                memberNameInput.dispatchEvent(new Event('change'));
            }

            if (memberIdInput) {
                memberIdInput.value = member.id;
            }

            // Update button state after member is processed
            updateConfirmButtonState();

            showToast(`Member: ${fullName}`, 'success');
            closeQRScannerModal();
        })
        .catch(error => {
            console.error('Member fetch error:', error);
            showToast('Failed to load member information', 'error');
            closeQRScannerModal();
        });
}

function processBookQR(qrData) {
    console.log('Processing book QR:', qrData);

    let bookId = null;

    try {
        const url = new URL(qrData);
        const parts = url.pathname.split('/');
        if (parts[1] === 'books' && parts[2]) {
            bookId = parts[2];
        }
    } catch {
        const match = qrData.match(/book-(\d+)/);
        if (match) {
            bookId = match[1];
        } else {
            bookId = qrData.split('/').pop();
        }
    }

    if (!bookId || isNaN(bookId)) {
        showToast('Invalid book QR code', 'error');
        closeQRScannerModal();
        return;
    }

    const row = document.querySelector(`tr[data-id="${bookId}"]`);

    if (!row) {
        showToast('Book not found in library', 'error');
        closeQRScannerModal();
        return;
    }

    const availability = parseInt(row.dataset.availability);
    if (isNaN(availability) || availability <= 0) {
        showToast('Book is not available', 'warning');
        closeQRScannerModal();
        return;
    }

    const title = row.dataset.title;
    const alreadySelected = selectedBooks.some(book => book.id == bookId);

    if (alreadySelected) {
        showToast('Book already selected', 'warning');
        closeQRScannerModal();
        return;
    }

    selectedBooks.push({ id: bookId, title: title });
    row.classList.add('selected');

    const list = document.getElementById('selectedBooksList');
    if (list) {
        const li = document.createElement('li');
        li.textContent = title;
        li.setAttribute('data-id', bookId);
        li.style.padding = '8px 0';
        li.style.borderBottom = '1px solid var(--border-light)';

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.className = 'btn btn-sm btn-danger';
        removeBtn.style.marginLeft = '10px';
        removeBtn.style.padding = '4px 8px';
        removeBtn.onclick = () => removeBookFromSelection(bookId);

        li.appendChild(removeBtn);
        list.appendChild(li);
    }

    updateConfirmButtonState();

    showToast(`Added: ${title}`, 'success');
    closeQRScannerModal();
}

// ======================
// EXPORT FUNCTIONS - CONSOLIDATED BORROW SYSTEM
// ======================

// Core borrow functions
window.borrowOne = borrowOne;
window.openBorrowModal = openBorrowModal;
window.closeBorrowModal = closeBorrowModal;
window.confirmBorrow = confirmBorrow;
window.clearMemberInfo = clearMemberInfo;
window.removeBookFromSelection = removeBookFromSelection;
window.updateConfirmButtonState = updateConfirmButtonState;

// Selection mode functions
window.enterSelectionMode = enterSelectionMode;
window.exitSelectionMode = exitSelectionMode;
window.selectAllBooks = selectAllBooks;
window.unselectAllBooks = unselectAllBooks;
window.deleteSelected = deleteSelected;
window.editBook = editBook;

// Toast notifications
window.showToast = showToast;

// QR Scanner functions
window.startQRScan = startQRScan;
window.stopQRScan = stopQRScan;
window.showQRScannerModal = showQRScannerModal;
window.closeQRScannerModal = closeQRScannerModal;
window.closeQRScanner = closeQRScanner;
window.testQRScanner = testQRScanner;
window.forceCleanupScanners = forceCleanupScanners;
window.stopAllMediaTracks = stopAllMediaTracks;
window.cleanupScannerInstance = cleanupScannerInstance;
window.processMemberQR = processMemberQR;
window.processBookQR = processBookQR;
window.initializeQRModalElements = initializeQRModalElements;

// BookAdd QR Scanner functions (imported from bookadd.js)
window.startQRScanBookAdd = startQRScanBookAdd;
window.stopQRScanBookAdd = stopQRScanBookAdd;

// Debug functions
window.debugTimeComparison = debugTimeComparison;
window.debugDateCalculation = debugDateCalculation;
window.testConfirmBorrow = testConfirmBorrow;
window.testConfirmButton = testConfirmButton;
window.forceTestConfirmButton = forceTestConfirmButton;
window.checkBorrowSystem = checkBorrowSystem;

// Debug function to compare server vs client time
window.debugTimeComparison = function() {
    console.log('🔍 SERVER vs CLIENT TIME COMPARISON');
    console.log('===================================');

    // Client-side JavaScript time
    const clientTime = new Date();
    const philippineTime = new Date(clientTime.toLocaleString("en-US", {timeZone: "Asia/Manila"}));

    console.log('💻 Client-side time:');
    console.log('  - UTC:', clientTime.toISOString());
    console.log('  - Local:', clientTime.toLocaleString());
    console.log('  - Philippine:', philippineTime.toISOString());
    console.log('  - Philippine Local:', philippineTime.toLocaleString('en-US', {timeZone: 'Asia/Manila'}));

    // Make a request to get server time
    fetch('/debug/time', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('🖥️  Server-side time:');
        console.log('  - Server time:', data.server_time);
        console.log('  - Server timezone:', data.timezone);
        console.log('  - Laravel time:', data.laravel_time);

        const serverDate = new Date(data.server_time);
        const clientDate = new Date();

        console.log('📊 Time difference:');
        console.log('  - Server date:', serverDate.toISOString().split('T')[0]);
        console.log('  - Client date:', clientDate.toISOString().split('T')[0]);

        if (serverDate.toISOString().split('T')[0] !== clientDate.toISOString().split('T')[0]) {
            console.log('⚠️  WARNING: Server and client dates do not match!');
            console.log('   This could cause the "way too off" date calculation issue.');
        } else {
            console.log('✅ Server and client dates match - timezone is configured correctly.');
        }
    })
    .catch(error => {
        console.log('❌ Could not fetch server time:', error.message);
        console.log('💡 Try running this on a page with server-side processing');
    });
};

// Debug function to manually test date calculation
window.debugDateCalculation = function() {
    console.log('🔧 MANUAL DATE CALCULATION DEBUG');
    console.log('================================');

    // Use Philippine timezone directly (this is more reliable)
    const now = new Date();
    const philippineTime = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Manila"}));

    console.log('🌐 Current UTC time:', now.toISOString());
    console.log('🇵🇭 Current Philippine time:', philippineTime.toISOString());

    // Start from current date (including today if it's a working day)
    const startDate = new Date(philippineTime);

    console.log('📅 Start date (current date, including today):', startDate.toISOString().split('T')[0]);

    // Philippine holidays for 2025
    const philippineHolidays = [
        '2025-01-01', '2025-02-25', '2025-04-17', '2025-04-18', '2025-04-19',
        '2025-05-01', '2025-06-12', '2025-08-25', '2025-11-01', '2025-11-30',
        '2025-12-25', '2025-12-30', '2025-12-31'
    ];

    console.log('🏖️  Philippine holidays in 2025:', philippineHolidays);

    // Calculate 10 working days (including today if it's a working day)
    let workingDaysCount = 0;
    let currentDate = new Date(startDate);
    const workingDates = [];

    while (workingDaysCount < 10) {
        const dayOfWeek = currentDate.getDay();
        const dateString = currentDate.toISOString().split('T')[0];
        const isHoliday = philippineHolidays.includes(dateString);

        if (dayOfWeek >= 1 && dayOfWeek <= 5 && !isHoliday) {
            workingDaysCount++;
            workingDates.push(new Date(currentDate));
            console.log(`${workingDaysCount}. ✅ ${dateString} (Working day)`);
        } else {
            console.log(`   ❌ ${dateString} (${dayOfWeek === 0 ? 'Sunday' : dayOfWeek === 6 ? 'Saturday' : 'Holiday'})`);
        }

        // Move to next day
        currentDate.setDate(currentDate.getDate() + 1);
    }

    console.log('🎯 Final due date:', currentDate.toISOString().split('T')[0]);
    console.log('📅 Available working dates:', workingDates.map(d => d.toISOString().split('T')[0]));

    return {
        currentPhilippineTime: philippineTime,
        startDate: startDate,
        finalDueDate: currentDate,
        workingDates: workingDates
    };
};

// Debug function to compare server vs client time

// Legacy compatibility
window.openQRScanner = showQRScannerModal;

// ======================
// FUNCTIONS IMPORTED FROM BOOKADD.JS
// ======================

// QR Scanner variables (moved from bookadd.js)
let qrScanner = null;

// QR Scanner functions (moved from bookadd.js)
function startQRScanBookAdd(type) {
  const modal = document.getElementById('qrScannerModal');
  if (modal) {
    modal.classList.add('show');
    modal.style.display = 'flex';
  }

  qrScanner = new Html5Qrcode("qr-reader");

  qrScanner.start(
    { facingMode: "environment" },
    { fps: 10, qrbox: 250 },
    async (decodedText) => {
      console.log('🎯 QR Code detected:', decodedText);
      console.log('🔄 Stopping scanner and closing modal...');

      // Stop scanner first
      if (qrScanner) {
        try {
          await qrScanner.stop();
          console.log('✅ Scanner stopped');
        } catch (err) {
          console.error('❌ Error stopping scanner:', err);
        } finally {
          // Clear after stopping
          try {
            qrScanner.clear();
            console.log('✅ Scanner cleared');
          } catch (e) {
            console.error('❌ Error clearing scanner:', e);
          }
          qrScanner = null;
        }
      }

      // Close modal immediately
      const modal = document.getElementById('qrScannerModal');
      if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        console.log('✅ qrScannerModal closed');
      } else {
        console.error('❌ qrScannerModal element not found');
      }

      if (type === 'member') {
        try {
          // Extract member ID from QR code URL (e.g., http://localhost:8000/members/1)
          let memberId = null;
          try {
            const url = new URL(decodedText);
            const parts = url.pathname.split('/');
            if (parts[1] === 'members' && parts[2]) {
              memberId = parts[2];
            }
          } catch {
            memberId = decodedText.split('/').pop();
          }

          if (!memberId || isNaN(memberId)) {
            showToast("Invalid member QR code format", 'error');
            return;
          }

          console.log('📋 Extracted member ID:', memberId);

          // Use the existing web route /members/{id}
          const res = await fetch(`/members/${memberId}`);
          const member = await res.json();

          if (member && member.id) {
            // Build full name from member data
            const nameParts = [
              member.first_name,
              (member.middle_name && member.middle_name !== 'null') ? member.middle_name : null,
              (member.last_name && member.last_name !== 'null') ? member.last_name : null
            ].filter(Boolean);

            const fullName = nameParts.join(' ');

            document.getElementById('memberName').value = fullName;
            document.getElementById('memberId').value = member.id;
            showToast(`✅ Member: ${fullName}`, 'success');

            // Close QR scanner modal immediately after successful scan
            stopQRScanBookAdd();
          } else {
            showToast("❌ Member not found", 'error');
          }
        } catch (err) {
          console.error('Error fetching member:', err);
          showToast("❌ Error fetching member", 'error');
        }
      } else if (type === 'book') {
        try {
          // Extract book ID from QR code URL (e.g., http://localhost:8000/books/1)
          let bookId = null;
          try {
            const url = new URL(decodedText);
            const parts = url.pathname.split('/');
            if (parts[1] === 'books' && parts[2]) {
              bookId = parts[2];
            }
          } catch {
            // Handle different QR code formats
            const match = decodedText.match(/book-(\d+)/);
            if (match) {
              bookId = match[1];
            } else {
              bookId = decodedText.split('/').pop();
            }
          }

          if (!bookId || isNaN(bookId)) {
            showToast("❌ Invalid book QR code format", 'error');
            return;
          }

          console.log('📚 Extracted book ID:', bookId);

          // Find the book row in the table
          const bookRow = document.querySelector(`tr[data-id="${bookId}"]`);
          if (!bookRow) {
            showToast("❌ Book not found in library", 'error');
            return;
          }

          // Check if book is already selected (prevent duplication)
          const existingSelection = document.querySelector(`#selectedBooksList li[data-id="${bookId}"]`);
          if (existingSelection) {
            showToast("⚠️ Book already selected", 'warning');
            stopQRScanBookAdd();
            return;
          }

          // Check book availability
          const availability = parseInt(bookRow.dataset.availability);
          if (isNaN(availability) || availability <= 0) {
            showToast("❌ Book is not available", 'error');
            return;
          }

          // Get book title
          const bookTitle = bookRow.dataset.title || 'Unknown Title';

          // Add book to selection visually
          const selectedBooksList = document.getElementById('selectedBooksList');
          if (selectedBooksList) {
            const li = document.createElement('li');
            li.textContent = bookTitle;
            li.setAttribute('data-id', bookId);
            li.style.cssText = 'padding: 8px 0; border-bottom: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;';

            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.className = 'btn btn-sm btn-danger';
            removeBtn.style.cssText = 'margin-left: 10px; padding: 4px 8px;';
            removeBtn.onclick = () => {
              li.remove();
              bookRow.classList.remove('selected');
              updateConfirmButtonState();
            };

            li.appendChild(removeBtn);
            selectedBooksList.appendChild(li);
          }

          // Mark book as selected in the table
          bookRow.classList.add('selected');

          showToast(`✅ Added: ${bookTitle}`, 'success');

          // Update confirm button state
          updateConfirmButtonState();

          // Close QR scanner modal immediately after successful scan
          stopQRScanBookAdd();

        } catch (err) {
          console.error('Error processing book QR:', err);
          showToast("❌ Error processing book", 'error');
        }
      }
    },
    error => {
      // Ignore minor scan errors
    }
  ).catch(err => {
    console.error("QR Scanner failed:", err);
    showToast("Failed to start camera.", 'error');
    stopQRScanBookAdd();
  });
}

function stopQRScanBookAdd() {
  console.log('🛑 Stopping QR scanner...');

  // First, immediately close the modal
  const modal = document.getElementById('qrScannerModal');
  if (modal) {
    modal.classList.remove('show');
    modal.style.display = 'none';
    console.log('✅ qrScannerModal closed immediately');
  } else {
    console.error('❌ qrScannerModal element not found');
  }

  // Then try to stop the scanner instance if it exists
  if (qrScanner) {
    qrScanner.stop().then(() => {
      console.log('✅ QR Scanner stopped successfully');
    }).catch(err => {
      console.error('❌ Error stopping QR scanner:', err);
    }).finally(() => {
      // Clear after stopping
      try {
        qrScanner.clear();
        console.log('✅ Scanner cleared after stopping');
      } catch (e) {
        console.error('❌ Error clearing scanner after stopping:', e);
      }
      qrScanner = null;
    });
  } else {
    console.log('ℹ️ No QR scanner instance to stop');
  }
}

// Export the bookadd versions for backward compatibility
window.startQRScanBookAdd = startQRScanBookAdd;
window.stopQRScanBookAdd = stopQRScanBookAdd;
>>>>>>> Stashed changes
