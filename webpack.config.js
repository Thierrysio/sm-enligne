var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    // the public path you will use in Symfony's asset() function - e.g. asset('build/some_file.js')
    .setManifestKeyPrefix('build/')

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())

    // the following line enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app', './assets/scss/global.scss')
    .addStyleEntry('css/index', './assets/scss/index.scss')
    .addStyleEntry('css/liste', './assets/scss/liste.scss')
    .addStyleEntry('css/carte', './assets/scss/carte.scss')
    .addStyleEntry('css/details', './assets/scss/details.scss')
    .addStyleEntry('css/profil', './assets/scss/profil.scss')
    .addStyleEntry('css/creationRestaurant', './assets/scss/creationRestaurant.scss')
    .addStyleEntry('css/tableau', './assets/scss/tableau.scss')

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
    
     
    .enableSassLoader(function(options) {
        // https://github.com/sass/node-sass#options
        // options.includePaths = [...]
    });

;

module.exports = Encore.getWebpackConfig();
