$('#prixZero').css('display', 'none');
$(function() {
    $('#checkCgv').click(function() {
        if ($('#checkCgv:checked').length > 0) {
            $('#prixZero').css('display', 'block')
        } else {
            $('#prixZero').css('display', 'none')
        }
    });
});
