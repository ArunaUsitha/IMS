let dTable = $('#tblCustomerOverview').dataTable($.extend(true, {}, {
    "ajax": {
        "url": "getAllCustomers",
        "type": 'get',
        "data": function (d) {
        },
        dataSrc: "customers"
    },
    columns: [
        {data: ['id']},
        {data: ['title']},
        {//name
            "data": null,
            "render": function (data, type, full, meta) {
                let last_name = (data['last_name']) !== null ? ". " +data['last_name'] : '';
                return data["initials"] + ". " + data["first_name"] + " " + last_name;
            }
        },
        {//gender
            "data": null,
            "render": function (data, type, full, meta) {
                switch (data['gender']) {
                    case 'f':
                        return 'Female';
                    case 'm':
                        return 'Male';
                }
            }
        },
        {data: ['mobile']},
        {//address
            "data": null,
            "render": function (data, type, full, meta) {
                return data["address_no"] + ", " + data["address_street"] + ", " + data['address_city'];
            }
        },
        {data: ['email']},
        {data: ['joined_date']},
        {
            "data": null,
            "render": function (data, type, full, meta) {


                if (data['status'] === 1) {
                    return getSetStatusButton(true, 'setProductStatus-'+data['id'], 'setProductStatus', data['id']);
                } else {
                    return getSetStatusButton(false, 'setProductStatus-'+data['id'], 'setProductStatus', data['id']);
                }


            }
        },

        {
            "data": null,
            "render": function (data, type, full, meta) {
                let c = '';
                let customerID = data['id'];

                // if (auth.can('read')) {
                //     c += '<button type="button" onclick="window.location= \'showCustomer?id=' + customerID + ' \'     "\n' +
                //         '                                                                    class="btn btn-icon text-success btn-sm"\n' +
                //         '                                                                    data-toggle="tooltip" data-placement="top" title=""\n' +
                //         '                                                                    data-original-title="Advance View"><i\n' +
                //         '                                                                    class="fas fa-search-plus"></i></button>'
                // }

                // if (auth.can('update')) {
                    c += '<button type="button" onclick="window.location= \'customerShowEdit?id=' + customerID + ' \'     " \n' +
                        '                                                                    class="btn btn-icon text-info btn-sm"\n' +
                        '                                                                    data-toggle="tooltip" data-placement="top"\n' +
                        '                                                                    title=""\n' +
                        '                                                                    data-original-title=" Edit"><i\n' +
                        '                                                                    class="fas fa-edit"></i>\n' +
                        '                                                        </button>'
                // }


                return c;


            }
        },

    ]
}, DtableDefaultSetting));


$('#dTableSearchBox').keyup(function () {
    dTable.api().search($(this).val()).draw();
});



function getSetStatusButton(isActive, id, name, value) {

    let c = '' +
        '                                <label class="custom-switch mt-2 custom-switch-no-padding ">';

    if (isActive) {
        c += ' <input type="checkbox" value="' + value + '"  name="' + name + '" id="' + id + '" class="custom-switch-input btnSetCustomerStatus" checked>';
    } else {
        c += ' <input type="checkbox" value="' + value + '"  name="' + name + '" id="' + id + '" class="custom-switch-input btnSetCustomerStatus">';
    }


    c += '                                    <span class="custom-switch-indicator"></span>\n' +
        '                                </label>\n';

    return c;

}


$(document).on('change', '.btnSetCustomerStatus', function () {

    let customerID = $(this).val();
    let checked = $(this).prop("checked");
    let status = 0;

    if (checked === true) {
        status = 1;
    }

    $.ajax({
        url: "setCustomerStatus",
        type: 'post',
        data: {
            "id": customerID,
            "status": status
        },

        success: function (data, textStatus, xhr) {

            if (!data['status']) {
                notify.error(data['message'])
            } else {
                notify.success(data['message'])
            }

            dTable.api().ajax.reload();

        },
        statusCode: { // laravel server side validations
            500: function (data, textStatus, xhr) {
                notify.serverError();
            }
        }

    });

});
