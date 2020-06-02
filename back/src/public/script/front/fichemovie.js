$(document).ready(function (e) {
    var code = 0;
    var msg;
    clearMessageErr();

    $('#btnAddPanier').on('click',function(){
        $.ajax({dataType: "JSON",
        type: "POST", url: "./src/ajax/panierAjax.php", data: {'type': 'addPanier'},
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
            displayMessageInfo(msg);
            
        } else
        {
            displayMessageErr(msg);
        }
    }
});
    })
    
})