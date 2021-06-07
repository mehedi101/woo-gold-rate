;(function($) {
    var regularPrice = $("#_regular_price");
    regularPrice.attr('readonly', true);

    $("#caratname_field").on("change", function() {
        var rate = Number( $(this).val());
        var carat_name = $(this).find("option:selected").text(); 
        console.log("Carat fileds"); 
        console.log(rate, carat_name);
        if(rate < 1){
            alert('Product carat has not assigned. Add product carat name after adding weight  under shipping Tab');
            return;
        }
        caretvalue(rate, carat_name)
    });

function caretvalue(rate, carat_name) {
    
var productweight = Number( $("#shipping_product_data #_weight").val());
console.log("weight", productweight); 

if(productweight < 1) {
    alert('Product weight is empty. Add product weight first under shipping Tab');
        return;
}else{
    var price = productweight * rate;
    console.log("price:", price); 
    regularPrice.val(price); 
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
