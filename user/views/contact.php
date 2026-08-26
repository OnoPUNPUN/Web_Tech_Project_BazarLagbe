<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="contact">

   <h1 class="title">get in touch</h1>

   <form action="" method="POST">
      <input type="text" name="name" class="box" required placeholder="enter your name" value="<?= isset($fetch_profile['name']) ? $fetch_profile['name'] : ''; ?>">
      <input type="email" name="email" class="box" required placeholder="enter your email" value="<?= isset($fetch_profile['email']) ? $fetch_profile['email'] : ''; ?>">
      <input type="number" name="number" min="0" class="box" required placeholder="enter your number">
      <textarea name="msg" class="box" required placeholder="enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>

</section>

<?php include __DIR__ . '/footer.php'; ?>

<script src="../shared/js/script.js"></script>

</body>
</html>
