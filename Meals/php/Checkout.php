<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Meal Plan</title>
    <link rel="stylesheet" href="../css/checkout.css">

    <!-- Load Modal First -->
    <?php include '../../assets/modal.php'; ?>
</head>

<body class="p-0 m-0">
    <?php
    require_once __DIR__ . "/../../Homepage/includes/navbar.php";
    ?>
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
                    <div class="time-option selected">08:00AM - 12:00AM</div>
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
                        <span class="credit-button">JOD 0</span>
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
                            <span id="planGoal">Loading...</span><br>
                            <span id="planDescription">Loading...</span>, <span id="planDays">Loading...</span> days
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

            <form id="paymentForm">
                <input type="hidden" name="plan_id" id="planId">
                <button class="pay-button" type="submit" id="payButton">Pay Loading...</button>
            </form>
        </div>
    </div>
    <?php
    require_once __DIR__ . "/../../Homepage/includes/footer.php";
    ?>
    <script>
        // Helper to read cookie by name
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return decodeURIComponent(parts.pop().split(';').shift());
        }

        // Format current date
        function formatDate(date) {
            return date.toISOString().split('T')[0];
        }

        // Load selected plan details
        function loadSelectedPlan() {
            const planData = localStorage.getItem('selectedPlan');
            if (!planData) {
                showModal("Error", 'No selected plan found. Please go back and choose a plan.');
                window.location.href = 'meal-details.php';
                return;
            }

            const plan = JSON.parse(planData);
            document.getElementById('planName').textContent = plan.name;
            document.getElementById('planGoal').textContent = plan.goal;
            document.getElementById('planDescription').textContent = plan.description;
            document.getElementById('planDays').textContent = plan.duration_days;

            const today = new Date();
            document.getElementById('startDate').textContent = formatDate(today);

            const price = parseFloat(plan.price).toFixed(2);
            const priceText = `JOD ${price}`;
            document.getElementById('packagePrice').textContent = priceText;
            document.getElementById('totalPrice').textContent = priceText;
            document.getElementById('payButton').textContent = `Pay ${priceText}`;
            document.getElementById('planId').value = plan.id;
        }

        // Handle subscription logic
        async function submitSubscription(userId, planId) {
            try {
                const token = getCookie('token'); // from cookie

                if (!token) {
                    showModal("Error", 'Missing authentication token.');
                    return;
                }

                const response = await fetch('http://127.0.0.1:8000/api/user-subscriptions/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token // ✅ This is the key line!
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        subscription_id: planId
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    showModal("Error", `${data.message ||'Subscription successful and meals scheduled!'} `);

                    console.log('Success:', data);
                    // Optional redirect or UI update
                } else {
                    showModal("Error", `${data.message || 'Subscription failed.'} `);
                    console.error('Error:', data);
                }
            } catch (error) {
                console.log('About to show modal');
                console.log(typeof showModal, showModal);
                showModal("Error", "An error occurred during subscription.");
                console.error('Request failed:', error);
            }
        }

        // Run when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            loadSelectedPlan();

            document.getElementById('paymentForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const plan = JSON.parse(localStorage.getItem('selectedPlan'));
                const userCookie = getCookie('user');

                if (!plan || !plan.id || !userCookie) {
                    showModal("Error", 'Missing user or plan data.');


                    return;
                }

                const user = JSON.parse(userCookie);
                submitSubscription(user.id, plan.id);
            });

            // Optional time option behavior
            document.querySelectorAll('.time-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.time-option').forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Your global modal script -->
    <script src="../../assets/global-modal.js"></script>

</body>

</html>