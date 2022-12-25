const Encore = require('@symfony/webpack-encore');
const path = require('path');
const webpack = require('webpack');
const ESLintWebpackPlugin = require('eslint-webpack-plugin');

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
    __VUE_OPTIONS_API__: true,
    __VUE_PROD_DEVTOOLS__: true,
}))

// Ajouter des alias pour les chemins d'accès aux fichiers sinon Vue ne les trouve pas avec @
.addAliases({
    
    '@root': path.resolve('assets'),
    '@styles': path.resolve('assets/styles'),
    '@app': path.resolve('assets/js'),
    '@view': path.resolve('assets/js/views'),
    "@comp": path.resolve('assets/js/components'),
    "@utils": path.resolve('assets/js/utils'),
    
})

// Ajouter un plugin pour linter les fichiers js 
// ne pas mettre vu et js dans les extensions sinon il y a des erreurs
// la config est ensuite faire dans .eslintrc 
.addPlugin(new ESLintWebpackPlugin({
    extensions: ['ts'],
}))

module.exports = Encore.getWebpackConfig(); 


