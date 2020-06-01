$(document).ready(function (e) {


    console.log("login.js");

    $("#idform").on('submit', (function (e) {
        var code = 0;
        var msg = 'No response';
        login = $('input[name=email]').val();
        pwd = $('input[name=pwd]').val();
        // Empêcher le rechargement de la page.
        event.preventDefault(); 
        $.ajax({dataType: "JSON",
            type: "POST", url: "../src/ajax/loginAjax.php", data: {'email': login, 'pwd': pwd, 'view':'front' },
            success: function (response) {
                code = response.code;
                msg = response.message;
                connection = response.value;
            },
            error: function (response) {
                code = response.code;
                msg = response.message;
            },
            complete: function () {
                if (code > 0)
                {
                    window.location = './index.php?page=accueil';
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
        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    }));
});