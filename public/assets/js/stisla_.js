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

let notify = {
    serverError: function () {
        iziToast.error({
            title: 'Oops!',
            message: 'Unable to establish a conntection with the server!',
            position: 'topRight',
            timeout: 5000,
        });
    },
    unauthorized: function () {
        iziToast.error({
            title: 'Whooow!',
            message: 'This Action is Unauthorized',
            position: 'topRight',
            timeout: 5000,
        });
    }
};


let CSRF = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};


let auth = {
    permissions: {},

    init: function () {
        $.ajax({
            headers: CSRF,
            url: window.base_url + "/user/getAuthData",
            type: 'get',
            async: false,
            success: function (data, textStatus, xhr) {
                auth.permissions = data['permissions'];


            },

        });
    },
    can: function (type) {

        switch (type) {
            case 'create':
                return auth.permissions[0]['create'];
            case 'read':
                return auth.permissions[0]['read'];
            case 'update':
                return auth.permissions[0]['update'];
            case 'delete':
                return auth.permissions[0]['delete']
        }
    },


};

auth.init();



