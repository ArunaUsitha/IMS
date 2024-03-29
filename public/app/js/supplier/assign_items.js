$(document).ready(function () {
    $('#itemSearch').select2({
        closeOnSelect : false,
        allowHtml: true,
        allowClear: true,
        tags: true,
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
                 results : $.map(JSON.parse(data.results), function (item) {
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
        minimumInputLength: 2   ,
    });


    //supplier serch
    $('#supplierSearch').select2({
        closeOnSelect : false,
        allowHtml: true,
        allowClear: true,
        // tags: true,
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
                    results : $.map(JSON.parse(data.results), function (item) {
                        return {
                            id: item.id,
                            text: item.name
                        };
                    })
                };
            },
        },
        cache: false,
        placeholder: 'Search for a Supplier',
        minimumInputLength: 2   ,
    });



});


// $(document).ready(function () {


// $("#itemSearch").select2({
//     ajax: {
//         url: "https://api.github.com/search/repositories",
//         dataType: 'json',
//         delay: 250,
//         data: function (params) {
//             return {
//                 q: params.term, // search term
//                 page: params.page
//             };
//         },
//         processResults: function (data, params) {
//             // parse the results into the format expected by Select2
//             // since we are using custom formatting functions we do not need to
//             // alter the remote JSON data, except to indicate that infinite
//             // scrolling can be used
//             params.page = params.page || 1;
//
//             return {
//                 results: data.items,
//                 pagination: {
//                     more: (params.page * 30) < data.total_count
//                 }
//             };
//         },
//         cache: true
//     },
//     placeholder: 'Search for a repository',
//     minimumInputLength: 1,
//     templateResult: formatRepo,
//     templateSelection: formatRepoSelection
// });
//
// function formatRepo (repo) {
//     if (repo.loading) {
//         return repo.text;
//     }
//
//     var $container = $(
//         "<div class='select2-result-repository clearfix'>" +
//         "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
//         "<div class='select2-result-repository__meta'>" +
//         "<div class='select2-result-repository__title'></div>" +
//         "<div class='select2-result-repository__description'></div>" +
//         "<div class='select2-result-repository__statistics'>" +
//         "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
//         "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
//         "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
//         "</div>" +
//         "</div>" +
//         "</div>"
//     );
//
//     $container.find(".select2-result-repository__title").text(repo.full_name);
//     $container.find(".select2-result-repository__description").text(repo.description);
//     $container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
//     $container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
//     $container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");
//
//     return $container;
// }
//
// function formatRepoSelection (repo) {
//     return repo.full_name || repo.text;
// }
// })
