let options = ({
    formID: 'frmSupplierRegister',
    animate: true,
    validate: {
        supplier_name: {
            type: 'text',
            methods: 'required'
        },
        company_name: {
            type: 'text',
            methods: 'required'
        },
        Address: {
            type: 'text',
            methods: 'required'
        },
        mobile: {
            type: 'text',
            methods: 'required|telephone'
        },

        fixed_line: {
            type: 'text',
            methods: 'required|telephone'
        },
        email: {
            type: 'text',
            methods: 'required|email'
        }
    },
});


let v = validator(options);
v.init();


$('#frmSupplierRegister').submit(function (e) {
    e.preventDefault();

    let btSave = $('#bt_submit');
    var formData = new FormData(this);

    if (v.status()) {//form validated OK!
        $.ajax({
            headers: CSRF,
            url: "store",
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

                    v.resetForm();
                }
            },
            error: function (data, textStatus, xhr) {
                spinButton.stop(btSave);
                iziToast.error({
                    title: 'Oops!',
                    message: 'Unable to establish a conntection with the server!',
                    position: 'topRight',
                    timeout: 5000,
                });
            },
            statusCode: { // laravel server side validations
                422: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    if (data.responseJSON['errors']) {
                        v.setServerValidations(data.responseJSON['errors'])
                    }
                }
            }
        });
    }

});


//rest form for clear button
$('#clearForm').on('click', function () {
    v.resetForm();
});
