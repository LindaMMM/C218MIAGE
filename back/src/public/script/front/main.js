window.loadMovie= function(liste){
    this.console.log("update liste");
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
    $('#news').html(content);

};

$(document).ready(function (e) {
    // Lecture des 4 derniers films
    var code = 0;
    var msg;
    var liste=[];
    $.ajax({dataType: "JSON",
    type: "POST", url: "../src/ajax/movieAjax.php", data: {'type': 'top4'},
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
        if (code > 0)
        {
            loadMovie(liste);
            
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