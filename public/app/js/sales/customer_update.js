let options = ({
    formID: 'frmCustomerRegister',
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

        first_name: {
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
        }, email: {
            type: 'text',
            methods: 'email'

        }
    },
});


let v = validator(options);
v.init();


$('#frmCustomerRegister').submit(function (e) {
    e.preventDefault();

    let btSave = $('#bt_submit');
    var formData = new FormData(this);

    if (v.status()) {//form validated OK!
        $.ajax({
            url: "customerUpdate",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,

            beforeSend: function () {
                spinButton.start(btSave);

            },
            success: function (data, textStatus, xhr) {
                spinButton.stop(btSave);

                if (!data['status']) {
                    notify.error(data['message']);
                } else {
                    notify.success(data['message']);

                }
            },

            statusCode: { // laravel server side validations
                422: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    if (data.responseJSON['errors']) {
                        v.setServerValidations(data.responseJSON['errors'])
                    }
                },
                500 :function (data,textStatus,xhr) {
                    spinButton.stop(btSave);
                    notify.serverError()
                },
                404  :function (data,textStatus,xhr) {
                    spinButton.stop(btSave);
                    notify.serverError()
                }
            }
        });
    }

});


