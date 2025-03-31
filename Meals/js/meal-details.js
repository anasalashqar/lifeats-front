async function fetchMealDetails() {
  const urlParams = new URLSearchParams(window.location.search);
  const subscriptionId = urlParams.get('id'); 
  
  try {
    const response = await fetch(`http://localhost:8000/api/subscriptions/${subscriptionId}`);
    const data = await response.json();

    if (data.status) {
     
      document.getElementById("mealImage").src = data.data.image_url;
      document.getElementById("mealName").textContent = data.data.name;
      document.getElementById("mealDescription").textContent = data.data.description;
      document.getElementById("mealGoal").textContent = data.data.goal;
      document.getElementById("mealPrice").textContent = `AED ${data.data.price.toFixed(2)}`;
      document.getElementById("mealPriceTotal").textContent = data.data.price.toFixed(2);
    } else {
      console.error("Failed to load subscription data.");
    }
  } catch (error) {
    console.error("Error fetching subscription details:", error);
  }
}

document.addEventListener("DOMContentLoaded", fetchMealDetails);
