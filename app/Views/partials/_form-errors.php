<?php if (session('validation')): ?>
  <?= session('validation')->listErrors() ?>
<?php endif ?>