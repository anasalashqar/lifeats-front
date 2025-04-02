<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Our Meal Plans</title>
  <link rel="stylesheet" href="../css/meal.css" />
  <style>
    .pagination-dots {
      display: flex;
      justify-content: center;
      margin: 2rem 0;
      gap: 10px;
    }

    .pagination-dots .dot {
      width: 12px;
      height: 12px;
      background-color: #ff691c;
      border-radius: 50%;
      cursor: pointer;
      opacity: 0.4;
      transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .pagination-dots .dot.active {
      opacity: 1;
      transform: scale(1.4);
    }
  </style>

</head>

<body>
  <?php
  require_once __DIR__ . "/../../Homepage/includes/navbar.php";
  ?>
  <div class="container">
    <h1 class="page-title">🍽️ Our Meal Plans</h1>
    <p class="page-description">Explore our healthy, delicious and goal-focused meal categories!</p>

    <!-- Here we will load the meal categories dynamically -->
    <div id="categories" class="categories-grid">
      <!-- Cards will be inserted here via JS -->
    </div>
  </div>
  <div id="paginationDots" class="pagination-dots"></div>

  <?php
  require_once __DIR__ . "/../../Homepage/includes/footer.php";
  ?>
  <script>
    document.addEventListener("DOMContentLoaded", async function() {
      const container = document.getElementById("categories");
      const dotsContainer = document.getElementById("paginationDots");
      const perPage = 9;
      let meals = [];

      try {
        const response = await fetch("http://127.0.0.1:8000/api/meals");
        const result = await response.json();

        if (result.status) {
          meals = result.data;
          const totalPages = Math.ceil(meals.length / perPage);

          renderPagination(totalPages);
          renderMeals(1);
        } else {
          container.innerHTML = "<p style='color:red;'>⚠️ No meals available.</p>";
        }
      } catch (error) {
        console.error("❌ Failed to fetch meals:", error);
        container.innerHTML = "<p style='color:red;'>❌ Error loading meals.</p>";
      }

      function renderMeals(page) {
        container.innerHTML = "";
        const start = (page - 1) * perPage;
        const pageMeals = meals.slice(start, start + perPage);

        pageMeals.forEach(meal => {
          const card = document.createElement("div");
          card.classList.add("meal-card");

          card.innerHTML = `
          <img src="${meal.image_url}" alt="${meal.name}" class="meal-image" />
          <div class="meal-info">
            <h3 class="meal-name">${meal.name}</h3>
            <p class="meal-description">${meal.description}</p>
            <ul class="meal-nutrition">
              <li><strong>Calories:</strong> ${meal.calories}</li>
              <li><strong>Protein:</strong> ${meal.protein}g</li>
              <li><strong>Carbs:</strong> ${meal.carbs}g</li>
              <li><strong>Fats:</strong> ${meal.fats}g</li>
            </ul>
          </div>
        `;

          container.appendChild(card);
        });
      }

      function renderPagination(totalPages) {
        dotsContainer.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
          const dot = document.createElement("div");
          dot.classList.add("dot");
          if (i === 1) dot.classList.add("active");

          dot.addEventListener("click", () => {
            document.querySelectorAll(".pagination-dots .dot").forEach(d => d.classList.remove("active"));
            dot.classList.add("active");
            renderMeals(i);
          });

          dotsContainer.appendChild(dot);
        }
      }
    });
  </script>

</body>

</html>