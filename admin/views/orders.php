<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">

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
         <p> order id : <span>#<?= $fetch_orders['id']; ?></span> </p>
         <p> user id : <span><?= $fetch_orders['user_id']; ?></span> </p>
         <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
         <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
         <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
         <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
         <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
         
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
         <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
         <p> assigned rider : <span style="color:var(--green); font-weight:bold;"><?= !empty($fetch_orders['rider_name']) ? $fetch_orders['rider_name'] : 'Unassigned'; ?></span> </p>
         
         <form action="" method="POST">
            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
            
            <p style="text-align:left; font-size:1.6rem; margin-top:1rem;">Payment Status:</p>
            <select name="update_payment" class="drop-down">
               <option value="pending" <?= ($fetch_orders['payment_status'] == 'pending') ? 'selected' : ''; ?>>pending</option>
               <option value="completed" <?= ($fetch_orders['payment_status'] == 'completed') ? 'selected' : ''; ?>>completed</option>
            </select>

            <p style="text-align:left; font-size:1.6rem; margin-top:1rem;">Order Status:</p>
            <select name="update_status" class="drop-down">
               <option value="pending" <?= ($fetch_orders['status'] == 'pending') ? 'selected' : ''; ?>>pending</option>
               <option value="confirmed" <?= ($fetch_orders['status'] == 'confirmed') ? 'selected' : ''; ?>>confirmed</option>
               <option value="processing" <?= ($fetch_orders['status'] == 'processing') ? 'selected' : ''; ?>>processing</option>
               <option value="out_for_delivery" <?= ($fetch_orders['status'] == 'out_for_delivery') ? 'selected' : ''; ?>>out_for_delivery</option>
               <option value="delivered" <?= ($fetch_orders['status'] == 'delivered') ? 'selected' : ''; ?>>delivered</option>
               <option value="cancelled" <?= ($fetch_orders['status'] == 'cancelled') ? 'selected' : ''; ?>>cancelled</option>
            </select>

            <p style="text-align:left; font-size:1.6rem; margin-top:1rem;">Assign Rider:</p>
            <select name="rider_id" class="drop-down">
               <option value="">-- None / Select Rider --</option>
               <?php if (!empty($riders)) { foreach ($riders as $rider_opt) { ?>
                  <option value="<?= $rider_opt['id']; ?>" <?= ($fetch_orders['rider_id'] == $rider_opt['id']) ? 'selected' : ''; ?>><?= $rider_opt['name']; ?></option>
               <?php } } ?>
            </select>

            <div class="flex-btn">
               <input type="submit" name="update_order" class="option-btn" value="update">
               <a href="index.php?page=orders&delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
            </div>
         </form>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">no orders placed yet!</p>';
         }
      ?>

   </div>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
