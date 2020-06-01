$(document).ready(function (e) {
    console.log("user.js");
    var selected = [];
    var roles = [];
    var tableConnexion = $('#tabUser').dataTable({
        "dom": '<"field is-horizontal"l> <"field is-horizontal"f>rt<"bottom"p><"clear">',
        "ajax": {
            "type": "POST",
            "url": "./src/ajax/lstUserAjax.php",
            "dataSrc": "aaData",
            "data": function (d) {
                return $.extend({}, d, {
                    "type": 'list'
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
            "search" : "Rechercher",
            "info": " _PAGE_ / _PAGES_",
            "infoEmpty": "Aucune enregistrement",
            "infoFiltered": "(filtered from _MAX_ total records)",
            paginate: {
                first:      "Premier",
                previous:   "Pr&eacute;c&eacute;dent",
                next:       "Suivant",
                last:       "Dernier"
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

    function initListRole() {
        $.ajax({
            dataType: "JSON",
            type: "POST",
            url: "./src/ajax/lstUserAjax.php",
            data: {
                type:'listRole',
            },
            success: function (reponse) {
                roles = reponse;
                afficheRole();
            },
            error: function (reponse) {
                html = '<div class="notification is-danger">\n\
                <button class="delete">\n\
                </button>' + reponse + '\n\
                </span>\n\
                </div>';
                    $('#err').html(html);
            }
            
        });
    }

    function afficheRole(){
        $('#rolesField').empty();
        _.forEach(roles, function (role) {
            var txt1 = '<div class="control"> <label class="checkbox"> <input type="checkbox" id=cbx_'+role.codRole +' /> '+role.namRole+'</label> </div>'; 
            $('#rolesField').append(txt1)
        });

    }
     function check_email(val){
        if(!val.match(/\S+@\S+\.\S+/)){ 
            return false;
        }
        if( val.indexOf(' ')!=-1 || val.indexOf('..')!=-1){
            return false;
        }
        return true;
    }
    
    function check_number(selector){
        var value =selector.val();
        selector.addClass("error_input");
        if (_.isEmpty(value) )
        {
            return false;
        }
        if (!$.isNumeric(value) )
        {
            return false;
        }
        selector.removeClass("error_input");
        return true;
    }

    function check_chaine(selector){
        var value =selector.val();
        selector.addClass("error_input");
        if (_.isEmpty(value) )
        {
            return false;
        }
        if (!_.isString(value) )
        {
            return false;
        }
        selector.removeClass("error_input");
        return true;
    }

    function clearSelected() {
        // supression dans la sélection
        $('.selected').each(function () {
            $(this).removeClass("is-selected");
        });
        selected = [];
    }
    function checkInput()
    {
        var continu = true;
        continu = check_chaine($("#txtfirstname"))&& continu;
        continu = check_chaine($("#txtlastname"))&& continu;
        continu = check_chaine($("#txtEmail"))&& continu;
      
        if(!check_email($("#txtEmail").val()))
        {
             $("#txtEmail").addClass("error_saisie");
            continu =false;    
        }
        
        return continu;
    }
    function addUser(event, ui,id)
    {
        if (!checkInput())
        {
            displayMessage("erreur","erreur ",'warning');
            return ;
        }
        
        /*Recupération info saisie*/
        var user={};
        if (id === undefined)
        {
            id=0;
        }
        
        user.id = id;
        user.firstname=$("#txtfirstname").val();
        user.lastname=$("#txtlastname").val();
        user.email=$("#txtEmail").val();
   
        
        
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
                type:'add',
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
                if (code>0)
                {
                    /*Fermer la boite de dialogue*/
                    $("#popup_create").dialog("close");
                }
                 tableConnexion.fnDraw(true);
                 displayMessage("infor",msg);
                 $eltUpdate = -1;
            }

        });
    }

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
                        _.forEach(user.roles,function(role){
                            $('#cbx_'+role.codRole).attr('checked', 'checked')
                        })
                    }
                    else {
                        html = '<div class="notification is-danger">\n\
                    <button class="delete">\n\
                    </button>' + msg + '\n\
                    </span>\n\
                    </div>';
                        $('#err').html(html);
                    }
                }
            });

        }
        else {
            $("#txtfirstname").val('');
            $("#txtlastName").val('');
            $("#txtEmail").val('');
        }
    }

    $("#addUser").click(function () {
        $('#title_popup').html("Création d'un utilisateur");
        getUser(0);
        $("#popup_create").addClass("is-active");
    });
    
    $("#updateUser").click(function () {
        if (selected.length == 0) {
            html = '<div class="notification is-danger">\n\
                    <button class="delete">\n\
                    </button>' + 'Aucun utilisateur a été sélectionné.' + '\n\
                    </span>\n\
                    </div>';
            $('#err').html(html);

        }
        else {
            $('#title_popup').html("Mise à jour d'un utilisateur");
            $eltUpdate = selected[0];
            getUser($eltUpdate);
            $("#popup_create").addClass("is-active");
        }

    });
    $("#deleteUser").click(function () {
        alert("dem for .click() called.");
    });

    // Mise à jour de l'affichage
    initListRole();
});

$(".modal-close").click(function() {
    $(".modal").removeClass("is-active");
 });