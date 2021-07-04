let options = ({
    formID: 'frmCreateProduct',
    animate: true,
    validate: {
        product_code: {
            type: 'text',
            methods: 'required'
        },
        c_product_code: {
            type: 'text',
            methods: 'required'
        },
        product_name: {
            type: 'text',
            methods: 'required'
        },
        p_category_id: {
            type: 'text',
            methods: 'required'
        },
        brand_id: {
            type: 'text',
            methods: 'required'
        },

        reorder_point: {
            type: 'number',
            methods: 'required|number'
        },

        reorder_quantity: {
            type: 'number',
            methods: 'required|number'
        },

    },
});


let v = validator(options);
v.init();


$('#frmCreateProduct').submit(function (e) {
    e.preventDefault();

    let btSave = $('#bt_submit');
    var formData = new FormData(this);

    if (v.status()) {//form validated OK!
        $.ajax({
            headers: CSRF,
            url: "storeProduct",
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
                    notify.error(data['message']);
                } else {
                    notify.success(data['message']);
                    v.resetForm();
                    $('#MdChkProdcutStatus').val(1)
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
                    notify.serverError()
                }
            }
        });
    }

});


//rest form for clear button
$('#clearForm').on('click', function () {
    v.resetForm();
});

//-----------------------------------------------------------------------------------------------
//Model create brand
let optionsFrmAddBrand = ({
    formID: 'mdFrmAddBrand',
    animate: true,
    validate: {
        brand_name: {
            type: 'text',
            methods: 'required'
        },
    },
});


let w = validator(optionsFrmAddBrand);
w.init();


$('#mdFrmAddBrand').submit(function (e) {
    e.preventDefault();

    let btSave = $('#mdBtSaveBrand');
    var formData = new FormData(this);

    if (w.status()) {//form validated OK!
        $.ajax({
            headers: CSRF,
            url: "storeBrand",
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
                    notify.error(data['message']);
                } else {
                    notify.success(data['message']);

                    w.resetForm();
                }
                selectOptions.loadBrands();
            },

            statusCode: { // laravel server side validations
                422: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    if (data.responseJSON['errors']) {
                        w.setServerValidations(data.responseJSON['errors'])
                    }
                },
                500: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    notify.serverError()
                },
                404: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    notify.serverError()
                }
            }
        });
    }

});


//rest form for clear button
$('#clearFormMdCreateBrand').on('click', function () {
    w.resetForm();
});


//--------------------------------------------------------------------------------------------
// model create category

let optionsFrmAddCategory = ({
    formID: 'mdFrmAddCategory',
    animate: true,
    validate: {
        category_name: {
            type: 'text',
            methods: 'required'
        },
    },
});


let x = validator(optionsFrmAddCategory);
x.init();


$('#mdFrmAddCategory').submit(function (e) {
    e.preventDefault();

    let btSave = $('#mdBtCreateCategory');
    var formData = new FormData(this);

    if (x.status()) {//form validated OK!
        $.ajax({
            headers: CSRF,
            url: "storeCategory",
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
                    notify.error(data['message']);
                } else {
                    notify.success(data['message']);

                    x.resetForm();
                }

                selectOptions.loadCategories();
            },

            statusCode: { // laravel server side validations
                422: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    if (data.responseJSON['errors']) {
                        x.setServerValidations(data.responseJSON['errors'])
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

//rest form for clear button
$('#clearFormMdCreateCategory').on('click', function () {
    x.resetForm();
});

//------------------------------------------------------------------
let selectOptions = {

    sendRequest: function (selectObject, ajaxURL) {

        $.ajax({
            headers: CSRF,
            url: ajaxURL,
            type: 'get',
            cache: false,
            success: function (data, textStatus, xhr) {

                selectObject.empty().append('<option value="-1">Select Option</option>');

                $.each(data, function (k, brand) {
                    selectObject.append('<option value="' + brand['id'] + '">' + brand['name'] + '</option>')
                })
            },
            error: function () {
                selectObject.empty().append('<option value="-1">Select Option</option>');
            }
        });
    },

    loadBrands: function () {
        selectOptions.sendRequest($('#brand_id'), 'getAllBrands')
    },

    loadCategories: function () {
        selectOptions.sendRequest($('#p_category_id'), 'getAllPoductCategories')
    }
};

selectOptions.loadBrands();
selectOptions.loadCategories();


//get new product code
function getNewProductCode() {
    let btRefresh = $('#btnGetNewProductCode');
    $.ajax({
        headers: CSRF,
        url: 'getNewProductCode',
        type: 'get',
        cache: false,

        beforeSend: function () {
            spinButton.start(btRefresh);

        },

        success: function (code, textStatus, xhr) {
            $('#product_code').val(code).change();
            spinButton.stop(btRefresh)
        },
        error: function () {
            spinButton.stop(btRefresh)
        }
    });
}


// getNewProductCode()

$(document).on('click', '#btnGetNewProductCode', function () {
    getNewProductCode();

});

