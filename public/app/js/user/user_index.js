


// let dTable = $('#tblUserOverview').DataTable({
//     responsive: true,
//     autoWidth: false, // full width fix bootstrap 4
//     // searching:false
//     dom: 'lrtip',
//     ajax:  {
//         url: 'getAllUsersNRoles',
//         dataSrc: 'users',
//         type: 'get',
//         "fnServerData": function ( sSource, aoData, fnCallback ) {
//
//             console.log(aoData)
//             var returnData = [];
//             for (var i = 0; i < aoData.length; i++) {
//                 //makes the data an array of arrays
//                 returnData.push($.makeArray(aoData[i]));
//             }
//
//             $.getJSON( sSource, returnData , function (json) {
//                 /* Do whatever additional processing you want on the callback, then
//                tell DataTables */
//                 console.log(sSource,returnData);
//                 fnCallback(json)
//             } );
//         }
//     },
//
//     columns: [
//         { data: "Name" },
//         { data: "Total" },
//         { data: "Passed" },
//         { data: "Failed" }
//     ]
// });

var DtableDefaultSetting = {
    "bProcessing": false,
    "bServerSide": false,
    language: {
        // processing: "<div class=\"dot-floating\"></div>",
        loadingRecords : "<img src="+ base_url +'/images/app_data/preloaders/double_ring_s.gif'+">"
    },
    dom: 'lrtip',
};



  let dTable =   $('#tblUserOverview').dataTable( $.extend( true, {},{
        "ajax": {
            "url": "getAllUsersNRoles",
            "type": 'get',
            "data": function (d) {
            },
            dataSrc: "users"
        },
        columns: [
            {data: ['id']},
            {data: ['first_name']},
            {
                "data": null,
                "render": function (data, type, full, meta) {
                    return data["address_no"] + ", " + data["address_street"] + ", " + data['address_city'];
                }
            },
            {data: ['mobile']},
            {data: ['DOB']},
            {data: ['NIC']},
            {data: ['email']},
            {
                "data": null,
                "render": function (data, type, full, meta) {

                    switch (data['status']) {
                        case 0:
                            return '<label class="badge badge-danger">Deactive</label>';
                        case 1:
                            return '<label class="badge badge-success">Active</label>';
                    }


                }
            },
            {
                "data": null,
                "render": function (data, type, full, meta) {
                    let c = '';
                    let userID = data['id'];

                    if (auth.can('read')) {
                        c += '<button type="button" onclick="window.location= \'showUser?id='+userID+' \'     "\n' +
                            '                                                                    class="btn btn-icon text-success btn-sm"\n' +
                            '                                                                    data-toggle="tooltip" data-placement="top" title=""\n' +
                            '                                                                    data-original-title="Advance View"><i\n' +
                            '                                                                    class="fas fa-search-plus"></i></button>'
                    }

                    if (auth.can('update')) {
                        c += '<button type="button" value="' + userID + '"\n' +
                            '                                                                    class="btn btn-icon text-info btn-sm btnQuickEdit"\n' +
                            '                                                                    data-toggle="tooltip" data-placement="top"\n' +
                            '                                                                    title=""\n' +
                            '                                                                    data-original-title="Quick Edit"><i\n' +
                            '                                                                    class="fas fa-edit"></i>\n' +
                            '                                                        </button>'
                    }

                    if (auth.can('delete')) {
                        c += '<button type="button"\n' +
                            '                                                                    class="btn btn-icon text-warning btn-sm"\n' +
                            '                                                                    data-toggle="tooltip" data-placement="top"\n' +
                            '                                                                    title=""\n' +
                            '                                                                    data-original-title="Delete User"><i\n' +
                            '                                                                    class="fas fa-trash"></i></button>'
                    }

                    return c;


                }
            },

        ]
    },DtableDefaultSetting));



$('#dTableSearchBox').keyup(function () {
    dTable.search($(this).val()).draw();
});


//Edit table
$(document).on('click', '.btnQuickEdit', (function () {
    let userID = ($(this).val());
    $('#mdUserID').val(userID);
    let MdChkUserStatus = $('#MdChkUserStatus');
    let MdSlctUserType = $('#MdSlctUserType');
    let mdUsername = $('#mdUsername');

    let btQuickEdit = $(this);


    let mdAdvRoute = $('#mdAdvRoute');
    mdAdvRoute.attr('href', mdAdvRoute.attr('href') + '?id=' + userID);


    $.ajax({
        headers: CSRF,
        url: "show",
        type: 'get',
        data: {
            "id": userID,
        },

        beforeSend: function () {

            spinButton.start(btQuickEdit, 'bar');

        },
        success: function (data, textStatus, xhr) {

            if (Object.keys(data).length > 0) {
                //status

                if (data['status'] === true) {
                    if (data.data.status === 1) {
                        MdChkUserStatus.prop('checked', true).change()
                    } else if (data.data.status === 0) {
                        MdChkUserStatus.prop('checked', false).change()
                    }

                    //role id
                    MdSlctUserType.val(data.data.role_id).change();
                    $('#mdUserEdit').modal('show');

                    mdUsername.html(data.data.first_name)
                } else {
                    notify.unauthorized();
                }


            }

            spinButton.stop(btQuickEdit, 'bar');

        },
        error: function (data, textStatus, xhr) {
            notify.serverError()
            spinButton.stop(btQuickEdit, 'bar');
        },

    });
}));


$('#mdFrmUserQuickUpdate').submit(function (e) {
    e.preventDefault();
    let btSave = $('#mdBtUpdateUser');


    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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


// $('#tblUserOverview').DataTable( {
//     responsive: false,
//     dom: 'Bfrtip',
//     buttons: [
//         'csv', 'excel', 'print'
//     ],
//     columns: [
//         { data: 'id' },
//         { data: 'first_name' },
//         { data: 'last_name' },
//         { data: 'email' },
//         { data: 'gender' }
//     ],
//     data : [
//         {"id":1,"first_name":"Martie","last_name":"Cescoti","email":"mcescoti0@about.com","gender":"Female"},
//             {"id":2,"first_name":"Burk","last_name":"Hutchins","email":"bhutchins1@ftc.gov","gender":"Male"},
//             {"id":3,"first_name":"Deedee","last_name":"Musslewhite","email":"dmusslewhite2@microsoft.com","gender":"Female"},
//             {"id":4,"first_name":"Conrade","last_name":"Searle","email":"csearle3@yellowbook.com","gender":"Male"},
//             {"id":5,"first_name":"Bryna","last_name":"Duker","email":"bduker4@webmd.com","gender":"Female"},
//             {"id":6,"first_name":"Karlee","last_name":"Darlaston","email":"kdarlaston5@yahoo.co.jp","gender":"Female"},
//             {"id":7,"first_name":"Francklin","last_name":"Droogan","email":"fdroogan6@dmoz.org","gender":"Male"},
//             {"id":8,"first_name":"Risa","last_name":"Demelt","email":"rdemelt7@webmd.com","gender":"Female"},
//             {"id":9,"first_name":"Izaak","last_name":"Turland","email":"iturland8@symantec.com","gender":"Male"},
//             {"id":10,"first_name":"Mariya","last_name":"Uman","email":"muman9@tinyurl.com","gender":"Female"},
//             {"id":11,"first_name":"Geordie","last_name":"Joslyn","email":"gjoslyna@google.it","gender":"Male"},
//             {"id":12,"first_name":"Lindy","last_name":"Southall","email":"lsouthallb@eventbrite.com","gender":"Female"},
//             {"id":13,"first_name":"Janeva","last_name":"Teodori","email":"jteodoric@wikipedia.org","gender":"Female"},
//             {"id":14,"first_name":"Aileen","last_name":"Bullen","email":"abullend@skyrock.com","gender":"Female"},
//             {"id":15,"first_name":"Harry","last_name":"Voelker","email":"hvoelkere@ifeng.com","gender":"Male"},
//             {"id":16,"first_name":"Nollie","last_name":"Allawy","email":"nallawyf@baidu.com","gender":"Male"},
//             {"id":17,"first_name":"Jemimah","last_name":"Castro","email":"jcastrog@scientificamerican.com","gender":"Female"},
//             {"id":18,"first_name":"Marlee","last_name":"Duckering","email":"mduckeringh@nbcnews.com","gender":"Female"},
//             {"id":19,"first_name":"Kalie","last_name":"Sabate","email":"ksabatei@zimbio.com","gender":"Female"},
//             {"id":20,"first_name":"Belle","last_name":"MacRirie","email":"bmacririej@w3.org","gender":"Female"},
//             {"id":21,"first_name":"Markos","last_name":"Blampy","email":"mblampyk@photobucket.com","gender":"Male"},
//             {"id":22,"first_name":"Rock","last_name":"Massimi","email":"rmassimil@g.co","gender":"Male"},
//             {"id":23,"first_name":"Cirilo","last_name":"Gossage","email":"cgossagem@sciencedaily.com","gender":"Male"},
//             {"id":24,"first_name":"Jacky","last_name":"Serck","email":"jserckn@t-online.de","gender":"Male"},
//             {"id":25,"first_name":"Keefer","last_name":"Ivchenko","email":"kivchenkoo@mit.edu","gender":"Male"},
//             {"id":26,"first_name":"Had","last_name":"Kilian","email":"hkilianp@domainmarket.com","gender":"Male"},
//             {"id":27,"first_name":"Waldon","last_name":"Dunthorne","email":"wdunthorneq@jalbum.net","gender":"Male"},
//             {"id":28,"first_name":"Malia","last_name":"Isoldi","email":"misoldir@wufoo.com","gender":"Female"},
//             {"id":29,"first_name":"Edy","last_name":"Romeuf","email":"eromeufs@exblog.jp","gender":"Female"},
//             {"id":30,"first_name":"Tomaso","last_name":"Tomaszewicz","email":"ttomaszewiczt@pinterest.com","gender":"Male"},
//             {"id":31,"first_name":"Verne","last_name":"Shovlar","email":"vshovlaru@icq.com","gender":"Male"},
//             {"id":32,"first_name":"Read","last_name":"Hambribe","email":"rhambribev@furl.net","gender":"Male"},
//             {"id":33,"first_name":"Edmon","last_name":"Armall","email":"earmallw@php.net","gender":"Male"},
//             {"id":34,"first_name":"Annecorinne","last_name":"Alwen","email":"aalwenx@wordpress.org","gender":"Female"},
//             {"id":35,"first_name":"Ariel","last_name":"Everleigh","email":"aeverleighy@ucoz.ru","gender":"Female"},
//             {"id":36,"first_name":"Cybil","last_name":"Peepall","email":"cpeepallz@time.com","gender":"Female"},
//             {"id":37,"first_name":"Emerson","last_name":"Trood","email":"etrood10@typepad.com","gender":"Male"},
//             {"id":38,"first_name":"Karisa","last_name":"Conway","email":"kconway11@blogspot.com","gender":"Female"},
//             {"id":39,"first_name":"Brigg","last_name":"Lampet","email":"blampet12@tuttocitta.it","gender":"Male"},
//             {"id":40,"first_name":"Shandeigh","last_name":"Zamboniari","email":"szamboniari13@sciencedaily.com","gender":"Female"}
//     ]
// } );

