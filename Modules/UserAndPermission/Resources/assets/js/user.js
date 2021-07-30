(function () {
    "use strict";

    const currentUri = window.location.pathname;
    const routes = [
        {
            module: '/modules/user_index.js',
            regex: /^\/dashboard_admin_23644466\/user$/s
        },
        {
            module: '/modules/user_create.js',
            regex: /^\/dashboard_admin_23644466\/user\/create$/s
        },
        {
            module: '/modules/user_edit.js',
            regex: /^\/dashboard_admin_23644466\/user\/[0-9]+\/edit$/s
        },
        {
            module: '/modules/user_profile.js',
            regex: /^\/dashboard_admin_23644466\/user\/profile$/
        }
    ];
    let path;

    for (let i = 0; i < routes.length; i++) {
        if (currentUri.match(routes[i].regex)) {
            path = routes[i].module;
            break;
        }
    }

    if (path) require('.' + path);
})();
