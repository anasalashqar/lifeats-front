<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Plan Details</title>
    <link rel="stylesheet" href="../css/meal-details.css">
</head>

<body>
    <?php
    $packageOptions = [
        [
            'name' => 'Full Day Standard',
            'details' => 'Breakfast + Lunch + Dinner',
            'image' => '../img/Full_Day.webp'
        ]
    ];

    $durationOptions = [20];
    $discounts = [null];
    ?>
    <?php
    require_once __DIR__ . "/../../Homepage/includes/navbar.php";
    ?>
    <div class="container">
        <div class="left-column">
            <div class="header">
                <a href="subscription-plans.php" class="back-button">←</a>
                <h1 id="mealName">Loading...</h1>
            </div>
            <div class="description" id="mealDescription">
                Loading...
            </div>
            <div class="feature-image">
                <img id="mealImage" src="https://via.placeholder.com/600x400" alt="Meal Plan">
                <div class="overlay-text">
                    <h2>Optimal for</h2>
                    <h3 id="mealGoal">Loading...</h3>
                </div>
            </div>
        </div>

        <div class="right-column">
            <div class="section-title">Choose your package type</div>
            <div class="package-options">
                <?php foreach ($packageOptions as $index => $option): ?>
                    <div class="package-option <?php echo $index === 0 ? 'selected' : ''; ?>">
                        <img src="<?php echo $option['image']; ?>" alt="<?php echo $option['name']; ?>" class="package-image">
                        <div class="package-name"><?php echo $option['name']; ?></div>
                        <div class="package-details"><?php echo $option['details']; ?></div>

                    </div>
                <?php endforeach; ?>
            </div>

            <div class="customize-option">
                <i>● </i> Vegan, pescatarian, or with other preferences? Fully customize your plan after payment.
            </div>

            <div class="section-title">Choose your calories</div>
            <div class="calorie-options">
                <div class="calorie-option selected">500-750</div>
                <div class="calorie-option">800-1000</div>
            </div>

            <div class="calorie-help">
                <i>●</i> Not sure what calories are right for your goals? <a href="#">Discover more</a>
            </div>

            <div class="trial-box">
                <div>
                    <div class="title">Try Right Bite for 1 Day?</div>
                    <div class="price" id="trialPrice">Starting JOD 41</div>
                </div>
                <a href="#" class="button">Click here</a>
            </div>

            <div class="section-title">Package duration days</div>
            <div class="duration-options">
                <p>Full flexibility of which days you can eat your delivery, including Saturday and Sunday.</p>
                <div class="duration-row">
                    <?php foreach ($durationOptions as $index => $days): ?>
                        <div class="duration-option <?php echo $index === 0 ? 'selected' : ''; ?>">
                            <?php echo $days; ?>
                            <?php if ($discounts[$index]): ?>
                                <div class="discount-tag"><?php echo $discounts[$index]; ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="start-plan">
                <i>●</i> Start your plan as early as <?php echo date('D j M', strtotime('+2 days')); ?><br>
                You will be able to choose the start date that suits you after checkout.
            </div>

            <div class="section-title">Nutrition breakdown</div>
            <div class="nutrition-bars">
                <div class="nutrition-bar proteins">
                    <div class="nutrition-name">Proteins</div>
                    <div class="nutrition-value">85 - 135g</div>
                </div>
                <div class="nutrition-bar carbs">
                    <div class="nutrition-name">Carbs</div>
                    <div class="nutrition-value">75 - 110g</div>
                </div>
                <div class="nutrition-bar fat">
                    <div class="nutrition-name">Fat</div>
                    <div class="nutrition-value">35 - 70g</div>
                </div>
            </div>
            <div class="nutrition-disclaimer">
                This daily nutrition breakdown can change based on your preferences and dietitian's recommendations.
            </div>

            <a href="#" class="view-menu-button">View sample menu</a>

            <div class="price-summary">
                <div class="price-row">
                    <div>Package</div>
                    <div id="mealPrice">Loading...</div>
                </div>
                <div class="price-row">
                    <div>Duration</div>
                    <div>20 days</div>
                </div>
                <div class="price-row total">
                    <div>Subtotal</div>
                    <div id="mealPriceTotal">Loading...</div>
                </div>
                <div class="vat-note">(incl. VAT)</div>
            </div>

            <a href="#" class="subscribe-button">Subscribe</a>
        </div>
    </div>
    <?php
    require_once __DIR__ . "/../../Homepage/includes/footer.php";
    ?>
    <script>
        // Load meal details from localStorage first
        function loadMealDetails() {
            const storedPlan = localStorage.getItem('selectedPlan');
            if (storedPlan) {
                const planData = JSON.parse(storedPlan);
                updatePageWithPlanData(planData);
                return true;
            }
            return false;
        }

        function updatePageWithPlanData(planData) {
            document.getElementById("mealName").textContent = planData.name;
            document.getElementById("mealDescription").textContent = planData.description;
            document.getElementById("mealImage").src = planData.image_url;
            document.getElementById("mealGoal").textContent = planData.goal;
            const formattedPrice = `JOD ${Number(planData.price).toFixed(2)}`;
            document.getElementById("mealPrice").textContent = formattedPrice;
            document.getElementById("mealPriceTotal").textContent = formattedPrice;
            const trialPrice = (Number(planData.price) / 20).toFixed(2);
            document.getElementById("trialPrice").textContent = `Starting JOD ${trialPrice}`;
            document.title = planData.name;
        }

        async function fetchMealDetailsFromApi() {
            const urlParams = new URLSearchParams(window.location.search);
            const subscriptionId = urlParams.get('id');
            if (!subscriptionId) {
                console.error("No subscription ID found in URL");
                document.getElementById("mealName").textContent = "Error: No plan selected";
                return;
            }
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/subscriptions/${subscriptionId}`);
                if (!response.ok) {
                    throw new Error(`API returned status: ${response.status}`);
                }
                const data = await response.json();
                if (data) {
                    const planData = data.data || data;
                    updatePageWithPlanData(planData);
                    localStorage.setItem('selectedPlan', JSON.stringify(planData));
                } else {
                    console.error("Invalid data structure received from API:", data);
                    document.getElementById("mealName").textContent = "Error loading data";
                }
            } catch (error) {
                console.error("Error fetching subscription details:", error);
                document.getElementById("mealName").textContent = "Error loading data";
                document.getElementById("mealDescription").textContent = "Please try again later.";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const loadedFromStorage = loadMealDetails();
            if (!loadedFromStorage) {
                fetchMealDetailsFromApi();
            }

            const calorieOptions = document.querySelectorAll('.calorie-option');
            calorieOptions.forEach(option => {
                option.addEventListener('click', function() {
                    calorieOptions.forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            const durationOptions = document.querySelectorAll('.duration-option');
            durationOptions.forEach(option => {
                option.addEventListener('click', function() {
                    durationOptions.forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            const packageOptions = document.querySelectorAll('.package-option');
            packageOptions.forEach(option => {
                option.addEventListener('click', function() {
                    packageOptions.forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
            const subscribeButton = document.querySelector('.subscribe-button');
            subscribeButton.addEventListener('click', function(e) {
                e.preventDefault();
                const planData = JSON.parse(localStorage.getItem('selectedPlan'));
                const selectedCalorie = document.querySelector('.calorie-option.selected').textContent;
                const selectedDuration = document.querySelector('.duration-option.selected').textContent;
                const selectedPackage = document.querySelector('.package-option.selected .package-name').textContent;

                const packagePrice = parseFloat(planData.price);
                const totalPrice = packagePrice;

                const checkoutData = {
                    plan: {
                        name: planData.name,
                        type: selectedPackage,
                        calories: selectedCalorie + ' Kcal',
                        days: selectedDuration + ' days'
                    },
                    pricing: {
                        package_price: packagePrice,
                        total: totalPrice
                    },
                    currency: 'AED',
                    start_date: new Date(Date.now() + (2 * 24 * 60 * 60 * 1000)).toLocaleDateString('en-US', {
                        weekday: 'short',
                        day: 'numeric',
                        month: 'short'
                    })
                };

                localStorage.setItem('checkoutData', JSON.stringify(checkoutData));
                window.location.href = 'Checkout.php';
            });

        });
    </script>
</body>

</html>