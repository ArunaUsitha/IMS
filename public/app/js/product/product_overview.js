let dTable = $('#tblProdcutOverview').dataTable($.extend(true, {}, {
    "ajax": {
        "url": "getAllProductsNCategories",
        "type": 'get',
        "data": function (d) {
        },
        dataSrc: ""
    },
    columns: [
        {data: ['code']},
        {data: ['custom_code']},
        {data: ['name']},
        {
            "data": null,
            "render": function (data, type, full, meta) {

                return data['product_category']['name']


            }
        },
        {
            "data": null,
            "render": function (data, type, full, meta) {

                return data['brand']['name']


            }
        },
        {data: ['model_no']},
        {
            "data": null,
            "render": function (data, type, full, meta) {


                if (data['status'] === 1) {
                    return getSetStatusButton(true, 'setProductStatus', 'setProductStatus', data['id'],auth.can('modify_product'));
                } else {
                    return getSetStatusButton(false, 'setProductStatus', 'setProductStatus', data['id'],auth.can('modify_product'));
                }


            }
        },
        {data: ['created_at']},
        {
            "data": null,
            "render": function (data, type, full, meta) {
                let c = '';
                let productID = data['id'];

                if (auth.can('view_products')) {
                c += '<a target="_blank" href="showProductHistory?id=' + productID + '"\n' +
                    '                                                                    class="btn btn-icon text-success btn-sm"\n' +
                    '                                                                    data-toggle="tooltip" data-placement="top" title=""\n' +
                    '                                                                    data-original-title="Advance View"><i\n' +
                    '                                                                    class="fas fa-search-plus"></i></a>'
                }

                if (auth.can('modify_product')) {
                c += '<button type="button" value="' + productID + '"\n' +
                    '                                                                    class="btn btn-icon text-info btn-sm btnQuickEdit"\n' +
                    '                                                                    data-toggle="tooltip" data-placement="top"\n' +
                    '                                                                    title=""\n' +
                    '                                                                    data-original-title="Set Default Price"><i\n' +
                    '                                                                    class="fas fa-dollar-sign"></i>\n' +
                    '                                                        </button>'
                }


                return c;


            }
        },

    ]
}, DtableDefaultSetting));


$('#dTableSearchBox').keyup(function () {
    dTable.api().search($(this).val()).draw();
});

function getSetStatusButton(isActive, id, name, value,disabled = false) {

    let isdisabled = disabled ?  '' : 'disabled';

    let c = '' +
        '                                <label class="custom-switch mt-2 custom-switch-no-padding ">';

    if (isActive) {
        c += ` <input ${isdisabled} type="checkbox" value="${value}"  name="${name}" id="${id}" class="custom-switch-input btnSetProductStatus" checked>`;
    } else {
        c += ` <input ${isdisabled} type="checkbox" value="${value}"  name="${name}" id="${id}" class="custom-switch-input btnSetProductStatus">`;
    }


    c += '                                    <span class="custom-switch-indicator"></span>\n' +
        '                                </label>\n';

    return c;

}


$(document).on('change', '.btnSetProductStatus', function () {

    let productID = $(this).val();
    let checked = $(this).prop("checked");
    let status = 0;

    if (checked === true) {
        status = 1;
    }

    $.ajax({
        headers: CSRF,
        url: "setProductStatus",
        type: 'post',
        data: {
            "id": productID,
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


$(document).on('click', '.btnQuickEdit', function () {

    let btQuickEdit = $(this);
    let product_id = btQuickEdit.val();
    let purchased_product_sell_prices = $('#purchased_product_sell_prices')
    let mdProdcutId = $('#mdProdcutId')

    $.ajax({
        headers: CSRF,
        url: "getPurchasedPricesByProductID",
        type: 'get',
        data: {
            "product_id": product_id,
        },

        beforeSend: function () {
            spinButton.start(btQuickEdit, 'bar');
        },

        success: function (data, textStatus, xhr) {

            let c = '<ul>'


            if (data && data.length > 0) {

                $.each(data, function (index, value) {
                    c += '<li>' + 'purchased on : ' + value.created_at + ' | ' + 'sell price : ' + value.sell_price + '</li>';
                });

            }
            c += '</ul>'

            mdProdcutId.val(product_id)
            purchased_product_sell_prices.empty().append(c);


            spinButton.stop(btQuickEdit, 'bar');
            v.resetForm()
            $('#mdSetPricing').modal('show');

        },
        error: function (data, textStatus, xhr) {
            notify.serverError();
            spinButton.stop(btQuickEdit, 'bar');
        },

    });

})


//validator plugin initialize

let options = ({
    formID: 'mdUpdateDefaultPrice',
    animate: true,
    validate: {
        default_sell_price: {
            type: 'text',
            methods: 'required|number'
        },

    },
});


let v = validator(options);
v.init();


$('#mdUpdateDefaultPrice').submit(function (e) {
    e.preventDefault();
    let btSave = $('#mdBtUpdateUser');

    if (v.status()) {

        $.ajax({
            headers: CSRF,
            url: "updateProductDefaultPrice",
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
                    v.resetForm()
                }




            },
            error: function (data, textStatus, xhr) {

                notify.serverError();
                spinButton.stop(btSave);

            },

        });

    }
});






