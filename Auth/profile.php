<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lifeats - Profile Tabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ff691c, #ff9d57);
            font-family: 'Quicksand', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            margin: 0;
        }

        .profile-card {
            background: #fff;
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
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
            padding: 0.75rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
        }

        .btn-orange:hover {
            background-color: #e85d17;
        }

        textarea {
            resize: none;
        }
    </style>
</head>

<body>

    <div class="profile-card">
        <ul class="nav nav-tabs justify-content-center" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">👤 Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">📜 History</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab">📆 Today</button>
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
                    <div class="d-grid">
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


    <script>
        const token = localStorage.getItem('token');
        const messageDiv = document.getElementById('message');

        if (!token) {
            messageDiv.textContent = 'You must be logged in.';
        } else {
            // Fetch user profile on page load
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
                    localStorage.setItem('user', JSON.stringify(user));
                })
                .catch(err => {
                    console.error(err);
                    messageDiv.textContent = 'Failed to load user info.';
                });

            // Handle profile update
            document.getElementById('profileForm').addEventListener('submit', async (e) => {
                e.preventDefault();

                const payload = {
                    name: document.getElementById('name').value.trim(),
                    email: document.getElementById('email').value.trim(),
                    preferences: document.getElementById('preferences').value.trim(),
                };

                try {
                    const res = await fetch('http://127.0.0.1:8000/api/user', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await res.json();

                    if (res.ok) {
                        messageDiv.style.color = 'green';
                        messageDiv.textContent = 'Profile updated successfully!';
                        localStorage.setItem('user', JSON.stringify(data.user || payload));
                    } else {
                        messageDiv.textContent = data.message || 'Update failed.';
                    }
                } catch (err) {
                    console.error(err);
                    messageDiv.textContent = 'Something went wrong. Please try again.';
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>