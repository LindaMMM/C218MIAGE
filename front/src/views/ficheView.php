<?php $title = 'Fiche'; ?>
<?php ob_start(); ?>

<?php  $id = $_SESSION['idmovie_selected'];
$movie = MovieService::GetMovieById($id,null);?>

<div class="container">
    <div id="err"></div>
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
                    <img src="<?php echo MEDIA_AFFICHE.($movie->getAffiche()); ?>" alt="Image">
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
                    <?php if (isset($_SESSION['client'])){
                        echo "<a id='btnAddPanier'>
                        <i class='fas fa-shopping-cart'></i> <strong>Ajouter au panier</strong>
                        </a>";
                    }?>
                    
                    </p>
                    <nav class="level is-mobile">
      <div class="level-left">
        <?php 
        $nbEtoile = intVal($movie->getNote());
        for($i=1 ; $i<=$nbEtoile; $i++)
        {
            echo (" <a class='level-item'>
                <span class='icon is-small'><i class='fas fa-star'></i></span>
            </a>
         ");     
        }
        
        ?>
       
      
      </div>
    </nav>
                </div>
            </div>
        </article>
    </div>

    <div class="box">
        <article class="media">
            <div class="media-content">
            <video class="image "  controls>
                <source src="<?php echo MEDIA_VIDEO.($movie->getVideo()); ?>" type="video/mp4">
            </video> 
            </div>
        </article>
    </div>

</div>

<?php $content = ob_get_clean(); ?>
<?php $js = '<script src="./src/public/script/front/fichemovie.js"></script>'; ?>
<?php $client = $_SESSION["client"];
    if(isset($client))
        require('./src/templates/tmpFrontConnect.php');
    else
        require('./src/templates/tmpFront.php'); ?>