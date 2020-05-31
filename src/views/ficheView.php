<?php $title = 'Fiche'; ?>
<?php ob_start(); ?>

<?php  $id = $_SESSION['idmovie_selected'];
$movie = MovieService::GetMovieById($id,null);?>
<div class="box">
    <div id="err"></div>
</div>
<div class="container">
    <div class="title is-parent  ">
        <div class="title is-child box">
            <?php echo ($movie->getName()); ?>
            <div class="subtitle ">
                <i>Réalisateur</i> <?php echo ($movie->getRealisateur()); ?>
            </div>
        </div>
    </div>
    <div class="box">
        <article class="media">
            <div class="media-left">
                <figure class="image">
                    <img src="../film/affiche/<?php echo ($movie->getAffiche()); ?>" alt="Image">
                </figure>
            </div>
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong><?php echo ($movie->getRealisateur()); ?></strong>
                        <br>
                        <?php echo ($movie->getDescription()); ?>
                    </p>
                    <p>
                    <a id='btnAddPanier'>
                        <i class="fas fa-shopping-cart"></i> <strong>Ajouter au panier</strong>
                    </a>
                    </p>
                </div>
            </div>
        </article>
    </div>

    <div class="box">
        <article class="media">
            <div class="media-content">
            <video class="image "  controls>
                <source src="../film/video/<?php echo ($movie->getVideo()); ?>" type="video/mp4">
            </video> 
            </div>
        </article>
    </div>

</div>

<?php $content = ob_get_clean(); ?>
<?php $js = '<script src="../src/public/script/front/ficheMovie.js"></script>'; ?>
<?php $roles = $_SESSION["user_roles"];
    if(isset($roles))
        require('../src/templates/tmpFrontConnect.php');
    else
        require('../src/templates/tmpFront.php'); ?>