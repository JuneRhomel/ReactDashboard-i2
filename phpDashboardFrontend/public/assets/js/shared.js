const update_status = (table, id, field, status, WEB_ROOT, email = '') => {
    console.log(table)
    $.ajax({
        url: WEB_ROOT + "/update-status.php",
        type: 'POST',
        data: {
            table: table,
            id: id,
            field: field,
            status: status,
            email: email
        },
        dataType: 'JSON',
        success: function (data) {

            popup({
                data: data,
                reload_time: 2000,
                redirect: location.href
            })
        },
    });
}


