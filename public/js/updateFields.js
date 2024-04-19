function updateFields() {
    var Brand = document.getElementById('Brand');
    var Brands = document.getElementById('categoryForm');
    var Code = document.getElementById("category");
    var Codes = document.getElementById("subKategoriSelect");
    var Tipe = document.getElementById("tipe");
    var SubSelect = Codes.value;

    if(SubSelect != null)
    {
        var SubAppend = SubSelect.split('|');
        var SubCates = SubAppend[0];
        var SubCate = SubAppend[1];
    }else{
        var SubCates = "";
        var SubCate = "";
    }

    var BrandSelect = Brand.value;
    var CategorySelect = Code.value;
    var Value = Tipe.value;
    var BrandAppend = BrandSelect.split('|');
    var CategoryAppend = CategorySelect.split('|');
    var LastLetter = Value.slice(0, 4).replace(/\s/g, '');
    var SKU = BrandAppend[0];
    var NAME = BrandAppend[1];
    var CategoryCode = CategoryAppend[0];
    var Category = CategoryAppend[1];

    var id = CategoryCode;
  

    if (id == 16) {
        document.getElementById("sku_nomor").value = "";
        document.getElementById('name').value = "";
    } else {
        document.getElementById("sku_nomor").value = SKU + SubCates + LastLetter;
        document.getElementById('name').value = NAME + " " + "- " + Category + " " + "- " + SubCate;
    }

    Brands.style.display = "block";
    document.getElementById('unit').value = "Unit";
    document.getElementById("unit").addEventListener("change", updateFields);
    document.getElementById("Brand").addEventListener("change", updateFields);
    document.getElementById("category").addEventListener("change", updateFields);
    document.getElementById("subKategoriSelect").addEventListener("change", updateFields);
    document.getElementById('tipe').addEventListener("input", updateFields);
}