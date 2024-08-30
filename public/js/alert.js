document.addEventListener('DOMContentLoaded', function() {
    var pcsElements = document.querySelectorAll('#pcs');
    var lowStockModal = new bootstrap.Modal(document.getElementById('lowStockModal'));

    var lowStock = false;

    // Iterasi melalui setiap elemen dengan ID 'pcs'
    pcsElements.forEach(function(element) {
        var pcsValue = parseInt(element.textContent);

        // Mengecek apakah jumlah pcs kurang dari 5
        if (pcsValue < 5) {
            lowStock = true;
        }
    });

    // Menampilkan modal jika ada barang dengan pcs kurang dari 5
    if (lowStock) {
        lowStockModal.show();
    }
});