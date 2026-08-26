<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="about">

   <div class="row">

      <div class="box">
         <img src="../images/about-img-1.png" alt="">
         <h3>why choose us?</h3>
         <p>We source the freshest vegetables, fruits, and quality meats directly from local farmers and trusted suppliers. Enjoy unbeatable prices and lightning-fast delivery.</p>
         <a href="index.php?page=contact" class="btn">contact us</a>
      </div>

      <div class="box">
         <img src="../images/about-img-2.png" alt="">
         <h3>what we provide?</h3>
         <p>From daily fresh produce to organic grains, dairy, and household essentials, BazarLagbe brings the entire grocery market straight to your doorstep.</p>
         <a href="index.php?page=shop" class="btn">our shop</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">clients reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="../images/pic-1.png" alt="">
         <p>BazarLagbe has made my daily grocery shopping so convenient. The produce is always super fresh!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>John Doe</h3>
      </div>

      <div class="box">
         <img src="../images/pic-2.png" alt="">
         <p>Fast delivery and great customer service. The rider delivered my order right on time.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Sarah Smith</h3>
      </div>

      <div class="box">
         <img src="../images/pic-3.png" alt="">
         <p>Love the clean UI and easy navigation. Stock tracking ensures items are always available.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Michael Lee</h3>
      </div>

   </div>

</section>

<?php include __DIR__ . '/footer.php'; ?>

<script src="../shared/js/script.js"></script>

</body>
</html>
