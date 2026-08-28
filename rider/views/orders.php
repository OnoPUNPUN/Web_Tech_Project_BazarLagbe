<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>assigned orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="placed-orders">

   <h1 class="title">my assigned orders</h1>

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
         <p> payment method : <span><?= $fetch_orders['method']; ?> (<?= $fetch_orders['payment_status']; ?>)</span> </p>
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

         <form action="" method="POST" style="margin-top:1.5rem;">
            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
            <p style="text-align:left; font-size:1.6rem; margin-bottom:.5rem;">Update Delivery Status:</p>
            <select name="status" class="drop-down" style="margin-bottom:1rem;">
               <option value="confirmed" <?= ($fetch_orders['status'] == 'confirmed') ? 'selected' : ''; ?>>confirmed</option>
               <option value="processing" <?= ($fetch_orders['status'] == 'processing') ? 'selected' : ''; ?>>processing</option>
               <option value="out_for_delivery" <?= ($fetch_orders['status'] == 'out_for_delivery') ? 'selected' : ''; ?>>out_for_delivery</option>
               <option value="delivered" <?= ($fetch_orders['status'] == 'delivered') ? 'selected' : ''; ?>>delivered</option>
            </select>
            <input type="submit" name="update_status" class="btn" value="update status">
         </form>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">no active assigned orders!</p>';
         }
      ?>

   </div>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
