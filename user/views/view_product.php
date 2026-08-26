<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="quick-view">

   <h1 class="title">quick view</h1>

   <?php
      if (!empty($product)) {
         $stock = $product['stock_quantity'];
         $is_out_of_stock = ($stock <= 0);
   ?>
   <form action="" class="box" method="POST">
      <div class="price">৳<span><?= $product['price']; ?></span>/-</div>
      <img src="../uploaded_img/<?= $product['image']; ?>" alt="">
      <div class="name"><?= $product['name']; ?></div>

      <div style="font-size:1.6rem; color:var(--orange); margin:.5rem 0;">
         <i class="fas fa-star"></i> <?= $avg_rating > 0 ? $avg_rating.'/5 ('.$total_reviews.' reviews)' : 'No ratings yet'; ?>
      </div>

      <div class="stock" style="font-size:1.6rem; color:<?= $is_out_of_stock ? 'var(--red)' : 'var(--green)'; ?>; font-weight:bold; margin-bottom:1rem;">
         Status: <?= $is_out_of_stock ? 'Out of Stock' : 'In Stock ('.$stock.' available)'; ?>
      </div>

      <div class="details"><?= $product['details']; ?></div>
      <input type="hidden" name="pid" value="<?= $product['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $product['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $product['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $product['image']; ?>">
      <input type="number" min="1" max="<?= $stock; ?>" value="1" name="p_qty" class="qty" <?= $is_out_of_stock ? 'disabled' : ''; ?>>
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn <?= $is_out_of_stock ? 'disabled' : ''; ?>" name="add_to_cart">
   </form>
   <?php
      } else {
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

</section>

<section class="reviews" style="padding-top: 0;">

   <h1 class="title">Customer Reviews</h1>

   <div class="box-container">
      <?php
         if (!empty($reviews)) {
            foreach ($reviews as $rev) {
      ?>
      <div class="box">
         <img src="../uploaded_img/<?= $rev['user_image']; ?>" alt="">
         <h3><?= $rev['user_name']; ?></h3>
         <div class="stars">
            <?php
               for ($i = 1; $i <= 5; $i++) {
                  if ($i <= $rev['rating']) {
                     echo '<i class="fas fa-star"></i>';
                  } else {
                     echo '<i class="far fa-star"></i>';
                  }
               }
            ?>
         </div>
         <p><?= $rev['review']; ?></p>
         <span style="font-size:1.2rem; color:var(--light-color);"><?= $rev['created_at']; ?></span>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty" style="width:100%;">No reviews for this product yet!</p>';
         }
      ?>
   </div>

</section>

<?php include __DIR__ . '/footer.php'; ?>

<script src="../shared/js/script.js"></script>

</body>
</html>
