let dTable =   $('#tblSalesOverview').dataTable( $.extend( true, {},{
    "ajax": {
        "url": "getSales",
        "type": 'get',
        "data": function (d) {
        },
        dataSrc: "data"
    },
    columns: [
        {data: ['invoice_no']},
        {data: ['customer_id']},
        {data: ['amount']},
        {data: ['created_at']},

        {
            "data": null,
            "render": function (data, type, full, meta) {
                let c = '';
                let invoice_no = data['invoice_no'];

                // if (auth.can('read')) {
                c += '<a type="button" target="_blank"  href="viewInvoice?invoice_no=' + invoice_no + '"\n' +
                    '                                                                    class="btn btn-icon text-success btn-sm"\n' +
                    '                                                                    data-toggle="tooltip" data-placement="top" title=""\n' +
                    '                                                                    data-original-title="View invoice"><i\n' +
                    '                                                                    class="fas fa-search-plus"></i></a>'
                return c;


            }
        },

    ]
},DtableDefaultSetting));



$('#dTableSearchBox').keyup(function () {
    dTable.api().search($(this).val()).draw();
});

