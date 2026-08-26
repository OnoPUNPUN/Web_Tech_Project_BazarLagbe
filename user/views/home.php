<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<div class="home-bg">

   <section class="home">

      <div class="content">
         <span>fresh & organic daily essentials</span>
         <h3>Reach For A Healthier You With BazarLagbe</h3>
         <p>Your one-stop destination for fresh vegetables, fruits, dairy, and daily household groceries delivered fast.</p>
         <a href="index.php?page=about" class="btn">about us</a>
      </div>

   </section>

</div>

<section class="home-category">

   <h1 class="title">shop by category</h1>

   <div class="box-container">

      <?php
         if (!empty($categories)) {
            foreach ($categories as $cat) {
      ?>
      <div class="box">
         <h3><?= $cat['name']; ?></h3>
         <p><?= !empty($cat['description']) ? $cat['description'] : 'Fresh quality products in this category.'; ?></p>
         <a href="index.php?page=category&id=<?= $cat['id']; ?>" class="btn">view <?= $cat['name']; ?></a>
      </div>
      <?php
            }
         } else {
      ?>
      <div class="box">
         <img src="../images/cat-1.png" alt="">
         <h3>fruits</h3>
         <p>Fresh organic fruits.</p>
         <a href="index.php?page=category&category=fruits" class="btn">fruits</a>
      </div>
      <div class="box">
         <img src="../images/cat-2.png" alt="">
         <h3>meat</h3>
         <p>Fresh quality meat.</p>
         <a href="index.php?page=category&category=meat" class="btn">meat</a>
      </div>
      <div class="box">
         <img src="../images/cat-3.png" alt="">
         <h3>vegitables</h3>
         <p>Farm fresh vegetables.</p>
         <a href="index.php?page=category&category=vegitables" class="btn">vegitables</a>
      </div>
      <div class="box">
         <img src="../images/cat-4.png" alt="">
         <h3>fish</h3>
         <p>Fresh river and ocean fish.</p>
         <a href="index.php?page=category&category=fish" class="btn">fish</a>
      </div>
      <?php } ?>

   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

   <?php
      if (!empty($latest_products)) {
         foreach ($latest_products as $fetch_products) { 
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
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

   </div>

</section>

<?php include __DIR__ . '/footer.php'; ?>

<script src="../shared/js/script.js"></script>

</body>
</html>
