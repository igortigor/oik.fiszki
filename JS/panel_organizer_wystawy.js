$(document).ready(function() {
	
    var table = $('#wystawyTable').DataTable( {
    	"ordering": false,
    	"dom": '<"top"i>rt<"bottom"flp><"clear">'
    } );
    
    $("#machineStatusTabel_length:first").hide();
    
    $('#wystawyTable_filter').hide();
    
    $('#nameSearch').on( 'keyup', function () {
        table
            .columns( 1 )
            .search( this.value )
            .draw();
    } );
    
    $('#citySearch').on( 'keyup', function () {
        table
            .columns( 2 )
            .search( this.value )
            .draw();
    } );
    
    $('#dataSearch').on( 'keyup', function () {
        table
            .columns( 3 )
            .search( this.value )
            .draw();
    } );
    
} );

function selectShow(showId)
{
    var form = document.createElement('form');
    form.style.visibility = 'hidden';
    form.method = 'POST';
    form.action = '?action=wystawy';

    input = document.createElement("input");
    input.value = showId;
    input.name = "show_id";

    form.appendChild(input);
    
    document.body.appendChild(form);
    form.submit();
}