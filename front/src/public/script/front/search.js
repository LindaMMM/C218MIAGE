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


window.loadfilm = function (liste) {
    this.console.log("Load film");
    _.templateSettings = {
        'interpolate': /\{\{(.+?)\}\}/g,      //  print value: {{ value_name }} 
        'evaluate': /\{%([\s\S]+?)%\}/g,  //  excute code: {% code_to_execute %} 
        'escape': /\{%-([\s\S]+?)%\}/g    //  excape HTML: {%- <script> %} prints &lt;script&gt; 
    };

    var content = '';
    var compileTpl = _.template($('script.TemplateMovie').html());

    // template
    _.forEach(liste, function (itemMovie) {
        content += compileTpl(itemMovie);
    });
    $('#movie').html(content);   
};

$(document).ready(function (e) {
    var code = 0;
    var msg;
    var liste = [];
    clearMessageErr();
    $.ajax({
        dataType: "JSON",
        type: "POST", url: "../src/ajax/movieAjax.php", data: { 'type': 'listCategorie' },
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
                $("a").click(function(){
                    console.log("change");
                    $( this ).toggleClass("is-active");
                    search();
                })
                searchGenre();
                // displayMessageInfo(msg);

            } else {
                displayMessageErr(msg);
            }
        }
    });

    function searchGenre(){
    $.ajax({
        dataType: "JSON",
        type: "POST", url: "../src/ajax/movieAjax.php", data: { 'type': 'listGenre' },
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
                $("input[type='checkbox']").on("change",function(){
                    console.log("change");
                    search();
                    
                })

                search();
                // displayMessageInfo(msg);

            } else {
                displayMessageErr(msg);
            }
        }
    });
}

    function search(){
        console.log("search film");
        $('#movie').html("");   
        var genre ='';
        
        _.forEach($('#block_genre').find('input:checked'), function (itemgenre) {
            genre +=  itemgenre.getAttribute("id_genre");
            genre +=  ", ";
        });
        
        var cat ='';
        _.forEach($('#panelCategorie' ).find(".is-active"), function (itemcat) {
            cat +=  itemcat.getAttribute("id_cat");
            cat +=  ", ";
        });

        var filter = {};
        filter.search = $('#txtsearchMovie').val();
        filter.genre =  genre.substring(0, genre.length - 2);
        filter.categorie = cat.substring(0, cat.length - 2);;
        $.ajax({
            dataType: "JSON",
            type: "POST", url: "../src/ajax/movieAjax.php", data: { 'type': 'search', 'filter': JSON.stringify(filter) },
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
                    loadfilm(liste);
                    // displayMessageInfo(msg);
    
                } else {
                    displayMessageErr(msg);
                }
            }
        });

        


    };
   
   

   

})