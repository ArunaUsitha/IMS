let dTable =   $('#tblStocksOverview').dataTable( $.extend( true, {},{
    "ajax": {
        "url": "getAllStocks",
        "type": 'get',
        "data": function (d) {
        },
        dataSrc: "stock"
    },
    columns: [
        {data: ['product_id']},
        {data: ['code']},
        {data: ['custom_code']},
        {data: ['category_name']},
        {data: ['model_no']},
        {data: ['name']},
        // {data: ['stock']},
        {
            "data": null,
            "render": function (data, type, full, meta) {

                let stock = data['stock'];
                let r_quantity = data['reorder_quantity'];

                console.log(stock)

                if (stock < r_quantity) {
                    return '<label class="badge badge-danger">'+stock+'</label>';
                } else {
                    return '<label class="badge badge-success">'+stock+'</label>';
                }

            }
        }

    ]
},DtableDefaultSetting));



$('#dTableSearchBox').keyup(function () {
    dTable.api().search($(this).val()).draw();
});

