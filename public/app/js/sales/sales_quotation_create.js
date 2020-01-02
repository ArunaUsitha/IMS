$(document).ready(function () {


//product search
    $('#slctItems').select2({
        ajax: {
            url: base_url + '/product/searchProductsForSale',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name: params.term, // search term
                };
            },
            processResults: function (data) {
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
        placeholder: 'Search Products',
    });


});


let salesOrder = {
    total: null,
    productsInfo: {},

    setProductsInfo: function (product_id, productCode, productName, price, warranty, quantity, total) {
        this.productsInfo
            [product_id] = {
            productID: product_id,
            productCode: productCode,
            productName: productName,
            warranty: warranty,
            price: price,
            quantity: quantity,
            total: total,
        };

        this.total += total
    },

    updateProductsInfo: function (product_id, price, warranty, quantity, total) {

        this.productsInfo[product_id].price = price;
        this.productsInfo[product_id].warranty = warranty;
        this.productsInfo[product_id].price = parseFloat(price);
        this.productsInfo[product_id].quantity = quantity;
        this.productsInfo[product_id].total = parseFloat(total);


    },

    removeProduct: function (product_id) {
        delete this.productsInfo[product_id];
        this.updateTotal()
    },

    getTotal: function () {
        this.updateTotal();
        return this.fullTotal
    },


    clear: function () {
        this.customerID = null;
        this.total = null;
        this.productsInfo = {}
    },

    updateTotal: function () {
        salesOrder.total = 0;
        $.each(this.productsInfo, function (k, v) {
            salesOrder.total += parseFloat(v.total);
        });
        $('#fullTotal').val(salesOrder.total);
    },
    getAllData: function () {
        return {
            total: this.total,
            productsInfo: this.productsInfo
        }
    }


};


let productInfoHandler = {
    btnAddProducts: $('#btnAddProduct'),
    btnPrintQuotation: $('#btPrintQuote'),
    btnPrint: $('#btPrint'),
    btnCheckout: $('#btCheckout'),
    btnClear: $('#btClear'),

    fullTotal: $('#fullTotal'),

    tbodyProducts: $('#tbodyProducts'),

    append: function (productID, productCode, productName, warrantyPeriod, price, quantity, total) {
        let c = '<tr id="tr-' + productID + '">\n' +
            '                                                    <td id="tdProductID-' + productID + '">' + productCode + '</td>\n' +
            '                                                    <td id="tdProductName-' + productID + '">' + productName + '</td>\n' +
            '                                                    <td id="tdWarranty-' + productID + '">' + warrantyPeriod + '</td>\n' +
            '                                                    <td id="tdBuyPrice-' + productID + '">' + price + '</td>\n' +
            '                                                    <td id="tdUnits-' + productID + '">' + quantity + '</td>\n' +
            '                                                    <td id="tdTotal-' + productID + '">' + total + '</td>\n' +

            '                                                    <td>' +
            '<button type="button" value="' + productID + '"\n' +
            '                                                                    class="btn btn-icon text-info btn-sm btnTblQuickEdit"\n' +
            '                                                                    data-toggle="tooltip" data-placement="top"\n' +
            '                                                                    title=""\n' +
            '                                                                    data-original-title="Quick Edit"><i\n' +
            '                                                                    class="fas fa-edit"></i>\n' +
            '                                                        </button>' +
            '<button type="button" value="' + productID + '"\n' +
            '                                                                    class="btn btn-icon text-danger btn-sm btnTblRemoveRow"\n' +
            '                                                                    data-toggle="tooltip" data-placement="top"\n' +
            '                                                                    title=""\n' +
            '                                                                    data-original-title="Quick Edit"><i\n' +
            '                                                                    class="fas fa-trash"></i>\n' +
            '                                                        </button>' +

            '</td>' +
            '                                                </tr>';

        this.tbodyProducts.append(c);
    },

    update: function (productID, productCode, productName, warrantyPeriod, price, quantity, total) {

        let tr = 'tr-' + productID;
        let tableRow = this.tbodyProducts.find('#' + tr);

        tableRow.find('#tdWarranty-' + productID).html(warrantyPeriod);
        tableRow.find('#tdSellPrice-' + productID).html(price);
        tableRow.find('#tdUnits-' + productID).html(quantity);
        tableRow.find('#tdTotal-' + productID).html(total);

        salesOrder.updateProductsInfo(productID, price, warrantyPeriod, quantity, total);
        salesOrder.updateTotal()
    },

    clear: function () {
        this.tbodyProducts.empty();
        $('#fullTotal').val(0)
    },

    setButtonStatus: function (option) {
        let btnAddProduct = $('#btnAddProduct');

        if (option === 'enable') {
            btnAddProduct.attr('disabled', false)
        } else {
            btnAddProduct.attr('disabled', true)
        }
    }
};


//model form
let mdAddItem = {
    model: $('#mdAddProduct'),
    button: $('#mdBtAddProducts'),
    //inputs
    slctItems: $("#slctItems"),
    mdQuantity: $("#mdQuantity"),
    mdProductCode: $("#mdProductCode"),
    mdPrice: $("#mdPrice"),
    mdTotal: $("#mdTotal"),
    mdWarranty: $("#mdWarranty"),

    disableSelect: function () {
        this.slctItems.prop("disabled", true);
    },

    enableSelect: function () {
        this.slctItems.prop("disabled", false)
    },

    show: function () {
        this.enableSelect();
        this.slctItems.select2('focus');
        this.model.modal('show');
    },

    clear: function () {
        this.slctItems.val(null).trigger('change').prop("disabled", false);
        this.mdQuantity.val('');

    },

    setDataNshow: function (productID, productName, quantity, productCode, price, warranty, total) {
        this.slctItems.select2("trigger", "select", {
            data: {id: productID, text: productName},
        });
        this.disableSelect();
        this.mdQuantity.val(quantity);
        this.mdProductCode.val(productCode);
        this.mdPrice.val(price);
        this.mdWarranty.val(warranty);
        this.mdTotal.val(total);


        this.model.modal('show');
    },

    updateProductDetails: function (productCode, price, warranty, total) {
        this.mdProductCode.val(productCode);
        this.mdPrice.val(price);
        this.mdWarranty.val(warranty);
        this.mdTotal.val(total);

    },

    setStatus: function (status) {

        if (status === 'add') {
            this.button.html('Add');
            this.button.val('add');
        } else if (status === 'update') {
            this.button.html('Update');
            this.button.val('update');
        }
    },
    updateTotal: function () {
        let quntity = this.mdQuantity.val();
        let unitPrice = this.mdPrice.val();

        let total = quntity * Number(unitPrice).toFixed(2);

        this.mdTotal.val(Number(total).toFixed(2))
    }


};


//item search change event
$(document).on('change', '#slctItems', function () {
    let productID = $(this).val();

    if (productID !== null) {
        $.ajax({
            url: base_url + '/product/getProductDetails',
            type: 'get',
            data: {
                'id': productID
            },
            success: function (data, textStatus, xhr) {

                data = JSON.parse(data['results']);


                if (data[0] !== undefined) {

                    mdAddItem.updateProductDetails(data[0]['code'], data[0]['sell_price'], data[0]['warranty_period']);
                }


            },
            error: function () {
                notify.serverError()
            }
        })
    }


});


//product add button click
$(document).on('click', '#btnAddProduct', function () {
    mdAddItem.clear();
    mdAddItem.setStatus('add');
    mdAddItem.show();

});


let mdAddProductsOptions = ({
    formID: 'FrmMdAddProduct',
    animate: true,
    validate: {
        slctItems: {
            type: 'text',
            methods: 'required'
        },
        mdQuantity: {
            type: 'number',
            methods: 'required'
        },

    },
});


let v = validator(mdAddProductsOptions);
v.init();


$('#FrmMdAddProduct').submit(function (e) {
    e.preventDefault();

    let mdBtAddProducts = $('#mdBtAddProducts');

    if (v.status()) {//form validated OK!


        mdAddItem.enableSelect();

        let values = $(this).serializeObject();


        let productName = $("#slctItems option:selected").text();
        let productID = values['slctItems'];
        let productCode = values['mdProductCode'];
        let quantity = values['mdQuantity'];
        let warrantyPeriod = values['mdWarranty'];
        let price = values['mdPrice'];
        let total = values['mdTotal'];

        // productID, productCode, productName, warrantyPeriod, price, quantity, total


        if (mdBtAddProducts.val() === 'update') {

            productInfoHandler.update(productID, productCode, productName, warrantyPeriod, price, quantity, total);

            mdAddItem.disableSelect();

            salesOrder.updateTotal();
        } else {

            if (salesOrder.productsInfo[productID]) {
                notify.error('Item Already added to the list');
            } else {

                productInfoHandler.append(productID, productCode, productName, warrantyPeriod, price, quantity, total);

                salesOrder.setProductsInfo(productID, productCode, productName, price, warrantyPeriod, quantity, total);
                salesOrder.updateTotal();
                v.resetForm();


            }
        }
    }
});

//update model total on keyup
$(document).on('keyup', '#mdQuantity', function () {

    mdAddItem.updateTotal();
});


//edit items
$(document).on('click', '.btnTblQuickEdit', function () {

    let productID = $(this).val();
    // productID, productCode, productName, warrantyPeriod, price, quantity, total

    let productCode = salesOrder.productsInfo[productID]['productCode'];
    let productName = salesOrder.productsInfo[productID]['productName'];
    let warranty = salesOrder.productsInfo[productID]['warranty'];
    let price = salesOrder.productsInfo[productID]['price'];
    let quantity = salesOrder.productsInfo[productID]['quantity'];
    let total = salesOrder.productsInfo[productID]['total'];


    mdAddItem.setStatus('update');
    mdAddItem.setDataNshow(productID, productName, quantity, productCode, price, warranty, total)

});


//remove table rows
$(document).on('click', '.btnTblRemoveRow', function () {
    $(this).closest('tr').remove();
    let productID = $(this).val();

    delete salesOrder.productsInfo[productID];
    salesOrder.updateTotal()
});




$(document).on('click', '#btPrintQuote', function () {


    if (Object.keys(salesOrder.productsInfo).length < 1) {
        notify.error('Oops!, Please select items to continue!');
    } else {
        $.ajax({
            url: 'triggerSalesQuotation',
            type: 'POST',
            data: salesOrder.getAllData()
            ,
            success: function (data, textStatus, xhr) {

                console.log(data)

                let a = document.createElement('a');
                a.target = '_blank';
                a.href = data['data']['invoice_url'];
                a.click();
                a.remove();


            },
            statusCode: { // laravel server side validations
                500: function (data, textStatus, xhr) {

                    notify.serverError()
                }
            }
        })

    }


});


$(document).on('click','#btClear',function () {

    salesOrder.clear();
    mdAddItem.clear();
    productInfoHandler.clear();
});
