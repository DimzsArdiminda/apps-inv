$(document).ready(function () {

    // Handle display options based on radio selection
    $('input[name="jenis_barang"]').on('change', function () {
        if ($(this).val() === 'Lanyard') {
            $('#lanyardOptions').show();
            $('#idCardOption').hide();
            $('#idCard2Option').hide();
            $('#holderOption').hide();
            $('#idCardOption2').hide();
            $('#nonLanyardOptions').hide();
        } else if ($(this).val() === 'Lanyard + ID Card') {
            $('#lanyardOptions').show();
            $('#idCardOption').show();
            $('#idCardOption2').show();
            $('#holderOption').hide();
            $('#nonLanyardOptions').hide();
        } else if ($(this).val() === 'Lanyard + ID Card + Holder') {
            $('#lanyardOptions').show();
            $('#idCardOption').show();
            $('#idCardOption2').show();
            $('#holderOption').show();
            $('#nonLanyardOptions').hide();
        } else {
            $('#lanyardOptions').hide();
            $('#nonLanyardOptions').show();
        }
    });

    // Ensure mutual exclusivity between Kertas and Kertas Dobel checkboxes
    $('#lanyardKertas').on('change', function () {
        if ($(this).is(':checked')) {
            $('#lanyardKertasDob').prop('checked', false);
        }
    });

    $('#lanyardKertasDob').on('change', function () {
        if ($(this).is(':checked')) {
            $('#lanyardKertas').prop('checked', false);
        }
    });

    // Ensure mutual exclusivity between ID Card and ID Card 2 checkboxes
    $('#idCard').on('change', function () {
        if ($(this).is(':checked')) {
            $('#idCard2').prop('checked', false);
        }
    });

    $('#idCard2').on('change', function () {
        if ($(this).is(':checked')) {
            $('#idCard').prop('checked', false);
        }
    });

    // Handle Harga Pas checkbox
    $('#hargaPas').on('change', function () {
        if ($(this).is(':checked')) {
            $('#Harga').val('Harga Pas');
        } else {
            $('#Harga').val('');
        }
    });

    // Pricing logic based on quantity and selected package
    $('#Jumlah').on('input', function () {
        var quantity = $(this).val();
        var selectedPackage = $('input[name="jenis_barang"]:checked').val();

        if (selectedPackage === 'Lanyard' || selectedPackage === 'Lanyard + ID Card' || selectedPackage === 'Lanyard + ID Card + Holder') {
            var price;

            if (quantity >= 1 && quantity <= 10) {
                price = selectedPackage === 'Lanyard' ? 17000 : selectedPackage === 'Lanyard + ID Card' ? 20000 : 23000;
            } else if (quantity >= 11 && quantity <= 23) {
                price = selectedPackage === 'Lanyard' ? 15000 : selectedPackage === 'Lanyard + ID Card' ? 19000 : 21000;
            } else if (quantity >= 24 && quantity <= 50) {
                price = selectedPackage === 'Lanyard' ? 15000 : selectedPackage === 'Lanyard + ID Card' ? 17000 : 19000;
            } else if (quantity >= 51 && quantity <= 100) {
                price = selectedPackage === 'Lanyard' ? 14000 : selectedPackage === 'Lanyard + ID Card' ? 16000 : 18000;
            }

            $('#Harga').val(price);
        } else {
            // For non-lanyard, keep manual input or use select box
            $('#Harga').val('').attr('readonly', false);
        }
    });
});
