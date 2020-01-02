function buildParameters(btnVal) {
    let type = '&type=';
    switch (btnVal) {
        case 'print':
            type += 'print';
            break;
        case 'pdf':
            type += 'pdf';
            break;
        case 'excel':
            type += 'excel';
            break;
        default:
            type = '';
    }

    return type;
}

//user activity report
$(document).on('click', '.btnGenUAReport', function () {

    let btnVal = $(this).val();
    let params = buildParameters(btnVal);


    let userID = $('#UARslctUser').val();

    if (userID == -1) {
        notify.error('Please Select a User');
    } else {
        let a = document.createElement('a');
        a.target = '_blank';
        a.href = 'generateUserActivityReport?user_id=' + userID + '' + params;
        a.click();
        a.remove();
    }


});


//sales report
$(document).on('click', '.btnGenSalesReport', function () {
    let btnVal = $(this).val();
    let params = buildParameters(btnVal);

    let fromDate = $('#SRFromDate').val();
    let toDate = $('#SRToDate').val();

    if (fromDate === toDate) {
        notify.error('Please Select a range');
    } else {

        let a = document.createElement('a');
        a.target = '_blank';
        a.href = 'generateSalesReport?fromDate=' + fromDate + '&toDate=' + toDate + '' + params;
        a.click();
        a.remove();
    }
});


//supplier Report
$(document).on('click', '.btnGenSReport', function () {
    let btnVal = $(this).val();
    let params = buildParameters(btnVal);

    let supplierID = $('#SRslctSupplier').val();


    if (supplierID === -1) {
        notify.error('Please Select a supplier');
    } else {

        let a = document.createElement('a');
        a.target = '_blank';
        a.href = 'generateSupplierReport?supplier_id=' + supplierID + '' + params;
        a.click();
        a.remove();
    }
});


//supplier Report
$(document).on('click', '.btnGenCWReport', function () {
    let btnVal = $(this).val();
    let params = buildParameters(btnVal);

    let customerID = $('#SRslctCustomer').val();


    if (customerID === -1) {
        notify.error('Please Select a Customer');
    } else {

        let a = document.createElement('a');
        a.target = '_blank';
        a.href = 'generateCustomerWiseReport?customer_id=' + customerID + '' + params;
        a.click();
        a.remove();
    }
});


//stock Report
$(document).on('click', '.btnGenStockReport', function () {
    let btnVal = $(this).val();
    let params = buildParameters(btnVal);

    let a = document.createElement('a');
    a.target = '_blank';
    a.href = 'generateStockReport?'+ params;
    a.click();
    a.remove();

});
