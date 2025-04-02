<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <title>Your Website Title</title>
</head>

<body>
  <?php include 'includes/navbar.php'; ?>

  <!-- Hero Section -->
  <section class="hero-section d-flex align-items-center justify-content-center text-center">
    <div class="container">
      <h1 class="display-3 fw-bold mb-4">The Best Time to Start? Now.</h1>
      <p class="lead mb-5" style="font-weight: bold;">Take the leap—your future self will thank you.</p>
      <a href="#" class="btn">Get Started</a>
    </div>
  </section>
  <!-- Meal Plans Section -->
  <section class="meal-plans-section" style="padding: 60px 20px; background-color: #f9f9f9;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
      <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="font-size: 32px; color: #333; margin: 0;">Our Meal Plans</h2>
        <a href="../Meals/php/subscription-plans.php" class="see-all-btn" style="background-color: #FF691C; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">See All</a>
      </div>

      <p class="section-description" style="font-size: 18px; color: #666; margin-bottom: 40px; max-width: 800px;">
        Our plans are crafted by dietitians and chefs to deliver fresh, balanced meals to fuel your lifestyle and health goals.
      </p>

      <div id="mealPlansGrid" class="meal-plans-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
        <!-- JS will inject content here -->
      </div>
    </div>
  </section>

  <style>
    /* Hover Effects */
    .meal-plan-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .meal-plan-card:hover .meal-plan-image img {
      transform: scale(1.05);
    }

    .select-plan-btn:hover {
      background-color: #e05a16;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .see-all-btn:hover {
      background-color: #e05a16;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .meal-plans-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }

      .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      h2 {
        font-size: 28px !important;
      }

      .section-description {
        font-size: 16px !important;
      }
    }
  </style>
  </section>
  <!-- most meal -->
  <section class="popular-meals" style="padding: 50px 0; background-color: #fff8f5;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
      <h2 style="text-align: center; margin-bottom: 40px; font-size: 32px; color: #333; position: relative; display: inline-block; left: 50%; transform: translateX(-50%);">
        Most Popular Meals
        <span style="display: block; width: 60px; height: 4px; background: #FF691C; margin: 10px auto 0;"></span>
      </h2>

      <div class="meals-slider-container" style="overflow: hidden; position: relative;">
        <div class="meals-slider-track" style="display: flex; gap: 25px; animation: scroll 25s linear infinite;">
          <!-- Meal Items -->
          <div class="meal-card" style="flex: 0 0 auto; width: 200px; text-align: center;">
            <div style="width: 180px; height: 180px; margin: 0 auto; border-radius: 12px; overflow: hidden;  padding: 3px;">
              <img src="images/mexican-breakfast-wrap.webp" Mexican Breakfast Wrap" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <p style="margin-top: 15px; font-weight: 700; color: #FF691C; font-size: 16px;">Mexican Breakfast Wrap</p>
          </div>

          <div class="meal-card" style="flex: 0 0 auto; width: 200px; text-align: center;">
            <div style="width: 180px; height: 180px; margin: 0 auto; border-radius: 12px; overflow: hidden; padding: 3px;">
              <img src="images/shawarma-beetroot-rice.webp" alt="Shawarma Beetroot Rice" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <p style="margin-top: 15px; font-weight: 700; color: #FF691C; font-size: 16px;">Shawarma Beetroot Rice</p>
          </div>

          <div class="meal-card" style="flex: 0 0 auto; width: 200px; text-align: center;">
            <div style="width: 180px; height: 180px; margin: 0 auto; border-radius: 12px; overflow: hidden;  padding: 3px;">
              <img src="images/fruit-salad.webp" alt="Fruit Salad" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <p style="margin-top: 15px; font-weight: 700; color: #FF691C; font-size: 16px;">Fruit Salad</p>
          </div>

          <div class="meal-card" style="flex: 0 0 auto; width: 200px; text-align: center;">
            <div style="width: 180px; height: 180px; margin: 0 auto; border-radius: 12px; overflow: hidden;  padding: 3px;">
              <img src="images/pumpkin-pancakes.webp" alt="Pumpkin Spiced Pancakes" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <p style="margin-top: 15px; font-weight: 700; color: #FF691C; font-size: 16px;">Pumpkin Spiced Pancakes</p>
          </div>

          <div class="meal-card" style="flex: 0 0 auto; width: 200px; text-align: center;">
            <div style="width: 180px; height: 180px; margin: 0 auto; border-radius: 12px; overflow: hidden;  padding: 3px;">
              <img src="images/pasta-chicken.webp" alt=" Pasta with Grilled Chicken" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <p style="margin-top: 15px; font-weight: 700; color: #FF691C; font-size: 16px;"> Pasta with Grilled Chicken</p>
          </div>

          <div class="meal-card" style="flex: 0 0 auto; width: 200px; text-align: center;">
            <div style="width: 180px; height: 180px; margin: 0 auto; border-radius: 12px; overflow: hidden;  padding: 3px;">
              <img src="images/chicken-salad.webp" alt="Chicken Salad" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <p style="margin-top: 15px; font-weight: 700; color: #FF691C; font-size: 16px;">Chicken Salad</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- what people say -->
  <section class="testimonials-section" style="background-color: #f9f9f9; padding: 60px 0;">
    <div class="container_testimonials">
      <h2 style="text-align: center; margin-bottom: 40px; color: #333; font-size: 40px ;">What People Say </h2>

      <div class="testimonial-slider" style="max-width: 800px; margin: 0 auto;">
        <!-- Testimonial Slides -->
        <div class="testimonial-slide active" style="text-align: center; padding: 30px; display: block;">
          <div class="quote-icon" style="color: #FF691C; font-size: 36px; margin-bottom: 20px;">"</div>
          <p class="testimonial-text" style="font-size: 18px; line-height: 1.6; color: #555; margin-bottom: 20px;">
            Lifeats has completely transformed my eating habits! The meals are delicious and perfectly portioned. I've lost 8kg in 2 months without feeling hungry.
          </p>
          <div class="author" style="font-weight: bold; color: #FF691C;">Sarah T.</div>
          <div class="role" style="color: #777; font-size: 14px;">Customer for 6 months</div>
        </div>

        <div class="testimonial-slide" style="text-align: center; padding: 30px; display: none;">
          <div class="quote-icon" style="color: #FF691C; font-size: 36px; margin-bottom: 20px;">"</div>
          <p class="testimonial-text" style="font-size: 18px; line-height: 1.6; color: #555; margin-bottom: 20px;">
            As a busy professional, Lifeats saves me so much time. The food arrives fresh and ready to eat. The low-carb plan helped me get my energy back!
          </p>
          <div class="author" style="font-weight: bold; color: #FF691C;">Mohammed A.</div>
          <div class="role" style="color: #777; font-size: 14px;">Customer for 3 months</div>
        </div>

        <div class="testimonial-slide" style="text-align: center; padding: 30px; display: none;">
          <div class="quote-icon" style="color: #FF691C; font-size: 36px; margin-bottom: 20px;">"</div>
          <p class="testimonial-text" style="font-size: 18px; line-height: 1.6; color: #555; margin-bottom: 20px;">
            The variety is amazing - I never get bored! My nutritionist was impressed with how balanced the meals are. Worth every dinar!
          </p>
          <div class="author" style="font-weight: bold; color: #FF691C;">Lina K.</div>
          <div class="role" style="color: #777; font-size: 14px;">Customer for 1 year</div>
        </div>

        <!-- Navigation Dots -->
        <div class="slider-dots" style="text-align: center; margin-top: 30px;">
          <span class="dot active" data-slide="0" style="height: 12px; width: 12px; background-color: #FF691C; border-radius: 50%; display: inline-block; margin: 0 5px; cursor: pointer; opacity: 1;"></span>
          <span class="dot" data-slide="1" style="height: 12px; width: 12px; background-color: #FF691C; border-radius: 50%; display: inline-block; margin: 0 5px; cursor: pointer; opacity: 0.4;"></span>
          <span class="dot" data-slide="2" style="height: 12px; width: 12px; background-color: #FF691C; border-radius: 50%; display: inline-block; margin: 0 5px; cursor: pointer; opacity: 0.4;"></span>
        </div>
      </div>
    </div>
  </section>





  <!-- FAQ Section Matching Image Style -->
  <section class="faq-section py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3" style="color: #333;">Answer all your questions</h1>
        <h2 class="h2" style="color: #ff691c; font-weight: 600;">Frequently Asked Questions</h2>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-8">
          <!-- Main Question 1 -->
          <div class="faq-item mb-4">
            <h3 class="faq-question py-3 px-4 mb-0 d-flex justify-content-between align-items-center"
              style="background-color: #f8f8f8; border-left: 4px solid #ff691c; cursor: pointer;"
              onclick="toggleAnswer(this)">
              <span style="font-weight: 600; color: #333;">How does the Right Bite meal plan work?</span>
              <i class="fas fa-chevron-down" style="color: #ff691c;"></i>
            </h3>
            <div class="faq-answer px-4 pt-3" style="display: block; border-left: 1px solid #eee;">
              <p style="color: #666; line-height: 1.7;">
                We make eating healthy effortless. You choose a plan that fits your lifestyle, and we take care of the rest — meals designed by experts, delivered daily, and tailored to your goals. Whether you're here to fuel your workouts, stay on track with balanced eating, or just want great-tasting meals without the hassle, we've got you covered.
              </p>
            </div>
          </div>

          <!-- Main Question 2 -->
          <div class="faq-item mb-4">
            <h3 class="faq-question py-3 px-4 mb-0 d-flex justify-content-between align-items-center"
              style="background-color: #f8f8f8; border-left: 4px solid #ff691c; cursor: pointer;"
              onclick="toggleAnswer(this)">
              <span style="font-weight: 600; color: #333;">What's included in my meal plan?</span>
              <i class="fas fa-chevron-down" style="color: #ff691c;"></i>
            </h3>
            <div class="faq-answer px-4 pt-3" style="display: none; border-left: 1px solid #eee;">
              <!-- Nested Question 1 -->
              <div class="nested-faq mb-3">
                <h4 class="nested-question py-2 px-3 mb-0 d-flex justify-content-between align-items-center"
                  style="background-color: #f0f0f0; border-radius: 4px; cursor: pointer;"
                  onclick="toggleNestedAnswer(this)">
                  <span style="font-weight: 500; color: #555;">Can I choose my meals?</span>
                  <i class="fas fa-chevron-down" style="color: #ff691c; font-size: 0.8rem;"></i>
                </h4>
                <div class="nested-answer px-3 pb-2" style="display: none;">
                  <p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
                    Yes! Our platform allows you to customize your weekly menu from our rotating selection of 20+ dietitian-approved meals to match your preferences and dietary needs.
                  </p>
                </div>
              </div>

              <!-- Nested Question 2 -->
              <div class="nested-faq">
                <h4 class="nested-question py-2 px-3 mb-0 d-flex justify-content-between align-items-center"
                  style="background-color: #f0f0f0; border-radius: 4px; cursor: pointer;"
                  onclick="toggleNestedAnswer(this)">
                  <span style="font-weight: 500; color: #555;">Can I check in with a dietitian after I start my plan?</span>
                  <i class="fas fa-chevron-down" style="color: #ff691c; font-size: 0.8rem;"></i>
                </h4>
                <div class="nested-answer px-3 pb-2" style="display: none;">
                  <p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
                    Absolutely. We offer optional dietitian check-ins to monitor your progress, answer questions, and make adjustments to your plan as needed.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- Main Question 3 -->
          <div class="faq-item mb-4">
            <h3 class="faq-question py-3 px-4 mb-0 d-flex justify-content-between align-items-center"
              style="background-color: #f8f8f8; border-left: 4px solid #ff691c; cursor: pointer;"
              onclick="toggleAnswer(this)">
              <span style="font-weight: 600; color: #333;">How often do you update your menu?</span>
              <i class="fas fa-chevron-down" style="color: #ff691c;"></i>
            </h3>
            <div class="faq-answer px-4 pt-3" style="display: none; border-left: 1px solid #eee;">
              <p style="color: #666; line-height: 1.7;">
                We refresh our menu completely every season (4 times per year) with 15+ new dishes, while rotating
                5-7 special items weekly to keep your meals exciting and varied throughout the year.
              </p>

              <!-- Nested Question -->
              <div class="nested-faq mt-3">
                <h4 class="nested-question py-2 px-3 mb-0 d-flex justify-content-between align-items-center"
                  style="background-color: #f0f0f0; border-radius: 4px; cursor: pointer;"
                  onclick="toggleNestedAnswer(this)">
                  <span style="font-weight: 500; color: #555;">Can I request my favorite meals to return?</span>
                  <i class="fas fa-chevron-down" style="color: #ff691c; font-size: 0.8rem;"></i>
                </h4>
                <div class="nested-answer px-3 pb-2" style="display: none;">
                  <p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
                    Absolutely! We maintain a "Customer Favorites" list and regularly bring back most-requested dishes.
                    You can vote for returning meals through your account dashboard.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Question 4 -->
          <div class="faq-item mb-4">
            <h3 class="faq-question py-3 px-4 mb-0 d-flex justify-content-between align-items-center"
              style="background-color: #f8f8f8; border-left: 4px solid #ff691c; cursor: pointer;"
              onclick="toggleAnswer(this)">
              <span style="font-weight: 600; color: #333;">What if I have food allergies?</span>
              <i class="fas fa-chevron-down" style="color: #ff691c;"></i>
            </h3>
            <div class="faq-answer px-4 pt-3" style="display: none; border-left: 1px solid #eee;">
              <p style="color: #666; line-height: 1.7;">
                We take allergies seriously. All meals are prepared in a facility that handles common allergens,
                but we offer dedicated filters for:
              </p>

              <ul style="color: #666; padding-left: 20px; margin-bottom: 15px;">
                <li>Gluten-free</li>
                <li>Dairy-free</li>
                <li>Nut-free</li>
                <li>Shellfish-free</li>
              </ul>

              <!-- Nested Question -->
              <div class="nested-faq">
                <h4 class="nested-question py-2 px-3 mb-0 d-flex justify-content-between align-items-center"
                  style="background-color: #f0f0f0; border-radius: 4px; cursor: pointer;"
                  onclick="toggleNestedAnswer(this)">
                  <span style="font-weight: 500; color: #555;">Can you accommodate severe allergies?</span>
                  <i class="fas fa-chevron-down" style="color: #ff691c; font-size: 0.8rem;"></i>
                </h4>
                <div class="nested-answer px-3 pb-2" style="display: none;">
                  <p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
                    For severe allergies, we recommend our "Custom Plan" option where our chefs will prepare
                    your meals separately after a consultation with our dietitian team.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Main Question 5 -->
          <div class="faq-item mb-4">
            <h3 class="faq-question py-3 px-4 mb-0 d-flex justify-content-between align-items-center"
              style="background-color: #f8f8f8; border-left: 4px solid #ff691c; cursor: pointer;"
              onclick="toggleAnswer(this)">
              <span style="font-weight: 600; color: #333;">How do I pause or cancel my subscription?</span>
              <i class="fas fa-chevron-down" style="color: #ff691c;"></i>
            </h3>
            <div class="faq-answer px-4 pt-3" style="display: none; border-left: 1px solid #eee;">
              <p style="color: #666; line-height: 1.7;">
                You have full control over your subscription through your online account:
              </p>

              <ul style="color: #666; padding-left: 20px; margin-bottom: 15px;">
                <li><strong>Pause:</strong> Skip 1-4 weeks at any time</li>
                <li><strong>Cancel:</strong> No commitments, cancel anytime before your next delivery</li>
                <li><strong>Change:</strong> Switch plans weekly as needed</li>
              </ul>

              <!-- Nested Question -->
              <div class="nested-faq">
                <h4 class="nested-question py-2 px-3 mb-0 d-flex justify-content-between align-items-center"
                  style="background-color: #f0f0f0; border-radius: 4px; cursor: pointer;"
                  onclick="toggleNestedAnswer(this)">
                  <span style="font-weight: 500; color: #555;">Is there a cancellation fee?</span>
                  <i class="fas fa-chevron-down" style="color: #ff691c; font-size: 0.8rem;"></i>
                </h4>
                <div class="nested-answer px-3 pb-2" style="display: none;">
                  <p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
                    No hidden fees! You can cancel anytime without penalty. We only charge for deliveries
                    already processed or in transit.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Contact CTA -->
          <div class="text-center mt-5">
            <a href="#" class="btn px-4 py-2 fw-bold"
              style="background-color: #ff691c; color: white; border: none; border-radius: 4px;">
              <i class="fas fa-envelope me-2"></i> Contact Us
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>








  <?php include 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle main FAQ answers
    function toggleAnswer(element) {
      const answer = element.nextElementSibling;
      const icon = element.querySelector('i');

      if (answer.style.display === 'none') {
        answer.style.display = 'block';
        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
      } else {
        answer.style.display = 'none';
        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
      }
    }

    // Toggle nested FAQ answers
    function toggleNestedAnswer(element) {
      const answer = element.nextElementSibling;
      const icon = element.querySelector('i');

      if (answer.style.display === 'none') {
        answer.style.display = 'block';
        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
      } else {
        answer.style.display = 'none';
        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
      }
    }
  </script>
  <script>
    // Auto-rotating testimonials
    let currentSlide = 0;
    const slides = document.querySelectorAll('.testimonial-slide');
    const dots = document.querySelectorAll('.dot');

    function showSlide(n) {
      // Hide all slides
      slides.forEach(slide => slide.style.display = 'none');
      dots.forEach(dot => dot.style.opacity = '0.4');

      // Show current slide
      currentSlide = (n + slides.length) % slides.length;
      slides[currentSlide].style.display = 'block';
      dots[currentSlide].style.opacity = '1';
    }

    function nextSlide() {
      showSlide(currentSlide + 1);
    }

    // Click event for dots
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        showSlide(index);
        resetTimer();
      });
    });

    // Auto-rotate every 3 seconds
    let slideInterval = setInterval(nextSlide, 3000);

    function resetTimer() {
      clearInterval(slideInterval);
      slideInterval = setInterval(nextSlide, 3000);
    }

    // Initial display
    showSlide(0);
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Clone all meal cards to create infinite loop effect
      const track = document.querySelector('.meals-slider-track');
      const meals = document.querySelectorAll('.meal-card');

      meals.forEach(meal => {
        const clone = meal.cloneNode(true);
        track.appendChild(clone);
      });
    });


    fetch("http://127.0.0.1:8000/api/subscriptions")
      .then(response => response.json())
      .then(data => {
        const grid = document.getElementById('mealPlansGrid');
        const firstThree = data.slice(0, 3);

        firstThree.forEach(plan => {
          const card = document.createElement('div');
          card.className = 'meal-plan-card';
          card.style = 'background-color: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease;';

          card.innerHTML = `
          <div class="meal-plan-image" style="height: 200px; overflow: hidden;">
            <img src="${plan.image_url}" alt="${plan.name}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
          </div>
          <div class="meal-plan-content" style="padding: 25px;">
            <h3 style="color: #FF691C; font-size: 22px; margin-top: 0; margin-bottom: 15px;">${plan.name}</h3>
            <p style="color: #666; margin-bottom: 15px; font-size: 16px; line-height: 1.5;">${plan.description}</p>
            <div class="price" style="font-weight: 700; color: #333; font-size: 18px; margin-bottom: 20px;">Starting from ${plan.price} per day</div>
            <button class="select-plan-btn" data-id="${plan.id}" style="background-color: #FF691C; color: white; padding: 12px 25px; border-radius: 4px; font-weight: 600; border: none; cursor: pointer;">Select Plan</button>
          </div>
        `;

          // Add click handler to button
          const button = card.querySelector('.select-plan-btn');
          button.addEventListener('click', () => {
            localStorage.setItem('selectedPlan', JSON.stringify(plan));
            window.location.href = `../Meals/php/meal-details.php?id=${plan.id}`;
          });

          grid.appendChild(card);
        });
      })
      .catch(error => {
        document.getElementById('mealPlansGrid').innerHTML = `
        <div class="error" style="grid-column: 1/-1; text-align: center; padding: 20px; background: #ffeeee; color: #ff3333; border-radius: 8px;">
          Currently unable to load meal plans. Please try again later.
        </div>
      `;
        console.error("Error fetching subscriptions:", error);
      });
  </script>







</body>

</html>