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

      <a href="index.php?page=dashboard" class="logo">Rider<span>Portal</span></a>

      <nav class="navbar">
         <a href="index.php?page=dashboard">home</a>
         <a href="index.php?page=orders">assigned orders</a>
         <a href="index.php?page=history">delivery history</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php if (isset($fetch_profile) && $fetch_profile) { ?>
            <img src="../uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
            <p><?= $fetch_profile['name']; ?></p>
            <p style="font-size:1.6rem; color:var(--green); font-weight:bold;"><?= $fetch_profile['user_type']; ?></p>
            <a href="../user/index.php?page=profile" class="btn">update profile</a>
            <a href="../auth/index.php?action=logout" class="delete-btn">logout</a>
         <?php } ?>
      </div>

   </div>

</header>
