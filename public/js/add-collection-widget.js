var fileCount = $('#filesBox').children().length;
var videoCount = $('#videosBox').children().length;
var fileProto = "#filesProto";
var videoProto = "#videosProto";
var videoHtml = '#figure_videos_';
var removeButton = "<button type='button' class='btn btn-danger btn-xs' onclick='removeFile($(this));'>remove</button>";
var addVideoButton = "<button type='button' class='btn btn-success btn-xs' onclick='addVideo(videoCount);'>add other video</button>";

/*
 * Delete the current line of added files.
 */
function removeFile(ob)
{
    ob.parent().parent().remove();
}

$(document).ready(function(){
    jQuery('.add-another-collection-widget').click(function (e) {
        var list = jQuery(jQuery(this).attr('data-list'));
        // Try to find the counter of the list
        var counter = list.data('widget-counter') | list.children().length;
        // If the counter does not exist, use the length of the list
        if (!counter) {
            counter = list.children().length;
        }
        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data(' widget-counter', counter);

        // create a new list element and add it to the list
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });
});