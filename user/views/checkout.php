<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      if (!empty($cart_items)) {
         foreach ($cart_items as $fetch_cart_items) {
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span>(<?= '৳'.$fetch_cart_items['price'].'/- x '. $fetch_cart_items['quantity']; ?>)</span> </p>
   <?php
         }
      } else {
         echo '<p class="empty">your cart is empty!</p>';
      }
   ?>
   <div class="grand-total">grand total : <span>৳<?= $cart_grand_total; ?>/-</span></div>
</section>

<section class="checkout-orders">

   <form action="" method="POST">

      <h3>place your order</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" required value="<?= isset($fetch_profile['name']) ? $fetch_profile['name'] : ''; ?>">
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" required value="<?= isset($fetch_profile['email']) ? $fetch_profile['email'] : ''; ?>">
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card (Simulated)</option>
               <option value="bkash">bKash (Simulated)</option>
               <option value="nagad">Nagad (Simulated)</option>
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" required>
         </div>
         <div class="inputBox">
            <span>address line 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" placeholder="e.g. Dhaka" class="box" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" placeholder="e.g. Dhaka" class="box" required>
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" placeholder="e.g. Bangladesh" class="box" required>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 1207" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>

<?php include __DIR__ . '/footer.php'; ?>

<script src="../shared/js/script.js"></script>

</body>
</html>
