let dTable = $('#tblSupplierOverview').DataTable({
    responsive: true,
    autoWidth: false, // full width fix bootstrap 4
    // searching:false
    dom: 'lrtip',
});


$('#dTableSearchBox').keyup(function () {
    dTable.search($(this).val()).draw();
});






//Edit table
$(".btnQuickEdit").click(function () {
    let supplierID = ($(this).val());
    $('#mdSupplierID').val(supplierID);

    let mdChkSupplierApprove = $('#mdChkSupplierApprove');
    let mdChkSupplierStatus = $('#mdChkSupplierStatus');
    let mdSupplierName = $('#mdUsername');

    let btQuickEdit = $(this);


    let mdAdvRoute = $('#mdAdvRoute');
    mdAdvRoute.attr('href',mdAdvRoute.attr('href')+ '?id='+supplierID );

    let isApproved = false;


    $.ajax({
        headers:CSRF,
        url: "show",
        type: 'get',
        data: {
            "id": supplierID,
        },

        beforeSend: function () {

            spinButton.start(btQuickEdit,'bar');

        },
        success: function (data, textStatus, xhr) {

            if (Object.keys(data).length > 0) {
                //status

                if (data['status'] === true){
                    if (data.data.status === 1) {
                        mdChkSupplierStatus.prop('checked', true).change()
                    } else if (data.data.status === 0) {
                        mdChkSupplierStatus.prop('checked', false).change()
                    }

                    if (data.data.is_approved === 1) {
                        mdChkSupplierApprove.prop('checked', true).change();
                        mdChkSupplierApprove.prop('disabled', true).change();
                        mdChkSupplierApprove.removeAttr('name');
                        $('#frmGrpSupplierApprove').hide();
                    } else if (data.data.status === 0) {
                        mdChkSupplierApprove.prop('checked', false).change();
                        mdChkSupplierApprove.prop('disabled', false).change();
                        mdChkSupplierApprove.attr('name', 'supplierApprove');
                        $('#frmGrpSupplierApprove').show();
                    }

                    mdSupplierName.html(data.data.name);
                    $('#mdSupplierEdit').modal('show');


                }else {
                    notify.unauthorized();
                }



            }

            spinButton.stop(btQuickEdit,'bar');

        },
        error: function (data, textStatus, xhr) {
            notify.serverError()
            spinButton.stop(btQuickEdit,'bar');
        },

    });
});


$('#mdFrmSupplierQuickUpdate').submit(function (e) {
    e.preventDefault();
    let btSave = $('#mdBtUpdateSupplier');




    $.ajax({
        headers: CSRF,
        url: "updateQuick",
        type: 'post',
        data: $(this).serialize(),

        beforeSend: function () {
            spinButton.start(btSave);

        },
        success: function (data, textStatus, xhr) {

            spinButton.stop(btSave);


            if (!data['status']) {
                iziToast.error({
                    title: 'Oops!',
                    message: data['message'],
                    position: 'topRight',
                    timeout: 10000,
                });
            } else {
                iziToast.success({
                    title: 'Yayy..!',
                    message: data['message'],
                    position: 'topRight',
                    timeout: 5000,
                });

            }


            location.reload();
        },
        error: function (data, textStatus, xhr) {
            notify.serverError();
            spinButton.stop(btSave);
        },

    });
});



