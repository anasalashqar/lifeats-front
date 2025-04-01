/**
 * LifeEats - FAQ JavaScript
 * Handles loading and displaying FAQs
 */

// Global variables
let allFaqs = [];
let currentCategory = 'all';

document.addEventListener('DOMContentLoaded', function() {
    // Load FAQs
    loadFAQs();
    
    // Add event listeners to category cards
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            filterFAQsByCategory(category);
            
            // Update active category
            categoryCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Add event listener to search input
    const searchInput = document.getElementById('faq-search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            searchFAQs(this.value);
        });
    }
});

/**
 * Load FAQs from API
 */
async function loadFAQs() {
    // Show loading indicator
    const loadingIndicator = document.getElementById('faq-loading');
    const errorAlert = document.getElementById('faq-error');
    const accordionContainer = document.getElementById('faqAccordion');
    
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }
    
    if (errorAlert) {
        errorAlert.style.display = 'none';
    }
    
    try {
        // Fetch FAQs from API
        const response = await axios.get(`${API_BASE_URL}/faqs`);
        
        // Check if response is valid
        if (response.data && response.data.data) {
            allFaqs = response.data.data;
            displayFAQs(allFaqs);
        } else {
            throw new Error('Invalid response format');
        }
    } catch (error) {
        // Handle error
        console.error('Error loading FAQs:', error);
        
        if (errorAlert) {
            const errorMessageElem = document.getElementById('faq-error-message');
            if (errorMessageElem) {
                errorMessageElem.textContent = handleApiError(error);
            }
            errorAlert.style.display = 'block';
        }
        
        // Display placeholder FAQs if API fails
        displayPlaceholderFAQs();
    } finally {
        // Hide loading indicator
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
    }
}

/**
 * Display FAQs in the accordion
 * @param {Array} faqs - Array of FAQ objects
 */
function displayFAQs(faqs) {
    const accordionContainer = document.getElementById('faqAccordion');
    
    if (!accordionContainer) return;
    
    // Clear existing FAQs
    accordionContainer.innerHTML = '';
    
    if (faqs.length === 0) {
        accordionContainer.innerHTML = `
            <div class="text-center py-4">
                <p class="mb-0">No FAQs found matching your criteria.</p>
            </div>
        `;
        return;
    }
    
    // Add FAQs to accordion
    faqs.forEach((faq, index) => {
        const isFirst = index === 0;
        const faqItem = document.createElement('div');
        faqItem.className = 'accordion-item border-0 shadow-sm mb-3';
        faqItem.innerHTML = `
            <h2 class="accordion-header" id="heading${index}">
                <button class="accordion-button ${isFirst ? '' : 'collapsed'}" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#collapse${index}" aria-expanded="${isFirst}" aria-controls="collapse${index}">
                    ${faq.question}
                </button>
            </h2>
            <div id="collapse${index}" class="accordion-collapse collapse ${isFirst ? 'show' : ''}" 
                 aria-labelledby="heading${index}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    ${faq.answer}
                </div>
            </div>
        `;
        accordionContainer.appendChild(faqItem);
    });
}

/**
 * Filter FAQs by category
 * @param {string} category - Category to filter by
 */
function filterFAQsByCategory(category) {
    currentCategory = category;
    
    if (category === 'all') {
        displayFAQs(allFaqs);
    } else {
        // In a real implementation, FAQs would have a category property
        // For now, we'll simulate filtering
        const filtered = allFaqs.filter((faq, index) => {
            // Simulate categories based on index for demo purposes
            if (category === 'general') return index % 4 === 0;
            if (category === 'meals') return index % 4 === 1;
            if (category === 'delivery') return index % 4 === 2;
            if (category === 'account') return index % 4 === 3;
            return false;
        });
        
        displayFAQs(filtered);
    }
}

/**
 * Search FAQs by keyword
 * @param {string} keyword - Search term
 */
function searchFAQs(keyword) {
    if (!keyword.trim()) {
        // If search is empty, show all FAQs or filtered by current category
        filterFAQsByCategory(currentCategory);
        return;
    }
    
    // Filter FAQs by keyword in question or answer
    const searchTerm = keyword.toLowerCase().trim();
    let filtered = allFaqs.filter(faq => 
        faq.question.toLowerCase().includes(searchTerm) || 
        faq.answer.toLowerCase().includes(searchTerm)
    );
    
    // Apply category filter if not 'all'
    if (currentCategory !== 'all') {
        filtered = filtered.filter((faq, index) => {
            // Simulate categories based on index for demo purposes
            if (currentCategory === 'general') return index % 4 === 0;
            if (currentCategory === 'meals') return index % 4 === 1;
            if (currentCategory === 'delivery') return index % 4 === 2;
            if (currentCategory === 'account') return index % 4 === 3;
            return false;
        });
    }
    
    displayFAQs(filtered);
}

/**
 * Display placeholder FAQs if API fails
 */
function displayPlaceholderFAQs() {
    const placeholderFaqs = [
        {
            question: 'How do I pick my meals?',
            answer: 'You can select your meals from our weekly menu through your account dashboard. We offer various options to fit different dietary preferences.'
        },
        {
            question: 'What time are meal reminders sent?',
            answer: 'Meal reminders are sent based on your preference settings. You can customize the timing in your profile settings.'
        },
        {
            question: 'Can I change my meal selection after ordering?',
            answer: 'Yes, you can modify your meal selection up to 48 hours before your scheduled delivery date.'
        },
        {
            question: 'Do you offer vegetarian options?',
            answer: 'Yes, we offer various vegetarian and plant-based meal options every week.'
        },
        {
            question: 'How do I contact customer support?',
            answer: 'You can contact our customer support team through the Contact Us page, or by emailing support@lifeats.com.'
        }
    ];
    
    allFaqs = placeholderFaqs;
    displayFAQs(placeholderFaqs);
}