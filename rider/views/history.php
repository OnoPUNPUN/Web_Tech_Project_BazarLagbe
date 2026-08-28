<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>delivery history</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="placed-orders">

   <h1 class="title">delivery history</h1>

   <div class="box-container">

      <?php
         if (!empty($orders)) {
            foreach ($orders as $fetch_orders) {
      ?>
      <div class="box">
         <p> order id : <span>#<?= $fetch_orders['id']; ?></span> </p>
         <p> customer name : <span><?= $fetch_orders['name']; ?></span> </p>
         <p> phone number : <span><?= $fetch_orders['number']; ?></span> </p>
         <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
         <p> total price : <span>৳<?= $fetch_orders['total_price']; ?>/-</span> </p>
         <p> status : <span style="color:var(--green); font-weight:bold;">Delivered</span> </p>
         <p> items : <span>
            <?php
               if (!empty($fetch_orders['items'])) {
                  $item_strings = [];
                  foreach ($fetch_orders['items'] as $item) {
                     $item_strings[] = $item['name'].' (x'.$item['quantity'].')';
                  }
                  echo implode(', ', $item_strings);
               } else {
                  echo $fetch_orders['total_products'];
               }
            ?>
         </span> </p>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">no delivery history found!</p>';
         }
      ?>

   </div>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
