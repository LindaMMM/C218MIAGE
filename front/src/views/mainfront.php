<?php $title = 'front'; ?>
<?php ob_start(); 
echo "<script> 
var affiche= '".MEDIA_AFFICHE.
"';</script>";
$page = "Nouveauté";
$js = '<script src="./src/public/script/front/main.js"></script>' ;
if (isset ($_SESSION['page'])){
    if (strcmp($_SESSION['page'],'child')==0){
        $page = "Les meilleurs DVDs pour toute la famille";
        $js = '<script src="./src/public/script/front/child.js"></script>' ;
    }
    else if (strcmp($_SESSION['page'],'best')==0){
        $page = "Les meilleurs";
        $js = '<script src="./src/public/script/front/best.js"></script>' ;
    }
}
?>

<div id="page" class="box">
    <div id="err"></div>
    <div class="is-center">
        <div class="title is-parent  ">
            <div class="title is-child box">
            <?php 
              
                echo($page);
            ?>
               
                <div class="subtitle ">
                    Dernier dvd
                </div>
            </div>
            <div class="columns is-child is-mobile" id="news">
             
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php
$js .= '<script type="text/template" class="TemplateMovie">
    <div class="column  ">
    <div class="card">
    <div class="card-image">
    <a href="./index.php?page=fiche&nb=178900-{{idMovie}}">
    <figure class="image">
        <img src="{% print(affiche+mainview); %}" alt="Placeholder image">
    </figure>
    </a>
    <div class="media">
    <div class="media-content">
        <a href="./index.php?page=fiche&nb=178900-{{idMovie}}"><p class="title is-4">{{name}}</p></a>
        <p class="subtitle is-6">@{{Realisateur}}</p>
    </div>
    </div>
</div>
</div>
    </div>
</script>'; ?>

<?php $client = $_SESSION["client"];
    if(isset($client))
        require('./src/templates/tmpFrontConnect.php');
    else
        require('./src/templates/tmpFront.php'); ?>