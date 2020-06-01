$(document).ready(function (e) {


    console.log("deconnect.js");

    $("#btnDeconnect").on('click', (function (e) {
        var code = 0;
        var msg = 'No response';
        // Empêcher le rechargement de la page.
        event.preventDefault(); 
        $.ajax({dataType: "JSON",
            type: "GET", url: "../src/ajax/deco.php",
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
                    window.location = './index.php';
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