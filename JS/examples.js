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