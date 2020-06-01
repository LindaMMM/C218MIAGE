<?php $title = 'Panier'; ?>
<?php ob_start(); echo "<script> 
var affiche= '".MEDIA_AFFICHE.
"';</script>";?>

<div id="page" class="box">
    <div id="err"></div>
    <div class="section has-text-centered  has-background-grey-lighter">
        <p class="title is-1">Panier du client</p>
            <div id="boxpanier" class="box"></div>
        <div>
            <button class="button is-success" id="btnsave">Enregistrer</button>
            <button class="button" id="btncancel">Annuler</button>
        </div>

    </div>
</div>


<?php $content = ob_get_clean(); ?>
<?php $js = "<script src='./src/public/script/front/panier.js'></script>" .
    "<script type='text/template' class='TemplatePanier'>
    <section class='panier' >
<article class='media'>
    <figure class='media-left'>
        <p class='image is-64'>
            <img src='{%print(affiche+film.view)%}'>
        </p>
    </figure>
    <div class='media-content'>
        <div class='content'>
            <p>
                <strong>{{film.title}}</strong>
            </p>
            <div class='help {%if(!valid){ print('is-danger')}%}'> {%if(!valid){ print('dvd indisponible ')}%}</div>
        </div>
    </div>
    <div class='media-right'>
    <button class='button is-danger is-outlined'  onclick='deletefilm({{film.id}})'>
    <span>Delete</span>
    <span class='icon is-small'>
      <i class='fas fa-trash'></i>
    </span>
  </button>
        
    </div>
</article>
<article class='message {%if(!valid){ print('is-danger')} %} '>
{%if(!valid){ print('dvd indisponible ')} else{ print('  ')} %}
</article>
</section >
</script>"; ?>



<?php $client = $_SESSION["client"];
if (isset($client))
    require('./src/templates/tmpFrontConnect.php');
else
    require('./src/templates/tmpFront.php'); ?>