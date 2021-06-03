;(function($) {

    $("#caratname_field").on("change", function() {
        var rate = $(this).val();
        var carat_name = $(this).find("option:selected").text(); 
        if(rate < 1){
            alert('Product carat has not assigned. Add product carat name after adding weight  under shipping Tab');
            return;
        }
        caretvalue(rate, carat_name)
    });

function caretvalue(rate, carat_name) {

var productweight = $("#_weight").val();

if(productweight < 1) {
    alert('Product weight is empty. Add product weight first under shipping Tab');
        return;
}else{
    var price = productweight * rate;
    $("#_regular_price").val(price);
    $("#assign_carat_name").val(carat_name);
}

}

$("#_weight").on("blur", function() {
    if( $(this).val() > 0 && $("#caratname_field").val() > 1){ 
    $("#caratname_field").trigger("change");
    }
})

console.log("loaded from gold price admin menu");

})(jQuery);