  let dTable =   $('#tblUserOverview').dataTable( $.extend( true, {},{
        "ajax": {
            "url": "getAllUsersNRoles",
            "type": 'get',
            "data": function (d) {
            },
            dataSrc: "users"
        },
        columns: [
            {data: ['id']},
            {data: ['first_name']},
            {
                "data": null,
                "render": function (data, type, full, meta) {
                    return data["address_no"] + ", " + data["address_street"] + ", " + data['address_city'];
                }
            },
            {data: ['mobile']},
            {data: ['DOB']},
            {data: ['NIC']},
            {data: ['email']},
            {
                "data": null,
                "render": function (data, type, full, meta) {

                    switch (data['status']) {
                        case 0:
                            return '<label class="badge badge-danger">Deactive</label>';
                        case 1:
                            return '<label class="badge badge-success">Active</label>';
                    }


                }
            },
            {
                "data": null,
                "render": function (data, type, full, meta) {
                    let c = '';
                    let userID = data['id'];

                    if (auth.can('view_users')) {
                        c += '<button type="button" onclick="window.location= \'showUser?id='+userID+' \'     "\n' +
                            '                                                                    class="btn btn-icon text-success btn-sm"\n' +
                            '                                                                    data-toggle="tooltip" data-placement="top" title=""\n' +
                            '                                                                    data-original-title="Advance View"><i\n' +
                            '                                                                    class="fas fa-search-plus"></i></button>'
                    }

                    if (auth.can('modify_user')) {
                        c += '<button type="button" value="' + userID + '"\n' +
                            '                                                                    class="btn btn-icon text-info btn-sm btnQuickEdit"\n' +
                            '                                                                    data-toggle="tooltip" data-placement="top"\n' +
                            '                                                                    title=""\n' +
                            '                                                                    data-original-title="Quick Edit"><i\n' +
                            '                                                                    class="fas fa-edit"></i>\n' +
                            '                                                        </button>'
                    }


                    return c;


                }
            },

        ]
    },DtableDefaultSetting));



$('#dTableSearchBox').keyup(function () {
    dTable.api().search($(this).val()).draw();
});


//Edit table
$(document).on('click', '.btnQuickEdit', (function () {
    let userID = ($(this).val());
    $('#mdUserID').val(userID);
    let MdChkUserStatus = $('#MdChkUserStatus');
    let MdSlctUserType = $('#MdSlctUserType');
    let mdUsername = $('#mdUsername');
    let btQuickEdit = $(this);
    let mdAdvRoute = $('#mdAdvRoute');
    mdAdvRoute.attr('href', mdAdvRoute.attr('href') + '?id=' + userID);


    $.ajax({
        headers: CSRF,
        url: "show",
        type: 'get',
        data: {
            "id": userID,
        },

        beforeSend: function () {
            spinButton.start(btQuickEdit, 'bar');
        },

        success: function (data, textStatus, xhr) {


            let userdata = data.data.userdata;

            if (Object.keys(data).length > 0) {
                //status
                if (data['status'] === true) {
                    if (userdata.status === 1) {
                        MdChkUserStatus.prop('checked', true).change()
                    } else if (userdata.status === 0) {
                        MdChkUserStatus.prop('checked', false).change()
                    }

                    //role id
                    MdSlctUserType.val(data.data.role).change();
                    $('#mdUserEdit').modal('show');

                    mdUsername.html(userdata.first_name)
                } else {
                    notify.unauthorized();
                }
            }

            spinButton.stop(btQuickEdit, 'bar');

        },
        error: function (data, textStatus, xhr) {
            notify.serverError();
            spinButton.stop(btQuickEdit, 'bar');
        },

    });
}));


$('#mdFrmUserQuickUpdate').submit(function (e) {
    e.preventDefault();
    let btSave = $('#mdBtUpdateUser');

    $.ajax({
        headers: CSRF,
        url: "updateQuick",
        type: 'post',
        data: $(this).serialize(),

        beforeSend: function () {
            spinButton.start(btSave);
        },
        success: function (data, textStatus, xhr) {

            spinButton.stop(btSave);

            if (!data['status']) {
                notify.error(data['message'])
            } else {
                notify.success(data['message'])
            }

            dTable.api().ajax.reload();

        },
        error: function (data, textStatus, xhr) {

            notify.serverError();
            spinButton.stop(btSave);

        },

    });
});


