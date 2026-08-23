<?php

if (isset($message) && is_array($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

<header class="header">

   <div class="flex">

      <a href="index.php?page=dashboard" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="index.php?page=dashboard">home</a>
         <a href="index.php?page=categories">categories</a>
         <a href="index.php?page=products">products</a>
         <a href="index.php?page=orders">orders</a>
         <a href="index.php?page=users">users</a>
         <a href="index.php?page=messages">messages</a>
         <a href="index.php?page=reviews">reviews</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php if (isset($fetch_profile) && $fetch_profile) { ?>
            <img src="../uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
            <p><?= $fetch_profile['name']; ?></p>
            <a href="index.php?page=update_profile" class="btn">update profile</a>
            <a href="../auth/index.php?action=logout" class="delete-btn">logout</a>
            <div class="flex-btn">
               <a href="../auth/index.php?action=login" class="option-btn">login</a>
               <a href="../auth/index.php?action=register" class="option-btn">register</a>
            </div>
         <?php } ?>
      </div>

   </div>

</header>
