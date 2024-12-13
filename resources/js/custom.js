document.addEventListener('DOMContentLoaded', function () {  
    const currencyInputs = document.querySelectorAll('input[id="jml_setoran"], input[id="jml_setoran_baru"]');  

    currencyInputs.forEach(input => {  
        input.addEventListener('input', function (e) {  
            // Hapus karakter non-digit  
            let value = input.value.replace(/[^0-9]/g, '');  
            // Format sebagai mata uang  
            value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value / 100);  
            input.value = value;  
        });  
    });  
});