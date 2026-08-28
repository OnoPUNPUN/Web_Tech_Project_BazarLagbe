<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>stock movement history</title>

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
         text-transform: uppercase;
      }
      .type-stock_out {
         color: var(--red);
         font-weight: bold;
         text-transform: uppercase;
      }
      .type-adjustment {
         color: var(--orange);
         font-weight: bold;
         text-transform: uppercase;
      }
   </style>
</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="show-products">

   <h1 class="title">stock movement history</h1>

   <?php if (!empty($movements)) { ?>
      <table class="movement-table">
         <thead>
            <tr>
               <th>ID</th>
               <th>Product</th>
               <th>Type</th>
               <th>Quantity</th>
               <th>Recorded By</th>
               <th>Note</th>
               <th>Date & Time</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($movements as $mv) { ?>
               <tr>
                  <td>#<?= $mv['id']; ?></td>
                  <td>
                     <div style="display:flex; align-items:center; gap:1rem;">
                        <?php if (!empty($mv['product_image'])) { ?>
                           <img src="../uploaded_img/<?= $mv['product_image']; ?>" style="width:4rem; height:4rem; object-fit:cover; border-radius:.3rem;">
                        <?php } ?>
                        <span><?= htmlspecialchars($mv['product_name'] ? $mv['product_name'] : ('Product #' . $mv['product_id'])); ?></span>
                     </div>
                  </td>
                  <td><span class="type-<?= $mv['type']; ?>"><?= str_replace('_', ' ', $mv['type']); ?></span></td>
                  <td><strong><?= $mv['quantity']; ?></strong></td>
                  <td><?= !empty($mv['employee_name']) ? htmlspecialchars($mv['employee_name']) : 'System / Online Order'; ?></td>
                  <td><?= htmlspecialchars($mv['note'] ? $mv['note'] : '-'); ?></td>
                  <td><?= $mv['created_at']; ?></td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
   <?php } else { ?>
      <p class="empty">no stock movements recorded yet.</p>
   <?php } ?>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
