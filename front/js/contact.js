/**
 * LifeEats - Contact Form JavaScript
 * Handles the contact form submission and validation
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get contact form element
    const contactForm = document.getElementById('contactForm');
    
    // If contact form exists, add event listener
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactFormSubmission);
    }
});

/**
 * Handle contact form submission
 * @param {Event} event - Form submission event
 */
async function handleContactFormSubmission(event) {
    event.preventDefault();
    
    // Get form elements
    const form = event.target;
    const submitButton = form.querySelector('#submitButton');
    const submitText = submitButton.querySelector('.submit-text');
    const submitSpinner = form.querySelector('#submitSpinner');
    const successAlert = document.getElementById('contact-success');
    const errorAlert = document.getElementById('contact-error');
    const errorMessage = document.getElementById('contact-error-message');
    
    // Get form data
    const formData = {
        name: form.querySelector('#name').value.trim(),
        email: form.querySelector('#email').value.trim(),
        message: form.querySelector('#message').value.trim()
    };
    
    // Add subject if provided
    const subject = form.querySelector('#subject').value.trim();
    if (subject) {
        formData.subject = subject;
    }
    
    // Validate form data
    if (!formData.name) {
        showError('Please enter your name.');
        return;
    }
    
    if (!formData.email || !validateEmail(formData.email)) {
        showError('Please enter a valid email address.');
        return;
    }
    
    if (!formData.message) {
        showError('Please enter your message.');
        return;
    }
    
    // Show loading state
    submitButton.disabled = true;
    submitSpinner.classList.remove('d-none');
    submitText.textContent = 'Sending...';
    
    // Hide any existing alerts
    successAlert.style.display = 'none';
    errorAlert.style.display = 'none';
    
    try {
        // Send data to API
        const response = await axios.post(`${API_BASE_URL}/support/contact`, formData);
        
        // Handle successful submission
        successAlert.style.display = 'block';
        form.reset();
        
        // Scroll to success message
        successAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
    } catch (error) {
        // Handle error
        let errorMsg = handleApiError(error);
        showError(errorMsg);
        
        // Scroll to error message
        errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } finally {
        // Reset button state
        submitButton.disabled = false;
        submitSpinner.classList.add('d-none');
        submitText.textContent = 'Send Message';
    }
    
    /**
     * Show error message
     * @param {string} message - Error message to display
     */
    function showError(message) {
        errorMessage.textContent = message;
        errorAlert.style.display = 'block';
    }
}