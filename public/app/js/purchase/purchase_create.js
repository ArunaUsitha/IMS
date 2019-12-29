let model = $('#mdAddPurchaseItem');
let modelbtAdd = $('#mdBtAddProductToList');

let grnData = {
    supplierID: 0,
    supplierName: null,
    invoiceNo: null,
    productsInfo: {},

    setSupplierID: function (supplierID, supplierName) {
        this.supplierID = supplierID;
        this.supplierName = supplierName;
    },

    setProductsInfo: function ({itemID, itemName, quantity}) {

        this.productsInfo
            [itemID] = {
            itemID: itemID,
            itemName: itemName,
            quantity: quantity,
        };
    },
    updateProductsInfo: function ({itemID, quantity}) {
        this.productsInfo[itemID].quantity = parseFloat(quantity);

    },

    clearGrnData: function () {
        this.supplierID = 0;
        this.productsInfo = {};
    }
};

$(document).ready(function () {
    let wizard = $('#smartwizard').smartWizard({
        'theme': 'arrows'
    });


    let optionsSelectSupplier = ({
        formID: 'selectDiv',
        animate: true,
        validate: {
            supplier: {
                type: 'text',
                methods: 'required'
            },
        },
    });


    let x = validator(optionsSelectSupplier);
    x.init();


    wizard.on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {


        if (stepNumber === 0) {
            return x.status();
        }

        if (stepNumber === 1 && stepDirection === 'forward') {
            if (Object.keys(grnData.productsInfo).length === 0) {
                notify.error('Please add products to continue!');
                return false
            } else {

                //last form

                showFullPurhcaseOrder()


            }
        }

    });


    function showFullPurhcaseOrder() {
        let supplierAddress = $('#address');
        let purchaseCode = '# ';

        let addressPO = $('#addressPO');
        let PONo = $('#PONo');
        let tbodyPO = $('#tbodyPO');
        let supplierNamePO = $('#supplierNamePO');

        let supplierName = grnData.supplierName;


        $.ajax({
            headers: CSRF,
            url: base_url + '/purchase/getNewPurchaseOrderCode',
            type: 'get',
            cache: false,
            success: function (data, textStatus, xhr) {
                grnData.invoiceNo = data;
                purchaseCode += data;


                addressPO.html(supplierAddress.html().split(",").join("<br />"));
                PONo.html(purchaseCode);

                supplierNamePO.html(supplierName);

                let c = '';

                $.each(grnData.productsInfo, function (k, v) {
                    c += ' <tr>\n' +
                        '                                                            <td>' + v['itemID'] + '</td>\n' +
                        '                                                            <td>' + v['itemName'] + '</td>\n' +
                        '                                                            <td>' + v['quantity'] + '</td>\n' +
                        '                                                        </tr>';

                });

                tbodyPO.empty().append(c);


            },
        });


    }


    //item search
    $('#mdSlctItems').select2({
        closeOnSelect: true,
        allowHtml: true,
        createSearchChoice: false,
        allowClear: true,
        minimumResultsForSearch: -1,
        tags: false,
        ajax: {
            url: base_url + '/product/searchProducts',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name: params.term, // search term

                };
            },


            processResults: function (data, params) {
                // let res = (data.results);
                return {
                    results: $.map(JSON.parse(data.results), function (item) {
                        return {
                            id: item.id,
                            text: item.name
                        };
                    })
                };
            },
        },
        cache: false,
        placeholder: 'Search for a Product',
        minimumInputLength: 2,
    });


    //save purchase order
    $(document).on('click', '#btSavePurchaseOrder', function () {
        let btSave = $(this);

        $.ajax({
            headers: CSRF,
            url: "savePurchaseOrder",
            type: 'post',
            cache: false,
            data: {
                supplierID: grnData.supplierID,
                order_code: grnData.invoiceNo,
                prodcutInfo: grnData.productsInfo

            },

            beforeSend: function () {
                spinButton.start(btSave);

            },
            success: function (data, textStatus, xhr) {
                spinButton.stop(btSave);

                if (!data['status']) {
                    notify.error(data['message'])
                } else {
                    notify.success(data['message']);

                    $(wizard).smartWizard("reset");
                    resetWizard();
                }

            },

            statusCode: { // laravel server side validations
                500: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    notify.serverError()
                }
            }
        });
    });


});


$(document).on('change', '#supplier', function () {

    let supplierID = $(this).val();
    let supplierName = $("#supplier option:selected").text();


    let companyName = $('#companyName');
    let email = $('#email');
    let address = $('#address');
    let fixed = $('#fixed');
    let mobile = $('#mobile');


    function empty() {
        companyName.html('');
        email.html('');
        address.html('');
        fixed.html('');
        mobile.html('');
    }


    $.ajax({
        headers: CSRF,
        url: base_url + '/supplier/show',
        type: 'get',
        data: {
            'id': supplierID
        },
        cache: false,
        success: function (data, textStatus, xhr) {
            if (data['status']) {

                if (data['data'] !== null) {


                    companyName.html(data['data']['company_name']);
                    email.html(data['data']['email']);
                    address.html(data['data']['address']);
                    fixed.html(data['data']['fixed']);
                    mobile.html(data['data']['mobile']);
                } else {
                    empty();
                }


            } else {
                empty();
                notify.serverError()
            }
        },
        error: function () {
            notify.serverError()
        }
    });

    grnData.setSupplierID(supplierID, supplierName)


});


$(document).on('click', '#btnAddProduct', function () {
    model.modal('show')
});


let mdAddProductsOptions = ({
    formID: 'mdFrmAddProduct',
    animate: true,
    validate: {
        mdSlctItems: {
            type: 'text',
            methods: 'required'
        },
        mdQuantity: {
            type: 'number',
            methods: 'required'
        }
    },
});


let v = validator(mdAddProductsOptions);
v.init();


$('#mdFrmAddProduct').submit(function (e) {
    e.preventDefault();

    let mdBtAddProducts = $('#mdBtAddProductToList');
    let btSave = $('#bt_submit');
    let tbodyPurchaseOrder = $('#tbodyPurchaseOrder');


    if (v.status()) {
        let slctItems = $('#mdSlctItems');

        slctItems.prop("disabled", false);

        let values = $(this).serializeObject();


        let itemName = $("#mdSlctItems option:selected").text();
        let itemID = values['mdSlctItems'];
        let quantity = values['mdQuantity'];


        if (mdBtAddProducts.val() === 'Update') {
            let tr = 'tr-' + itemID;
            let tableRow = tbodyPurchaseOrder.find('#' + tr);
            tableRow.find('#tdMdQuantity-' + itemID).html(quantity);

            grnData.updateProductsInfo({itemID, quantity});


        } else {

            if (grnData.productsInfo[itemID]) {
                notify.error('Item Already added to the list');
            } else {


                let c = '';

                c += '<tr id="tr-' + itemID + '">' +
                    '<td id="tdItemID-' + itemID + '">' + itemID + '</td>' +
                    '<td id="tdItemName-' + itemID + '">' + itemName + '</td>' +
                    '<td id="tdMdQuantity-' + itemID + '">' + quantity + '</td>' +
                    '<td><button type="button" value="' + itemID + '"\n' +
                    '                                                                    class="btn btn-icon text-info btn-sm btnTblQuickEdit"\n' +
                    '                                                                    data-toggle="tooltip" data-placement="top"\n' +
                    '                                                                    title=""\n' +
                    '                                                                    data-original-title="Quick Edit"><i\n' +
                    '                                                                    class="fas fa-edit"></i>\n' +
                    '                                                        </button>' +
                    '<button type="button" value="' + itemID + '"\n' +
                    '                                                                    class="btn btn-icon text-danger btn-sm btnTblRemoveRow"\n' +
                    '                                                                    data-toggle="tooltip" data-placement="top"\n' +
                    '                                                                    title=""\n' +
                    '                                                                    data-original-title="Quick Edit"><i\n' +
                    '                                                                    class="fas fa-trash"></i>\n' +
                    '                                                        </button>' +

                    '</td>' +
                    '</tr>';

                tbodyPurchaseOrder.append(c);

                grnData.setProductsInfo({itemID, itemName, quantity});


                v.resetForm();

                slctItems.select2('focus');
            }


        }


    }

});


//remove table rows
$(document).on('click', '.btnTblRemoveRow', function () {
    let s = $(this).closest('tr').remove();
    let productID = $(this).val();

    delete grnData.productsInfo[productID];


});


//edit items
$(document).on('click', '.btnTblQuickEdit', function () {
    let tr = $(this).closest('tr');
    let itemID = $(this).val();

    let itemName = grnData.productsInfo[itemID]['itemName'];
    let quantity = grnData.productsInfo[itemID]['quantity'];

    // $('#slctItems').select2('data', {id: itemID, text: itemName}).change();
    let slctItems = $("#mdSlctItems");

    slctItems.select2("trigger", "select", {
        data: {id: itemID, text: itemName},
    });
    slctItems.prop("disabled", true);


    $('#mdQuantity').val(quantity);

    formSetStatus('update');

    model.modal('show');


});


function formSetStatus(status) {
    let button = $('#mdBtAddProductToList');

    if (status === 'add') {
        button.html('Add');
        button.val('Add');
    } else if (status === 'update') {
        button.html('Update');
        button.val('Update');
    }
}

$(document).on('click', '#btnPrint', function () {
    printElem('toPrint');
});


function resetWizard() {
    $('#tbodyPurchaseOrder').empty();

    $('#addressPO').html('');
    $('#PONo').html('');
    $('#tbodyPO').empty();
    $('#supplierNamePO').html();

    $('#supplier').prop('selectedIndex', -1);

    $('#companyName').html('');
    $('#email').html('');
    $('#address').html('');
    $('#fixed').html('');
    $('#mobile').html('');
}
