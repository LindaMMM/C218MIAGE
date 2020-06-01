<?php $title = 'Nouvelle utilisateur'; ?>
<?php ob_start(); ?>

<div id="page" class="box">
    <div id="err"></div>
    <div class="section has-text-centered  has-background-grey-lighter">
        <p class="title is-1">Nouveau client</p>
        <div id="page" class="box">
            <section class="modal-card-body">
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Identité</label>
                    </div>
                    <div class="field-body">
                        <div class="field-body">
                            <div class="field">
                                <p class="control is-expanded has-icons-left">
                                    <input class="input" type="text" placeholder="Prénom" id="txtfirstname">
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="field">
                                <p class="control is-expanded has-icons-left has-icons-right">
                                    <input class="input" type="text" placeholder="Nom" id="txtlastname">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal"></div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left has-icons-right">
                                <input class="input" type="email" placeholder="Email" id="txtemail">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <span class="icon is-small is-right">
                                    <i class="fas fa-check"></i>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">Adresse</div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left has-icons-right">
                                <input class="input" type="text" placeholder="adresse" id="txtadresse">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
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
                        <div class="field-body">
                            <div class="field">
                                <p class="control is-expanded has-icons-left">
                                    <input class="input" type="text" placeholder="Code postal" id="txtcodepostal">
                                </p>
                            </div>
                            <div class="field">
                                <p class="control is-expanded has-icons-left has-icons-right">
                                    <input class="input" type="tel" placeholder="Ville" id="txtville">
                                </p>
                            </div>

                            <div class="field">
                                <p class="control is-expanded">
                                    <input class="input" type="text" placeholder="Pays" id="txtpays">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">Numéro de portable</div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left has-icons-right">
                                <input class="input" type="text" placeholder="Num Portable" id="txtphone">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-phone"></i>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">Mot de passe</div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left has-icons-right">
                                <input class="input " type="password" placeholder="Mot de passe" id="txtpwd">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-key"></i>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal"></div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left">
                                <input class="input " type="password" placeholder="Mot de passe confirmation" id="txtconfirpwd">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-key"></i>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">Choix du forfait</label>
                    </div>
                    <div class="field-body">

                        <div class="field panel" id="rolesField">
                            <div class="control is-expanded">
                                <div class="select">
                                    <select id='forfait'>
                                        <option selected>Aucun forfait</option>
                                        <option>Select dropdown</option>
                                        <option>With options</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>
            <section>
                <button class="button is-success" id="btnsave">Enregistrer</button>
                <button class="button" id="btncancel">Annuler</button>
            </section>
        </div>
    </div>
</div>
<!-- Popup enregistrement du paiement-->
<div id="popup_create" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title" id="title_popup">Enregistrement du paiement</p>
            <button class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <p class="title is-1">Cette page permet de simuler le paiement.</p>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success" id="savePaied" >Enregistrer</button>
            <button class="button">Annuler</button>
        </footer>
    </div>

    <?php $content = ob_get_clean(); ?>
    <?php $js = '<script src="../src/public/script/front/register.js"></script>' ?>
    <?php require('../src/templates/tmpFront.php'); ?>