<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Payment Gateway Simulation</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../shared/css/style.css">

</head>
<body>
   
<?php include __DIR__ . '/header.php'; ?>

<section>

   <div class="payment-container">

      <?php if ($step == 1): ?>
         <h3>Select Payment Method</h3>
         <p style="font-size: 1.6rem; color: var(--light-color); margin-bottom: 2rem;">Choose your preferred mobile banking gateway to proceed:</p>

         <form action="index.php?page=payment" method="POST">
            <input type="hidden" name="amount" value="<?= htmlspecialchars($amount); ?>">
            <div class="gateway-options">

               <label class="gateway-card">
                  <input type="radio" name="method" value="bkash" required style="display:none;" onchange="highlightCard(this)">
                  <img src="../images/bkash.png" alt="bKash">
                  <p>bKash</p>
               </label>

               <label class="gateway-card">
                  <input type="radio" name="method" value="nagad" required style="display:none;" onchange="highlightCard(this)">
                  <img src="../images/nagad.png" alt="Nagad">
                  <p>Nagad</p>
               </label>

               <label class="gateway-card">
                  <input type="radio" name="method" value="rocket" required style="display:none;" onchange="highlightCard(this)">
                  <img src="../images/rocket.png" alt="Rocket">
                  <p>Rocket</p>
               </label>

            </div>

            <input type="submit" name="select_gateway" class="btn" value="Continue to Payment">
         </form>

      <?php elseif ($step == 2): ?>
         <h3>Payment Gateway Simulation</h3>
         
         <div class="selected-gateway-header">
            <?php 
               $logo_file = '../images/' . strtolower($selected_method) . '.png';
               if (file_exists(__DIR__ . '/../../images/' . strtolower($selected_method) . '.png')) {
                   echo '<img src="../images/' . strtolower($selected_method) . '.png" alt="' . htmlspecialchars($selected_method) . '">';
               }
            ?>
            <h4><?= htmlspecialchars(ucfirst($selected_method)); ?> Payment</h4>
         </div>

         <form action="index.php?page=payment" method="POST" class="payment-form">
            <input type="hidden" name="method" value="<?= htmlspecialchars($selected_method); ?>">
            <input type="hidden" name="amount" value="<?= htmlspecialchars($amount); ?>">

            <div class="inputBox">
               <span>Amount to Pay:</span>
               <input type="text" value="৳<?= htmlspecialchars($amount); ?>/-" readonly style="font-weight: bold; color: var(--green);">
            </div>

            <div class="inputBox">
               <span>Enter Your <?= htmlspecialchars(ucfirst($selected_method)); ?> Mobile Number:</span>
               <input type="text" name="phone_number" placeholder="e.g. 01712345678" required pattern="[0-9]{11}" title="Please enter a valid 11-digit mobile number">
            </div>

            <div class="flex-btn">
               <input type="submit" name="process_payment" class="btn" value="Confirm & Pay">
               <a href="index.php?page=payment" class="option-btn">Change Gateway</a>
            </div>
         </form>

      <?php elseif ($step == 3): ?>
         <div class="success-box">
            <i class="fas fa-check-circle"></i>
            <h4>Payment Successful!</h4>
            <p style="font-size: 1.6rem; color: var(--light-color);">Thank you! Your payment simulation has completed successfully.</p>

            <div class="receipt-details">
               <p>Status: <span>SUCCESS</span></p>
               <p>Gateway: <span><?= htmlspecialchars(ucfirst($selected_method)); ?></span></p>
               <p>Phone Number: <span><?= htmlspecialchars($phone_number); ?></span></p>
               <p>Amount Paid: <span>৳<?= htmlspecialchars($amount); ?>/-</span></p>
               <p>Transaction ID: <span><?= htmlspecialchars($transaction_id); ?></span></p>
               <p>Date & Time: <span><?= date('d M Y, h:i A'); ?></span></p>
            </div>

            <div class="flex-btn">
               <a href="index.php?page=orders" class="btn">View Orders</a>
               <a href="index.php?page=home" class="option-btn">Return to Home</a>
            </div>
         </div>

      <?php endif; ?>

   </div>

</section>

<?php include __DIR__ . '/footer.php'; ?>

<script>
function highlightCard(radio) {
   document.querySelectorAll('.gateway-card').forEach(card => {
      card.classList.remove('active');
   });
   if (radio.checked) {
      radio.closest('.gateway-card').classList.add('active');
   }
}
</script>

<script src="../shared/js/script.js"></script>

</body>
</html>
