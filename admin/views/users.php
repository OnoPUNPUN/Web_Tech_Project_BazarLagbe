<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>user accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">
</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="user-accounts">

   <h1 class="title">user accounts</h1>

   <div class="box-container">

      <?php
         if (!empty($users)) {
            foreach ($users as $fetch_users) {
      ?>
      <div class="box" style="<?php if ($fetch_users['id'] == $admin_id) { echo 'border: 2px solid var(--green);'; } ?>">
         <img src="../uploaded_img/<?= $fetch_users['image']; ?>" alt="">
         <p> user id : <span><?= $fetch_users['id']; ?></span></p>
         <p> username : <span><?= $fetch_users['name']; ?></span></p>
         <p> email : <span><?= $fetch_users['email']; ?></span></p>
         <p> user type : <span style="color:<?php if ($fetch_users['user_type'] == 'admin') { echo 'orange'; } elseif ($fetch_users['user_type'] == 'rider') { echo 'var(--green)'; } elseif ($fetch_users['user_type'] == 'stock_manager') { echo 'blue'; } elseif ($fetch_users['user_type'] == 'warehouse_staff') { echo 'purple'; } ?>"><?= $fetch_users['user_type']; ?></span></p>
         
         <?php if ($fetch_users['id'] != $admin_id) { ?>
         <form action="" method="POST" style="margin-top: 1rem;">
            <input type="hidden" name="user_id" value="<?= $fetch_users['id']; ?>">
            <select name="user_type" class="box" style="width: 100%; margin-bottom: 1rem; padding: 1rem; border: var(--border); border-radius: .5rem; font-size: 1.6rem;">
               <option value="user" <?= ($fetch_users['user_type'] == 'user') ? 'selected' : ''; ?>>user</option>
               <option value="admin" <?= ($fetch_users['user_type'] == 'admin') ? 'selected' : ''; ?>>admin</option>
               <option value="stock_manager" <?= ($fetch_users['user_type'] == 'stock_manager') ? 'selected' : ''; ?>>stock_manager</option>
               <option value="rider" <?= ($fetch_users['user_type'] == 'rider') ? 'selected' : ''; ?>>rider</option>
               <option value="warehouse_staff" <?= ($fetch_users['user_type'] == 'warehouse_staff') ? 'selected' : ''; ?>>warehouse_staff</option>
            </select>
            <input type="submit" value="update role" name="update_role" class="option-btn">
         </form>
         <a href="index.php?page=users&delete=<?= $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete</a>
         <?php } else { ?>
            <p style="margin-top: 1rem; color: var(--green); font-weight: bold;">(Current Logged-in Admin)</p>
         <?php } ?>
      </div>
      <?php
            }
         }
      ?>
   </div>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
