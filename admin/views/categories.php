<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>categories</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="add-products">

   <h1 class="title">add new category</h1>

   <form action="" method="POST">
      <input type="text" name="name" class="box" required placeholder="enter category name">
      <textarea name="description" class="box" placeholder="enter category description" cols="30" rows="4"></textarea>
      <input type="submit" class="btn" value="add category" name="add_category">
   </form>

</section>

<section class="show-products">

   <h1 class="title">categories list</h1>

   <div class="box-container">

   <?php
      if (!empty($categories)) {
         foreach ($categories as $fetch_cat) {  
   ?>
   <div class="box">
      <div class="name"><?= $fetch_cat['name']; ?></div>
      <div class="cat" style="margin: 1rem 0;">Products Linked: <?= $fetch_cat['product_count']; ?></div>
      <div class="details"><?= $fetch_cat['description']; ?></div>
      <form action="" method="POST" style="margin-top: 1.5rem; text-align: left;">
         <input type="hidden" name="cat_id" value="<?= $fetch_cat['id']; ?>">
         <input type="text" name="name" class="box" value="<?= $fetch_cat['name']; ?>" required style="margin-bottom:1rem; padding:1rem; border:var(--border); border-radius:.5rem; font-size:1.6rem; width:100%;">
         <textarea name="description" class="box" style="margin-bottom:1rem; padding:1rem; border:var(--border); border-radius:.5rem; font-size:1.6rem; width:100%;" rows="2"><?= $fetch_cat['description']; ?></textarea>
         <div class="flex-btn">
            <input type="submit" name="update_category" value="update" class="option-btn">
            <a href="index.php?page=categories&delete=<?= $fetch_cat['id']; ?>" class="delete-btn" onclick="return confirm('delete this category?');">delete</a>
         </div>
      </form>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">no categories added yet!</p>';
      }
   ?>

   </div>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
