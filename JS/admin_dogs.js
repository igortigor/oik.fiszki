$(document).ready(function() {
    /*
    var table = $('#dogsListTable').DataTable( {
        initComplete: function () {
            this.api().columns([1]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
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
*/
if(document.getElementById("dogsListTable")){
    var table = $('#dogsListTable').DataTable();
}


// #myInput is a <input type="text"> element

    $('#dog_id_col').on( 'keyup', function () {
        table
            .columns( 0 )
            .search( this.value )
            .draw();
    } );

    $('#rasa_id_col').on( 'keyup', function () {
        table
            .columns( 1 )
            .search( this.value )
            .draw();
    } );
    
    
     $('#owner_id_col').on( 'keyup', function () {
        table
            .columns( 2 )
            .search( this.value )
            .draw();
    } );
    
    $('#nazwa_col').on( 'keyup', function () {
        table
            .columns( 3 )
            .search( this.value )
            .draw();
    } );
    
    $('#birthday_col').on( 'keyup', function () {
        table
            .columns( 4 )
            .search( this.value )
            .draw();
    } );
    
    $('#chip_col').on( 'keyup', function () {
        table
            .columns( 5 )
            .search( this.value )
            .draw();
    } );
    
    $('#hodowca_col').on( 'keyup', function () {
        table
            .columns( 6 )
            .search( this.value )
            .draw();
    } );   

    $('#sex_sel').on( 'change', function () {
        table
            .columns( 7 )
            .search( this.value )
            .draw();
    } );

    $('#confirm_sel').on( 'change', function () {
        table
            .columns( 8 )
            .search( this.value )
            .draw();
    } );
} );

function submit_show_dog(dog_id)
{
    var form = document.createElement('form');
    form.style.visibility = 'hidden';
    form.method = 'POST';
    form.action = '?action=dogs&dog_id=' + dog_id;

    document.body.appendChild(form);
    form.submit();
}

function showSelect()
{
    document.getElementById("confirmSelect").hidden = false;
}
