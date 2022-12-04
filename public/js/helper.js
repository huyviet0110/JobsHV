function formatDatetimeToDisplay(datetime){
    let date = new Date(datetime);

    return ("0" + date.getUTCDate()).slice(-2) + "/" +
        ("0" + (date.getUTCMonth()+1)).slice(-2) + "/" +
        date.getUTCFullYear() + " " +
        ("0" + date.getUTCHours()).slice(-2) + ":" +
        ("0" + date.getUTCMinutes()).slice(-2) + ":" +
        ("0" + date.getUTCSeconds()).slice(-2);
}

function renderPagination(links){
    links.forEach(function(each){
        let is_active = '';
        let url = '';
        is_active = (each.active) ? 'active' : '';

        $('#pagination').append($('<li>').attr('class', `page-item ${is_active}`)
            .append(`<a class="page-link"">${each.label}</a>`)
        );
    });
}

function notifySuccess(message = ''){
    $.toast({
        heading: 'Success',
        text: message,
        showHideTransition: 'slide',
        hideAfter: 5000,
        position: 'bottom-right',
        icon: 'success'
    });
}

function notifyError(message = ''){
    $.toast({
        heading: 'Error',
        text: message,
        showHideTransition: 'slide',
        hideAfter: 5000,
        position: 'bottom-right',
        icon: 'error'
    });
}
