let dTable =   $('#tblSupplierHistory').dataTable( $.extend( true, {},{
    "ajax": {
        "url": "getAllOrderHistories",
        "type": 'get',
        "data": function (d) {
        },
        dataSrc: "data"
    },
    columns: [
        {data: ['id']},
        {data: ['purchase_id']},git
        {data: ['product_id']},
        {data: ['quantity']},
        {data: ['buy_price']},
        {data: ['sell_price']},
        {data: ['profit_percentage']},
        {data: ['profit_type']},

    ]
},DtableDefaultSetting));



$('#dTableSearchBox').keyup(function () {
    dTable.api().search($(this).val()).draw();
});

