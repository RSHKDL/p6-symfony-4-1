$(document).ready(function() {
    var imagesHolder = $('.js-img-collection-fields-holder');
    var videosHolder = $('.js-vid-collection-fields-holder');

    imagesHolder.on('click', '.js-remove-collection-field', function (e) {
        $(this).closest('.js-collection-fields-item').remove();
    });

    imagesHolder.on('click', '.js-add-another-collection-field', function (e) {
        e.preventDefault();
        var prototype = imagesHolder.data('prototype');
        var index = imagesHolder.data('index');
        var newForm = prototype.replace(/__name__/g, index);
        imagesHolder.data('index', index + 1);
        $(this).before(newForm);
    });

    videosHolder.on('click', '.js-remove-collection-field', function (e) {
        $(this).closest('.js-collection-fields-item').remove();
    });

    videosHolder.on('click', '.js-add-another-collection-field', function (e) {
        e.preventDefault();
        var prototype = videosHolder.data('prototype');
        var index = videosHolder.data('index');
        var newForm = prototype.replace(/__name__/g, index);
        videosHolder.data('index', index + 1);
        $(this).before(newForm);
    });
});