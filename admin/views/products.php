<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="add-products">

   <h1 class="title">add new product</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <input type="text" name="name" class="box" required placeholder="enter product name">
            <select name="category_id" class="box" required>
               <option value="" selected disabled>select category</option>
               <?php
                  if (!empty($categories)) {
                     foreach ($categories as $cat_row) {
                        echo '<option value="'.$cat_row['id'].'">'.$cat_row['name'].'</option>';
                     }
                  }
               ?>
            </select>
         </div>
         <div class="inputBox">
            <input type="number" min="0" name="price" class="box" required placeholder="enter product price">
            <input type="number" min="0" name="stock_quantity" class="box" required placeholder="enter stock quantity" value="50">
         </div>
      </div>
      <div class="flex">
         <div class="inputBox">
            <input type="number" min="0" name="low_stock_threshold" class="box" required placeholder="low stock threshold" value="10">
         </div>
         <div class="inputBox">
            <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
         </div>
      </div>
      <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="5"></textarea>
      <input type="submit" class="btn" value="add product" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="title">products added</h1>

   <div class="box-container">

   <?php
      if (!empty($products)) {
         foreach ($products as $fetch_products) {  
            $stock = $fetch_products['stock_quantity'];
            $threshold = $fetch_products['low_stock_threshold'];
            $status_color = 'var(--green)';
            $status_text = 'In Stock';
            if ($stock <= 0) {
               $status_color = 'var(--red)';
               $status_text = 'Out of Stock';
            } elseif ($stock <= $threshold) {
               $status_color = 'var(--orange)';
               $status_text = 'Low Stock ('.$stock.')';
            }
   ?>
   <div class="box">
      <div class="price">৳<?= $fetch_products['price']; ?>/-</div>
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="cat"><?= !empty($fetch_products['cat_name']) ? $fetch_products['cat_name'] : $fetch_products['category']; ?></div>
      <div class="details" style="font-size:1.6rem; color:<?= $status_color; ?>; font-weight:bold; margin-top:.5rem; margin-bottom:.5rem;">
         Status: <?= $status_text; ?> | Qty: <?= $stock; ?>
      </div>
      <div class="details"><?= $fetch_products['details']; ?></div>
      <div class="flex-btn">
         <a href="index.php?page=products&update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="index.php?page=products&delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

   </div>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
