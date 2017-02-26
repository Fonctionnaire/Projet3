// DISABLE SUR LE BOUTON STRIPE SI LA CHECKBOX CGV N'EST PAS CHECKED

document.getElementsByClassName("stripe-button-el")[0].disabled=true;

$(function() {
    $('#checkCgv').click(function() {
        if ($('#checkCgv:checked').length > 0) {

            document.getElementsByClassName("stripe-button-el")[0].disabled=false;
        } else {
            document.getElementsByClassName("stripe-button-el")[0].disabled=true;
        }
    });
});