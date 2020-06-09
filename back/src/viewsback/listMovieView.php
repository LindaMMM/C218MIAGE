<?php $title = 'Liste des films' ?>
<?php ob_start(); ?>

<div id="page" class="box">
    <div id="err"></div>
    <div class="section has-text-centered  has-background-grey-lighter">
        <p class="title is-1">Liste des films</p>
        <p class="subtitle is-3">Gestion des films</p>

        <div id="pagefilm" class="box">
            <nav>
                <div class="nav-item">
                    <div class="field is-grouped">
                        <p class="control">
                            <a class="bd-tw-button button is-info" id="addMovie">
                                <span class="icon">
                                    <i class="fas fa-plus fa-2x"></i>
                                </span>
                                <span>
                                    Ajouter
                                </span>
                            </a>
                        </p>
                        <p class="control">
                            <a class="button is-primary" id="updateMovie" href="#">
                                <span class="icon">
                                    <i class="fas fa-pen fa-2x"></i>
                                </span>
                                <span>
                                    Modifier
                                </span>
                            </a>
                        </p>
                        <p class="control" style='display:none'>
                            <a class="button is-danger" id="deleteMovie" href="#">
                                <span class="icon">
                                    <i class="fas fa-trash fa-2x"></i>

                                </span>
                                <span>
                                    Supprimer
                                </span>
                            </a>
                        </p>
                    </div>
                </div>
            </nav>
        </div>
        
        <div class="table-container">
                <table id="tabmovie" class="table is-fullwidth">
                </table>
            </div>
    </div>
</div>

<div id="popup_create" class="modal">
    <div id="errModal"></div>

    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Fiche Film</p>
            <button class="delete" aria-label="close"></button>
        </header>

        <section class="modal-card-body">
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Film</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Titre" maxlength="40" id="title_movie">
                            <span class="icon is-small is-left">
                                <i class="fas fa-film"></i>
                            </span>
                        </p>
                    </div>

                </div>
            </div>


            <div class="field is-horizontal">
                <div class="field-label"></div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <textarea class="textarea" placeholder="description" id="describ_movie" maxlength="200"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Media</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="nom du fichier de l'affiche" id="name_affiche">
                        </p>
                    </div>
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="nom du fichier de la vidéo" id="name_video">
                        </p>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Date de sortie</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="date" placeholder="date de sortie" id="dateout">
                        </p>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label"></label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Réalisateur" id="realisateur">
                        </p>
                    </div>
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Producteur" id="producteur">
                        </p>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Classification</label>
                </div>
                <div class="field-body">
                    <div class="field is-narrow">
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select id="panelCategorie">
                                    <option>Tout public</option>
                                    <option>Interdiction -10</option>
                                    <option>+12</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Genre</label>
                </div>
                <div class="field-body">
                    <div class="field panel" id="block_genre">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox">
                                Remember me
                            </label>
                        </div>
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox">
                                Remember me
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Note</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Note" id="note_movie">
                            <span class="icon is-small is-left">
                                <i class="fas fa-star"></i>
                            </span>
                        </p>
                    </div>

                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Stock</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Réf. du stock" id="stockRef">
                            <span class="icon is-small is-left">
                                <i class="fas fa-clipboard-list"></i>
                            </span>
                        </p>
                    </div>

                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label"></label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="DVD en stock" id="stockNb">
                            <span class="icon is-small is-left">
                                <i class="fas fa-warehouse"></i>
                            </span>
                        </p>
                    </div>

                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="en attente" id="stockNbwait">
                            <span class="icon is-small is-left">
                                <i class="fas fa-dolly"></i>
                            </span>
                        </p>
                    </div>

                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="DVD envoyés" id="stockNbSend">
                            <span class="icon is-small is-left">
                                <i class="fas fa-truck-pickup"></i>
                            </span>
                        </p>
                    </div>

                </div>
            </div>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success" id="btnSavePopup">Enregistrer</button>
            <button class="button" id="btnCancelPopup">Annuler</button>
        </footer>
    </div>

    <div id="encode" style="display: none;"></div>

</div>


<?php $content = ob_get_clean(); ?>
<?php $js = '<script src="./src/public/script/movie.js"></script>' .
    " <script type='text/template' class='TemplateCategorie'>

<option value={{id}}>{{name}} </option>
    
</script>" .
    "<script type='text/template' class='TemplateGenre'>
            <div class='control'>
                <label class='checkbox'>
                    <input type='checkbox' id_genre={{id}}>
                    {{name}}
                </label>
            </div>
</script>";

?>
<?php require('./src/templates/tmpBack.php'); ?>