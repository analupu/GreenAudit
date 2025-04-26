$(function() {
// init Isotope
    var $grid = $('.articles').isotope({
        itemSelector: '.article',
        layoutMode: 'fitRows',
        fitRows: {
            equalheight: true
        },
        masonry: {
            columnWidth: 40,
            isFitWidth: true
        }
    });
    // filter functions
    var filterFns = {
        // show if number is greater than 50
        numberGreaterThan50: function() {
            var number = $(this).find('.number').text();
            return parseInt( number, 10 ) > 50;
        },
        // show if name ends with -ium
        ium: function() {
            var name = $(this).find('.name').text();
            return name.match( /ium$/ );
        }
    };
    // bind filter button click
    $('.articles-categories-buttons').on( 'click', 'a', function(e) {
        e.preventDefault();
        var filterValue = $( this ).attr('data-filter');
        // use filterFn if matches value
        filterValue = filterFns[ filterValue ] || filterValue;
        $grid.isotope({ filter: filterValue });
    });
    // change is-checked class on buttons
    $('.articles-categories-buttons').each( function( i, button ) {
        var $button = $( button );
        $button.on( 'click', 'li a', function() {
            $button.find('li a').removeClass('active');
            $( this ).addClass('active');
        });
    });

});