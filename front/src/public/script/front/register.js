
$(document).ready(function (e) {
    var client = {};
    var listForfait = [];
    var code = 0;
    var msg;

    ///
    // Mise à jour de la selection du type de forfait
    function loadPage() {
        $('#forfait').empty();
        _.forEach(listForfait, function (forfait, key) {
            $('#forfait').append($('<option>', {
                value: forfait.idForfait,
                text: htmlentities.decode(forfait.name)
            }));
        });
    }
    
    function testSaisie() {
        if ($('#forfait option:selected').length > 0) {
            var newmdp = $('#txtpwd').val();
            if ($('#txtpwd').val().indexOf($('#txtconfirpwd').val())== -1 )
            {
                displayMessageErr("Les mots de passe doivent être identique");
                return false;
            }
            else if (checkStrength(newmdp)<2 || newmdp.length<5 )
            {
                displayMessageErr("Le mot de passe n'est pas assez complexe");
                return false;
            }
            

            var continu = true;
            continu = check_chaine($("#txtfirstname"))&& continu;
            continu = check_chaine($("#txtlastname"))&& continu;
            continu = check_chaine($("#txtemail"))&& continu;
            continu = check_chaine($("#txtadresse"))&& continu;
            continu = check_chaine($("#txtville"))&& continu;
            continu = check_chaine($("#txtpays"))&& continu;
            continu = check_number($("#txtcodepostal"))&& continu;
            continu = check_number($("#txtphone"))&& continu;

            if(!check_email($("#txtemail").val()))
            {
                 $("#txtemail").addClass("is-danger");
                continu =false;    
            }            
            
            return continu;
        }
        else
        {
            displayMessageErr("le choix du forfait est obligatoire");
        }
        return false;
    }
    
    
    $.ajax({dataType: "JSON",
    type: "POST", url: "../src/ajax/movieAjax.php", data: {'type': 'listForfait'},
    success: function (response) {
        code = response.code;
        msg = response.message;
        listForfait = response.value;
    },
    error: function (response) {
        code = response.code;
        msg = response.message;
    },
    complete: function () {
        if (code > 0)
        {
            loadPage();
            
        } else
        {
            html = '<div class="notification is-danger">\n\
                    <button class="delete">\n\
                    </button>' + msg + '\n\
                    </span>\n\
                </div>';
            $('#err').html(html);
        }
    }
});
    $('#btncancel').on('click', function () {
        window.location = './index.php?page=accueil';
    })
    $('#btnsave').on('click', function () {
        clearMessageErr();
        // si thème sélectionné
        if (testSaisie()) {

            client.firstname = $('#txtfirstname').val();
            client.lastname = $('#txtlastname').val();
            client.email = $('#txtemail').val();
            client.adress = $('#txtadresse').val();
            client.codpostal = $('#txtcodepostal').val();
            client.ville = $('#txtville').val();
            client.pays = $('#txtpays').val();
            client.phone = $('#txtphone').val();
            client.pwd = $('#txtpwd').val();
            client.forfait = $('#forfait option:selected').val();
            $("#popup_create").addClass("is-active")
        }
        else {
            // erreur dans la  saisie
            displayMessageErr("le formulaire n'est pas valide");
        }
    })
    $('#savePaied').on('click', function () {
        $.ajax({dataType: "JSON",
        type: "POST", url: "../src/ajax/clientAjax.php", data: {'type': 'create','value':JSON.stringify(client) },
        success: function (response) {
            code = response.code;
            msg = response.message;
            listForfait = response.value;
        },
        error: function (response) {
            code = response.code;
            msg = response.message;
        },
        complete: function () {
            if (code > 0)
            {
                window.location = './index.php?page=login';
                
            } else
            {
                html = '<div class="notification is-danger">\n\
                        <button class="delete">\n\
                        </button>' + msg + '\n\
                        </span>\n\
                    </div>';
                $('#err').html(html);
            }
        }
    });
        
    })
    $(".modal-close").click(function() {
        $(".modal").removeClass("is-active");
      });
      
      
})
