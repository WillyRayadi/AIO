$.ajax({
    url: BaseUrlSKU,
    type: "GET",
    dataType: "json",
    success: function(response) {
        var Check = response;

        document.getElementById("tipe").addEventListener("input", function() {
            var inputTipe = this.value.trim();
            var firstFourDigits = inputTipe.substring(0, 4);
        
            var validationMessageElement = document.getElementById("validation_message");
            validationMessageElement.textContent = "";
        
            var newSkuNomor = "";
            
               
            setTimeout(function(){
                for (var i = 0; i < Check.length; i++) {
                    var skuNumber = Check[i].sku_number;
                    var lastFourDigits = skuNumber.substring(skuNumber.length - 4);
            
                    if (lastFourDigits === firstFourDigits) {
                        var shiftedFirstChar = inputTipe.charAt(0);
                        var shiftedTipe = inputTipe.substring(1) + shiftedFirstChar;
                        var modifiedSku = shiftedTipe.substring(0, 4);
                        var skuNomor = document.getElementById("sku_nomor").value;
                
                        newSkuNomor = skuNomor.substring(0, skuNomor.length - 4) + modifiedSku;
                        document.getElementById('sku_nomor').value = newSkuNomor;
                        validationMessageElement.textContent = "Nomor SKU sudah ada!, Value diubah menjadi " + newSkuNomor;
                    
                        break;
                    }
                    
                }
            }, 20);
        });
    }
});
