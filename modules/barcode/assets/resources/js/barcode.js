
$(document).ready(function() {

    barcode.config.start = 0.1;
    barcode.config.end = 0.9;
    barcode.config.video = '#barcodevideo';
    barcode.config.canvas = '#barcodecanvas';
    barcode.config.canvasg = '#barcodecanvasg';
    barcode.setHandler(function(barcode) {
        $('#barcodes').prepend('<option value="' + barcode + '">' + barcode + '</option>');
        $('#barcodes option').last().remove();

        $.post('/barcode/default/save', {code: barcode});
    });
    barcode.init();

});