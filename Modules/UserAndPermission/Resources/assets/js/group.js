(function () {
    "use strict";

    const currentUri = window.location.pathname;
    const routes = [
        {
            module: '/modules/group_index.js',
            regex: /^\/dashboard_admin_23644466\/group$/s
        },
        {
            module: '/modules/group_create.js',
            regex: /^\/dashboard_admin_23644466\/group\/create$/s
        },
        {
            module: '/modules/group_edit.js',
            regex: /^\/dashboard_admin_23644466\/group\/[0-9]+\/edit$/s
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
