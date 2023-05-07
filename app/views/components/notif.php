<?php include_once('app/config/notif_codes.php'); ?>

<?php if (isset($_GET['success'])) : ?>
  <div class="col-md-12 notif success">
    <?= $notifCodes[$_GET['success']]; ?>
  </div>
<?php elseif (isset($_GET['error'])) : ?>
  <div class="col-md-12 notif error">
  <?= isset($notifCodes[$_GET['error']]) ? $notifCodes[$_GET['error']] : $notifCodes['internal_error'] ; ?>
  </div>
<?php endif; ?>
