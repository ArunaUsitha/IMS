let options = ({
    formID: 'frmUserUpdate',
    animate: true,
    validate: {
        title: {
            type: 'text',
            methods: 'required'
        },
        initials: {
            type: 'text',
            methods: 'required'
        },
        initials_full: {
            type: 'text',
            methods: 'required'
        },
        first_name: {
            type: 'text',
            methods: 'required'
        },
        last_name: {
            type: 'text',
            methods: 'required'
        },
        gender1: {
            type: 'radio',
            methods: 'required|date'
        },
        mobile: {
            type: 'text',
            methods: 'required|telephone'
        },
        address_no: {
            type: 'text',
            methods: 'required'
        },
        address_street: {
            type: 'text',
            methods: 'required'
        },
        address_city: {
            type: 'text',
            methods: 'required'
        }, birthday: {
            type: 'text',
            methods: 'required'

        },
        nic: {
            type: 'text',
            methods: 'required|length=10'
        },
        email: {
            type: 'text',
            methods: 'required|email'
        },

        role_id: {
            type: 'text',
            methods: 'required'
        },
    },
});


let v = validator(options);
// v.init();

$('#frmUserUpdate').submit(function (e) {
    e.preventDefault();

    let btSave = $('#bt_update');
    var formData = new FormData(this);

    // if (v.status()) {//form validated OK!
    $.ajax({
        headers: CSRF,
        url: "updateUser",
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function () {
            spinButton.start(btSave);

        },
        success: function (data, textStatus, xhr) {
            spinButton.stop(btSave);

            if (!data['status']) {
                iziToast.error({
                    title: 'Oops!',
                    message: data['message'],
                    position: 'topRight',
                    timeout: 10000,
                });
            } else {
                iziToast.success({
                    title: 'Yayy..!',
                    message: data['message'],
                    position: 'topRight',
                    timeout: 5000,
                });


            }
        },
        statusCode: { // laravel server side validations
            422: function (data, textStatus, xhr) {
                spinButton.stop(btSave);
                if (data.responseJSON['errors']) {
                    v.setServerValidations(data.responseJSON['errors'])
                }
            },
            500: function (data, textStatus, xhr) {
                spinButton.stop(btSave);
                iziToast.error({
                    title: 'Oops!',
                    message: 'Unable to establish a conntection with the server!',
                    position: 'topRight',
                    timeout: 10000,
                });
            }
        }
    });

});


$('#btnChangeProfile').on('click', function () {
    $('#mdChangePrfilePic').modal('show');
});


let optionsmdFrmChangeProfilePic = ({
    formID: 'mdFrmChangeProfilePic',
    animate: true,
    isModel: true,
    validate: {
        profile_img: {
            type: 'file',
            methods: 'required'
        },
    },
});


let ss = new validator(optionsmdFrmChangeProfilePic);

ss.init();


$('#mdFrmChangeProfilePic').submit(function (e) {
    e.preventDefault();

    let btSave = $('#mdBtUpdateUser');
    var formData = new FormData(this);


    if (ss.status()) {//form validated OK!
        $.ajax({
            headers: CSRF,
            url: "updatePic",
            type: 'post',
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            beforeSend: function () {
                spinButton.start(btSave);

            },
            success: function (data, textStatus, xhr) {
                spinButton.stop(btSave);

                if (!data['status']) {
                    iziToast.error({
                        title: 'Oops!',
                        message: data['message'],
                        position: 'topRight',
                        timeout: 10000,
                    });
                } else {
                    iziToast.success({
                        title: 'Yayy..!',
                        message: data['message'],
                        position: 'topRight',
                        timeout: 5000,
                    });

                    ss.resetForm();
                }
            },
            statusCode: { // laravel server side validations
                422: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    if (data.responseJSON['errors']) {
                        ss.setServerValidations(data.responseJSON['errors'])
                    }
                },
                500: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                   notify.serverError()
                }
            }
        });
    }

});


$('#btnChangePassword').on('click', function () {
    $('#mdChangePassword').modal('show');
});

let optionsmdFrmChangePassword = ({
    formID: 'mdFrmChangePassword',
    animate: true,
    isModel: true,
    validate: {
        password: {
            type: 'password',
            methods: 'required|password',
            passwordConfirmID: 'passwordConf'
        },
    },
});


let p = new validator(optionsmdFrmChangePassword);

p.init();


$('#mdFrmChangePassword').submit(function (e) {
    e.preventDefault();

    let btSave = $('#mdBtChangePass');
    var formData = new FormData(this);


    if (p.status()) {//form validated OK!
        $.ajax({
            headers: CSRF,
            url: "updatePass",
            type: 'post',
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            beforeSend: function () {
                spinButton.start(btSave);

            },
            success: function (data, textStatus, xhr) {
                spinButton.stop(btSave);

                if (!data['status']) {
                    iziToast.error({
                        title: 'Oops!',
                        message: data['message'],
                        position: 'topRight',
                        timeout: 10000,
                    });
                } else {
                    iziToast.success({
                        title: 'Yayy..!',
                        message: data['message'],
                        position: 'topRight',
                        timeout: 5000,
                    });

                    p.resetForm();
                }
            },
            statusCode: { // laravel server side validations
                422: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    if (data.responseJSON['errors']) {
                        p.setServerValidations(data.responseJSON['errors'])
                    }
                },
                500: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    notify.serverError();
                }
            }
        });
    }

});



//show password
$('#chkShowPass').on('change',function () {

    let x = document.getElementById("password");
    let y = document.getElementById("passwordConf");
    if (x.type && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
})
