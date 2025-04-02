/**
 * LifeEats - Blog JavaScript
 * Handles loading and displaying blog posts
 */

// Global variables
let allBlogPosts = [];
let currentPage = 1;
const postsPerPage = 6;
let totalPosts = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Load initial blog posts
    loadBlogPosts();
    
    // Add event listener to search input
    const searchInput = document.getElementById('blog-search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            debounce(searchBlogPosts, 500)(this.value);
        });
    }
    
    // Add event listener to load more button
    const loadMoreButton = document.getElementById('load-more-posts');
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', loadMorePosts);
    }
});

/**
 * Load blog posts from API
 */
async function loadBlogPosts() {
    // Show loading indicator
    const loadingIndicator = document.getElementById('blog-loading');
    const errorAlert = document.getElementById('blog-error');
    const postsContainer = document.getElementById('blog-posts-container');
    const loadMoreButton = document.getElementById('load-more-posts');
    
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }
    
    if (errorAlert) {
        errorAlert.style.display = 'none';
    }
    
    if (loadMoreButton) {
        loadMoreButton.disabled = true;
    }
    
    try {
        // Fetch blog posts from API
        const response = await axios.get(`${API_BASE_URL}/blog`);
        
        // Check if response is valid
        if (response.data && response.data.data) {
            allBlogPosts = response.data.data;
            totalPosts = allBlogPosts.length;
            
            // Display first page of posts
            displayBlogPosts(allBlogPosts.slice(0, postsPerPage));
            
            // Update load more button visibility
            updateLoadMoreButton();
        } else {
            throw new Error('Invalid response format');
        }
    } catch (error) {
        // Handle error
        console.error('Error loading blog posts:', error);
        
        if (errorAlert) {
            const errorMessageElem = document.getElementById('blog-error-message');
            if (errorMessageElem) {
                errorMessageElem.textContent = handleApiError(error);
            }
            errorAlert.style.display = 'block';
        }
        
        // Display placeholder blog posts if API fails
        displayPlaceholderBlogPosts();
    } finally {
        // Hide loading indicator
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
        
        // Enable load more button
        if (loadMoreButton) {
            loadMoreButton.disabled = false;
        }
    }
}

/**
 * Display blog posts in the grid
 * @param {Array} posts - Array of blog post objects
 * @param {boolean} append - Whether to append to existing posts or replace them
 */
function displayBlogPosts(posts, append = false) {
    const postsContainer = document.getElementById('blog-posts-container');
    
    if (!postsContainer) return;
    
    // Clear existing posts if not appending
    if (!append) {
        postsContainer.innerHTML = '';
    }
    
    if (posts.length === 0 && !append) {
        // Instead of showing "No posts found", display default posts
        displayPlaceholderBlogPosts();
        return;
    }
    
    // Add blog posts to container
    posts.forEach(post => {
        const postElement = document.createElement('div');
        postElement.className = 'col-lg-4 col-md-6 mb-4';
        
        // Ensure post has a slug - generate one from title if not available
        if (!post.slug) {
            post.slug = generateSlug(post.title);
        }
        
        // Create post image URL (placeholder or actual)
        const imageUrl = post.image || `https://source.unsplash.com/random/800x500/?food,health,${encodeURIComponent(post.title)}`;
        
        postElement.innerHTML = `
            <div class="card h-100 border-0 shadow-sm blog-card">
                <img src="${imageUrl}" class="card-img-top" alt="${post.title}">
                <div class="card-body p-4">
                    <h3 class="card-title h5 fw-bold">${post.title}</h3>
                    <p class="card-text text-muted mb-3">${post.description}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="blog-detail.html?slug=${post.slug}" class="btn btn-link p-0 text-primary">Read More</a>
                        <small class="text-muted">${formatDate(post.published_at || post.created_at)}</small>
                    </div>
                </div>
            </div>
        `;
        
        postsContainer.appendChild(postElement);
    });
}

/**
 * Generate a URL-friendly slug from a string
 * @param {string} text - Text to convert to slug
 * @returns {string} URL-friendly slug
 */
function generateSlug(text) {
    return text
        .toLowerCase()
        .replace(/[^\w\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-')     // Replace spaces with hyphens
        .replace(/-+/g, '-')      // Replace multiple hyphens with a single one
        .trim();                  // Trim leading/trailing spaces or hyphens
}

/**
 * Load more posts when button is clicked
 */
function loadMorePosts() {
    const loadMoreButton = document.getElementById('load-more-posts');
    
    if (loadMoreButton) {
        loadMoreButton.disabled = true;
        loadMoreButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
    }
    
    // Calculate next page posts
    const nextPage = currentPage + 1;
    const startIndex = currentPage * postsPerPage;
    const endIndex = nextPage * postsPerPage;
    
    // Get next batch of posts
    const nextPosts = allBlogPosts.slice(startIndex, endIndex);
    
    // Append posts
    displayBlogPosts(nextPosts, true);
    
    // Update current page
    currentPage = nextPage;
    
    // Update button state
    updateLoadMoreButton();
    
    if (loadMoreButton) {
        loadMoreButton.disabled = false;
        loadMoreButton.textContent = 'Load More Articles';
    }
}

/**
 * Update load more button visibility
 */
function updateLoadMoreButton() {
    const loadMoreButton = document.getElementById('load-more-posts');
    
    if (!loadMoreButton) return;
    
    const totalPages = Math.ceil(totalPosts / postsPerPage);
    
    if (currentPage >= totalPages) {
        loadMoreButton.style.display = 'none';
    } else {
        loadMoreButton.style.display = 'block';
    }
}

/**
 * Search blog posts by keyword
 * @param {string} keyword - Search term
 */
function searchBlogPosts(keyword) {
    if (!keyword.trim()) {
        // If search is empty, show all posts (first page)
        currentPage = 1;
        displayBlogPosts(allBlogPosts.slice(0, postsPerPage));
        totalPosts = allBlogPosts.length;
        updateLoadMoreButton();
        return;
    }
    
    // Filter posts by keyword in title or description
    const searchTerm = keyword.toLowerCase().trim();
    const filtered = allBlogPosts.filter(post => 
        post.title.toLowerCase().includes(searchTerm) || 
        post.description.toLowerCase().includes(searchTerm)
    );
    
    // Update total and reset current page
    totalPosts = filtered.length;
    currentPage = 1;
    
    // Display filtered posts
    displayBlogPosts(filtered.slice(0, postsPerPage));
    
    // Update load more button
    updateLoadMoreButton();
}

/**
 * Display placeholder blog posts if API fails or no posts found
 */
function displayPlaceholderBlogPosts() {
    const placeholderPosts = [
        {
            title: 'The Benefits of Meal Planning',
            slug: 'benefits-of-meal-planning',
            description: 'Discover how meal planning can save you time, money, and help you eat healthier.',
            created_at: '2025-03-15T12:00:00Z',
            image: 'img/meal.png'
        },
        {
            title: 'Top 10 Nutritious Breakfast Ideas',
            slug: 'nutritious-breakfast-ideas',
            description: 'Start your day right with these healthy and delicious breakfast recipes.',
            created_at: '2025-03-10T12:00:00Z',
            image: 'img/bre.png'
        },
        {
            title: 'How to Balance Your Macros',
            slug: 'balance-your-macros',
            description: 'A comprehensive guide to understanding and balancing your macronutrients for optimal health.',
            created_at: '2025-03-05T12:00:00Z',
            image: 'img/bala.png'
        },
        {
            title: 'Eating for Energy: Foods That Boost Your Productivity',
            slug: 'eating-for-energy',
            description: 'Learn which foods can help you maintain energy levels throughout the day and boost productivity.',
            created_at: '2025-02-28T12:00:00Z',
            image: 'img/en.png'
        },
        {
            title: 'Seasonal Eating: Why It Matters',
            slug: 'seasonal-eating',
            description: 'Explore the benefits of eating with the seasons and how it impacts both your health and the environment.',
            created_at: '2025-02-20T12:00:00Z',
            image: 'img/elth.png'
        },
        {
            title: 'Meal Prep 101: A Beginner\'s Guide',
            slug: 'meal-prep-beginners-guide',
            description: 'Everything you need to know to get started with meal prepping, including tips, tricks, and easy recipes.',
            created_at: '2025-02-15T12:00:00Z',
            image: 'img/meal101.png'
        },
        {
            title: 'The Psychology of Healthy Eating',
            slug: 'psychology-of-healthy-eating',
            description: 'Understanding your relationship with food and how to develop healthier eating habits.',
            created_at: '2025-02-10T12:00:00Z',
            image: 'img/helth.png'
        },
        {
            title: 'Plant-Based Proteins: Complete Guide',
            slug: 'plant-based-proteins-guide',
            description: 'Everything you need to know about getting enough protein on a plant-based diet.',
            created_at: '2025-02-05T12:00:00Z',
            image: 'img/plant.png'
        },
        {
            title: 'How to Read Nutrition Labels',
            slug: 'how-to-read-nutrition-labels',
            description: 'A step-by-step guide to understanding food labels and making informed choices.',
            created_at: '2025-01-30T12:00:00Z',
            image: 'img/read.png'
        }
    ];
    
    allBlogPosts = placeholderPosts;
    totalPosts = placeholderPosts.length;
    currentPage = 1;
    
    displayBlogPosts(placeholderPosts.slice(0, postsPerPage));
    updateLoadMoreButton();
}

/**
 * Debounce function for search
 * @param {Function} func - Function to debounce
 * @param {number} wait - Time to wait in milliseconds
 * @returns {Function} Debounced function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}