$(document).ready(function() {
	
    var table = $('#psyTable').DataTable( {
    	"ordering": false,
    	"dom": '<"top"i>rt<"bottom"flp><"clear">',
    	
     	
    	initComplete: function () {
            this.api().columns([3,7,8]).every( function () {
                var column = this;
                var select = $('<select><option value="">*</option></select>')
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
    
    
    //new $.fn.dataTable.Buttons( table, { buttons: ['copy', 'excel', 'pdf' ]} );
    
    
    
    $("#machineStatusTabel_length:first").hide();
    
    $('#psyTable_filter').hide();
    
    $('#nameSearch').on( 'keyup', function () {
        table
            .columns( 0 )
            .search( this.value )
            .draw();
    } );
    
    $('#emailSearch').on( 'keyup', function () {
        table
            .columns( 1 )
            .search( this.value )
            .draw();
    } );
        
    $('#birthSearch').on( 'keyup', function () {
        table
            .columns( 2 )
            .search( this.value )
            .draw();
    } );
    
    $('#rasaSearch').on( 'keyup', function () {
        table
            .columns( 4 )
            .search( this.value )
            .draw();
    } );
    
    $('#colorSearch').on( 'keyup', function () {
        table
            .columns( 5 )
            .search( this.value )
            .draw();
    } );
    
    $('#inDatetimeSearch').on( 'keyup', function () {
        table
            .columns( 6 )
            .search( this.value )
            .draw();
    } );
    

    

} );


function selectMemberDetails(showId, dogId)
{
	var form = document.createElement('form');
    form.style.visibility = 'hidden';
    form.method = 'POST';
    form.action = '?action=wystawy';

    input = document.createElement("input");
    input.value = showId;
    input.name = "show_id";

    form.appendChild(input);
    
    input = document.createElement("input");
    input.value = dogId;
    input.name = "info_member_id";

    form.appendChild(input);
    
    document.body.appendChild(form);
    form.submit();
}