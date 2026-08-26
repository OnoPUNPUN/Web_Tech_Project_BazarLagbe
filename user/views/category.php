<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>category</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="p-category">
   <?php
      if (!empty($all_categories)) {
         foreach ($all_categories as $cat) {
            echo '<a href="index.php?page=category&id='.$cat['id'].'">'.$cat['name'].'</a>';
         }
      }
   ?>
</section>

<section class="products">

   <h1 class="title">category products</h1>

   <div class="box-container">

   <?php
      if (!empty($products)) {
         foreach ($products as $fetch_products) { 
            $stock = $fetch_products['stock_quantity'];
            $is_out_of_stock = ($stock <= 0);
            $avg_rating = $fetch_products['avg_rating'];
            $total_reviews = $fetch_products['total_reviews'];
   ?>
   <form action="" class="box" method="POST">
      <div class="price">৳<span><?= $fetch_products['price']; ?></span>/-</div>
      <a href="index.php?page=product&pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>

      <div style="font-size:1.5rem; color:var(--orange); margin:.5rem 0;">
         <i class="fas fa-star"></i> <?= $avg_rating > 0 ? $avg_rating.'/5 ('.$total_reviews.')' : 'No ratings yet'; ?>
      </div>

      <div class="stock" style="font-size:1.5rem; color:<?= $is_out_of_stock ? 'var(--red)' : 'var(--green)'; ?>; margin-bottom:.5rem;">
         <?= $is_out_of_stock ? 'Out of Stock' : 'In Stock ('.$stock.')'; ?>
      </div>

      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <input type="number" min="1" max="<?= $stock; ?>" value="1" name="p_qty" class="qty" <?= $is_out_of_stock ? 'disabled' : ''; ?>>
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn <?= $is_out_of_stock ? 'disabled' : ''; ?>" name="add_to_cart">
   </form>
   <?php
         }
      } else {
         echo '<p class="empty">no products available in this category!</p>';
      }
   ?>

   </div>

</section>

<?php include __DIR__ . '/footer.php'; ?>

<script src="../shared/js/script.js"></script>

</body>
</html>
