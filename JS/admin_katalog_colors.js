$(document).ready(function() {
    var table = $('#colorsTable').DataTable( {

    } );

    $('#colorsTable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

} );

function setIdToHref(selId)
{
    document.getElementById("hrefToEdit").href = "?action=katalog&sel=colors&edit_id=" + selId;
}