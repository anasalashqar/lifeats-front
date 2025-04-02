<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lifeats - Profile Tabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <?php include '../assets/confirm.php'; ?>
    <?php include '../assets/modal.php'; ?>
    <style>
        body {
            background: linear-gradient(to right, #ff691c, #ff9d57);
            font-family: 'Quicksand', sans-serif;
            height: 100vh;
            margin: 0;
            padding: 0;
            position: relative;
        }

        @media (max-width: 800px) {
            body {
                margin-top: 100px;
            }
        }

        .profile-card {
            background: #fff;
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
            margin: auto;
        }

        .nav-tabs .nav-link {
            color: #ff691c;
            font-weight: 600;
        }

        .nav-tabs .nav-link.active {
            background-color: #ff691c;
            color: white;
            border: none;
            border-radius: 1rem;
        }

        .tab-content {
            margin-top: 2rem;
        }

        .btn-orange {
            background-color: #ff691c;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-orange:hover {
            background-color: #e85d17;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-orange {
            background-color: white;
            color: #ff691c;
            border: 2px solid #ff691c;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-outline-orange:hover {
            background-color: #ff691c;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }


        textarea {
            resize: none;
        }

        /* ✅ Final Logout Button Styling */
        .logout-fixed {
            background-color: white;
            color: #ff691c;
            border: 2px solid #ff691c;
            padding: 0.6rem 1.3rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 1000;
        }

        .logout-fixed:hover {
            background-color: #ff691c;
            color: white;
        }
    </style>
</head>

<body>
    <?php
    require_once __DIR__ . "/../Homepage/includes/navbar.php";
    ?>
    <div class="mt-3 mb-3">

        <div class="profile-card">
            <ul class="nav nav-tabs justify-content-center" id="profileTabs" role="tablist">
                <!-- This one stays as a tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">👤 Profile</button>
                </li>

                <!-- These are now normal links to real pages -->
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="history-tab" href="schedule.php" role="tab">📜 Schedule</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="schedule-tab" href="selection.php" role="tab">📆 Today Selections</a>
                </li>
            </ul>
            <div class="tab-content" id="profileTabsContent">

                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <h3 class="text-center mb-3">Update Your Info</h3>
                    <form id="profileForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="preferences" class="form-label">Preferences / Allergies</label>
                            <textarea class="form-control" id="preferences" rows="3" placeholder="No peanuts, dairy-free..."></textarea>
                        </div>
                        <div class="d-flex justify-content-between gap-3 flex-wrap mt-4">
                            <button id="logoutBtn" type="button" class="btn btn-outline-orange">🚪 Logout</button>
                            <button type="submit" class="btn btn-orange">Update Profile</button>
                        </div>

                        <div id="message" class="text-center mt-3 text-danger"></div>
                    </form>
                </div>

                <!-- History Tab -->
                <div class="tab-pane fade" id="history" role="tabpanel">
                    <h3 class="text-center mb-3">Your Subscription History</h3>
                    <p class="text-muted text-center">Coming soon... 🛠️ We’re cooking this feature!</p>
                </div>

                <!-- Schedule Tab -->
                <div class="tab-pane fade" id="schedule" role="tabpanel">
                    <h3 class="text-center mb-3">Today’s Meals</h3>
                    <p class="text-muted text-center">Custom meal schedule will appear here 🍱</p>
                </div>

            </div>
        </div>
    </div>
    <?php
    require_once __DIR__ . "/../Homepage/includes/footer.php";
    ?>
    <script>
        // Get cookie by name
        function s(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? decodeURIComponent(match[2]) : null;
        }

        const userCookie = s('user');

        if (!userCookie) {
            // Cookie not found at all
            window.location.href = '../dashboard/views/403.php';
        } else {
            try {
                const user = JSON.parse(userCookie);

                // Check if user has a valid ID
                if (!user.id || typeof user.id !== 'number') {
                    window.location.href = '../dashboard/views/403.php';
                }

                // Optional: expose userId globally if needed
                window.userId = user.id;

            } catch (error) {
                // Malformed cookie or bad JSON
                console.error('Invalid user cookie:', error);
                window.location.href = '../dashboard/views/403.php';
            }
        }

        const messageDiv = document.getElementById('message');

        // COOKIE UTILS
        function getCookie(name) {
            const cookies = document.cookie.split(';');
            for (let cookie of cookies) {
                const [key, value] = cookie.trim().split('=');
                if (key === name) return decodeURIComponent(value);
            }
            return null;
        }

        function setCookie(name, value, days = 1) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/`;
        }

        function deleteCookie(name) {
            document.cookie = `${name}=; Max-Age=0; path=/`;
        }

        // GET TOKEN FROM COOKIE
        const token = getCookie('token');

        if (!token) {
            messageDiv.textContent = 'You must be logged in.';
        } else {
            // Fetch user profile
            fetch('http://127.0.0.1:8000/api/user', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(res => res.json())
                .then(user => {
                    document.getElementById('name').value = user.name || '';
                    document.getElementById('email').value = user.email || '';
                    document.getElementById('preferences').value = user.preferences || '';
                    setCookie('user', JSON.stringify(user));
                })
                .catch(err => {
                    console.error(err);
                    messageDiv.textContent = 'Failed to load user info.';
                });

            // Handle profile update
            document.getElementById('profileForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const confirmed = await confirmModalPromise("Confirm Update", "Are you sure you want to update your profile?");
                if (!confirmed) return;

                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const preferences = document.getElementById('preferences').value.trim();

                try {
                    const response = await fetch("http://127.0.0.1:8000/api/user", {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify({
                            name,
                            email,
                            preferences
                        })
                    });

                    const result = await response.json();

                    if (result && result.name && result.email) {
                        showModal("Profile Updated", "Your profile was updated successfully.");
                    } else {
                        const errorMessage = result?.message || "Something went wrong.";
                        showModal("Update Failed", errorMessage);
                    }


                } catch (error) {
                    console.error('Profile update failed:', error);
                    showModal("Update Failed", "A server error occurred.");
                }
            });


            // Logout handler
            document.getElementById('logoutBtn').addEventListener('click', async () => {
                const confirmed = await confirmModalPromise("Logout", "Are you sure you want to logout?");
                if (confirmed) {
                    try {
                        await fetch('http://127.0.0.1:8000/api/logout', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${token}`
                            }
                        });

                        deleteCookie('token');
                        deleteCookie('user');
                        deleteCookie('selectedPlan');
                        deleteCookie('checkoutData');

                        window.location.href = 'login.php';
                    } catch (error) {
                        console.error('Logout failed', error);
                        showModal("Logout Failed", "Something went wrong while logging out.");
                    }
                }
            });


        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Your global modal script -->
    <script src="../../assets/global-modal.js"></script>
</body>

</html>