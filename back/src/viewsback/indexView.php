<?php $title = 'Back office'; ?>
<?php ob_start(); ?>


<?php $content = ob_get_clean(); ?>
<?php  require('./src/templates/tmpBack.php'); ?>