function fetchdata(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: window.location.href,
        type: 'post',
        success: function(stockData){
            console.log(stockData);
        },
        complete:function(stockData){
            setTimeout(fetchdata,5000);
        }
    });
}
   
$(document).ready(function(){
    fetchdata();
});