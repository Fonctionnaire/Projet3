// CONFIGURATION DU DATEPICKER

$.datepicker.regional['fr'] = {
    closeText: 'Fermer',
    prevText: 'Précédent',
    nextText: 'Suivant',
    currentText: 'Aujourd\'hui',
    monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
    monthNamesShort: ['Janv.','Févr.','Mars','Avril','Mai','Juin','Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
    dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
    dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
    dayNamesMin: ['D','L','M','M','J','V','S'],
    weekHeader: 'Sem.',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''};

$.datepicker.setDefaults($.datepicker.regional['fr']);

// ON DESACTIVE LA SELECTION DES MARDI, DU 1er MAI, 1er NOVEMBRE ET 25 DECEMBRE
function disableDayAndDates(date) {

    var m = date.getMonth();
    var d = date.getDay();
    var currDate = date.getDate();
    var heure   = ('0'+now.getHours()  ).slice(-2);
    if (d == 2) {

        return [false] ;

    }else if (currDate == 1 && (m == 10 || m == 4)){
        return [false];
    }else if (currDate == 25 && m == 11){
        return [false];
    }
    else if (currDate && heure >= 18)
    {
        return [false];
    }
    else {

        return [true] ;
    }

}

var now = new Date();
var annee   = now.getFullYear();
var mois    = ('0'+(now.getMonth() + 1 )).slice(-2);
var jour    = ('0'+now.getDate()   ).slice(-2);
var heure   = ('0'+now.getHours()  ).slice(-2);

var jourActuel = jour + "/" + mois + "/" + annee;

var ticketOptionDelete = $(".typeTicket option[value='1']");
var formSelect = $(".typeTicket option[value='0']");

$(function() {

    $( ".datepicker").datepicker({
        minDate: 0,
        changeMonth: true,
        changeYear: true,
        beforeShowDay: disableDayAndDates,
        // ON RECUP LA DATE CHOISIE POUR ENLEVER LA JOUR. COMPL. SI = JOUR MEME et 14h +
        onSelect: function(dateText, inst){
            $('#date').val(dateText);

            if (dateText == jourActuel && heure >= 14 && heure < 24){
                ticketOptionDelete.detach();
                console.log(dateText);
            }else{
                ticketOptionDelete.insertBefore(formSelect);
                console.log(dateText);
            }
        }
    });
});