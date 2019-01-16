jQuery(function($) {
    $('.js-load-more').click(function () {
        const button = $(this);
        let total = $(this).data('total');
        let offset = $(this).data('offset');
        let data = {
            "offset":offset,
            "total":total
        };

        $.ajax({
            url: $(this).data('url'), // Symfony controller use this route
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend : function (xhr) {
                button.html('<span class="fas fa-spinner fa-spin" aria-hidden="true"></span> Loading...');
            },
            success: function (data) {
                if (data) {
                    console.log(data);
                    $('.comments-container').append(data);
                    button.text('Load more comments');
                    button.data('offset', offset+5);
                    if ( offset+5 >= total ) {
                        button.remove(); // if offset reach total, remove the button
                    }
                } else {
                    button.remove(); // if no data, remove the button
                }
            }
        });
    });
});