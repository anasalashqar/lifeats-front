async function loadMeals() {
    try {
      const response = await fetch("http://localhost:8000/api/meals");
      const result = await response.json();
  
      if (result.status) {
        const container = document.getElementById("categories"); 
        container.innerHTML = "";
  
        result.data.forEach(meal => {
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
      } else {
        console.error("⚠️ API returned error status");
      }
    } catch (error) {
      console.error("❌ Failed to fetch meals:", error);
    }
  }
  
  document.addEventListener("DOMContentLoaded", loadMeals);
  