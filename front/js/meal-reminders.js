
/**
 * LifeEats - Meal Reminder JavaScript
 * Handles displaying and managing meal reminders
 */

// Global variables
let userHasSelectedMeals = false;

document.addEventListener('DOMContentLoaded', function() {
    // Check if reminder alert exists on page
    const reminderAlert = document.getElementById('reminder-alert');
    
    if (reminderAlert) {
        // Check if user needs a reminder
        checkMealReminders();
    }
    
    // Populate meal selection grid if on homepage
    const mealsContainer = document.getElementById('meals-container');
    if (mealsContainer) {
        loadAvailableMeals();
    }
    
    // Add event listeners to meal filter buttons
    const filterButtons = document.querySelectorAll('.meal-filters button');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            filterMeals(filter);
            
            // Update active class
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
});

/**
 * Check if the user needs a meal reminder
 */
function checkMealReminders() {
    const reminderAlert = document.getElementById('reminder-alert');
    
    // In a real app, this would check via API if the user has selected meals
    // For demo purposes, we'll use localStorage or simulate it
    
    try {
        // Check localStorage for previous selections
        userHasSelectedMeals = localStorage.getItem('mealSelections') !== null;
        
        // If user has not selected meals, show reminder
        if (!userHasSelectedMeals) {
            reminderAlert.style.display = 'block';
            
            // Add event listener to close button
            const closeButton = reminderAlert.querySelector('.btn-close');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    reminderAlert.style.display = 'none';
                });
            }
        }
    } catch (error) {
        console.error('Error checking meal reminders:', error);
    }
}

/**
 * Send reminder API request
 */
async function sendMealReminder() {
    try {
        const response = await axios.post(`${API_BASE_URL}/reminders/send`);
        
        // Check if successful
        if (response.data && response.data.success) {
            showToast('Meal reminders sent successfully!', 'success');
        } else {
            throw new Error('Failed to send reminders');
        }
    } catch (error) {
        console.error('Error sending meal reminders:', error);
        showToast('Unable to send meal reminders. Please try again.', 'error');
    }
}

/**
 * Load available meals and display in grid
 */
async function loadAvailableMeals() {
    const mealsContainer = document.getElementById('meals-container');
    
    if (!mealsContainer) return;
    
    // Show loading state
    mealsContainer.innerHTML = `
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading meals...</p>
        </div>
    `;
    
    try {
        // In a real app, this would fetch from API
        // For demo, we'll use placeholder meals
        setTimeout(() => {
            displayMeals(getSampleMeals());
        }, 1000);
    } catch (error) {
        console.error('Error loading meals:', error);
        mealsContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Unable to load available meals. Please try again later.
                </div>
            </div>
        `;
    }
}

/**
 * Display meals in the grid
 * @param {Array} meals - Array of meal objects
 */
function displayMeals(meals) {
    const mealsContainer = document.getElementById('meals-container');
    
    if (!mealsContainer) return;
    
    // Clear container
    mealsContainer.innerHTML = '';
    
    if (meals.length === 0) {
        mealsContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No meals available matching your filter.
                </div>
            </div>
        `;
        return;
    }
    
    // Add meals to container
    meals.forEach(meal => {
        const mealElement = document.createElement('div');
        mealElement.className = 'col-lg-4 col-md-6';
        mealElement.setAttribute('data-meal-tags', meal.tags.join(' '));
        
        mealElement.innerHTML = `
            <div class="card h-100 border-0 shadow-sm">
                <div class="meal-image-container">
                    <img src="${meal.image}" class="card-img-top" alt="${meal.name}">
                    <div class="meal-badges">
                        ${meal.tags.map(tag => `<span class="badge bg-${getMealTagColor(tag)}">${tag}</span>`).join(' ')}
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h3 class="card-title h5 fw-bold mb-0">${meal.name}</h3>
                        <span class="meal-calories badge bg-light text-dark">${meal.calories} cal</span>
                    </div>
                    <p class="card-text">${meal.description}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">Prep time: ${meal.prepTime} min</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="meal-${meal.id}" data-meal-id="${meal.id}">
                            <label class="form-check-label" for="meal-${meal.id}">Select</label>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        mealsContainer.appendChild(mealElement);
    });
    
    // Add event listeners to meal selection checkboxes
    const mealCheckboxes = document.querySelectorAll('.form-check-input[data-meal-id]');
    mealCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const mealId = this.getAttribute('data-meal-id');
            updateMealSelection(mealId, this.checked);
        });
    });
}

/**
 * Filter meals by tag
 * @param {string} filter - Tag to filter by
 */
function filterMeals(filter) {
    const mealItems = document.querySelectorAll('[data-meal-tags]');
    
    mealItems.forEach(item => {
        const tags = item.getAttribute('data-meal-tags');
        
        if (filter === 'all' || tags.includes(filter)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

/**
 * Update meal selection in local storage
 * @param {string} mealId - ID of the meal
 * @param {boolean} selected - Whether the meal is selected
 */
function updateMealSelection(mealId, selected) {
    try {
        // Get current selections from localStorage
        let selections = JSON.parse(localStorage.getItem('mealSelections')) || {};
        
        // Update selection
        if (selected) {
            selections[mealId] = true;
        } else {
            delete selections[mealId];
        }
        
        // Save to localStorage
        localStorage.setItem('mealSelections', JSON.stringify(selections));
        
        // Update user status
        userHasSelectedMeals = Object.keys(selections).length > 0;
        
        // Hide reminder if user has selected meals
        if (userHasSelectedMeals) {
            const reminderAlert = document.getElementById('reminder-alert');
            if (reminderAlert) {
                reminderAlert.style.display = 'none';
            }
        }
        
        // Show confirmation toast
        if (selected) {
            showToast('Meal added to your selections', 'success');
        } else {
            showToast('Meal removed from your selections', 'info');
        }
    } catch (error) {
        console.error('Error updating meal selection:', error);
        showToast('Unable to update meal selection', 'error');
    }
}

/**
 * Get color for meal tag
 * @param {string} tag - Meal tag
 * @returns {string} Bootstrap color class
 */
function getMealTagColor(tag) {
    switch (tag.toLowerCase()) {
        case 'vegetarian':
            return 'success';
        case 'keto':
            return 'primary';
        case 'lowcal':
            return 'info';
        case 'glutenfree':
            return 'warning';
        case 'dairyfree':
            return 'secondary';
        default:
            return 'light text-dark';
    }
}

/**
 * Get sample meals for demo
 * @returns {Array} Sample meal objects
 */
function getSampleMeals() {
    return [
        {
            id: '1',
            name: 'Grilled Salmon Bowl',
            description: 'Wild-caught salmon with quinoa, roasted vegetables, and lemon herb sauce.',
            calories: 520,
            prepTime: 25,
            tags: ['keto', 'glutenfree'],
            image: './img/image.png'
        },
        {
            id: '2',
            name: 'Mediterranean Veggie Bowl',
            description: 'Falafel with hummus, tabbouleh, olives, and tahini dressing.',
            calories: 480,
            prepTime: 20,
            tags: ['vegetarian', 'lowcal'],
            image: './img/image.png'
        },
        {
            id: '3',
            name: 'Thai Chicken Curry',
            description: 'Free-range chicken with coconut curry sauce, bamboo shoots, and jasmine rice.',
            calories: 590,
            prepTime: 30,
            tags: ['glutenfree', 'dairyfree'],
            image: './img/image.png'
        },
        {
            id: '4',
            name: 'Black Bean Burrito Bowl',
            description: 'Seasoned black beans, brown rice, guacamole, corn salsa, and lime crema.',
            calories: 450,
            prepTime: 15,
            tags: ['vegetarian', 'lowcal'],
            image: './img/image.png'
        },
        {
            id: '5',
            name: 'Steak & Sweet Potato',
            description: 'Grass-fed steak with roasted sweet potatoes and garlic green beans.',
            calories: 620,
            prepTime: 35,
            tags: ['keto', 'glutenfree'],
            image: './img/image.png'
        },
        {
            id: '6',
            name: 'Tofu Stir Fry',
            description: 'Organic tofu with mixed vegetables in a ginger-soy sauce over brown rice.',
            calories: 420,
            prepTime: 20,
            tags: ['vegetarian', 'lowcal', 'dairyfree'],
            image: './img/image.png'
        }
    ];
}