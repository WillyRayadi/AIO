document.getElementById("category").addEventListener("change", loadSubCategories);

function loadSubCategories() {
    var selectedOption = document.getElementById("category").value;
    var categoryId = selectedOption.split('|')[0];

    $.ajax({
        url: BaseUrlLoad,
        type: 'POST',
        data: {
            category_id: categoryId
        },
        dataType: 'json',
        success: function(response) {
            var subSelect = document.getElementById("subKategoriSelect");
            var subLabel = document.getElementById("subKategoriLabel");
            var sub = document.getElementById("subForm");
            var brand = document.getElementById("merk");
            subSelect.innerHTML = "";
            var subCategories = response[categoryId];
            var hasSubCategories = subCategories.length > 0;

            if (hasSubCategories) {
                subSelect.style.display = "block";
                subLabel.style.display = "block";
                sub.style.display = "block";
                brand.style.display = "block";

                var hideBrand = subCategories.some(function(subCategory) {
                    return subCategory.category_id === "16";

                });

                if (hideBrand) {
                    brand.style.display = "none";
                    var sku = document.getElementById('sku_nomor');
                    sku.value = "";
                } else {
                    brand.style.display = "block";
                }

                var chooseOption = document.createElement("option");
                chooseOption.value = "";
                chooseOption.textContent = "-- Pilih Sub Kategori --";
                subSelect.insertBefore(chooseOption, subSelect.firstChild);
                subSelect.selectedIndex = 0;

                for (var i = 0; i < subCategories.length; i++) {
                    var subCategory = subCategories[i];
                    var option = document.createElement("option");
                    option.value = subCategory.code + "|" + subCategory.name;
                    option.textContent = subCategory.name;
                    subSelect.appendChild(option);
                }

                subSelect.selectedIndex = 0;

            } else {
                subSelect.style.display = "none";
                subLabel.style.display = "none";
                sub.style.display = "none";
                brand.style.display = "none";
                document.getElementById("sku_nomor").value = "";
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}