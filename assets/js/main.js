$(document).ready(function(){
    const baseUrl = "http://localhost/Investus/";
    $("#modalPopUp").on('shown.bs.modal', ()=>{});
    $("#buyPop").click(()=>{
        $("#modalPopUp").modal('show');
    $('.close').click(()=>{
        $('#modalPopUp').modal('hide');
        });
    });

    $('#buyStock').click(()=>{
        let stocksAction = $('#stockQuantity').val();
        let sendData = {amount: stocksAction};
        
        $.ajax({
            type: "POST",
            url: baseUrl + "stocksHandler",
            dataType: "json",
            data: sendData,
            success: function(response){ 
                alert(response);
            },
            error: function(thrownError){ 
                console.log(thrownError);
            }
        })
        
      /* $.post('http://localhost/Investus/model/stocksHandler.php',{'info':'bananas'}, function(data){
           console.log(data);
        })*/
    });
});