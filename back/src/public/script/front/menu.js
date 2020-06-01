
$(document).ready(function (e) {
    $('#search').on('change',function(e){
        window.location = './index.php?page=search&val='+ $('#search').val();
        
    })
    
    
})