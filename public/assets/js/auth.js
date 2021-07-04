
let auth = {
    permissions: {},

    init: function () {
        $.ajax({
            headers: CSRF,
            url: window.base_url + "/user/getAuthData",
            type: 'get',
            async: false,
            success: function (permissions, textStatus, xhr) {
                auth.permissions = permissions;
            },

        });
    },
    can: function (type) {
        return this.permissions.indexOf(type) >= 0;
    },



};

auth.init();


