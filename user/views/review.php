<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>product review</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="contact">

   <h1 class="title">leave a product review</h1>

   <?php if (!empty($delivered_products)) { ?>
   <form action="" method="POST">
      <p style="text-align:left; font-size:1.6rem; margin-bottom:.5rem;">Select Delivered Item:</p>
      <select name="product_info" class="box" required onchange="
         let val = this.value.split('|');
         document.getElementById('p_id').value = val[0];
         document.getElementById('o_id').value = val[1];
      ">
         <option value="" selected disabled>-- Select Product from Delivered Orders --</option>
         <?php foreach ($delivered_products as $dp) { ?>
            <option value="<?= $dp['product_id'].'|'.$dp['order_id']; ?>"><?= $dp['name']; ?> (Order #<?= $dp['order_id']; ?>)</option>
         <?php } ?>
      </select>

      <input type="hidden" name="product_id" id="p_id" value="">
      <input type="hidden" name="order_id" id="o_id" value="">

      <p style="text-align:left; font-size:1.6rem; margin-bottom:.5rem;">Rating (1 to 5 Stars):</p>
      <select name="rating" class="box" required>
         <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
         <option value="4">⭐⭐⭐⭐ (4/5)</option>
         <option value="3">⭐⭐⭐ (3/5)</option>
         <option value="2">⭐⭐ (2/5)</option>
         <option value="1">⭐ (1/5)</option>
      </select>

      <textarea name="review" class="box" required placeholder="write your review details here..." cols="30" rows="5"></textarea>
      <input type="submit" value="submit review" name="submit_review" class="btn">
   </form>
   <?php } else { ?>
      <p class="empty">You have no delivered orders available to review!</p>
   <?php } ?>

</section>

<section class="reviews" style="padding-top:0;">
   <h1 class="title">your past reviews</h1>
   <div class="box-container">
      <?php
         if (!empty($user_reviews)) {
            foreach ($user_reviews as $r) {
      ?>
      <div class="box">
         <h3><?= $r['product_name']; ?></h3>
         <div class="stars">
            <?php
               for ($i = 1; $i <= 5; $i++) {
                  if ($i <= $r['rating']) echo '<i class="fas fa-star"></i>';
                  else echo '<i class="far fa-star"></i>';
               }
            ?>
         </div>
         <p><?= $r['review']; ?></p>
         <span style="font-size:1.2rem; color:var(--light-color);"><?= $r['created_at']; ?></span>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty" style="width:100%;">You have not posted any reviews yet.</p>';
         }
      ?>
   </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>

<script src="../shared/js/script.js"></script>

</body>
</html>
