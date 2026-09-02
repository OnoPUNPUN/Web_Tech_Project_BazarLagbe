<?php

if (isset($message) && is_array($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>' . $msg . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

<header class="header">

   <div class="flex">

      <a href="index.php?page=home" class="logo">BazarLagbe<span>.</span></a>

      <nav class="navbar">
         <a href="index.php?page=home">home</a>
         <a href="index.php?page=shop">shop</a>
         <a href="index.php?page=category">categories</a>
         <a href="index.php?page=orders">orders</a>
         <a href="index.php?page=about">about</a>
         <a href="index.php?page=contact">contact</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <a href="index.php?page=search" class="fas fa-search"></a>
         <a href="index.php?page=wishlist"><i
               class="fas fa-heart"></i><span>(<?= isset($count_wishlist_items) ? $count_wishlist_items : 0; ?>)</span></a>
         <a href="index.php?page=cart"><i
               class="fas fa-shopping-cart"></i><span>(<?= isset($count_cart_items) ? $count_cart_items : 0; ?>)</span></a>
      </div>

      <div class="profile">
         <?php if (isset($fetch_profile) && $fetch_profile) { ?>
            <img src="../uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
            <p><?= $fetch_profile['name']; ?></p>
            <p style="font-size:1.6rem; color:var(--green); font-weight:bold;"><?= $fetch_profile['user_type']; ?></p>
            <a href="index.php?page=profile" class="btn">update profile</a>
            <a href="../auth/index.php?action=logout" class="delete-btn">logout</a>
         <?php } else { ?>
            <div class="flex-btn">
               <a href="../auth/index.php?action=login" class="option-btn">login</a>
               <a href="../auth/index.php?action=register" class="option-btn">register</a>
            </div>
         <?php } ?>
      </div>

   </div>

</header>