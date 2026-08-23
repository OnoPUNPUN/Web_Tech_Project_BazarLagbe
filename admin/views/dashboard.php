<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>৳<?= $stats['total_pendings']; ?>/-</h3>
         <p>total pendings</p>
         <a href="index.php?page=orders" class="btn">see orders</a>
      </div>

      <div class="box">
         <h3>৳<?= $stats['total_completed']; ?>/-</h3>
         <p>completed orders</p>
         <a href="index.php?page=orders" class="btn">see orders</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_of_orders']; ?></h3>
         <p>orders placed</p>
         <a href="index.php?page=orders" class="btn">see orders</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_of_products']; ?></h3>
         <p>products added</p>
         <a href="index.php?page=products" class="btn">see products</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_of_low_stock']; ?></h3>
         <p>low stock items</p>
         <a href="index.php?page=products" class="btn">see products</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_of_categories']; ?></h3>
         <p>categories</p>
         <a href="index.php?page=categories" class="btn">see categories</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_of_users']; ?></h3>
         <p>customers</p>
         <a href="index.php?page=users" class="btn">see accounts</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_of_stock_managers']; ?></h3>
         <p>stock managers</p>
         <a href="index.php?page=users" class="btn">see accounts</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_of_riders']; ?></h3>
         <p>riders</p>
         <a href="index.php?page=users" class="btn">see accounts</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_of_admins']; ?></h3>
         <p>total admins</p>
         <a href="index.php?page=users" class="btn">see accounts</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_of_messages']; ?></h3>
         <p>total messages</p>
         <a href="index.php?page=messages" class="btn">see messages</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_of_reviews']; ?></h3>
         <p>total reviews</p>
         <a href="index.php?page=reviews" class="btn">see reviews</a>
      </div>

   </div>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
