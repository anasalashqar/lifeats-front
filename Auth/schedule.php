<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Weekly Meal Schedule</title>

  <!-- Bootstrap + Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

  <!-- Your Custom Gradient Style -->
  <style>
    body {
      background: linear-gradient(to left, #ff691c, #ff9d57);
      font-family: 'Quicksand', sans-serif;
      margin: 0;
    }

    .tab-content {
      background: #fff;
      padding: 2rem;
      border-radius: 1.5rem;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
      margin-top: 1rem;
    }

    .nav-tabs .nav-link.active {
      background-color: #ff691c !important;
      color: white !important;
      font-weight: bold;
    }

    .nav-tabs .nav-link {
      color: #ff691c;
      font-weight: 600;
    }

    .accordion-button {
      font-weight: 600;
      background-color: #f8f9fa;
    }

    .meal-item {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 1rem;
      border-bottom: 1px solid #eee;
    }

    .meal-item img {
      width: 60px;
      height: 60px;
      border-radius: 0.75rem;
      object-fit: cover;
    }

    .meal-info h6 {
      margin: 0;
      font-weight: 600;
      color: #333;
    }

    .meal-info small {
      color: #777;
    }

    .locked-badge {
      font-size: 0.8rem;
      font-weight: bold;
      color: white;
      background-color: #ff691c;
      border-radius: 0.5rem;
      padding: 0.25rem 0.5rem;
    }
  </style>
</head>

<body>
  <?php
  require_once __DIR__ . "/../Homepage/includes/navbar.php";
  ?>
  <div class="container p-2 mt-5 mb-5">
    <h2 class="text-white text-center mb-4"><i class="fas fa-calendar-week me-2"></i>My Weekly Meal Schedule</h2>

    <ul class="nav nav-tabs" id="scheduleTabs" role="tablist"></ul>
    <div class="tab-content" id="scheduleTabContent"></div>
  </div>
  <?php
  require_once __DIR__ . "/../Homepage/includes/footer.php";
  ?>
  <!-- Script -->
  <script>
    // Utility to get a cookie by name
    function getCookie(name) {
      const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
      return match ? decodeURIComponent(match[2]) : null;
    }

    const userCookie = getCookie('user');


    if (!userCookie) {
      // Redirect to 403 page if cookie not found
      window.location.href = '/../dashboard/views/403.php';
    } else {
      const user = JSON.parse(userCookie);
      const userId = user.id;
      console.log(userId);
      fetch(`http://localhost:8000/api/user-subscriptions/${userId}/schedule`)
        .then(async res => {
          if (res.status === 403) {
            window.location.href = '/../dashboard/views/403.php';
            return;
          }



          const data = await res.json();


          const tabList = document.getElementById('scheduleTabs');
          const tabContent = document.getElementById('scheduleTabContent');

          if (!Array.isArray(data)) {
            tabContent.innerHTML = `<div class="alert alert-warning text-center">No schedule found.</div>`;
            return;
          }


          data.slice(0, 7).forEach((day, index) => {
            const date = new Date(day.date);
            const dayName = date.toLocaleDateString('en-US', {
              weekday: 'short'
            });

            // Tabs
            const tab = document.createElement('li');
            tab.className = 'nav-item';
            tab.innerHTML = `
          <button class="nav-link ${index === 0 ? 'active' : ''}" id="tab-${index}" data-bs-toggle="tab" data-bs-target="#day-${index}" type="button" role="tab">
            ${dayName}<br><small>${day.date}</small>
          </button>
        `;
            tabList.appendChild(tab);

            // Meals by category
            const categoryMap = {};
            day.selections.forEach(sel => {
              if (!categoryMap[sel.category]) categoryMap[sel.category] = [];
              categoryMap[sel.category].push(sel.meal);
            });

            let accordionHTML = '';
            let catIndex = 0;
            for (let cat in categoryMap) {
              const mealsHTML = categoryMap[cat].map(meal => `
            <div class="meal-item">
              <img src="${meal.image_url}" alt="${meal.name}" />
              <div class="meal-info">
                <h6>${meal.name}</h6>
                <small>${meal.calories} cal</small>
              </div>
            </div>
          `).join('');

              accordionHTML += `
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading-${index}-${catIndex}">
                <button class="accordion-button ${catIndex > 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${index}-${catIndex}">
                  <i class="fas fa-utensils me-2 text-orange"></i> ${cat}
                </button>
              </h2>
              <div id="collapse-${index}-${catIndex}" class="accordion-collapse collapse ${catIndex === 0 ? 'show' : ''}" data-bs-parent="#accordion-${index}">
                <div class="accordion-body">
                  ${mealsHTML}
                </div>
              </div>
            </div>
          `;
              catIndex++;
            }

            const tabPane = document.createElement('div');
            tabPane.className = `tab-pane fade ${index === 0 ? 'show active' : ''}`;
            tabPane.id = `day-${index}`;
            tabPane.setAttribute('role', 'tabpanel');
            tabPane.innerHTML = `
          <div class="d-flex justify-content-end mb-3">
            ${day.locked ? '<span class="locked-badge"><i class="fas fa-lock me-1"></i> Locked</span>' : ''}
          </div>
          <div class="accordion" id="accordion-${index}">
            ${accordionHTML}
          </div>
        `;

            tabContent.appendChild(tabPane);
          });
        })
        .catch(err => {
          console.error(err);
          document.getElementById("scheduleTabContent").innerHTML = `
        <div class="alert alert-danger text-center">Error loading schedule.</div>
      `;
        });
    }
  </script>

  <!-- Bootstrap JS (for tabs & accordion) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>