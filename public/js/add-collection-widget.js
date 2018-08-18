/*
 *
 */
var fileCount = $('#filesBox').children().length;
var removeButton = "<button type='button' class='btn btn-danger btn-xs' onclick='removeFile($(this));'>remove</button>";

/*
 * Delete the current line of added files.
 */
function removeFile(ob)
{
    ob.parent().parent().remove();
}

/*
 * Grab the prototype template and replace the "__name__" by the fileCount.
 * Once the file is added, create another instance of the "add file" button.
 * Currently add another line even if you edit a selected image.
 */
function createAddFile(fileCount)
{

    var newWidget = $("#filesProto").attr('data-prototype');
    newWidget = newWidget.replace(/__name__/g, fileCount);

    $("#filesBox").append("<div class='row'>" + "<div class='col-md-1'>" + removeButton + "</div><div class='col-md-10'>" + newWidget + "</div></div>");

    $('#figure_images_' + fileCount).on('change', function() {
        createAddFile(parseInt(fileCount)+1);
    });
}

$(document).ready(function(){
    createAddFile(fileCount);
    fileCount++;
});