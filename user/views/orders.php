<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="placed-orders">

   <h1 class="title">placed orders</h1>

   <div class="box-container">

   <?php
      if (!empty($orders)) {
         foreach ($orders as $fetch_orders) {
   ?>
   <div class="box">
      <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
      <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
      
      <p> items : <span>
         <?php
            if (!empty($fetch_orders['items'])) {
               $item_strings = [];
               foreach ($fetch_orders['items'] as $item) {
                  $item_strings[] = $item['name'].' (x'.$item['quantity'].') - ৳'.$item['price'];
               }
               echo implode(', ', $item_strings);
            } else {
               echo $fetch_orders['total_products'];
            }
         ?>
      </span> </p>
      
      <p> total price : <span>৳<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> payment status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') { echo 'red'; } else { echo 'green'; } ?>;"><?= $fetch_orders['payment_status']; ?></span> </p>
      <p> order status : <span style="color:<?php if ($fetch_orders['status'] == 'pending') { echo 'red'; } elseif ($fetch_orders['status'] == 'cancelled') { echo 'gray'; } else { echo 'green'; } ?>; font-weight:bold;"><?= $fetch_orders['status']; ?></span> </p>

      <?php if ($fetch_orders['status'] == 'pending') { ?>
         <a href="index.php?page=orders&cancel=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('are you sure you want to cancel this order?');">cancel order</a>
      <?php } ?>

      <?php if ($fetch_orders['status'] == 'delivered') { ?>
         <a href="index.php?page=review" class="btn" style="background-color: var(--orange);">write a review</a>
      <?php } ?>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">no orders placed yet!</p>';
      }
   ?>

   </div>

</section>

<?php include __DIR__ . '/footer.php'; ?>

<script src="../shared/js/script.js"></script>

</body>
</html>
