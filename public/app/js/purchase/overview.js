let dTable =   $('#tblPurchaseOrdersOverview').dataTable( $.extend( true, {},{
    "ajax": {
        "url": "getAllPurchaseOrders",
        "type": 'get',
        "data": function (d) {
        },
        dataSrc: "data"
    },
    columns: [
        {data: ['order_code']},
        {data: ['company_name']},
        {data: ['address']},
        {data: ['email']},
        {data: ['mobile']},
        {data: ['fixed']},
        {data: ['created_at']},


        {
            "data": null,
            "render": function (data, type, full, meta) {
                let c = '';
                let purchaseOrderId = data['id'];

                if (auth.can('view_purchase_order')) {
                c += '<button type="button" onclick="window.location= \'showPurchaseOrder?purchaseOrderID='+purchaseOrderId+' \'     "\n' +
                    '                                                                    class="btn btn-icon text-success btn-sm"\n' +
                    '                                                                    data-toggle="tooltip" data-placement="top" title=""\n' +
                    '                                                                    data-original-title="Detailed View"><i\n' +
                    '                                                                    class="fas fa-search-plus"></i></button>'
                }


                return c;


            }
        },

    ]
},DtableDefaultSetting));



$('#dTableSearchBox').keyup(function () {
    dTable.api().search($(this).val()).draw();
});
