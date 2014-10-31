$(document).ready(function(){
    $("#btnSubmit").click(function(event) {
        event.preventDefault();
        $.ajax({
            url: 'index.php',
            type: 'POST',
            async: true,
            context: jQuery('#resultado'),
            success: function(data){
                this.append(data);
            }
        });    
    });
    
});