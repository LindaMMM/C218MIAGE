window.loadPanier = function (liste) {
    this.console.log("Load panier");
    _.templateSettings = {
        'interpolate': /\{\{(.+?)\}\}/g,      //  print value: {{ value_name }} 
        'evaluate': /\{%([\s\S]+?)%\}/g,  //  excute code: {% code_to_execute %} 
        'escape': /\{%-([\s\S]+?)%\}/g    //  excape HTML: {%- <script> %} prints &lt;script&gt; 
    };

    var content = '';
    var compileTpl = _.template($('script.TemplatePanier').html());

    // template
    _.forEach(liste, function (itemMovie) {
        content += compileTpl(itemMovie);
    });
    $('#boxpanier').html(content);   
};

window.deletefilm = function (idfilm){
    $.ajax({
        dataType: "JSON",
        type: "POST", url: "./src/ajax/panierAjax.php", data: { 'type': 'delPanier', 'movie':idfilm },
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
                document.location.reload(true);
                displayMessageInfo(msg);

            } else {
                displayMessageErr(msg);
            }
        }
    });

}

$(document).ready(function (e) {
    var code = 0;
    var msg;
    var liste = [];
    clearMessageErr();
    $.ajax({
        dataType: "JSON",
        type: "POST", url: "./src/ajax/panierAjax.php", data: { 'type': 'get' },
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
                loadPanier(liste);
                // displayMessageInfo(msg);

            } else {
                displayMessageErr(msg);
            }
        }
    });

    $('#btnsave').on('click', function(){
        $.ajax({
            dataType: "JSON",
            type: "POST", url: "./src/ajax/panierAjax.php", data: { 'type': 'save' },
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
                    displayMessageInfo(msg);
    
                } else {
                    displayMessageErr(msg);
                }
            }
        });
    })

    $('#btncancel').on('click', function(){
        $.ajax({
            dataType: "JSON",
            type: "POST", url: "./src/ajax/panierAjax.php", data: { 'type': 'viderPanier' },
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
                    displayMessageInfo(msg);
    
                } else {
                    displayMessageErr(msg);
                }
            }
        });
    })

})