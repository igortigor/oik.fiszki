$(document).ready(function() {
	
	//add input for each footer column
	$('#citiesTable tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
    
    
    
    var table = $('#citiesTable').DataTable( {
    	"ordering": false,
    	"columnDefs": [
    { "searchable": false, "targets": 2 }
  ],
  
  //Add select to each header (or may change to footer) column with class=select-filter
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
    
    
    //Hide main search input (citiesTable - table id)
    $('#citiesTable_filter').hide();


} );