<?php $title = 'Liste des films' ?>
<?php ob_start(); ?>

<div id="page" class="box">
    <p class="title is-1">Liste des films</p>
    <p class="subtitle is-3">Gestion des films</p>
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
                <p class="control">
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
    <div class="table-container">
        <table id="tabmovie" class="table is-fullwidth">
        </table>
    </div>
</div>
<div id="popup_delete" style="display: none"></div>
<div id="popup_create">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Modal title</p>
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
                            <input class="input" type="text" placeholder="Titre" id="title_movie">
                            <span class="icon is-small is-left">
                                <i class="fas fa-movie"></i>
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
                            <textarea class="textarea" placeholder="description" id="describ_movie"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Affiche</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="file control">
                            <label class="file-label">
                                <input class="file-input" type="file" name="resume">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">
                                        Right file…
                                    </span>
                                </span>
                                <span class="file-name">
                                    Screen Shot 2017-07-29 at 15.54.25.png
                                </span>
                            </label>
                        </div>


                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Bande annonce</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="file control" id="btnUploadFile">
                            <label class="file-label">
                                <input class="file-input" type="file" name="resume" id="fileBO">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label" id="labelFileBo">
                                        Right file…
                                    </span>
                                </span>
                                <span class="file-name">
                                    Screen Shot 2017-07-29 at 15.54.25.png
                                </span>
                            </label>
                        </div>


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
                                <select>
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

                    <div class="field panel ">
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
    </div>
    </section>
    <footer class="modal-card-foot">
        <button class="button is-success" id="btnSavePopup">Enregistrer</button>
        <button class="button" id="btnCancelPopup">Annuler</button>
    </footer>
</div>


</div>

<?php $content = ob_get_clean(); ?>
<?php $js = '<script src="./src/public/script/movie.js"></script>' ?>
<?php require('./src/templates/tmpBack.php'); ?>