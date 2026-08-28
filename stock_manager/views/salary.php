<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>employee salary management</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/admin_style.css">
   <style>
      .salary-table {
         width: 100%;
         border-collapse: collapse;
         background-color: var(--white);
         box-shadow: var(--box-shadow);
         border-radius: .5rem;
         overflow: hidden;
         margin-top: 2rem;
         font-size: 1.5rem;
      }
      .salary-table th, .salary-table td {
         padding: 1.2rem 1.5rem;
         text-align: left;
         border-bottom: var(--border);
      }
      .salary-table th {
         background-color: var(--black);
         color: var(--white);
      }
      .badge-paid {
         background-color: var(--green);
         color: var(--white);
         padding: .3rem .8rem;
         border-radius: .3rem;
         font-weight: bold;
      }
      .badge-unpaid {
         background-color: var(--red);
         color: var(--white);
         padding: .3rem .8rem;
         border-radius: .3rem;
         font-weight: bold;
      }
      .filter-box {
         background-color: var(--white);
         padding: 1.5rem;
         border-radius: .5rem;
         box-shadow: var(--box-shadow);
         margin-bottom: 2rem;
         display: flex;
         align-items: center;
         gap: 1rem;
         font-size: 1.6rem;
      }
   </style>
</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section class="show-products">

   <h1 class="title">employee salary management</h1>

   <form action="" method="GET" class="filter-box">
      <input type="hidden" name="page" value="salary">
      <label for="month"><strong>Salary Month:</strong></label>
      <input type="text" id="month" name="month" value="<?= htmlspecialchars($selected_month); ?>" placeholder="e.g. August 2026" class="box" style="padding:.8rem; border:var(--border); border-radius:.5rem; font-size:1.5rem;">
      <input type="submit" value="Change Month" class="btn" style="margin-top:0; width:auto; padding:.8rem 1.5rem;">
   </form>

   <div class="box-container">

      <?php
         if (!empty($employees)) {
            foreach ($employees as $emp) {
      ?>
      <div class="box">
         <img src="../uploaded_img/<?= !empty($emp['image']) ? $emp['image'] : 'default-avatar.png'; ?>" alt="">
         <div class="name"><?= htmlspecialchars($emp['name']); ?></div>
         <p style="font-size: 1.5rem; color: var(--light-color); margin-top: .5rem;">
            Role: <span style="font-weight:bold; color:var(--black);"><?= str_replace('_', ' ', $emp['employee_type']); ?></span>
         </p>
         <p style="font-size: 1.5rem; color: var(--light-color);">
            Default Salary: <span style="font-weight:bold; color:var(--green);">৳<?= number_format($emp['salary'], 2); ?></span>
         </p>
         <p style="font-size: 1.5rem; margin-top: .5rem;">
            <?= htmlspecialchars($selected_month); ?> Status: 
            <?php if ($emp['payment_status'] == 'PAID') { ?>
               <span class="badge-paid">PAID</span>
            <?php } else { ?>
               <span class="badge-unpaid">UNPAID</span>
            <?php } ?>
         </p>

         <?php if ($emp['payment_status'] == 'PAID' && !empty($emp['payment_details'])) { ?>
            <div style="background:#f9f9f9; padding:1rem; border-radius:.5rem; margin-top:1rem; text-align:left; font-size:1.3rem;">
               <p><strong>Amount Paid:</strong> ৳<?= number_format($emp['payment_details']['amount'], 2); ?></p>
               <p><strong>Payment Date:</strong> <?= $emp['payment_details']['payment_date']; ?></p>
               <p><strong>Processed By:</strong> <?= htmlspecialchars($emp['payment_details']['payer_name']); ?></p>
            </div>
         <?php } else { ?>
            <form action="" method="POST" style="margin-top:1.5rem; text-align:left;">
               <input type="hidden" name="employee_id" value="<?= $emp['id']; ?>">
               <input type="hidden" name="salary_month" value="<?= htmlspecialchars($selected_month); ?>">
               
               <p style="font-size:1.4rem; color:var(--light-color);">Payment Amount (৳):</p>
               <input type="number" name="amount" step="0.01" min="0.01" value="<?= $emp['salary']; ?>" required class="box" style="margin:.5rem 0 1rem 0; padding:1rem; border:var(--border); border-radius:.5rem; width:100%; font-size:1.5rem;">

               <p style="font-size:1.4rem; color:var(--light-color);">Notes / Reference:</p>
               <input type="text" name="notes" placeholder="Optional payment note" class="box" style="margin:.5rem 0 1rem 0; padding:1rem; border:var(--border); border-radius:.5rem; width:100%; font-size:1.5rem;">

               <input type="submit" name="pay_salary" value="Pay Salary" class="btn" onclick="return confirm('Confirm paying ৳' + this.form.amount.value + ' salary to <?= htmlspecialchars($emp['name']); ?> for <?= htmlspecialchars($selected_month); ?>?');">
            </form>
         <?php } ?>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">no active employees found!</p>';
         }
      ?>

   </div>

   <h2 style="font-size: 2.2rem; margin-top: 3rem; text-transform: capitalize; color: var(--black);">Salary Payment History</h2>
   
   <?php if (!empty($payments)) { ?>
      <table class="salary-table">
         <thead>
            <tr>
               <th>Payment ID</th>
               <th>Employee</th>
               <th>Role</th>
               <th>Salary Month</th>
               <th>Amount Paid</th>
               <th>Payment Date</th>
               <th>Paid By (Stock Manager)</th>
               <th>Status</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($payments as $pay) { ?>
               <tr>
                  <td>#<?= $pay['id']; ?></td>
                  <td><?= htmlspecialchars($pay['employee_name']); ?></td>
                  <td><?= str_replace('_', ' ', $pay['employee_type']); ?></td>
                  <td><?= htmlspecialchars($pay['salary_month']); ?></td>
                  <td>৳<?= number_format($pay['amount'], 2); ?></td>
                  <td><?= $pay['payment_date']; ?></td>
                  <td><?= htmlspecialchars($pay['payer_name']); ?></td>
                  <td><span class="badge-paid"><?= strtoupper($pay['status']); ?></span></td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
   <?php } else { ?>
      <p class="empty" style="margin-top:1rem;">no salary payments recorded yet.</p>
   <?php } ?>

</section>

<script src="../shared/js/script.js"></script>

</body>
</html>
