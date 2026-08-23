<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="update-product">

   <h1 class="title">update product</h1>   

   <?php if (!empty($product)) { ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="old_image" value="<?= $product['image']; ?>">
      <input type="hidden" name="pid" value="<?= $product['id']; ?>">
      <img src="../uploaded_img/<?= $product['image']; ?>" alt="">
      <input type="text" name="name" placeholder="enter product name" required class="box" value="<?= $product['name']; ?>">
      <input type="number" name="price" min="0" placeholder="enter product price" required class="box" value="<?= $product['price']; ?>">
      
      <p style="text-align:left; font-size:1.6rem; margin-top:1rem;">Stock Quantity:</p>
      <input type="number" name="stock_quantity" min="0" placeholder="enter stock quantity" required class="box" value="<?= $product['stock_quantity']; ?>">
      
      <p style="text-align:left; font-size:1.6rem; margin-top:1rem;">Low Stock Threshold:</p>
      <input type="number" name="low_stock_threshold" min="0" placeholder="enter threshold" required class="box" value="<?= $product['low_stock_threshold']; ?>">
      
      <p style="text-align:left; font-size:1.6rem; margin-top:1rem;">Category:</p>
      <select name="category_id" class="box" required>
         <?php
            if (!empty($categories)) {
               foreach ($categories as $cat_row) {
                  $selected = ($cat_row['id'] == $product['category_id']) ? 'selected' : '';
                  echo '<option value="'.$cat_row['id'].'" '.$selected.'>'.$cat_row['name'].'</option>';
               }
            }
         ?>
      </select>
      <textarea name="details" required placeholder="enter product details" class="box" cols="30" rows="5"><?= $product['details']; ?></textarea>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <div class="flex-btn">
         <input type="submit" class="btn" value="update product" name="update_product">
         <a href="index.php?page=products" class="option-btn">go back</a>
      </div>
   </form>
   <?php } else { ?>
      <p class="empty">no products found!</p>
   <?php } ?>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
