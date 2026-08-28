<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>stock manager dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">
   <style>
      .movement-table {
         width: 100%;
         border-collapse: collapse;
         background-color: var(--white);
         box-shadow: var(--box-shadow);
         border-radius: .5rem;
         overflow: hidden;
         margin-top: 2rem;
         font-size: 1.5rem;
      }
      .movement-table th, .movement-table td {
         padding: 1.2rem 1.5rem;
         text-align: left;
         border-bottom: var(--border);
      }
      .movement-table th {
         background-color: var(--black);
         color: var(--white);
      }
      .type-stock_in {
         color: var(--green);
         font-weight: bold;
      }
      .type-stock_out {
         color: var(--red);
         font-weight: bold;
      }
      .type-adjustment {
         color: var(--orange);
         font-weight: bold;
      }
   </style>
</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="dashboard">

   <h1 class="title">inventory dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3><?= $stats['number_of_products']; ?></h3>
         <p>total products</p>
         <a href="index.php?page=inventory" class="btn">view inventory</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_in_stock']; ?></h3>
         <p>in stock products</p>
         <a href="index.php?page=inventory&filter=in_stock" class="btn">view in stock</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_low_stock']; ?></h3>
         <p>low stock items</p>
         <a href="index.php?page=inventory&filter=low_stock" class="btn">view low stock</a>
      </div>

      <div class="box">
         <h3><?= $stats['number_out_stock']; ?></h3>
         <p>out of stock items</p>
         <a href="index.php?page=inventory&filter=out_of_stock" class="btn">view out of stock</a>
      </div>

      <div class="box">
         <h3><?= $stats['total_employees']; ?></h3>
         <p>total employees</p>
         <a href="index.php?page=salary" class="btn">manage employees & salary</a>
      </div>

      <div class="box">
         <h3 style="color:var(--red);"><?= $stats['pending_salaries']; ?></h3>
         <p>salary pending (<?= htmlspecialchars($current_month); ?>)</p>
         <a href="index.php?page=salary" class="btn">pay salaries</a>
      </div>

   </div>

   <h2 style="font-size: 2.2rem; margin-top: 3rem; text-transform: capitalize; color: var(--black);">Recent Stock Movements</h2>
   
   <?php if (!empty($recent_movements)) { ?>
      <table class="movement-table">
         <thead>
            <tr>
               <th>ID</th>
               <th>Product</th>
               <th>Type</th>
               <th>Quantity</th>
               <th>Recorded By</th>
               <th>Note</th>
               <th>Timestamp</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($recent_movements as $mv) { ?>
               <tr>
                  <td>#<?= $mv['id']; ?></td>
                  <td><?= htmlspecialchars($mv['product_name'] ? $mv['product_name'] : ('Product #' . $mv['product_id'])); ?></td>
                  <td><span class="type-<?= $mv['type']; ?>"><?= strtoupper(str_replace('_', ' ', $mv['type'])); ?></span></td>
                  <td><strong><?= $mv['quantity']; ?></strong></td>
                  <td><?= !empty($mv['employee_name']) ? htmlspecialchars($mv['employee_name']) : 'System / Online Order'; ?></td>
                  <td><?= htmlspecialchars($mv['note'] ? $mv['note'] : '-'); ?></td>
                  <td><?= $mv['created_at']; ?></td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
   <?php } else { ?>
      <p class="empty" style="margin-top:1rem;">no recent stock movements recorded.</p>
   <?php } ?>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
