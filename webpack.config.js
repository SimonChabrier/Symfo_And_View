const Encore = require('@symfony/webpack-encore');
const path = require('path');
const webpack = require('webpack');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
// le repertoire où les assets compilés seront stockés
.setOutputPath('public/build/')
// le repertoire public utilisé par le serveur web pour accéder au repertoire de sortie
.setPublicPath('/build')
// L'application Vue.js est dans le dossier assets
.addEntry('app', './assets/app.js')

.splitEntryChunks()
.enableSingleRuntimeChunk()
.cleanupOutputBeforeBuild()
.enableBuildNotifications()
.enableSourceMaps(!Encore.isProduction())
.enableVersioning(Encore.isProduction())

.configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage';
    config.corejs = 3;
})

.enableSassLoader()

.enableVueLoader(() => { }, {
    version: 3,
    runtimeCompilerBuild: false,
    useJsx: false,
  })

// Configurer les règles de chargement du scss pour ajouter les variables globales dans l'application Vue.js
Encore.configureLoaderRule('scss', loaderRule => {
loaderRule.oneOf.forEach(rule => {
    rule.use.forEach(loader => {
    if (loader.loader.indexOf('sass-loader') > -1) {
        loader.options.additionalData = `
        @import "./assets/styles/_vars.scss";
        `;
    }
    })
});
})

// Déclarer explicitement les plugins de webpack ici pour ne pas avoir les messages relatifs à ces plugins en console
.addPlugin(new webpack.DefinePlugin({
    __VUE_OPTIONS_API__: false,
    __VUE_PROD_DEVTOOLS__: false,
}))

// Ajouter des alias pour les chemins d'accès aux fichiers sinon Vue ne les trouve pas avec @
.addAliases({
    '@app': path.resolve('assets/js'),
    '@root': path.resolve('assets'),
    '@styles': path.resolve('assets/styles'),
})

module.exports = Encore.getWebpackConfig();