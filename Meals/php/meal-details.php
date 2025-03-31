<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Carb Meal Plan</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 2500px;  
            margin: 0 auto;
            padding: 25px;  
            display: flex;
            flex-wrap: wrap;
        }
        .left-column {
            flex: 1;
            min-width: 375px;  
            padding-right: 25px;  
        }
        .right-column {
            flex: 1;
            min-width: 375px;  
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;  
        }
        .header h1 {
            margin: 0;
            font-size: 25px;  
            margin-left: 12px;  
        }
        .back-button {
            font-size: 25px;  
            text-decoration: none;
            color: #333;
        }
        .description {
            font-size: 18px;  
            color: #666;
            margin-bottom: 25px;  
        }
        .feature-image {
            width: 100%;
            height: 312px;  
            object-fit: cover;
            border-radius: 12px;  
            margin-bottom: 25px;  
            position: relative;
        }
        .feature-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }
        .overlay-text {
            position: absolute;
            bottom: 25px;  
            left: 25px;  
            color: white;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
        .overlay-text h2 {
            margin: 0;
            font-size: 20px;  
            font-weight: normal;
        }
        .overlay-text h3 {
            margin: 0;
            font-size: 30px;  
            font-weight: bold;
        }
        .thumbnail-row {
            display: flex;
            overflow-x: auto;
            gap: 12px;  
            margin-bottom: 25px;  
        }
        .thumbnail {
            width: 62px; 
            height: 62px; 
            border-radius: 6px;  
            flex-shrink: 0;
        }
        .section-title {
            font-size: 20px;  
            font-weight: bold;
            margin-bottom: 18px;  
        }
        .package-options {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); 
            gap: 18px; 
            margin-bottom: 31px;  
        }
        .package-option {
            border: 1px solid #ddd;
            border-radius: 10px;  
            padding: 12px; 
            cursor: pointer;
            transition: border-color 0.3s;
        }
        .package-option.selected {
            border-color: #ff6b35;
        }
        .package-image {
            width: 100%;
            height: 100px;  
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 6px;  
        }
        .package-name {
            font-weight: bold;
            font-size: 15px;  
            margin-bottom: 6px;  
        }
        .package-details {
            font-size: 13px;  
            color: #666;
        }
        .customize-option {
            display: flex;
            align-items: center;
            margin-bottom: 25px;  
            font-size: 15px;  
            color: #ff6b35;
        }
        .calorie-options {
            display: flex;
            gap: 13px; 
            margin-bottom: 25px;  
        }
        .calorie-option {
            border: 1px solid #ddd;
            border-radius: 25px;  
            padding: 7px 19px;  
            font-size: 17px;  
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .calorie-option.selected {
            background-color: #ff6b35;
            color: white;
            border-color: #ff6b35;
        }
        .calorie-help {
            display: flex;
            align-items: center;
            font-size: 15px;  
            color: #666;
            margin-bottom: 25px;  
        }
        .calorie-help i {
            color: #ff6b35;
            margin-right: 7px;  
        }
        .calorie-help a {
            color: #ff6b35;
            text-decoration: none;
            margin-left: 7px;  
        }
        .trial-box {
            background-color: #ff6b35;
            color: white;
            border-radius: 10px;  
            padding: 18px;  
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;  
        }
        .trial-box .title {
            font-weight: bold;
            font-size: 20px;  
        }
        .trial-box .price {
            font-size: 18px;  
        }
        .trial-box .button {
            background-color: white;
            color: #333;
            border-radius: 25px;  
            padding: 7px 19px;  
            font-size: 15px;  
            text-decoration: none;
        }
        .duration-options {
            margin-bottom: 25px;  
        }
        .duration-options p {
            font-size: 15px;  
            color: #666;
            margin-bottom: 13px;  
        }
        .duration-row {
            display: flex;
            gap: 13px;  
            margin-bottom: 13px;  
        }
        .duration-option {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 7px;  
            padding: 13px;  
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s;
            font-size: 17px;  
        }
        .duration-option.selected {
            border-color: #ff6b35;
        }
        .discount-tag {
            font-size: 13px;  
            color: #ff6b35;
            margin-top: 7px;  
        }
        .start-plan {
            display: flex;
            align-items: center;
            font-size: 15px;  
            color: #666;
            margin-bottom: 25px;  
        }
        .start-plan i {
            color: #ff6b35;
            margin-right: 7px;  
        }
        .nutrition-breakdown {
            margin-bottom: 25px;  
        }
        .nutrition-bars {
            display: flex;
            gap: 13px;  
            margin-bottom: 13px;  
        }
        .nutrition-bar {
            flex: 1;
            border-radius: 7px;  
            padding: 13px;  
            font-size: 15px;  
        }
        .nutrition-bar.proteins {
            background-color: #e8f5e9;
        }
        .nutrition-bar.carbs {
            background-color: #fff3e0;
        }
        .nutrition-bar.fat {
            background-color: #e1f5fe;
        }
        .nutrition-name {
            font-weight: bold;
            margin-bottom: 7px;  
        }
        .nutrition-value {
            font-size: 16px;  
        }
        .nutrition-disclaimer {
            font-size: 13px;  
            color: #666;
            margin-bottom: 25px;  
        }
        .view-menu-button {
            display: block;
            width: 100%;
            padding: 13px;  
            border: 1px solid #ddd;
            border-radius: 7px;  
            text-align: center;
            text-decoration: none;
            color: #333;
            margin-bottom: 25px;  
        }
        .price-summary {
            border-top: 1px solid #ddd;
            padding-top: 18px;  
            margin-bottom: 25px;  
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 13px;  
            font-size: 16px;  
        }
        .price-row.total {
            font-weight: bold;
        }
        .vat-note {
            font-size: 13px;  
            color: #666;
            text-align: right;
        }
        .subscribe-button {
            display: block;
            width: 100%;
            padding: 18px; 
            background-color: #000;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 7px; 
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
    // Example data - in a real application, this would come from a database
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

    <div class="container">
        <div class="left-column">
            <div class="header">
                <a href="#" class="back-button">←</a>
                <h1>Low Carb Meal Plan</h1>
            </div>
            <div class="description">
                Reach your goals & curb your cravings with low carb, high protein meals.
            </div>
            <div class="feature-image">
                <img src="https://via.placeholder.com/600x400" alt="Low Carb Meal">
                <div class="overlay-text">
                    <h2>Optimal for</h2>
                    <h3>Toning</h3>
                </div>
            </div>
            <div class="thumbnail-row">
                <img src="https://via.placeholder.com/50" alt="Meal Thumbnail" class="thumbnail">
                <img src="https://via.placeholder.com/50" alt="Meal Thumbnail" class="thumbnail">
                <img src="https://via.placeholder.com/50" alt="Meal Thumbnail" class="thumbnail">
                <img src="https://via.placeholder.com/50" alt="Meal Thumbnail" class="thumbnail">
                <img src="https://via.placeholder.com/50" alt="Meal Thumbnail" class="thumbnail">
                <img src="https://via.placeholder.com/50" alt="Meal Thumbnail" class="thumbnail">
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
                <i>●</i> Vegan, pescatarian, or with other preferences? Fully customize your plan after payment.
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
                    <div class="price">Starting AED 41</div>
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
                <i>●</i> Start your plan as early as Wed 3 Apr
                <br>You will be able to choose the start date that suits you after checkout.
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
                    <div></div>
                    <div></div>
                </div>
                <div class="price-row">
                    <div></div>
                    <div></div>
                </div>
                <div class="price-row total">
                    <div>Subtotal</div>
                    <div>AED 328.00</div>
                </div>
                <div class="vat-note">(incl. VAT)</div>
            </div>

            <a href="#" class="subscribe-button">Subscribe</a>
        </div>
    </div>

    <script>
        // Simple interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Package selection
            const packageOptions = document.querySelectorAll('.package-option');
            packageOptions.forEach(option => {
                option.addEventListener('click', function() {
                    packageOptions.forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            // Calorie selection
            const calorieOptions = document.querySelectorAll('.calorie-option');
            calorieOptions.forEach(option => {
                option.addEventListener('click', function() {
                    calorieOptions.forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            // Duration selection
            const durationOptions = document.querySelectorAll('.duration-option');
            durationOptions.forEach(option => {
                option.addEventListener('click', function() {
                    durationOptions.forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        });
    </script>
</body>
</html>