/**
 * LifeEats - Blog Detail JavaScript
 * Handles loading and displaying a single blog post
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get slug from URL
    const urlParams = new URLSearchParams(window.location.search);
    const slug = urlParams.get('slug');
    
    if (slug) {
        loadBlogPost(slug);
    } else {
        // No slug provided, redirect to blog page
        window.location.href = 'blog.html';
    }
});

/**
 * Load blog post from API or show placeholder content
 * @param {string} slug - Article slug from URL
 */
async function loadBlogPost(slug) {
    // Show loading indicator
    const loadingIndicator = document.getElementById('blog-detail-loading');
    const errorAlert = document.getElementById('blog-detail-error');
    const contentContainer = document.getElementById('blog-detail-content');
    
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }
    
    if (errorAlert) {
        errorAlert.style.display = 'none';
    }
    
    if (contentContainer) {
        contentContainer.style.display = 'none';
    }
    
    try {
        // Try to fetch blog post from API
        // In a real app with working backend, uncomment this:
        /*
        const response = await axios.get(`${API_BASE_URL}/blog/${slug}`);
        if (response.data && response.data.data) {
            displayBlogPost(response.data.data);
        } else {
            throw new Error('Article not found');
        }
        */
        
        // For demo purposes, we'll use placeholder content based on the slug
        setTimeout(() => {
            const blogPost = getBlogPostBySlug(slug);
            if (blogPost) {
                displayBlogPost(blogPost);
            } else {
                throw new Error('Article not found');
            }
        }, 800);
    } catch (error) {
        // Handle error
        console.error('Error loading blog post:', error);
        showError('Unable to load the article. Please try again later.');
    } finally {
        // Hide loading indicator
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
    }
}

/**
 * Display blog post content
 * @param {Object} post - Blog post object
 */
function displayBlogPost(post) {
    // Get DOM elements
    const contentContainer = document.getElementById('blog-detail-content');
    const titleElement = document.getElementById('article-title');
    const descriptionElement = document.getElementById('article-description');
    const dateElement = document.getElementById('article-date');
    const authorElement = document.getElementById('article-author');
    const imageElement = document.getElementById('article-image');
    const contentElement = document.getElementById('article-content');
    const breadcrumbTitle = document.getElementById('breadcrumb-title');
    const authorName = document.getElementById('author-name');
    const authorTitle = document.getElementById('author-title');
    const authorBio = document.getElementById('author-bio');
    const authorImage = document.getElementById('author-image');
    const tagsContainer = document.getElementById('article-tags');
    
    // Update page title
    document.title = `${post.title} - LifeEats Blog`;
    
    // Update article content
    if (titleElement) titleElement.textContent = post.title;
    if (descriptionElement) descriptionElement.textContent = post.description;
    if (dateElement) dateElement.textContent = formatDate(post.published_at || post.created_at);
    if (authorElement) authorElement.textContent = post.author || 'LifeEats Team';
    if (breadcrumbTitle) breadcrumbTitle.textContent = post.title;
    
    // Set image
    if (imageElement) {
        imageElement.src = post.image || `https://source.unsplash.com/random/1200x800/?${encodeURIComponent(post.title)}`;
        imageElement.alt = post.title;
    }
    
    // Set content
    if (contentElement) {
        contentElement.innerHTML = post.content || generatePlaceholderContent(post.title);
    }
    
    // Set author info
    if (authorName) authorName.textContent = post.author || 'LifeEats Team';
    if (authorTitle) authorTitle.textContent = post.author_title || 'Nutrition Specialist';
    if (authorBio) authorBio.textContent = post.author_bio || 'Our team of nutrition experts work together to bring you the most up-to-date and scientifically-backed information about healthy eating and wellness.';
    if (authorImage) {
        if (post.author_image) {
            authorImage.src = post.author_image;
        } else {
            // Generate random but consistent author image based on title
            const authorIndex = Math.abs(hashCode(post.title) % 99) + 1;
            const gender = authorIndex % 2 === 0 ? 'women' : 'men';
            authorImage.src = `https://randomuser.me/api/portraits/${gender}/${authorIndex}.jpg`;
        }
    }
    
    // Set tags
    if (tagsContainer) {
        tagsContainer.innerHTML = '';
        
        const tags = post.tags || generateTagsFromTitle(post.title);
        tags.forEach(tag => {
            const tagLink = document.createElement('a');
            tagLink.href = `blog.html?tag=${encodeURIComponent(tag)}`;
            tagLink.className = 'badge bg-light text-dark text-decoration-none';
            tagLink.textContent = tag;
            tagsContainer.appendChild(tagLink);
        });
    }
    
    // Display content
    if (contentContainer) {
        contentContainer.style.display = 'block';
    }
    
    // Load related articles
    loadRelatedArticles(post);
}

/**
 * Show error message
 * @param {string} message - Error message
 */
function showError(message) {
    const errorAlert = document.getElementById('blog-detail-error');
    const errorMessage = document.getElementById('blog-detail-error-message');
    
    if (errorAlert && errorMessage) {
        errorMessage.textContent = message;
        errorAlert.style.display = 'block';
    }
}

/**
 * Load related articles
 * @param {Object} currentPost - Current blog post
 */
function loadRelatedArticles(currentPost) {
    // In a real app, we would fetch related articles based on tags or categories
    // For demo purposes, we'll just show some placeholder articles
    const relatedContainer = document.getElementById('related-articles');
    
    if (!relatedContainer) return;
    
    relatedContainer.innerHTML = '';
    
    // Get sample blog posts
    const allPosts = getSampleBlogPosts();
    
    // Filter out current post and get 3 random posts
    const filteredPosts = allPosts
        .filter(post => post.slug !== currentPost.slug)
        .sort(() => 0.5 - Math.random())
        .slice(0, 3);
    
    // Add related articles to container
    filteredPosts.forEach(post => {
        const articleElement = document.createElement('div');
        articleElement.className = 'col-md-4';
        
        articleElement.innerHTML = `
            <div class="card h-100 border-0 shadow-sm blog-card">
                <img src="${post.image || `https://source.unsplash.com/random/800x500/?${encodeURIComponent(post.title)}`}" class="card-img-top" alt="${post.title}">
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
        
        relatedContainer.appendChild(articleElement);
    });
}

/**
 * Simple hash function for strings
 * @param {string} str - String to hash
 * @returns {number} Hash code
 */
function hashCode(str) {
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
        const char = str.charCodeAt(i);
        hash = ((hash << 5) - hash) + char;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
}

/**
 * Get blog post by slug
 * @param {string} slug - Blog post slug
 * @returns {Object|null} Blog post object or null if not found
 */
function getBlogPostBySlug(slug) {
    const allPosts = getSampleBlogPosts();
    return allPosts.find(post => post.slug === slug) || getPlaceholderPost(slug);
}

/**
 * Get placeholder post for a slug if real post not found
 * @param {string} slug - Blog post slug
 * @returns {Object} Placeholder blog post
 */
function getPlaceholderPost(slug) {
    // Create a placeholder post based on the slug
    const title = slug
        .split('-')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
    
    return {
        title: title,
        slug: slug,
        description: `Learn all about ${title.toLowerCase()} in this comprehensive guide.`,
        created_at: '2025-03-15T12:00:00Z',
        image: `https://source.unsplash.com/random/1200x800/?${encodeURIComponent(title)}`,
        content: generatePlaceholderContent(title),
        author: getRandomAuthor().name,
        author_title: getRandomAuthor().title,
        author_bio: getRandomAuthor().bio,
        author_image: null, // Will be generated in displayBlogPost
        tags: generateTagsFromTitle(title)
    };
}

/**
 * Get random author information
 * @returns {Object} Author info (name, title, bio)
 */
function getRandomAuthor() {
    const authors = [
        {
            name: 'Sarah Johnson',
            title: 'Nutrition Specialist',
            bio: 'Sarah is a certified nutritionist with over 10 years of experience helping people develop healthy eating habits. She specializes in plant-based nutrition and meal planning for busy professionals.'
        },
        {
            name: 'Michael Chen',
            title: 'Chef & Food Writer',
            bio: 'Michael is a professional chef with a passion for creating nutritious and delicious recipes. He believes that a good breakfast is the foundation of a productive day.'
        },
        {
            name: 'Dr. James Wilson',
            title: 'Sports Nutritionist',
            bio: 'Dr. Wilson has helped hundreds of athletes optimize their nutrition for peak performance. He specializes in macronutrient balance and personalized nutrition plans.'
        },
        {
            name: 'Lisa Martinez',
            title: 'Wellness Coach',
            bio: 'Lisa helps busy professionals optimize their diet and lifestyle for maximum energy and productivity. Her approach combines nutritional science with practical, sustainable habits.'
        },
        {
            name: 'Emma Thompson',
            title: 'Environmental Nutritionist',
            bio: 'Emma specializes in sustainable nutrition practices that benefit both personal health and the planet. She advocates for local, seasonal eating as a cornerstone of environmental wellness.'
        }
    ];
    
    return authors[Math.floor(Math.random() * authors.length)];
}

/**
 * Generate sample blog posts
 * @returns {Array} Array of blog post objects
 */
function getSampleBlogPosts() {
    return [
        {
            title: 'The Benefits of Meal Planning',
            slug: 'benefits-of-meal-planning',
            description: 'Discover how meal planning can save you time, money, and help you eat healthier.',
            created_at: '2025-03-15T12:00:00Z',
            image: 'https://sa1s3optim.patientpop.com/assets/images/provider/photos/2731342.jpg',
            content: generatePlaceholderContent('The Benefits of Meal Planning'),
            author: 'Sarah Johnson',
            author_title: 'Nutrition Specialist',
            author_bio: 'Sarah is a certified nutritionist with over 10 years of experience helping people develop healthy eating habits. She specializes in plant-based nutrition and meal planning for busy professionals.',
            author_image: 'https://randomuser.me/api/portraits/women/44.jpg',
            tags: ['meal planning', 'time management', 'healthy eating']
        },
        {
            title: 'Top 10 Nutritious Breakfast Ideas',
            slug: 'nutritious-breakfast-ideas',
            description: 'Start your day right with these healthy and delicious breakfast recipes.',
            created_at: '2025-03-10T12:00:00Z',
            image: 'https://images.immediate.co.uk/production/volatile/sites/30/2017/08/smoothie-bowl-3a8632c.jpg?quality=90&resize=556,505',
            content: generatePlaceholderContent('Top 10 Nutritious Breakfast Ideas'),
            author: 'Michael Chen',
            author_title: 'Chef & Food Writer',
            author_bio: 'Michael is a professional chef with a passion for creating nutritious and delicious recipes. He believes that a good breakfast is the foundation of a productive day.',
            author_image: 'https://randomuser.me/api/portraits/men/32.jpg',
            tags: ['breakfast', 'recipes', 'nutrition']
        },
        {
            title: 'How to Balance Your Macros',
            slug: 'balance-your-macros',
            description: 'A comprehensive guide to understanding and balancing your macronutrients for optimal health.',
            created_at: '2025-03-05T12:00:00Z',
            image: './img/mac1.jpg',
            content: generatePlaceholderContent('How to Balance Your Macros'),
            author: 'Dr. James Wilson',
            author_title: 'Sports Nutritionist',
            author_bio: 'Dr. Wilson has helped hundreds of athletes optimize their nutrition for peak performance. He specializes in macronutrient balance and personalized nutrition plans.',
            author_image: './img/mac1.jpg',
            tags: ['macronutrients', 'nutrition', 'diet planning']
        },
        {
            title: 'Eating for Energy: Foods That Boost Your Productivity',
            slug: 'eating-for-energy',
            description: 'Learn which foods can help you maintain energy levels throughout the day and boost productivity.',
            created_at: '2025-02-28T12:00:00Z',
            image: 'https://images.immediate.co.uk/production/volatile/sites/30/2017/08/smoothie-bowl-3a8632c.jpg?quality=90&resize=556,505',
            content: generatePlaceholderContent('Eating for Energy: Foods That Boost Your Productivity'),
            author: 'Lisa Martinez',
            author_title: 'Wellness Coach',
            author_bio: 'Lisa helps busy professionals optimize their diet and lifestyle for maximum energy and productivity. Her approach combines nutritional science with practical, sustainable habits.',
            author_image: './img/mac1.jpg',
            tags: ['energy', 'productivity', 'superfoods']
        },
        {
            title: 'Seasonal Eating: Why It Matters',
            slug: 'seasonal-eating',
            description: 'Explore the benefits of eating with the seasons and how it impacts both your health and the environment.',
            created_at: '2025-02-20T12:00:00Z',
            image: 'https://lirp.cdn-website.com/1fc1b1e8/dms3rep/multi/opt/Restaurant+Blog+Images+Nov+2022-640w.jpg',
            content: generatePlaceholderContent('Seasonal Eating: Why It Matters'),
            author: 'Emma Thompson',
            author_title: 'Environmental Nutritionist',
            author_bio: 'Emma specializes in sustainable nutrition practices that benefit both personal health and the planet. She advocates for local, seasonal eating as a cornerstone of environmental wellness.',
            author_image: 'https://randomuser.me/api/portraits/women/62.jpg',
            tags: ['seasonal eating', 'sustainability', 'local food']
        },
        {
            title: 'Meal Prep 101: A Beginner\'s Guide',
            slug: 'meal-prep-beginners-guide',
            description: 'Everything you need to know to get started with meal prepping, including tips, tricks, and easy recipes.',
            created_at: '2025-02-15T12:00:00Z',
            image: 'https://www.peanutbutterandfitness.com/wp-content/uploads/2023/12/Meal-Prep-101-horizontal-1024x576.jpg',
            content: generatePlaceholderContent('Meal Prep 101: A Beginner\'s Guide'),
            author: 'David Parker',
            author_title: 'Meal Prep Expert',
            author_bio: 'David has helped thousands of busy people transform their eating habits through simple, effective meal preparation strategies. His practical approach makes healthy eating accessible to everyone.',
            author_image: 'https://randomuser.me/api/portraits/men/22.jpg',
            tags: ['meal prep', 'beginners', 'kitchen tips']
        },
        {
            title: 'The Psychology of Healthy Eating',
            slug: 'psychology-of-healthy-eating',
            description: 'Understanding your relationship with food and how to develop healthier eating habits.',
            created_at: '2025-02-10T12:00:00Z',
            image: 'https://domf5oio6qrcr.cloudfront.net/medialibrary/8727/conversions/bigstock-diet-brain-Food-For-Though-81817028-thumb.jpg',
            content: generatePlaceholderContent('The Psychology of Healthy Eating'),
            author: 'Dr. Amanda Lewis',
            author_title: 'Food Psychologist',
            author_bio: 'Dr. Lewis specializes in helping people overcome psychological barriers to healthy eating. Her research focuses on habit formation and mindful eating practices.',
            author_image: 'https://randomuser.me/api/portraits/women/56.jpg',
            tags: ['psychology', 'mindful eating', 'behavior change']
        },
        {
            title: 'Plant-Based Proteins: Complete Guide',
            slug: 'plant-based-proteins-guide',
            description: 'Everything you need to know about getting enough protein on a plant-based diet.',
            created_at: '2025-02-05T12:00:00Z',
            image: 'https://blog.muscleblaze.com/wp-content/uploads/2024/11/2-1-1.jpg',
            content: generatePlaceholderContent('Plant-Based Proteins: Complete Guide'),
            author: 'Robert Chen',
            author_title: 'Vegan Nutritionist',
            author_bio: 'Robert is a nutrition expert specializing in plant-based diets. He focuses on helping people meet all their nutritional needs while following vegetarian and vegan lifestyles.',
            author_image: 'https://randomuser.me/api/portraits/men/76.jpg',
            tags: ['plant-based', 'protein', 'vegan', 'vegetarian']
        },
        {
            title: 'How to Read Nutrition Labels',
            slug: 'how-to-read-nutrition-labels',
            description: 'A step-by-step guide to understanding food labels and making informed choices.',
            created_at: '2025-01-30T12:00:00Z',
            image: 'https://source.unsplash.com/random/1200x800/?nutrition,label',
            content: generatePlaceholderContent('How to Read Nutrition Labels'),
            author: 'Jennifer Adams',
            author_title: 'Dietitian',
            author_bio: 'Jennifer is a registered dietitian who helps clients navigate the often confusing world of nutrition information. She believes that understanding food labels is key to making healthy choices.',
            author_image: 'https://randomuser.me/api/portraits/women/35.jpg',
            tags: ['nutrition labels', 'shopping guide', 'food education']
        }
    ];
}

/**
 * Generate tags based on article title
 * @param {string} title - Article title
 * @returns {Array} Array of tag strings
 */
function generateTagsFromTitle(title) {
    // Get base tags that most articles will have
    const baseTags = ['healthy eating', 'nutrition'];
    
    // Add specific tags based on title keywords
    const titleLower = title.toLowerCase();
    
    if (titleLower.includes('meal')) baseTags.push('meal planning');
    if (titleLower.includes('breakfast')) baseTags.push('breakfast');
    if (titleLower.includes('lunch')) baseTags.push('lunch');
    if (titleLower.includes('dinner')) baseTags.push('dinner');
    if (titleLower.includes('protein')) baseTags.push('protein');
    if (titleLower.includes('vegan') || titleLower.includes('plant')) baseTags.push('plant-based');
    if (titleLower.includes('weight')) baseTags.push('weight management');
    if (titleLower.includes('energy')) baseTags.push('energy');
    if (titleLower.includes('macro')) baseTags.push('macronutrients');
    
    // Return up to 5 tags
    return baseTags.slice(0, 5);
}

/**
 * Generate placeholder content for blog post
 * @param {string} title - Blog post title
 * @returns {string} HTML content
 */
function generatePlaceholderContent(title) {
    return `
        <p class="lead">Welcome to our comprehensive guide on ${title.toLowerCase()}. In this article, we'll explore everything you need to know about this important topic and how it can benefit your health and wellness journey.</p>
        
        <h2>Why ${title} Matters</h2>
        <p>When it comes to maintaining a healthy lifestyle, understanding ${title.toLowerCase()} is crucial. Research has consistently shown that incorporating these principles into your daily routine can lead to significant improvements in overall wellbeing, energy levels, and long-term health outcomes.</p>
        
        <p>Here are some key benefits to consider:</p>
        <ul>
            <li>Improved nutritional balance and dietary quality</li>
            <li>Better energy management throughout the day</li>
            <li>Reduced food waste and environmental impact</li>
            <li>Significant time and cost savings</li>
            <li>More consistent healthy eating habits</li>
        </ul>
        
        <blockquote class="blockquote">
            <p>"The food you eat can be either the safest and most powerful form of medicine or the slowest form of poison."</p>
            <footer class="blockquote-footer">Ann Wigmore</footer>
        </blockquote>
        
        <h2>Getting Started</h2>
        <p>Beginning your journey with ${title.toLowerCase()} doesn't have to be complicated. By following these simple steps, you can gradually incorporate these practices into your routine:</p>
        
        <ol>
            <li><strong>Start small</strong> - Begin with just 2-3 days per week</li>
            <li><strong>Plan ahead</strong> - Set aside dedicated time for preparation</li>
            <li><strong>Keep it simple</strong> - Focus on nutritious whole foods</li>
            <li><strong>Be flexible</strong> - Adapt your approach as needed</li>
            <li><strong>Track your progress</strong> - Notice improvements in your health and habits</li>
        </ol>
        
        <h2>Key Components</h2>
        <p>Understanding the fundamental elements of ${title.toLowerCase()} will help you implement it effectively:</p>
        
        <h3>Quality Ingredients</h3>
        <p>The foundation of any healthy eating plan is high-quality, nutrient-dense ingredients. Focus on whole foods like fresh vegetables, fruits, lean proteins, whole grains, and healthy fats. When possible, choose organic options for items on the "dirty dozen" list to minimize pesticide exposure.</p>
        
        <h3>Balanced Nutrition</h3>
        <p>Each meal should include a balance of macronutrients - proteins, carbohydrates, and fats - to support optimal health and sustained energy. Aim for colorful plates with a variety of foods to ensure you're getting a wide spectrum of nutrients.</p>
        
        <figure class="figure my-4">
            <img src="img/mac2.jpg" class="figure-img img-fluid rounded" alt="Balanced healthy meal">
            <figcaption class="figure-caption text-center">A properly balanced meal with all essential nutrients.</figcaption>
        </figure>
        
        <h3>Practical Implementation</h3>
        <p>Putting theory into practice requires a systematic approach. Consider these practical strategies:</p>
        
        <ul>
            <li>Dedicate time each weekend for planning and preparation</li>
            <li>Invest in quality storage containers for portioning and freshness</li>
            <li>Batch cook staple items like grains, proteins, and roasted vegetables</li>
            <li>Use versatile ingredients that can be incorporated into multiple meals</li>
            <li>Embrace freezer-friendly options for longer-term storage</li>
        </ul>
        
        <h2>Common Challenges and Solutions</h2>
        <p>Even with the best intentions, you may encounter obstacles along the way. Here are solutions to common challenges:</p>
        
        <h3>Time Constraints</h3>
        <p>Finding time in a busy schedule can be difficult. Combat this by starting with simple recipes, utilizing time-saving kitchen tools, and employing efficient batch cooking methods. Even 1-2 hours of dedicated preparation time weekly can make a significant difference.</p>
        
        <h3>Food Fatigue</h3>
        <p>Eating the same meals repeatedly can lead to boredom. Prevent this by incorporating a rotation of recipes, using different seasonings and cooking methods, and allowing for occasional flexibility in your plan.</p>
        
        <h3>Budget Concerns</h3>
        <p>Healthy eating doesn't have to be expensive. Focus on seasonal produce, buy in bulk when possible, utilize frozen fruits and vegetables, and incorporate cost-effective protein sources like beans, lentils, and eggs.</p>
        
        <h2>Expert Tips for Success</h2>
        <p>Our nutrition specialists recommend these advanced strategies to elevate your approach:</p>
        
        <ul>
            <li>Theme your days for simplicity (e.g., Meatless Monday, Taco Tuesday)</li>
            <li>Prepare "component" ingredients rather than complete meals for greater flexibility</li>
            <li>Keep a running list of favorite recipes that you can rotate through</li>
            <li>Schedule regular "clean out the fridge" meals to minimize waste</li>
            <li>Listen to your body's hunger and fullness cues</li>
        </ul>
        
        <h2>Conclusion</h2>
        <p>Incorporating ${title.toLowerCase()} into your lifestyle is one of the most impactful steps you can take toward improved health and wellbeing. By starting with small, manageable changes and gradually building consistent habits, you'll experience benefits ranging from better nutrition to reduced stress around mealtime decisions.</p>
        
        <p>Remember that perfection isn't the goal—progress is. Be patient with yourself as you develop these new skills and habits. With time and practice, ${title.toLowerCase()} will become a natural, enjoyable part of your healthy lifestyle journey.</p>
    `;
}