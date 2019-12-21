
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


