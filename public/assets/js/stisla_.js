let spinButton = {

    start: function (element, type) {

        if (type === '' || type === undefined) {
            element.addClass('btn-progress');
            element.css('color', 'transparent')

        } else {
            element.addClass('btn-progress-' + type);
            element.css('color', 'transparent')
        }


    },

    stop: function (element, type) {
        if (type === '' || type === undefined) {
            element.removeClass('btn-progress');
            element.css('color', '')
        } else {
            element.removeClass('btn-progress-' + type);
            element.css('color', '')
        }
    }

};



iziToast.settings({
    timeout: 5000,
    resetOnHover: true,
    icon: 'material-icons',
    position: 'topRight',
});

let notify = {
    serverError: function () {
        iziToast.error({
            title: 'Oops!',
            message: 'Unable to establish a conntection with the server!',
        });
    },
    unauthorized: function () {
        iziToast.error({
            title: 'Oops!',
            message: 'This Action is Unauthorized',
        });
    },
    error:function (message) {
        iziToast.error({
            title: 'Oops!',
            message: message,
        });
    },
    success:function (message) {
        iziToast.success({
            title: 'Yayy..!',
            message: message,
        });
    }
};


let DtableDefaultSetting = {
    "bProcessing": false,
    "bServerSide": false,
    language: {
        // processing: "<div class=\"dot-floating\"></div>",
        loadingRecords : "<img src="+ base_url +'/images/app_data/preloaders/double_ring_s.gif'+">"
    },
    dom: 'lrtip',
    "drawCallback": function( settings ) {
        initTooltips();
    },
    "pageLength": 50
};




