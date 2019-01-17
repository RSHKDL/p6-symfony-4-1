jQuery(function($) {
    const button = $('.js-load-more');
    button.click(function () {
        let offset = button.data('offset');
        let length = button.data('length');
        let total = button.data('total');
        let data = {
            "offset":offset,
            "length":length
        };
        $.ajax({
            url: button.data('url'), // Symfony controller use this route
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend : function () {
                button.html('<span class="fas fa-spinner fa-spin" aria-hidden="true"></span> Loading...');
            },
            success: function (result) {
                if (result) {
                    $('.comments-container').append(result);
                    button.text('Load more comments');
                    button.data("offset", offset+length);
                    if ( offset+length >= total ) {
                        button.remove(); // if offset reach total, remove the button
                    }
                } else {
                    button.remove(); // if no data, remove the button
                }
            }
        });
    });
});