<?php $title = 'Recherche'; ?>
<?php ob_start();
    $search =$_SESSION['search'];
    unset($_SESSION['search']);
?>

<div id="page" class="box">
    <div id="err"></div>
    <div class="section has-text-centered  has-background-grey-lighter">
        <p class="title is-1">Recherche</p>
        <div id="page" class="box">
            <div class="columns is-mobile">
                <div class="column is-three-fifths">

                    <nav class="panel">
                       <!-- <p class="panel-heading">
                            Recherche
                        </p> -->
                        <div class="panel-block">
                            <p class="control has-icons-left">
                                <input class="input" type="text" id="txtsearchMovie" placeholder="Search" value="<?php if (isset($search)){echo $search;}?>" >
                                <span class="icon is-left">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                </span>
                            </p>
                        </div>
                        <p id="panelCategorie" class="panel-tabs">
                            <a class="is-active">Tous</a>
                            <a>Public</a>
                            <a>Private</a>
                            <a>Sources</a>
                            <a>Forks</a>
                        </p>
                        <div id="block_genre">

                        </div>
                    </nav>
                </div>

                <div class="column">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Affiche</th>
                                <th>Titre</th>
                            </tr>
                        </thead>
                        <tbody id="movie">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


    <?php $content = ob_get_clean(); ?>
    <?php $js = '<script src="../src/public/script/front/search.js"></script>' .
        " <script type='text/template' class='TemplateCategorie'>
    <a class='panel-block is-active' id_cat={{id}}> <span class='panel-icon'>
    <i class='fas fa-book' aria-hidden='true'></i>
</span>
{{name}}</a>
</script>" .
        "<script type='text/template' class='TemplateGenre'>
<label class='panel-block'>
                    <input type='checkbox' id_genre={{id}}>
                    {{name}}
                </label>
</script>" .
        "<script type='text/template' class='TemplateMovie'>
    <tr>
        <td> <p class='image is-64'>
        <img src='../film/affiche/{{mainview}}'>
    </p></td>
        <td><a href='./index.php?page=fiche&nb=178900-{{idMovie}}'>{{name}}</a></td>
    </tr>
</script>"; ?>
    <?php $client = $_SESSION["client"];
    if (isset($client))
        require('../src/templates/tmpFrontConnect.php');
    else
        require('../src/templates/tmpFront.php'); ?>