let grnData = {
    supplierID: 0,
    productsInfo: {},
    fullTotal: 0,

    setSupplierID : function (supplierID) {
        this.supplierID = supplierID;
    },
    setFullTotal : function (total) {
        this.fullTotal = total;
    },
    setProductsInfo : function ({itemID,itemName,quantity,unitPrice,total}) {
        console.log(unitPrice)
        this.productsInfo
            [itemID] = {
            itemID: itemID,
            itemName: itemName,
            quantity: quantity,
            unitPrice: unitPrice,
            total: total
        };
    },
    updateProductsInfo : function({itemID,quantity,unitPrice,total}){
        this.productsInfo[itemID].quantity = parseFloat(quantity);
        this.productsInfo[itemID].unitPrice = parseFloat(unitPrice);
        this.productsInfo[itemID].total = parseFloat(total);
    },

    clearGrnData : function () {
        this.supplierID = 0;
        this.productsInfo = {};
        this.fullTotal = 0;
    },

    updateFullTotal : function () {
        this.fullTotal = 0;
        $.each(grnData.productsInfo, function (k, v) {
            grnData.fullTotal += parseFloat(v.total);
            console.log(v)
        });
       return grnData.fullTotal
    }

};

$(document).ready(function () {


    //supplier search
    $('#supplierSearch').select2({
        closeOnSelect: true,
        allowHtml: true,
        minimumResultsForSearch: -1,
        createSearchChoice: false,
        allowClear: true,
        tags: false,
        ajax: {
            url: base_url + '/supplier/searchSuppliers',
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
        placeholder: 'Search Supplier',
        minimumInputLength: 2,
    });


    //item search
    $('#slctItems').select2({
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
});


$(document).on('change', '#supplierSearch', function () {

    let supplierID = $(this).val();

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


});


$(document).on('change', '#supplierSearch', function () {
    let slct = $(this);

    if (slct.val() !== null) {
        $('#btnAddProduct').prop('disabled', false);
        grnData.setSupplierID(slct.val());
    }
});

$(document).on('click', '#btnAddProduct', function () {
    //check supplier is selected
    let slctSupplier = $('#supplierSearch').val();
    clearAddModalForm();

    formSetStatus('add');

    if (slctSupplier !== null) {
        $('#mdAddProduct').modal('show');
        $("#slctItems").select2('focus');

    }


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
        mdUnitPrice: {
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
    let btSave = $('#bt_submit');
    let tblProducts = $('#tblProducts');


    if (v.status()) {//form validated OK!

        let slctItems = $('#slctItems');
        slctItems.prop("disabled", false);

        let values = $(this).serializeObject();


        let itemName = $("#slctItems option:selected").text();
        let itemID = values['slctItems'];
        let quantity = values['mdQuantity'];
        let unitPrice = values['mdUnitPrice'];
        let total = values['mdTotal'];


        if (mdBtAddProducts.val() === 'Update') {
            let tr = 'tr-' + itemID;
            let tableRow = tblProducts.find('#' + tr);

            tableRow.find('#tdUnitPrice-'+itemID).html(unitPrice);
            tableRow.find('#tdMdQuantity-'+itemID).html(quantity);
            tableRow.find('#tdMdTotal-'+itemID).html(total);

            grnData.updateProductsInfo({itemID,unitPrice,quantity,total});

            updateFullTotal()

        } else {

            if (grnData.productsInfo[itemID]) {
                notify.error('Item Already added to the list');
            } else {


                let c = '';

                c += '<tr id="tr-' + itemID + '">' +
                    '<td id="tdItemID-' + itemID + '">' + itemID + '</td>' +
                    '<td id="tdItemName-' + itemID + '">' + itemName + '</td>' +
                    '<td id="tdUnitPrice-' + itemID + '">' + unitPrice + '</td>' +
                    '<td id="tdMdQuantity-' + itemID + '">' + quantity + '</td>' +
                    '<td id="tdMdTotal-' + itemID + '">' + total + '</td>' +
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

                tblProducts.append(c);

                grnData.setProductsInfo({itemID,itemName,quantity,unitPrice,total});


                updateFullTotal();

                v.resetForm();

                $("#slctItems").select2('focus');
            }


        }


    }

});


$(document).on('keyup', '#mdQuantity,#mdUnitPrice', function () {
    let quntity = $('#mdQuantity').val();
    let unitPrice = $('#mdUnitPrice').val();

    let total = quntity * Number(unitPrice).toFixed(2);

    $('#mdTotal').val(Number(total).toFixed(2))
});

//remove table rows
$(document).on('click', '.btnTblRemoveRow', function () {
    let s = $(this).closest('tr').remove();
    let productID = $(this).val();

    // let subTotal = grnData.productsInfo[productID].total;
    // grnData.fullTotal = parseFloat(grnData.fullTotal) - parseFloat(subTotal);

    delete grnData.productsInfo[productID];

    updateFullTotal();


});


//edit items
$(document).on('click', '.btnTblQuickEdit', function () {
    let tr = $(this).closest('tr');
    let itemID = $(this).val();

    let itemName = grnData.productsInfo[itemID]['itemName'];
    let quantity = grnData.productsInfo[itemID]['quantity'];
    let unitPrice = grnData.productsInfo[itemID]['unitPrice'];
    let total = grnData.productsInfo[itemID]['total'];

    // $('#slctItems').select2('data', {id: itemID, text: itemName}).change();
    let slctItems = $("#slctItems");

    slctItems.select2("trigger", "select", {
        data: {id: itemID, text: itemName},
    });
    slctItems.prop("disabled", true);


    $('#mdQuantity').val(quantity);
    $('#mdUnitPrice').val(unitPrice);
    $('#mdTotal').val(total);

    formSetStatus('update');

    $('#mdAddProduct').modal('show');


});


function clearAddModalForm() {
    // let slctItems = $("#slctItems");
    $("#slctItems").val(null).trigger('change').prop("disabled", false);
    $('#mdQuantity').val('');
    $('#mdUnitPrice').val('');
    $('#mdTotal').val(0);

}

function updateFullTotal() {
    // grnData.fullTotal = 0;
    // $.each(grnData.productsInfo, function (k, v) {
    //     grnData.fullTotal += parseFloat(v.total);
    //
    //
    // });
    $('#fullTotal').val(grnData.updateFullTotal())
}

function formSetStatus(status) {
    let button = $('#mdBtAddProducts');

    if (status === 'add') {
        button.html('Add');
        button.val('Add');
    } else if (status === 'update') {
        button.html('Update');
        button.val('Update');
    }
}


