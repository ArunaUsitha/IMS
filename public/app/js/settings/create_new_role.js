let options = ({
    formID: 'frmCreateNewRole',
    animate: true,
    validate: {
        role_name: {
            type: 'text',
            methods: 'required'
        },

    },
});


let v = validator(options);
v.init();


$(document).on('click', '#btnCrateNewRole', (function () {

    let btnSaveChanges = $(this);

    if (v.status()) {

        $.ajax({
            headers: CSRF,
            url: "/settings/createNewRole",
            type: 'post',
            data: {
                'role_name': $('#role_name').val(),
                'permissions': $('#frmCreateRolePermissions').serialize(),
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

    }

}))