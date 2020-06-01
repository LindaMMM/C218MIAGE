<?php $title = 'Liste des utilisateurs'; ?>
<?php ob_start(); ?>


<div id="page" class="box">
    <div id="err"></div>
    <div class="section has-text-centered  has-background-grey-lighter">
        <p class="title is-1">Liste des Utilisateurs</p>
        <p class="subtitle is-3">Gestion des Utilisateurs</p>
        <div id="page" class="box">
            <nav>
                <div class="nav-item">
                    <div class="field is-grouped">
                        <p class="control">
                            <a class="bd-tw-button button is-info" id="addUser">
                                <span class="icon">
                                    <i class="fas fa-plus fa-2x"></i>
                                </span>
                                <span>
                                    Ajouter
                                </span>
                            </a>
                        </p>
                        <p class="control">
                            <a class="button is-primary" id="updateUser" href="#">
                                <span class="icon">
                                    <i class="fas fa-pen fa-2x"></i>
                                </span>
                                <span>
                                    Modifier
                                </span>
                            </a>
                        </p>
                        <p class="control">
                            <a class="button is-danger" id="deleteUser" href="#">
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
        <table id="tabUser" class="dataTable table is-fullwidth">
        </table>
    </div>
</div>

<div id="popup_create" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title"id="title_popup">Modal title</p>
            <button class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Identité</label>
                    </div>
                    <div class="field-body">
                        <div class="field-body">
                            <div class="field">
                                <p class="control is-expanded has-icons-left">
                                    <input class="input" type="text" placeholder="FirstName" id="txtfirstname">
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </p>
                                <p class="help">Le prénom n'est pas valide</p>
                            </div>
                            <div class="field">
                                <p class="control is-expanded has-icons-left has-icons-right">
                                    <input class="input is-success" type="text" placeholder="LastName" id="txtlastName">
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-id-card"></i>
                                    </span>

                                </p>
                                <p class="help is-danger">This email is invalid</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal"></div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left has-icons-right">
                                <input class="input is-success" type="email" placeholder="Email" id="txtEmail" value="alex@smith.com">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <span class="icon is-small is-right">
                                    <i class="fas fa-check"></i>
                                </span>
                            </p>
                            <p class="help is-danger">This email is invalid</p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">Role</label>
                    </div>
                    <div class="field-body">

                        <div class="field panel" id="rolesField">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" >
                                    Admin
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
            



        </section>
        <footer class="modal-card-foot">
      <button class="button is-success">Enregistrer</button>
      <button class="button">Annuler</button>
    </footer>
    </div>
   
</div>

<?php $content = ob_get_clean(); ?>
<?php $js = '<script src="./src/public/script/user.js"></script>' ?>
<?php require('./src/templates/tmpBack.php'); ?>