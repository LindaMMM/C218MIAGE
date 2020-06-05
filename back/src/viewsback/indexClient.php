<?php $title = 'Back office'; ?>
<?php ob_start(); ?>
<div id="page" class="box">
    <div id="err"></div>
    <div class="section has-text-centered  has-background-grey-lighter">
        <p class="title is-1">Espace client</p>
        
        Page en cours de construction.... 

    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('./src/templates/tmpBack.php'); ?>