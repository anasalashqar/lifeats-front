<?php
// Sample data - in a real application, this would come from a database
$plan = [
    'name' => 'Convenience Meal Plan',
    'type' => 'Lunch',
    'calories' => '550-650 Kcal',
    'days' => '5 days'
];

$pricing = [
    'package_price' => 259.00,
    'cooler_bag_deposit' => 150.00,
    'vat' => 12.95,
    'total' => 422.00
];

$currency = 'AED';
$start_date = 'Thu 3 Apr';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Meal Plan</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.5;
            padding: 20px;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            gap: 20px;
        }
        .left-column {
            flex: 1;
            padding: 20px 0;
        }
        .right-column {
            flex: 1;
            background: white;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .edit-link {
            color: #FF8C00;
            text-decoration: none;
            font-size: 14px;
            float: right;
            margin-top: 5px;
        }
        .location-container {
            display: flex;
            align-items: flex-start;
            margin-bottom: 5px;
        }
        .location-icon {
            background-color: #FFF5EB;
            color: #FF8C00;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        .location-info {
            font-size: 16px;
        }
        .location-address {
            color: #888;
            font-size: 14px;
            margin-top: 2px;
        }
        .time-options {
            display: flex;
            gap: 10px;
        }
        .time-option {
            border: 1px solid #E5E5E5;
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }
        .time-option.selected {
            background-color: #FFF5EB;
            border-color: #FF8C00;
        }
        .contact-form {
            display: flex;
            gap: 10px;
            margin-bottom: 5px;
        }
        .country-code {
            border: 1px solid #E5E5E5;
            border-radius: 5px;
            display: flex;
            align-items: center;
            padding: 0 10px;
            width: 100px;
        }
        .flag {
            margin-right: 8px;
        }
        .mobile-input {
            flex: 1;
            border: 1px solid #E5E5E5;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 14px;
        }
        .error-message {
            color: #FF4444;
            font-size: 12px;
            margin-top: 5px;
        }
        .payment-option {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .payment-icon {
            margin-right: 10px;
            font-size: 20px;
            color: #555;
        }
        .payment-text {
            flex: 1;
        }
        .payment-radio {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #ddd;
        }
        .credits-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-top: 1px solid #EAEAEA;
        }
        .credit-button {
            background-color: #00A36C;
            color: white;
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 4px;
            margin-right: 10px;
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 24px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            border-radius: 34px;
            transition: .4s;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            border-radius: 50%;
            transition: .4s;
        }
        input:checked + .slider {
            background-color: #00A36C;
        }
        input:checked + .slider:before {
            transform: translateX(16px);
        }
        .discount-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-top: 1px solid #EAEAEA;
        }
        .add-code {
            color: #FF8C00;
            text-decoration: none;
        }
        
        /* Right column styles */
        .plan-summary-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
        }
        .meal-plan-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .meal-plan-info {
            display: flex;
            align-items: flex-start;
        }
        .meal-icon {
            background-color: #FFF5EB;
            color: #FF8C00;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 18px;
        }
        .meal-details {
            font-size: 14px;
            color: #888;
            margin-top: 5px;
            line-height: 1.4;
        }
        .start-date-box {
            background-color: #EFF8FC;
            border-radius: 8px;
            padding: 16px;
            margin: 25px 0;
            display: flex;
            align-items: flex-start;
        }
        .calendar-icon {
            color: #3399CC;
            font-size: 20px;
            margin-right: 10px;
        }
        .date-info {
            flex: 1;
        }
        .date-title {
            font-weight: 500;
            margin-bottom: 5px;
        }
        .date-description {
            font-size: 14px;
            color: #666;
        }
        .payment-summary-title {
            font-size: 18px;
            font-weight: 600;
            margin: 25px 0 15px;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding-top: 12px;
            margin-top: 5px;
            border-top: 1px solid #EAEAEA;
            font-weight: 600;
        }
        .vat-note {
            font-size: 12px;
            color: #888;
            font-weight: normal;
        }
        .pay-button {
            background-color: black;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 16px;
            font-size: 16px;
            width: 100%;
            margin-top: 25px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-column">
            <div class="section">
                <div class="section-title">Delivery address</div>
                <div class="location-container">
                    <div class="location-icon">📍</div>
                    <div class="location-info">
                        Other
                        <div class="location-address">Other</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <a href="#" class="edit-link">Edit</a>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Delivery time</div>
                <div class="time-options">
                    <div class="time-option selected">04:00 - 08:00</div>
                    <div class="time-option">18:00 - 21:00</div>
                    <div class="time-option">18:02 - 21:00</div>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Contact details</div>
                <div class="contact-form">
                    <div class="country-code">
                        <span class="flag">🇦🇪</span>
                        +971
                    </div>
                    <input type="text" class="mobile-input" placeholder="Mobile number">
                </div>
                <div class="error-message">The mobile number is not valid</div>
            </div>

            <div class="section">
                <div class="section-title">Payment</div>
                <div class="payment-option">
                    <div class="payment-icon">💳</div>
                    <div class="payment-text">Add new card</div>
                    <div class="payment-radio"></div>
                </div>
                
                <div class="credits-row">
                    <div>Use credits</div>
                    <div style="display: flex; align-items: center;">
                        <span class="credit-button">AED 0</span>
                        <label class="toggle-switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
                
                <div class="discount-row">
                    <div>Looking for discount code?</div>
                    <a href="#" class="add-code">Add code</a>
                </div>
            </div>
        </div>

        <div class="right-column">
            <div class="plan-summary-title">Plan summary</div>
            
            <div class="meal-plan-container">
                <div class="meal-plan-info">
                    <div class="meal-icon">🍽️</div>
                    <div>
                        <div><?php echo $plan['name']; ?></div>
                        <div class="meal-details">
                            <?php echo $plan['type']; ?><br>
                            <?php echo $plan['calories']; ?>, <?php echo $plan['days']; ?>
                        </div>
                    </div>
                </div>
                <a href="#" class="edit-link">Edit</a>
            </div>
            
            <div class="start-date-box">
                <div class="calendar-icon">📅</div>
                <div class="date-info">
                    <div class="date-title">Start your plan as early as <?php echo $start_date; ?></div>
                    <div class="date-description">
                        You will be able to choose the start date that suits you after checkout.
                    </div>
                </div>
            </div>
            
            <div class="payment-summary-title">Payment summary</div>
            
            <div class="price-row">
                <div>Package Price</div>
                <div><?php echo $currency; ?> <?php echo number_format($pricing['package_price'], 2); ?></div>
            </div>
            
            <div class="price-row">
                <div>Cooler Bag Deposit</div>
                <div><?php echo $currency; ?> <?php echo number_format($pricing['cooler_bag_deposit'], 2); ?></div>
            </div>
            
            <div class="price-row">
                <div>VAT</div>
                <div><?php echo $currency; ?> <?php echo number_format($pricing['vat'], 2); ?></div>
            </div>
            
            <div class="total-row">
                <div>Total</div>
                <div>
                    <span class="vat-note">(incl. VAT)</span> 
                    <?php echo $currency; ?> <?php echo number_format($pricing['total'], 2); ?>
                </div>
            </div>
            
            <button class="pay-button">Pay <?php echo $currency; ?> <?php echo number_format($pricing['total'], 2); ?></button>
        </div>
    </div>
</body>
</html>