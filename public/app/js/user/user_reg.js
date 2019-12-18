// $('.datepicker').daterangepicker({
//     locale: {format: 'YYYY-MM-DD'},
//     showDropdowns: true,
//     singleDatePicker: true,
// });

//validator plugin initialize

let options = ({
    formID: 'frmUserRegister',
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
        // last_name: {
        //     type: 'text',
        //     methods: 'required'
        // },
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
        password: {
            type: 'password',
            methods: 'required|password',
            passwordConfirmID: 'passwordConf'
        },
        profile_img: {
            type: 'file',
            methods: 'required'
        },
        role_id: {
            type: 'text',
            methods: 'required'
        },
    },
});


let v = validator(options);
v.init();


$('#frmUserRegister').submit(function (e) {
    e.preventDefault();

    let btSave = $('#bt_submit');
    var formData = new FormData(this);

    if (v.status()) {//form validated OK!
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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

var timeout1;
var timeout2;
//check email exists
$('#email').on('focus click keyup', function () {

    let email = $(this).val();


        if (timeout1) {
            clearTimeout(timeout1);
            timeout1 = null;
        }

   timeout1 = setTimeout(function (){checkUserDataAjax({email: email, id: '#email'})}, 500);

});

//check nic exists
$('#nic').on('focus click keyup', function () {

    let nic = $(this).val();

    if (timeout2) {
        clearTimeout(timeout2);
        timeout2 = null;
    }


    timeout2 = setTimeout(function(){ checkUserDataAjax({nic: nic, id: '#nic'}) }, 500);


});

function checkUserDataAjax(data) {
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "checkUserData",
        type: 'post',
        data: data,
        beforeSend: function () {

        },
        success: function (data, textStatus, xhr) {

            let id = data['id'];
            if (data['result'] === true) {

                let msg = "";
                if (data['type'] === 'email') {
                    msg = "Email Already Exists";
                } else if (data['type'] === 'nic') {
                    msg = "NIC Already Exists";
                }

                $(id).removeClass('is-valid').addClass('is-invalid');
                $(id).parent().find('span').removeClass('valid-feedback').addClass('invalid-feedback-polyfill').html(msg);

            }
        },
        error: function (data, textStatus, xhr) {
            notify.serverError()
        },
    });
}
