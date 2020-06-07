/* Chargement */
// Chargement des catégories de films
window.loadcategorie = function (liste) {
    this.console.log("Load categorie");
    _.templateSettings = {
        'interpolate': /\{\{(.+?)\}\}/g,      //  print value: {{ value_name }} 
        'evaluate': /\{%([\s\S]+?)%\}/g,  //  excute code: {% code_to_execute %} 
        'escape': /\{%-([\s\S]+?)%\}/g    //  excape HTML: {%- <script> %} prints &lt;script&gt; 
    };

    var content = '';
    var compileTpl = _.template($('script.TemplateCategorie').html());

    // template
    _.forEach(liste, function (itemMovie) {
        content += compileTpl(itemMovie);
    });
    $('#panelCategorie').html(content);

};

// Chargement des genres de films
window.loadGenre = function (liste) {
    this.console.log("Load genre");
    _.templateSettings = {
        'interpolate': /\{\{(.+?)\}\}/g,      //  print value: {{ value_name }} 
        'evaluate': /\{%([\s\S]+?)%\}/g,  //  excute code: {% code_to_execute %} 
        'escape': /\{%-([\s\S]+?)%\}/g    //  excape HTML: {%- <script> %} prints &lt;script&gt; 
    };

    var content = '';
    var compileTpl = _.template($('script.TemplateGenre').html());

    // template
    _.forEach(liste, function (itemMovie) {
        content += compileTpl(itemMovie);
    });
    $('#block_genre').html(content);

};

// Chargement de la page par JQuery
$(document).ready(function (e) {
    console.log("movie.js");
    $tablemovie = {};
    $film = {};
    var selected = [];
    $eltUpdate = -1;
    var code = 0;
    var msg;
    var liste = [];
    
    function clearSelected() {
        // supression dans la sélection
        $('.is-selected').each(function () {
            $(this).removeClass("is-selected");
        });
        selected = [];
    }

    function loadlist() {
    $tablemovie = $('#tabmovie').dataTable({
        "dom": '<"field is-horizontal"> <"field is-horizontal"f>rt<"bottom"p><"clear">',
        "ajax": {
            "type": "POST",
            "url": "./src/ajax/movieAjax.php",
            "dataSrc": "aaData",
            "data": function (d) {
                return $.extend({}, d, {
                    "type": 'list'
                });
            }
        },
        "columns": [
            { "data": "idMovie", "title": "ID" },
            { "data": "name", "title": "Titre" },
            { "data": "description", "title": "Résumé" },
            { "data": "dateout", "title": "Date de sortie", render: function(data, type, row){
                if(type === "sort" || type === "type"){
                    return data;
                }
                return moment(data).format("MM-DD-YYYY");
            } },
            { "data": "Realisateur", "title": "Réalisateur" }
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
            { "sWidth": "15%", "aTargets": [1] },// titre
            { "sWidth": "70%",  "bVisible": false,"aTargets": [2] },// résume
            { "sWidth": "10%", "aTargets": [3], "orderable": false },// date]
            { "sWidth": "10%", "aTargets": [4], "orderable": false } // réalisateur
        ],
        "select": true,
        "paging": true,
        "searching": true,
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        //"scrollY": "300",
        "rowCallback": function (row, data) {
            if ($.inArray(data.idMovie, selected) !== -1) {
                $(row).addClass('selected');
            }
        }
    });
    $('#tabmovie tbody').on('click', 'tr', function () {
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
    }
   
    function getGenre() {
        var genre = '';
        _.forEach($('#block_genre').find('input:checked'), function (itemgenre) {
            genre += itemgenre.getAttribute("id_genre");
            genre += ", ";
        });
        return genre;
    }
    function setScreenFilm(film) {
        $("#title_movie").val(film.title);
        $("#describ_movie").val(film.desc);
        $("#name_video").val(film.video);
        $("#name_affiche").val(film.view);
        $("#dateout").val(film.dtOut);
        $("#note_movie").val(film.note);
        $("#realisateur").val(film.realisateur);
        $("#producteur").val(film.producteur);
        $("panelCategorie").val(film.classif.id);
        $('input[type="checkbox"]').each(function () {
            $(this).prop('checked', false);
        });
       _.forEach(film.genres,function(genre){
            $('input[id_genre='+genre.idgenre+']').prop('checked',true)
        })
        $("#stockRef").val(film.stock.refproduct);
        $("#stockNb").val(film.stock.nbstock);
        $("#stockNbwait").val(film.stock.nbwait);
        $("#stockNbSend").val(film.stock.nbsend);

    }
    
    function clearpopup() {
        $film.id = 0;
        $("#title_movie").val("");
        $("#describ_movie").val("");
        $("#name_video").val("");
        $("#name_affiche").val("");
        $("#dateout").val("");
        $("#note_movie").val("");
        $("#realisateur").val("");
        $("#producteur").val("");
        
        $('input[type="checkbox"]').each(function () {
            $(this).prop('checked', false);
        });
        /*
        $film.genre = [];
        $film.genre = getGenre();
        */
        $("#stockRef").val("");
        $("#stockNb").val("");
        $("#stockNbwait").val("");
        $("#stockNbSend").val("");
    }

    function getScreenFilm() {
        $film.title = $("#title_movie").val();
        $film.desc = $("#describ_movie").val();
        $film.video = $("#name_video").val();
        $film.affiche = $("#name_affiche").val();
        $film.dateout = $("#dateout").val();
        $film.note = $("#note_movie").val();
        $film.realisateur = $("#realisateur").val();
        $film.producteur = $("#producteur").val();
        $film.idcategory = $('#panelCategorie option:selected').val();
        $film.genre = [];
        $film.genre = getGenre();
        $film.stockRef = $("#stockRef").val();
        $film.nbstock = $("#stockNb").val();
        $film.nbwait = $("#stockNbwait").val();
        $film.nbsend = $("#stockNbSend").val();

    }

    
    $("#btnSavePopup").click(function () {
        // save 
        $("#popup_create").removeClass("is-active");
        getScreenFilm();
        var code = 0;
        var msg = "";

        $.ajax({
            dataType: "JSON",
            type: "POST",
            url: "./src/ajax/movieAjax.php",
            data: {
                type: 'save',
                movie: JSON.stringify($film)
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
                    html = '<div class="notification is-info">\n\
                    <button class="delete">\n\
                    </button>' + msg + '\n\
                    </span>\n\
                    </div>';
                    $('#err').html(html);

                    $tablemovie.fnDraw(true);
                    $eltUpdate = -1;
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


    });

    $("#btnCancelPopup").click(function () {
        $("#popup_create").removeClass("is-active");
    });


    $("#addMovie").click(function () {
        getMovie(0);
        $("#popup_create").addClass("is-active");

        $(".modal-close").click(function () {
            $(".modal").removeClass("is-active");
        });
    });

    $("#updateMovie").click(function () {
        if (selected.length == 0) {
            html = '<div class="notification is-danger">\n\
                    <button class="delete">\n\
                    </button>' + 'Aucun film a été sélectionné.' + '\n\
                    </span>\n\
                    </div>';
            $('#err').html(html);

        }
        else {
            
            $eltUpdate = selected[0];
            clearSelected();
            getMovie($eltUpdate);
            $("#popup_create").addClass("is-active");
            $(".modal-close").click(function () {
                $(".modal").removeClass("is-active");
            });
        }
        
    });

    $("#deleteMovie").click(function () {
        alert("dem for .click() called.");
    });

    function getMovie(id) {
        $('#block_genre').find('input[type="checkbox"]').removeAttr('checked');
        //Lecture 
        if (id != 0) {
            var movie = {};
            $.ajax({
                dataType: "JSON",
                type: "POST",
                url: "./src/ajax/movieAjax.php",
                data: {
                    type: 'get',
                    id: id
                },
                success: function (response) {
                    code = response.code;
                    msg = response.message;
                    movie = response.value;
                },
                error: function (response) {
                    code = response.code;
                    msg = response.message;
                },
                complete: function () {
                    if (code > 0) {
                        $film.id = $eltUpdate;
                        setScreenFilm(movie);
                       
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
           clearpopup();
        }
    }

   


    function searchGenre() {
        $.ajax({
            dataType: "JSON",
            type: "POST", url: "./src/ajax/movieAjax.php", data: { 'type': 'listGenre' },
            success: function (response) {
                code = response.code;
                msg = response.message;
                liste = response.value;
            },
            error: function (response) {
                code = response.code;
                msg = response.message;
            },
            complete: function () {
                if (code > 0) {
                    loadGenre(liste);
                    loadlist();
                    // displayMessageInfo(msg);

                } else {
                    displayMessageErr(msg);
                }
            }
        });
    }

    clearMessageErr();
    $.ajax({
        dataType: "JSON",
        type: "POST", url: "./src/ajax/movieAjax.php", data: { 'type': 'listCategorie' },
        success: function (response) {
            code = response.code;
            msg = response.message;
            liste = response.value;
        },
        error: function (response) {
            code = response.code;
            msg = response.message;
        },
        complete: function () {
            if (code > 0) {
                loadcategorie(liste);
                $("a").click(function () {
                    console.log("change");
                    $(this).toggleClass("is-active");
                })
                searchGenre();
                // displayMessageInfo(msg);

            } else {
                displayMessageErr(msg);
            }
        }
    });

});