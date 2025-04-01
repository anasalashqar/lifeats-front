<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Meal Categories</title>
  <link rel="stylesheet" href="../css/meal-plan.css" />
</head>
<body>
  <div class="container">
    <h1 class="page-title">Our Meal Categories</h1>
    <p class="page-description">
      Explore a variety of meal types to match your daily routine — from energizing breakfasts to satisfying lunches, wholesome dinners, light snacks, and fresh salads.
    </p>

    <div id="categories" class="categories-grid"></div>
  </div>

  <script>
    const tags = {
      breakfast: "Perfect for mornings",
      lunch: "Mid-day meals",
      dinner: "Evening delight",
      snacks: "On-the-go fuel",
      salads: "Crisp & healthy"
    };

    const descriptions = {
      breakfast: "Start your day with healthy and energizing meals.",
      lunch: "Satisfy your hunger with balanced mid-day options.",
      dinner: "Enjoy delicious dinners to end your day right.",
      snacks: "Light and tasty bites between meals.",
      salads: "Fresh greens and wholesome combinations."
    };

    fetch('http://localhost:8000/api/meal-categories')
      .then(response => response.json())
      .then(result => {
        if (result.status) {
          const categories = result.data;
          const container = document.getElementById('categories');

          categories.forEach(category => {
            const nameKey = category.name.toLowerCase();
            const tag = tags[nameKey] || "Meal time";
            const description = descriptions[nameKey] || "Delicious and nutritious.";
            const image = category.image || "https://via.placeholder.com/300x250?text=No+Image";

            const card = document.createElement('div');
            card.className = 'category-card';
            card.onclick = () => {
              window.location.href = `meal-details.php?category=${category.id}`;
            };

            card.innerHTML = `
              <img src="${image}" alt="${category.name}" class="category-image" />
              <div class="category-overlay">
                <p class="category-tag">${tag}</p>
                <h2 class="category-highlight">${category.name}</h2>
              </div>
              <div class="category-content">
                <h3 class="category-name">${category.name}</h3>
                <p class="category-description">${description}</p>
              </div>
            `;

            container.appendChild(card);
          });
        } else {
          document.getElementById('categories').innerHTML = '<p style="color:red;">🚫 No categories found.</p>';
        }
      })
      .catch(error => {
        console.error('Error fetching meal categories:', error);
        document.getElementById('categories').innerHTML = '<p style="color:red;">⚠️ Failed to load meal categories.</p>';
      });
  </script>
</body>
</html>
