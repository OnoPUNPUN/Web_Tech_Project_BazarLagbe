<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>wishlist</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="wishlist">

   <h1 class="title">products wishlist</h1>

   <div class="box-container">

   <?php
      $grand_total = 0;
      if (!empty($wishlist_items)) {
         foreach ($wishlist_items as $fetch_wishlist) {
            $grand_total += $fetch_wishlist['price'];
   ?>
   <form action="" method="POST" class="box">
      <a href="index.php?page=wishlist&delete=<?= $fetch_wishlist['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from wishlist?');"></a>
      <a href="index.php?page=product&pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
      <img src="../uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
      <div class="name"><?= $fetch_wishlist['name']; ?></div>
      <div class="price">৳<?= $fetch_wishlist['price']; ?>/-</div>
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_wishlist['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_wishlist['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_wishlist['image']; ?>">
      <input type="hidden" name="p_qty" value="1">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
   </form>
   <?php
         }
      } else {
         echo '<p class="empty">your wishlist is empty</p>';
      }
   ?>
   </div>

   <div class="wishlist-total">
      <p>grand total : <span>৳<?= $grand_total; ?>/-</span></p>
      <a href="index.php?page=shop" class="option-btn">continue shopping</a>
      <a href="index.php?page=wishlist&delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>">delete all</a>
   </div>

</section>

<?php include __DIR__ . '/footer.php'; ?>

<script src="../shared/js/script.js"></script>

</body>
</html>
