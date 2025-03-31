<?php

$mealCategories = file_get_contents("http://localhost:8000/api/meal-categories");
$mealCategories = json_decode($mealCategories, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Our Meal Plans</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fff;
      margin: 0;
      padding: 0;
      color: #1a2a3a;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 32px 16px;
    }
    
    .page-title {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 8px;
      color: #1a2a3a;
    }
    
    .page-description {
      font-size: 1rem;
      line-height: 1.5;
      color: #555;
      margin-bottom: 42px;
      max-width: 700px;
    }
    
    .categories-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 24px;
    }
    
    .category-card {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      position: relative;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    
    .category-image {
      width: 100%;
      height: 250px;
      object-fit: cover;
      display: block;
    }
    
    .category-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 250px;
      background: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.3));
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      padding: 20px;
      box-sizing: border-box;
      color: white;
    }
    
    .category-tag {
      font-size: 1.1rem;
      font-weight: normal;
      margin-bottom: 5px;
    }
    
    .category-highlight {
      font-size: 2rem;
      font-weight: bold;
      margin: 0;
    }
    
    .category-content {
      padding: 20px;
    }
    
    .category-name {
      font-size: 1.3rem;
      font-weight: bold;
      margin-bottom: 8px;
      color: #1a2a3a;
    }
    
    .category-description {
      font-size: 0.95rem;
      color: #555;
      margin-bottom: 20px;
      line-height: 1.4;
    }
    
    .category-price {
      font-size: 1rem;
      font-weight: bold;
      color: #1a2a3a;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="page-title">Our meal plans</h1>
    <p class="page-description">are expertly crafted by dietitians and prepared by specialized chefs to provide fresh, balanced and delicious nutrition, fuel your lifestyle and help you reach your health goals.</p>
    
    <div class="categories-grid">
      <?php
      if ($mealCategories['status']) {
        foreach ($mealCategories['data'] as $category) {
       
          $tag = isset($category['tag']) ? $category['tag'] : "Optimal for";
          $highlight = isset($category['highlight']) ? $category['highlight'] : $category['name'];
          $description = isset($category['description']) ? $category['description'] : "";
         
          
          echo '<div class="category-card" onclick="window.location.href=\'meal-details.php?category=' . $category['id'] . '\'">';
          echo '<img src="' . $category['image'] . '" alt="' . $category['name'] . '" class="category-image" />';
          echo '<div class="category-overlay">';
          echo '<p class="category-tag">' . $tag . '</p>';
          echo '<h2 class="category-highlight">' . $highlight . '</h2>';
          echo '</div>';
          echo '<div class="category-content">';
          echo '<h3 class="category-name">' . $category['name'] . '</h3>';
          echo '<p class="category-description">' . $description . '</p>';
       
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo '<p>No meal categories found.</p>';
      }
      ?>
    </div>
  </div>
</body>
</html>