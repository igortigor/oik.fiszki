$(document).ready(function() {
    var table = $('#rasyTable').DataTable( {
        initComplete: function () {
            this.api().columns([1]).every( function () {
                var column = this;
                var select = $('<select><option value="">Wszystkie grupy</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }

    } );

    $('#rasyTable tbody').on( 'click', 'tr', function () {
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
    document.getElementById("hrefToEdit").href = "?action=katalog&sel=rasy&edit_id=" + selId;
}