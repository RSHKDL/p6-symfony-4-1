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
            url: $(this).data('url'), // Symfony controller will use this route
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend : function (xhr) {
                button.html('<span class="fas fa-spinner fa-spin" aria-hidden="true"></span> Loading...');
            },
            success: function (data) {
                if (data) {
                    data.batch.forEach(function(value) {
                        $('.comments-container').append("<div class='row mb-3'>"+
                            "<div class='col-sm-4'>"+
                            "<small class='text-muted'>#"+value.id+"</small> "+
                            value.author+
                            "<small class='text-muted'><i> "+value.date+"</i></small>"+
                            "</div>"+
                            "<div class='col-sm-8'>"+value.content+"</div>"+
                            "</div>"
                        );
                    });
                    button.text( 'Load more comments' ).prev().before(data).show();
                    button.data('offset', offset+5);

                    if ( offset >= total ) {
                        button.remove(); // if offset reach total, remove the button
                    }
                } else {
                    button.remove(); // if no data, remove the button
                }
            }
        });
    });
});