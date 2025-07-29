$(window).on('load', function () {
    var $grid = $('.galerie').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows'
    });

    $('.galerie-categories-buttons').on('click', 'a', function (e) {
        e.preventDefault();

        var filterValue = $(this).attr('data-filter');
        $grid.isotope({ filter: filterValue });

        $('.galerie-categories-buttons a').removeClass('active');
        $(this).addClass('active');
    });
});

$(document).ready(function () {
    $('.btn-like, .btn-dislike').on('click', function () {
        const isLike = $(this).hasClass('btn-like');
        const id = $(this).data('id');
        const button = $(this);

        $.post('/imagini/like_dislike.php', {
            id: id,
            action: isLike ? 'like' : 'dislike'
        }, function (data) {
            const result = JSON.parse(data);
            button.closest('.card-footer').find('.like-count').text(result.likes);
            button.closest('.card-footer').find('.dislike-count').text(result.dislikes);
        });
    });
});






