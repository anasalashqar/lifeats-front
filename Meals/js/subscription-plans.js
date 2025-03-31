
async function loadSubscriptions() {
    try {
      const response = await fetch("http://localhost:8000/api/subscriptions");
      const data = await response.json();
  
      if (Array.isArray(data)) {
        const container = document.getElementById("subscriptions");
        container.innerHTML = "";
  
        data.forEach(plan => {
          const card = document.createElement("div");
          card.classList.add("meal-card");
  
          card.innerHTML = `
            <div class="meal-overlay">Optimal for <br>${plan.goal}</div>
            <img src="${plan.image_url}" alt="${plan.name}" class="meal-image" />
            <div class="meal-info">
              <div class="meal-name">${plan.name}</div>
              <div class="meal-description">${plan.description}</div>
              <div class="meal-price">Starting from JOD ${ (Number(plan.price)).toFixed(2) } per month</div>

            </div>
          `;
  
          container.appendChild(card);
        });
      } else {
        console.error("⚠️ API response is not an array");
      }
    } catch (error) {
      console.error("❌ Failed to fetch subscriptions:", error);
    }
  }
  
  document.addEventListener("DOMContentLoaded", loadSubscriptions);
  