<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="shopping-cart">

   <h1 class="title">shopping cart</h1>

   <div class="box-container">

   <?php
      $grand_total = 0;
      if (!empty($cart_items)) {
         foreach ($cart_items as $fetch_cart) { 
            $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $sub_total;
   ?>
   <form action="" method="POST" class="box">
      <a href="index.php?page=cart&delete=<?= $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
      <a href="index.php?page=product&pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
      <img src="../uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['name']; ?></div>
      <div class="price">৳<?= $fetch_cart['price']; ?>/-</div>
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <div class="flex-btn">
         <input type="number" min="1" value="<?= $fetch_cart['quantity']; ?>" class="qty" name="p_qty">
         <input type="submit" value="update" name="update_qty" class="option-btn">
      </div>
      <div class="sub-total"> sub total : <span>৳<?= $sub_total; ?>/-</span> </div>
   </form>
   <?php
         }
      } else {
         echo '<p class="empty">your cart is empty</p>';
      }
   ?>
   </div>

   <div class="cart-total">
      <p>grand total : <span>৳<?= $grand_total; ?>/-</span></p>
      <a href="index.php?page=shop" class="option-btn">continue shopping</a>
      <a href="index.php?page=cart&delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>">delete all</a>
      <a href="index.php?page=checkout" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

</section>

<?php include __DIR__ . '/footer.php'; ?>

<script src="../shared/js/script.js"></script>

</body>
</html>
