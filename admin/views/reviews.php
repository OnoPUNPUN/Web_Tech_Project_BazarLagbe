<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>reviews</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="placed-orders">

   <h1 class="title">customer reviews</h1>

   <div class="box-container">

   <?php
      if (!empty($reviews)) {
         foreach ($reviews as $fetch_rev) {  
   ?>
   <div class="box">
      <p> review id : <span>#<?= $fetch_rev['id']; ?></span></p>
      <p> user : <span><?= $fetch_rev['user_name']; ?></span></p>
      <p> product : <span><?= $fetch_rev['product_name']; ?></span></p>
      <p> order id : <span>#<?= $fetch_rev['order_id']; ?></span></p>
      <p> rating : <span style="color:var(--orange); font-size: 1.8rem;">
         <?php
            for ($i = 1; $i <= 5; $i++) {
               if ($i <= $fetch_rev['rating']) {
                  echo '<i class="fas fa-star"></i>';
               } else {
                  echo '<i class="far fa-star"></i>';
               }
            }
         ?>
         (<?= $fetch_rev['rating']; ?>/5)
      </span></p>
      <p> date : <span><?= $fetch_rev['created_at']; ?></span></p>
      <p> review : <span><?= $fetch_rev['review']; ?></span></p>
      
      <a href="index.php?page=reviews&delete=<?= $fetch_rev['id']; ?>" class="delete-btn" onclick="return confirm('delete this review?');">delete review</a>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">no reviews posted yet!</p>';
      }
   ?>

   </div>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
