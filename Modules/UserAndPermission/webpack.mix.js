const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');
mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'static/backend/js/app.js')
    .js(__dirname + '/Resources/assets/js/user.js', 'static/backend/js/user.js')
    .js(__dirname + '/Resources/assets/js/group.js', 'static/backend/js/group.js')
    .js(__dirname + '/Resources/assets/js/history.js', 'static/backend/js/history.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'static/backend/css/userandpermission.css');

if (mix.inProduction()) {
    mix.version();
}
