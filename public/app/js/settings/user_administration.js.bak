// //user role change
// $(document).on('change', '#slctUserRole', function () {
//     let role_id = $(this).val();
//
//
//     $.ajax({
//         url: 'getUserModulesNPermissions',
//         type: 'post',
//         data: {
//             'role_id': role_id
//         },
//         success: function (data, textStatus, xhr) {
//             console.log(data)
//
//
//             buildDOM(data['data'])
//
//
//
//         },
//         statusCode: { // laravel server side validations
//             500: function (data, textStatus, xhr) {
//                 notify.serverError()
//             }
//         }
//     })
//
//     //get modules
//
//
// });
//
//
//
// function buildDOM(data) {
//
//     let left,right = '';
//
//     $.each(data,function (k,v) {
//
//         let module_name= v['module_data']['module'];
//         let permission_id = v['module_data']['permission_id'];
//         let role_permission_id = v['module_data']['role_permission_id'];
//
//         let tabid = module_name+'-'+permission_id;
//         let tblID = 'tbl-'+module_name+'-'+permission_id;
//         let href= '#'+module_name+''+permission_id;
//
//         let chkName = role_permission_id+'-'+permission_id;
//
//         let right_tabs = $('#rightTabs');
//
//
//         left += '<tr><td>\n' +
//             '                                                <a class="nav-link active show" id="'+tabid+'" data-toggle="tab"\n' +
//             '                                                   href="'+href+'" role="tab" aria-controls="'+module_name+'" aria-selected="true">'+module_name+'</a>\n' +
//             '                                            </td></tr>';
//
//
//         $('#leftTabs').empty().append(left)
//
//         // let tab = '<div class="tab-pane fade" id="'+href+'" role="tabpanel"\n' +
//         //     '                                                 aria-labelledby="'+tabid+'">\n' +
//         //     '                                                <table class="table table-condensed table-striped table-sm table-slate" id="'+tblID+'">\n' +
//         //     '                                                    \n' +
//         //     '\n' +
//         //     '\n' +
//         //     '\n' +
//         //     '                                                </table>\n' +
//         //     '                                            </div>';
//         //
//         // right_tabs.empty().append(tab);
//
//         $.each(v['permission_data'],function (k,p) {
//
//             right += '<tr>\n' +
//                 '                                                        <td>\n' +
//                 '                                                            <div class="custom-control custom-checkbox">\n' +
//                 '                                                                <input type="checkbox" class="custom-control-input"\n' +
//                 '                                                                       id="'+chkName+'" name="'+chkName+'">\n' +
//                 '                                                                <label class="custom-control-label"\n' +
//                 '                                                                       for="'+chkName+'"></label>\n' +
//                 '                                                            </div>\n' +
//                 '                                                        </td>\n' +
//                 '                                                        <td>\n' +
//                 '                                                            <h6>'+module_name+'</h6>\n' +
//                 '                                                        </td>\n' +
//                 '                                                    </tr>'
//
//             $('#rightTabs').empty().append(right)
//         });
//
//
//     })
//
// }


$(document).on('click', '#btnShowPer', function () {
    let slctUserRole = $('#slctUserRole');
    let slctModule = $('#slctModule');

    if (slctUserRole.val() == -1) {
        notify.error('Please Select a user role to continue')
    } else if (slctModule.val() == -1) {
        notify.error('Please Select a system module to continue')
    } else {


        $.ajax({
            url: 'getPermissions',
            type: 'post',
            data: {
                'module_id': slctModule.val(),
                'user_role': slctUserRole.val()
            },
            success: function (data, textStatus, xhr) {

                let permissions = data['data'][0];

                showOnCheckBoxes(permissions);


            },
            statusCode: { // laravel server side validations
                500: function (data, textStatus, xhr) {
                    notify.serverError()
                }
            }
        })


    }


});

function showOnCheckBoxes(permissions) {

    let create = $('#pCreate');
    let pRead = $('#pRead');
    let pUpdate = $('#pUpdate');
    let pDelete = $('#pDelete');

    create.val(permissions['rp_id'] + '-c');
    pRead.val(permissions['rp_id'] + '-r');
    pUpdate.val(permissions['rp_id'] + '-u');
    pDelete.val(permissions['rp_id'] + '-d');

    if (permissions['create'] === 1) {
        create.prop("checked", true);
    } else {
        create.prop("checked", false)
    }

    if (permissions['read'] === 1) {
        pRead.prop("checked", true)
    } else {
        pRead.prop("checked", false)
    }

    if (permissions['update'] === 1) {
        pUpdate.prop("checked", true)
    } else {
        pUpdate.prop("checked", false)
    }

    if (permissions['delete'] === 1) {
        pDelete.prop("checked", true)
    } else {
        pDelete.prop("checked", false)
    }


}


$(document).on('click', '.chkPermission', function () {
    let val = $(this).val();

    var items = val.split('-');

    let isChecked = $(this).is(":checked");

    let role_val = 0;
    if (isChecked) {
        role_val = 1
    } else {
        role_val = 0
    }

    let rp_id = items[0];
    let role = items[1];

    if (val !== undefined || val !== null){
        $.ajax({
            url: 'updatePermission',
            type: 'post',
            data: {
                'rp_id': rp_id,
                'role': role,
                'role_val': role_val
            },
            success: function (data, textStatus, xhr) {

                if (!data['status']) {
                    notify.error(data['message'])
                } else {
                    notify.success(data['message']);
                }


            },
            statusCode: { // laravel server side validations
                500: function (data, textStatus, xhr) {
                    notify.serverError()
                }
            }
        })
    }

});



$(document).on('click','#addModule',function () {
    $('#msAddModule').modal('show');
})

$(document).on('click','#addRole',function () {
    $('#msAddUserRole').modal('show');
})



let optionsv = ({
    formID: 'frmAddModule',
    animate: true,
    validate: {
        moduleName: {
            type: 'text',
            methods: 'required'
        },

    },
});


let v = validator(optionsv);
v.init();



$('#frmAddModule').submit(function (e) {
    e.preventDefault();

    let btSave = $('#mdBtSaveModule');
    var formData = new FormData(this);

    if (v.status()) {//form validated OK!
        $.ajax({

            url: "storeNewModule",
            type: 'post',
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            beforeSend: function () {
                spinButton.start(btSave);

            },
            success: function (data, textStatus, xhr) {
                spinButton.stop(btSave);

                if (!data['status']) {
                    notify.error(data['message'])
                } else {
                    notify.success(data['message'])
                    v.resetForm()
                }
            },
            statusCode: { // laravel server side validations
                500: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    notify.serverError()
                }
            }
        });
    }

});




let optionsx = ({
    formID: 'frmAddUserRole',
    animate: true,
    validate: {
        userRoleName: {
            type: 'text',
            methods: 'required'
        },

    },
});


let x = validator(optionsx);
x.init();



$('#frmAddUserRole').submit(function (e) {
    e.preventDefault();

    let btSave = $('#mdBtSaveUserRole');
    var formData = new FormData(this);

    if (x.status()) {//form validated OK!
        $.ajax({

            url: "storeNewUserRole",
            type: 'post',
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            beforeSend: function () {
                spinButton.start(btSave);

            },
            success: function (data, textStatus, xhr) {
                spinButton.stop(btSave);

                if (!data['status']) {
                    notify.error(data['message'])
                } else {
                    notify.success(data['message'])
                    x.resetForm()
                }
            },
            statusCode: { // laravel server side validations
                500: function (data, textStatus, xhr) {
                    spinButton.stop(btSave);
                    notify.serverError()
                }
            }
        });
    }

});
