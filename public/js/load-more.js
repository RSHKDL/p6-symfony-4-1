jQuery(function($) {
    $('.js-load-more').click(function () {

        const button = $(this);
        let total = $(this).data('total');
        let offset = 0;
        let data = {};

        $.ajax({
            url: $(this).data('url'), // Symfony controller will use this route
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend : function (xhr) {
                button.html('<span class="fas fa-spinner fa-spin" aria-hidden="true"></span> Loading...');
            },
            success: function (data) {
                if (data) {
                    console.log(data);
                    let fig = data['figureTest'];
                    console.log(fig);
                    button.text( 'Load more comments' ).prev().before(data).show();

                    if ( offset === total ) {
                        button.remove(); // if offset reach total, remove the button
                    }

                } else {
                    button.remove(); // if no data, remove the button
                }
            }
        });
    });
});