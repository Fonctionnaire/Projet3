$(document).ready(function() {

    var $container = $('div#appbundle_commande_tickets');

    var index = $container.find(':input').length;

    $('#add_ticket').click(function(e) {
        addTicket($container);

        e.preventDefault();
        return false;
    });


    if (index == 0 && index <= 30) {
        addTicket($container);
    } else {

        $container.children('div').each(function() {
            addDeleteLink($(this));
        });
    }


    function addTicket($container) {

        var template = $container.attr('data-prototype')
                .replace(/__name__label__/g,'<hr>' + 'Billet' )
                .replace(/__name__/g,        index)
            ;

        var $prototype = $(template);

        if (index >= 1){
            addDeleteLink($prototype);
        }


        $container.append($prototype);

        index++;
    }


    function addDeleteLink($prototype) {

        var $deleteLink = $('<a href="#" class=" suppr btn btn-danger">Supprimer</a>');

        $prototype.append($deleteLink);

        $deleteLink.click(function(e) {
            $prototype.remove();

            e.preventDefault();
            return false;
        });
    }
});
