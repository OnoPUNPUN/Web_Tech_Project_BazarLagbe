<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>inventory management</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="show-products">

   <h1 class="title">inventory management (<?= str_replace('_', ' ', $filter); ?>)</h1>

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
               $status_text = 'Low Stock';
            }
   ?>
   <div class="box">
      <div class="price">৳<?= $fetch_products['price']; ?>/-</div>
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= htmlspecialchars($fetch_products['name']); ?></div>
      <div class="cat"><?= htmlspecialchars(!empty($fetch_products['cat_name']) ? $fetch_products['cat_name'] : $fetch_products['category']); ?></div>
      
      <div class="details" style="font-size:1.6rem; color:<?= $status_color; ?>; font-weight:bold; margin-top:.5rem;">
         Status: <?= $status_text; ?>
      </div>
      <p style="font-size:1.6rem; color:var(--black); font-weight:bold; margin-bottom:.5rem;">
         Current Stock: <span><?= $fetch_products['stock_quantity']; ?></span>
      </p>

      <form action="" method="POST" style="margin-top:1rem; text-align:left;">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         
         <p style="font-size:1.4rem; color:var(--light-color);">Action Type:</p>
         <select name="type" class="box" style="margin:.5rem 0 1rem 0; padding:1rem; border:var(--border); border-radius:.5rem; width:100%; font-size:1.5rem;">
            <option value="stock_in">Stock In (Add to stock)</option>
            <option value="stock_out">Stock Out (Deduct from stock)</option>
            <option value="adjustment">Adjustment (Set total stock)</option>
         </select>

         <p style="font-size:1.4rem; color:var(--light-color);">Quantity:</p>
         <input type="number" name="quantity" min="0" value="0" required class="box" style="margin:.5rem 0 1rem 0; padding:1rem; border:var(--border); border-radius:.5rem; width:100%; font-size:1.5rem;">

         <p style="font-size:1.4rem; color:var(--light-color);">Low Stock Threshold:</p>
         <input type="number" name="low_stock_threshold" min="0" value="<?= $fetch_products['low_stock_threshold']; ?>" required class="box" style="margin:.5rem 0 1rem 0; padding:1rem; border:var(--border); border-radius:.5rem; width:100%; font-size:1.5rem;">

         <p style="font-size:1.4rem; color:var(--light-color);">Movement Note:</p>
         <input type="text" name="note" placeholder="Reason or batch note" class="box" style="margin:.5rem 0 1rem 0; padding:1rem; border:var(--border); border-radius:.5rem; width:100%; font-size:1.5rem;">

         <input type="submit" name="update_stock" value="Update Stock & Record Movement" class="btn">
      </form>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">no inventory items found!</p>';
      }
   ?>

   </div>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
