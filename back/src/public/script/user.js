$(document).ready(function (e) {
    console.log("user.js");
    // Liste des éléments selectionnés dans la liste
    var selected = [];
    var roles = [];
    $eltUpdate = -1;
    var tableConnexion = $('#tabUser').dataTable({
        "dom": '<"field is-horizontal"> <"field is-horizontal"f>rt<"bottom"p><"clear">',
        "ajax": {
            "type": "POST",
            "url": "./src/ajax/lstUserAjax.php",
            "dataSrc": "aaData",
            "data": function (d) {
                return $.extend({}, d, {
                    "type": 'list',
                    "role": 'back'
                });
            }
        },
        "columns": [
            { "data": "iduser", "title": "ID" },
            { "data": "firstName", "title": "Prénom" },
            { "data": "lastName", "title": "Nom" },
            { "data": "email", "title": "Email" }
        ],
        "language": {
            "lengthMenu": "Affichage _MENU_ par page",
            "zeroRecords": "Pas d'enregistrement",
            "search": "Rechercher",
            "info": " _PAGE_ / _PAGES_",
            "infoEmpty": "Aucune enregistrement",
            "infoFiltered": "(filtered from _MAX_ total records)",
            paginate: {
                first: "Premier",
                previous: "Pr&eacute;c&eacute;dent",
                next: "Suivant",
                last: "Dernier"
            },
        },
        "columnDefs": [
            { "bSearchable": false, "bVisible": false, "aTargets": [0] }, // ID
            { "sWidth": "40%", "aTargets": [1] },// NOM
            { "sWidth": "10%", "aTargets": [2], "orderable": false },// PRENOM]
            { "sWidth": "10%", "aTargets": [3], "orderable": false }
        ],
        "select": true,
        "paging": true,
        "searching": true,
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        //"scrollY": "300",
        "rowCallback": function (row, data) {
            if ($.inArray(data.iduser, selected) !== -1) {
                $(row).addClass('selected');
            }
        }
    });

    // suppression des lignes sélectionées sur la table
    function clearSelected() {
        // supression dans la sélection
        $('.is-selected').each(function () {
            $(this).removeClass("is-selected");
        });
        selected = [];
    }

    //
    // Selection dans la liste
    // 
    $('#tabUser tbody').on('click', 'tr', function () {
        // Ajout dans la sélection
        var id = this.id;
        var index = $.inArray(id, selected);

        if (index === -1) {
            clearSelected();
            selected.push(id);
        } else {
            selected.splice(index, 1);
        }

        $(this).toggleClass('is-selected');
    });

    ///--------------------------------------
    // Lecture de la liste de rôles
    ///-------------------------------------
    function initListRole() {
        $.ajax({
            dataType: "JSON",
            type: "POST",
            url: "./src/ajax/lstUserAjax.php",
            data: {
                type: 'listRole',
                role: 'back',
            },
            success: function (reponse) {
                code = reponse.code;
                msg = reponse.message; 
                roles = JSON.parse(reponse.value);
                
            },
            error: function (reponse) {
                code = -1;
                msg = "la liste des rôles est non trouvable.";
            },
            complete: function (){
                if (code > 0) {
                    afficheRole();
                } else {
                    displayMessageErr(msg);
                }
            }

        });
    }

    // affiche la liste des rôles
    function afficheRole() {
        $('#rolesField').empty().html('');
        _.forEach(roles, function (role) {
            var txt1 = '<div class="control"> <label class="checkbox"> <input type="checkbox" id=cbx_' + role.code + ' /> ' + role.name + '</label> </div>';
            $('#rolesField').append(txt1)
        });
    }

    ///---------------------------------------------------
    /// vérification de la liste des saisie
    ///---------------------------------------------------
    function checkInput() {
        var continu = true;
        continu = check_chaine($("#txtfirstname")) && continu;
        continu = check_chaine($("#txtlastname")) && continu;
        continu = check_chaine($("#txtEmail")) && continu;
        continu = check_chaine($("#txtPwd")) && continu;

        if (!check_email($("#txtEmail").val())) {
            $("#txtEmail").addClass("is-danger");
            continu = false;
        }

        return continu;
    }

    /**** Annuler de la popup */
    $('#btnCancel').on('click',function(){
        $("#popup_create").removeClass("is-active");
    });

    function getroles() {
        var role = '';
        _.forEach($('#rolesField').find('input:checked'), function (itemrole) {
            role += itemrole.getAttribute("val");
            role += ", ";
        });
        return role;
    }

    /**** Ajout de la popup  */
    $('#btnSave').on('click',function(){
    
    
        if (!checkInput()) {
            displayMessageErr("L'ajout n'est pas possible");
            return;
        }

        /*Recupération info saisie*/
        var user = {};
        
        if ($eltUpdate === -1) {
            user.id = 0;
        }
        else{
            user.id = $eltUpdate ;
        }

        
        user.firstname = $("#txtfirstname").val();
        user.lastname = $("#txtlastname").val();
        user.email = $("#txtEmail").val();
        user.pwd = $("#txtPwd").val();

        /*Transmission de la sauvegarde*/
        console.log("save");
        var code = 0;
        var msg;
        //Enregistre les modifications 
        $.ajax({
            dataType: "JSON",
            type: "POST",
            url: "./src/ajax/lstUserAjax.php",
            data: {
                type: 'add',
                user: JSON.stringify(user)
            },
            success: function (response) {
                code = response.code;
                msg = response.message;

            },
            error: function (response) {
                code = response.code;
                msg = response.message;
            },
            complete: function () {
                if (code > 0) {
                    /*Fermer la boite de dialogue*/
                    $("#popup_create").removeClass("is-active");
                }
                tableConnexion.fnDraw(true);
                displayMessageInfo(msg);
                $eltUpdate = -1;
            }

        });
    });

    //-------------------------------------
    // lecture de l'utilisateur
    //--------------------------------------
    function getUser(id) {
        $('#rolesField').find('input[type="checkbox"]').removeAttr('checked');
        //Lecture 
        if (id != 0) {
            var user = {};
            $.ajax({
                dataType: "JSON",
                type: "POST",
                url: "./src/ajax/lstUserAjax.php",
                data: {
                    type: 'get',
                    id: id
                },
                success: function (response) {
                    code = response.code;
                    msg = response.message;
                    user = response.value;
                },
                error: function (response) {
                    code = response.code;
                    msg = response.message;
                },
                complete: function () {
                    if (code > 0) {
                        $("#txtfirstname").val(user.firstName);
                        $("#txtlastName").val(user.lastName);
                        $("#txtEmail").val(user.email);
                        $("#txtPwd").val(user.pwd);
                        _.forEach(user.roles, function (role) {
                            $('#cbx_' + role.codRole).attr('checked', 'checked')
                        })
                    }
                    else {
                        displayMessageErr(msg);
                    }
                }
            });

        }
        else {
            $("#txtfirstname").val('');
            $("#txtlastName").val('');
            $("#txtEmail").val('');
            $("#txtPwd").val('');
        }
    }

    /********************************************************************************************* */
    /*                          Evenements de la page                                               */
    /********************************************************************************************* */
    $("#addUser").click(function () {
        $('#title_popup').html("Création d'un utilisateur");
        getUser(0);
        $("#popup_create").addClass("is-active");
    });

    $("#updateUser").click(function () {
        if (selected.length == 0) {
            displayMessageErr('Aucun utilisateur a été sélectionné.');
        }
        else {
            $('#title_popup').html("Mise à jour d'un utilisateur");
            $eltUpdate = selected[0];
            getUser($eltUpdate);
            $("#popup_create").addClass("is-active");
            $(".modal-close").click(function () {
                $(".modal").removeClass("is-active");
            });
        }
    });

    $("#deleteUser").click(function () {
        if (selected.length == 0) {
            displayMessageErr('Aucun utilisateur a été sélectionné.');
        }
        else {
            $eltUpdate = selected[0];
            getUser($eltUpdate);
            $("#popup_delete").addClass("is-active");
            $(".modal-close").click(function () {
                $(".modal").removeClass("is-active");
            });
        }
    });

    // Mise à jour de l'affichage
    initListRole();
    clearMessageErr();
});


