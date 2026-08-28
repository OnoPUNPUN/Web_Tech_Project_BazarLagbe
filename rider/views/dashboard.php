<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>rider dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="dashboard">

   <h1 class="title">rider dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3><?= $stats['number_active']; ?></h3>
         <p>active assigned orders</p>
         <a href="index.php?page=orders" class="btn">see assigned orders</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_delivered']; ?></h3>
         <p>completed deliveries</p>
         <a href="index.php?page=history" class="btn">see delivery history</a>
      </div>

   </div>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
