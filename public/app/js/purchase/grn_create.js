$(document).ready(function () {

//supplier search
    $('#supplierSearch').select2({
        ajax: {
            url: base_url + '/supplier/searchSuppliers',
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
        placeholder: 'Search Supplier',
    });

//item search
    $('#slctItems').select2({
        ajax: {
            url: base_url + '/product/searchProducts',
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
        placeholder: 'Search for a Product'
    });

});

let GRN = {
    supplierID: null,
    // supplierName: null,
    invoiceNo: null,
    repName: null,
    fullTotal: 0,
    productsInfo: {
        // productID: null,
        // productName: null,
        // warranty: null,
        // buyPrice: null,
        // sellPrice: null,
        // units: null,
        // total: null,
    },

    getTotal: function () {
        this.updateTotal();
        return GRN.fullTotal
    },
    updateTotal: function () {
        GRN.fullTotal = 0;
        $.each(GRN.productsInfo, function (k, v) {
            GRN.fullTotal += parseFloat(v.total);
        });
        $('#fullTotal').val(GRN.fullTotal);
    },
    setProductsInfo: function (productID, productName, warranty, buyPrice, sellPrice, units, total) {

        this.productsInfo
            [productID] = {
            productID: productID,
            productName: productName,
            warranty: warranty,
            buyPrice: buyPrice,
            sellPrice: sellPrice,
            units: units,
            total: total,
        };

        this.fullTotal += total

    },

    updateProductsInfo: function (productID, warranty, buyPrice, sellPrice, units, total) {
        this.productsInfo[productID].productID = productID;
        this.productsInfo[productID].warranty = warranty;
        this.productsInfo[productID].units = units;
        this.productsInfo[productID].buyPrice = parseFloat(buyPrice);
        this.productsInfo[productID].sellPrice = parseFloat(sellPrice);
        this.productsInfo[productID].total = parseFloat(total);

    },

    clearGrnData: function () {
        this.supplierID = null;
        this.invoiceNo = null;
        this.repName = null;
        this.fullTotal = 0;
        this.productsInfo = {};

    },

    getAllData : function () {
        return  {
            supplierID: this.supplierID,
            invoiceNo: this.invoiceNo,
            repName: this.repName,
            fullTotal: this.fullTotal,
            productsInfo: this.productsInfo
        }
    }
};

let supplier = {
    supCompanyName: $('#supCompanyName'),
    supEmail: $('#supEmail'),
    supAddress: $('#supAddress'),

    showInfo: function (email, address, company) {
        this.supEmail.html(email);
        this.supAddress.html(address);
        this.supCompanyName.html(company);
    },

    clearInfo: function () {
        this.supEmail.html('');
        this.supAddress.html('');
        this.supCompanyName.html('');
    }

};


let products = {
    tbody: $('#tblProducts'),

    append: function (productID, productName, warrantyPeriod, buyPrice, sellPrice, units, total) {
        let c = '<tr id="tr-' + productID + '">\n' +
            '                                                    <td id="tdProductID-' + productID + '">' + productID + '</td>\n' +
            '                                                    <td id="tdProductName-' + productID + '">' + productName + '</td>\n' +
            '                                                    <td id="tdWarranty-' + productID + '">' + warrantyPeriod + '</td>\n' +
            '                                                    <td id="tdBuyPrice-' + productID + '">' + buyPrice + '</td>\n' +
            '                                                    <td id="tdSellPrice-' + productID + '">' + sellPrice + '</td>\n' +
            '                                                    <td id="tdUnits-' + productID + '">' + units + '</td>\n' +
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

        this.tbody.append(c);
    },

    update: function (productID, warrantyPeriod, buyPrice, sellPrice, units, total) {

        let tr = 'tr-' + productID;
        let tableRow = this.tbody.find('#' + tr);

        tableRow.find('#tdWarranty-' + productID).html(warrantyPeriod);
        tableRow.find('#tdBuyPrice-' + productID).html(buyPrice);
        tableRow.find('#tdSellPrice-' + productID).html(sellPrice);
        tableRow.find('#tdUnits-' + productID).html(units);
        tableRow.find('#tdTotal-' + productID).html(total);

        GRN.updateProductsInfo(productID, warrantyPeriod, buyPrice, sellPrice, units, total);
        GRN.updateTotal()
    },

    clear: function () {
        this.tbody.empty();
        $('#fullTotal').val('')
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
    mdBuyPrice: $("#mdBuyPrice"),
    mdSellPrice: $("#mdSellPrice"),
    mdWarranty: $("#mdWarranty"),
    mdTotal: $("#mdTotal"),

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
        this.mdBuyPrice.val('');
        this.mdSellPrice.val('');
        this.mdWarranty.val('');
        this.mdTotal.val('');
    },

    setDataNshow: function (productID, productName, quantity, buyPrice, sellPrice, warranty, total) {
        this.slctItems.select2("trigger", "select", {
            data: {id: productID, text: productName},
        });
        this.disableSelect();
        this.mdQuantity.val(quantity);
        this.mdBuyPrice.val(buyPrice);
        this.mdSellPrice.val(sellPrice);
        this.mdWarranty.val(warranty);
        this.mdTotal.val(total);

        this.model.modal('show');
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
        let unitPrice = this.mdBuyPrice.val();

        let total = quntity * Number(unitPrice).toFixed(2);

        this.mdTotal.val(Number(total).toFixed(2))
    }

};


//supplier change event
$(document).on('change', '#supplierSearch', function () {
    let supplierID = $(this).val();
    // let supplierName = $("#supplierSearch option:selected").text();

    $.ajax({
        url: base_url + '/supplier/show',
        type: 'get',
        data: {
            'id': supplierID
        },
        success: function (data, textStatus, xhr) {
            if (data['status']) {

                if (data['data'] !== null) {

                    let email = data['data']['email'];
                    let address = data['data']['address'];
                    let company_name = data['data']['company_name'];

                    supplier.clearInfo();
                    supplier.showInfo(email, address, company_name);

                    products.setButtonStatus('enable');

                    GRN.supplierID = supplierID;
                    // GRN.supplierName = supplierName;

                } else {
                    supplier.clearInfo();
                }

            } else {
                supplier.clearInfo();
                notify.serverError()
            }
        },
        error: function () {
            notify.serverError()
        }
    })
});


//product add button click
$(document).on('click', '#btnAddProduct', function () {
    mdAddItem.clear();
    mdAddItem.setStatus('add');

    //set GRNNo and rep name
    GRN.invoiceNo = $('#grnNo').val();
    GRN.repName = $('#repName').val();

    if (GRN.supplierID !== null) {
        mdAddItem.show();
    }
});


//update model total on keyup
$(document).on('keyup', '#mdQuantity,#mdBuyPrice', function () {

    mdAddItem.updateTotal();
});

//remove table rows
$(document).on('click', '.btnTblRemoveRow', function () {
    $(this).closest('tr').remove();
    let productID = $(this).val();

    delete GRN.productsInfo[productID];
    GRN.updateTotal()
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
        mdBuyPrice: {
            type: 'number',
            methods: 'required'
        },
        mdSellPrice: {
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

        let itemName = $("#slctItems option:selected").text();
        let itemID = values['slctItems'];
        let quantity = values['mdQuantity'];
        let mdBuyPrice = values['mdBuyPrice'];
        let mdSellPrice = values['mdSellPrice'];
        let mdWarranty = values['mdWarranty'];
        let mdTotal = values['mdTotal'];


        if (mdBtAddProducts.val() === 'update') {

            products.update(itemID, mdWarranty, mdBuyPrice, mdSellPrice, quantity, mdTotal);

            mdAddItem.disableSelect();

            GRN.updateTotal();
        } else {

            if (GRN.productsInfo[itemID]) {
                notify.error('Item Already added to the list');
            } else {

                products.append(itemID, itemName, mdWarranty, mdBuyPrice, mdSellPrice, quantity, mdTotal);

                GRN.setProductsInfo(itemID, itemName, mdWarranty, mdBuyPrice, mdSellPrice, quantity, mdTotal);
                GRN.updateTotal();
                v.resetForm();


            }
        }
    }
});


//edit items
$(document).on('click', '.btnTblQuickEdit', function () {

    let itemID = $(this).val();

    let itemName = GRN.productsInfo[itemID]['productName'];
    let warranty = GRN.productsInfo[itemID]['warranty'];
    let buyPrice = GRN.productsInfo[itemID]['buyPrice'];
    let sellPrice = GRN.productsInfo[itemID]['sellPrice'];
    let units = GRN.productsInfo[itemID]['units'];
    let total = GRN.productsInfo[itemID]['total'];

    mdAddItem.setStatus('update');
    mdAddItem.setDataNshow(itemID, itemName, units, buyPrice, sellPrice, warranty, total)

});


let grnNrepOptions = ({
    formID: 'grnNRep',
    animate: true,
    validate: {
        supplierSearch: {
            type: 'text',
            methods: 'required'
        },
        grnNo: {
            type: 'text',
            methods: 'required'
        },
        repName: {
            type: 'number',
            methods: 'required'
        },

    },
});


let x = validator(grnNrepOptions);
x.init();

$(document).on('click', '#btSaveGrn', function () {
    let btSave = $(this);

    if (x.status()) {
        if (Object.keys(GRN.productsInfo).length < 1) {
            notify.error('Oops!, Please select items to continue!');
        }else {
            $.ajax({
                url: 'saveGRN',
                type: 'POST',
                data: GRN.getAllData()
                ,
                beforeSend: function () {
                    spinButton.start(btSave);

                },
                success: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);

                    if (!data['status']) {
                        notify.error(data['message'])
                    } else {
                        notify.success(data['message']);

                        x.resetForm();
                        GRN.clearGrnData();
                        mdAddItem.clear();
                        products.clear();
                        supplier.clearInfo();
                    }
                },
                statusCode: { // laravel server side validations
                    500: function (data, textStatus, xhr) {
                        spinButton.stop(btSave);
                        notify.serverError()
                    }
                }
            })
        }
    }
});


