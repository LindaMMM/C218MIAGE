$(document).ready(function (e) {
    console.log("movie.js");
    $("#addMovie").click(function () {
        getMovie(0);
        $("#popup_create").addClass("is-active");
    });
    $("#updateMovie").click(function () {
        alert("update for .click() called.");
    });
    $("#deleteMovie").click(function () {
        alert("dem for .click() called.");
    });
    
    function getMovie(id) {
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
    onloadTable = function () {
        var code = 0;
        var msg = 'No response';
        // event.preventDefault(); 
        $.ajax({
            dataType: "JSON",
            type: "POST", url: "./src/ajax/movie.php", data: { 'type': 'list' },
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
                if (code > 0) {
                    window.location = './index.php?page=accueil';
                } else {
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
        // event.preventDefault();
    }
    onloadTable();

    $('#fileBO').change(function (e) {
        var fileName = e.target.files[0].name;
        $('#labelFileBo').html(fileName);
        var file_data = $('#fileBO').prop('files')[0];
        var form_data = new FormData();

        form_data.append('file', file_data);
        alert(form_data);
        $.ajax({
            url: './src/ajax/upload.php', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response) {
                alert(php_script_response); // display response from the PHP script, if any
            }
        });
    });
});