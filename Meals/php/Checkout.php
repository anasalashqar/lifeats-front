<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Meal Plan</title>
    <link rel="stylesheet" href="../css/checkout.css">
</head>
<body>
    <div class="container">
        <div class="left-column">
            <div class="section">
                <div class="section-title">Delivery address</div>
                <div class="location-container">
                    <div class="location-icon">📍</div>
                    <div class="location-info">
                        Jordan
                        <div class="location-address">Amman</div>
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
                        <span class="flag">JO</span>
                        +962
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
                        <div id="planName">Loading...</div>
                        <div class="meal-details">
                            <span id="planType">Loading...</span><br>
                            <span id="planCalories">Loading...</span>, <span id="planDays">Loading...</span>
                        </div>
                    </div>
                </div>
                <a href="meal-details.php" class="edit-link">Edit</a>
            </div>
            
            <div class="start-date-box">
                <div class="calendar-icon">📅</div>
                <div class="date-info">
                    <div class="date-title">Start your plan as early as <span id="startDate">Loading...</span></div>
                    <div class="date-description">
                        You will be able to choose the start date that suits you after checkout.
                    </div>
                </div>
            </div>
            
            <div class="payment-summary-title">Payment summary</div>
            
            <div class="price-row">
                <div>Package Price</div>
                <div id="packagePrice">Loading...</div>
            </div>
            
            <div class="total-row">
                <div>Total</div>
                <div>
                    <span id="totalPrice">Loading...</span>
                </div>
            </div>
            
            <button class="pay-button" id="payButton">Pay Loading...</button>
        </div>
    </div>

    <script>
        // Load checkout data from localStorage
        function loadCheckoutData() {
            const checkoutData = localStorage.getItem('checkoutData');
            if (checkoutData) {
                const data = JSON.parse(checkoutData);

                // Update plan details
                document.getElementById('planName').textContent = data.plan.name;
                document.getElementById('planType').textContent = data.plan.type;
                document.getElementById('planCalories').textContent = data.plan.calories;
                document.getElementById('planDays').textContent = data.plan.days;
                document.getElementById('startDate').textContent = data.start_date;

                // Update pricing details
                const currency = data.currency;
                document.getElementById('packagePrice').textContent = `${currency} ${data.pricing.package_price.toFixed(2)}`;
                document.getElementById('totalPrice').textContent = `${currency} ${data.pricing.total.toFixed(2)}`;

                // Update pay button
                document.getElementById('payButton').textContent = `Pay ${currency} ${data.pricing.total.toFixed(2)}`;
            } else {
                alert('No checkout data found. Please return to the meal details page.');
                window.location.href = 'meal-details.php';
            }
        }

        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Load checkout data when page loads
            loadCheckoutData();

            // Handle pay button click (for demo purposes)
            document.getElementById('payButton').addEventListener('click', function() {
                const checkoutData = JSON.parse(localStorage.getItem('checkoutData'));
                console.log('Payment initiated:', checkoutData);
                alert('Payment processing initiated! (This is a demo)');
                
            });

            // Handle time option selection
            const timeOptions = document.querySelectorAll('.time-option');
            timeOptions.forEach(option => {
                option.addEventListener('click', function() {
                    timeOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        });
    </script>
</body>
</html>
