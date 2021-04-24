let dTable = $('#tblRolesOverview').dataTable($.extend(true, {}, {
    "ajax": {
        "url": "getRoles",
        "type": 'get',
        "data": function (d) {
        },
        dataSrc: "data"
    },
    columns: [
        {data: ['id']},
        {data: ['role_name']},
        {data: ['permissions']},

        {
            "data": null,
            "render": function (data, type, full, meta) {
                let c = '';
                let roleID = data['id'];

                c += '<button type="button" value="' + roleID + '"\n' +
                    '                                                                    class="btn btn-icon text-info btn-sm " id="btnShowPermissons" \n' +
                    '                                                                    data-toggle="tooltip" data-placement="top"\n' +
                    '                                                                    title=""\n' +
                    '                                                                    data-original-title="Edit Permissions"><i\n' +
                    '                                                                    class="fas fa-edit"></i>\n' +
                    '                                                        </button>'

                c += '<button type="button" value="' + roleID + '"\n' +
                    '                                                                    class="btn btn-icon text-danger btn-sm " id="btnDeleteRole" \n' +
                    '                                                                    data-toggle="tooltip" data-placement="top"\n' +
                    '                                                                    title=""\n' +
                    '                                                                    data-original-title="Delete Role"><i\n' +
                    '                                                                    class="fas fa-trash"></i>\n' +
                    '                                                        </button>'


                return c;


            }
        },

    ]
}, DtableDefaultSetting));


$('#dTableSearchBox').keyup(function () {
    dTable.api().search($(this).val()).draw();
});


$(document).on('click', '#btnShowPermissons', (function () {

    let roleID = $(this).val();

    location.href = 'editRolePermissions/' + roleID

}))


$(document).on('click', '#btnSaveChanges', (function () {

    let btnSaveChanges = $(this);


    // frmUpdateRolePermissions
    $.ajax({
        headers: CSRF,
        url: "/settings/updateRolePermissions",
        type: 'post',
        data: {
            'role_id': $('#role_id').val(),
            'permissions': $('#frmUpdateRolePermissions').serialize(),
        },

        beforeSend: function () {
            spinButton.start(btnSaveChanges);
        },

        success: function (data, textStatus, xhr) {

            if (!data['status']) {
                notify.error(data['message'])
            } else {
                notify.success(data['message'])
            }


            spinButton.stop(btnSaveChanges);

        },
        error: function (data, textStatus, xhr) {
            notify.serverError();
            spinButton.stop(btnSaveChanges);
        },

    });

}))


$(document).on('click','#btnDeleteRole',(function (){

    let btnDeleteRole = $(this);

    $.ajax({
        headers: CSRF,
        url: "/settings/deleteRole",
        type: 'post',
        data: {
            'role_id': btnDeleteRole.val(),
        },

        beforeSend: function () {
            spinButton.start(btnDeleteRole,'bar');
        },

        success: function (data, textStatus, xhr) {

            if (!data['status']) {
                notify.error(data['message'])
            } else {
                notify.success(data['message'])
                dTable.api().ajax.reload();
            }


            spinButton.stop(btnDeleteRole,'bar');

        },
        error: function (data, textStatus, xhr) {
            notify.serverError();
            spinButton.stop(btnDeleteRole,'bar');
        },

    });
}));

