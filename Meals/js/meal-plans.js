async function loadMealCategories() {
    try {
      const response = await fetch("http://localhost:8000/api/meal-categories");
      const result = await response.json();
  
      if (result.status) {
        const container = document.getElementById("categories");
        container.innerHTML = ""; 
  
        result.data.forEach(category => {
          const card = document.createElement("div");
          card.classList.add("category-card");
  
          card.innerHTML = `
            <img src="${category.image}" alt="${category.name}" class="category-image" />
            <h3 class="category-name">${category.name}</h3>
          `;
  
      
          card.addEventListener("click", () => {
            window.location.href = `meal-details.php?category=${category.id}`;
          });
  
          container.appendChild(card);
        });
      } else {
        console.error("⚠️ API returned error status");
      }
    } catch (error) {
      console.error("❌ Failed to fetch meal categories:", error);
    }
  }
  
  document.addEventListener("DOMContentLoaded", loadMealCategories);
  