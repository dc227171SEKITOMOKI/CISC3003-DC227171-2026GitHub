/* add code here  */

// ==========================================
// PART 1: Core Form Validation & Highlighting
// ==========================================
window.addEventListener('load', function() {
    
    // 1. Handle the highlight effect when gaining and losing focus
    const hilightableElements = document.querySelectorAll('.hilightable');
    
    hilightableElements.forEach(function(element) {
        // Add the 'highlight' class on focus
        element.addEventListener('focus', function(e) {
            e.target.classList.add('highlight');
        });
        
        // Remove the 'highlight' class on blur
        element.addEventListener('blur', function(e) {
            e.target.classList.remove('highlight');
        });
    });

    // 2. Handle non-empty validation upon form submission
    const form = document.getElementById('mainForm');
    const requiredElements = document.querySelectorAll('.required');

    form.addEventListener('submit', function(e) {
        let hasError = false;

        requiredElements.forEach(function(element) {
            // If a required field is empty (after trimming leading/trailing spaces)
            if (element.value.trim() === '') {
                element.classList.add('error');
                hasError = true;
            } else {
                element.classList.remove('error');
            }
        });

        // If there are errors, prevent form submission
        if (hasError) {
            e.preventDefault();
        }
    });

    // 3. Remove the error styling when the content of a required field changes
    requiredElements.forEach(function(element) {
        // Using the 'input' event allows real-time removal of error styling as the user types
        element.addEventListener('input', function(e) {
            if (e.target.value.trim() !== '') {
                e.target.classList.remove('error');
            }
        });
    });
});


// ==========================================
// PART 2: Test-Driver Automation
// ==========================================
window.addEventListener('load', function() {
    
    // Using setTimeout to add a delay so you can clearly see the automated test process after the page loads.

    // Corresponds to Requirement 2: Programmatically focus on field "Description"
    setTimeout(function() {
        console.log("Test-driver: Automatically focusing on the Description field...");
        const descriptionField = document.getElementById('description');
        if (descriptionField) {
            // Programmatically trigger focus; the core code above will automatically add a yellow highlight background to it.
            descriptionField.focus(); 
        }
    }, 1000); // Executes 1 second after page load

    // Corresponds to Requirement 3: Programmatically error on empty fields ("Title", "Description", "Year")
    setTimeout(function() {
        console.log("Test-driver: Automatically submitting empty form...");
        const form = document.getElementById('mainForm');
        if (form) {
            // Programmatically dispatch a submit event; the core code above will intercept the submission and add the red exclamation mark error styling.
            form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
        }
    }, 3500); // Executes 3.5 seconds after page load
});