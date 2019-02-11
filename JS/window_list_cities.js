$(document).ready(function() {
	
    var table = $('#citiesTable').DataTable( {
    	"ordering": false,
    	
        initComplete: function () {
            this.api().columns('.select-filter').every( function () {
                var column = this;
                var select = $('<select><option value="">WOJEWODSTWA-WSZYSTKIE</option></select>')
                    .appendTo( $(column.header()).empty() )
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
    
    $('#citiesTable_filter').hide();
    
     $('#citySearch').on( 'keyup', function () {
        table
            .columns( 0 )
            .search( this.value )
            .draw();
    } );

} );



/*
var table = $('#citiesTable').DataTable();
 
table.columns( '.select-filter' ).every( function () {
    var that = this;
 
    // Create the select list and search operation
    var select = $('<select />')
        .appendTo(
            this.footer()
        )
        .on( 'change', function () {
            that
                .search( $(this).val() )
                .draw();
        } );
 
    // Get the search data for the first column and add to the select list
    this
        .cache( 'search' )
        .sort()
        .unique()
        .each( function ( d ) {
            select.append( $('<option value="'+d+'">'+d+'</option>') );
        } );
} );
*/
function setIdToHref(selId)
{
    document.getElementById("hrefToEdit").href = "?action=katalog&sel=rasy&edit_id=" + selId;
}