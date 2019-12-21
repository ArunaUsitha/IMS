let dTable =   $('#tblProdcutOverview').dataTable( $.extend( true, {},{
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
        { "data": null,
            "render": function (data, type, full, meta) {

                return data['product_category']['name']


            } },
        {"data": null,
            "render": function (data, type, full, meta) {

                return data['brand']['name']


            }},
        {data: ['model_no']},
        {
            "data": null,
            "render": function (data, type, full, meta) {



                if(data['status'] === 1){
                    return getSetStatusButton(true,'setProductStatus','setProductStatus',data['id']);
                }else{
                    return getSetStatusButton(false,'setProductStatus','setProductStatus',data['id']);
                }


            }
        },
        {data: ['created_at']},
        {
            "data": null,
            "render": function (data, type, full, meta) {
                let c = '';
                let productID = data['id'];

                if (auth.can('read')) {
                    c += '<button type="button" onclick="window.location= \'showpPoduct?id='+productID+' \'     "\n' +
                        '                                                                    class="btn btn-icon text-success btn-sm"\n' +
                        '                                                                    data-toggle="tooltip" data-placement="top" title=""\n' +
                        '                                                                    data-original-title="Advance View"><i\n' +
                        '                                                                    class="fas fa-search-plus"></i></button>'
                }

                if (auth.can('update')) {
                    c += '<button type="button" value="' + productID + '"\n' +
                        '                                                                    class="btn btn-icon text-info btn-sm btnQuickEdit"\n' +
                        '                                                                    data-toggle="tooltip" data-placement="top"\n' +
                        '                                                                    title=""\n' +
                        '                                                                    data-original-title="Quick Edit"><i\n' +
                        '                                                                    class="fas fa-edit"></i>\n' +
                        '                                                        </button>'
                }



                return c;


            }
        },

    ]
},DtableDefaultSetting));



$('#dTableSearchBox').keyup(function () {
    dTable.api().search($(this).val()).draw();
});

function getSetStatusButton(isActive,id,name,value) {

    let c = '' +
        '                                <label class="custom-switch mt-2 custom-switch-no-padding ">';

    if (isActive){
        c+= ' <input type="checkbox" value="'+value+'"  name="'+name+'" id="'+id+'" class="custom-switch-input btnSetProductStatus" checked>';
    }else {
        c+= ' <input type="checkbox" value="'+value+'"  name="'+name+'" id="'+id+'" class="custom-switch-input btnSetProductStatus">';
    }


      c +=  '                                    <span class="custom-switch-indicator"></span>\n' +
        '                                </label>\n';

    return c;

}


$(document).on('change','.btnSetProductStatus',function () {

    let productID = $(this).val();
    let checked = $(this). prop("checked");
    let status = 0;

    if(checked === true){
        status = 1;
    }

    $.ajax({
        headers: CSRF,
        url: "setProductStatus",
        type: 'post',
        data: {
            "id": productID,
            "status" : status
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
