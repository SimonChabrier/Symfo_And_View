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
// Lorsque cette option est activée, Webpack sépare vos fichiers en morceaux plus petits pour une meilleure optimisation.
.splitEntryChunks()
// demandera un tag script supplémentaire pour runtime.js
// mais vous voudrez probablement ceci, sauf si vous construisez une application monopage
.enableSingleRuntimeChunk()
/*
    * Configurez les fonctionnalités de Webpack en fonction de vos besoins.
    * Activer et configurer d'autres fonctionnalités ci-dessous. Pour une liste complète des fonctionnalités, voir:
    * https://symfony.com/doc/current/frontend.html#adding-more-features
*/
// Nettoyer le répertoire de sortie avant chaque compilation
.cleanupOutputBeforeBuild()
// Activer les notifications de compilation
.enableBuildNotifications()
// Activer la génération de source maps
.enableSourceMaps(!Encore.isProduction())
// activer le hash dans le nom des fichiers (e.g. app.abc123.css)
.enableVersioning(Encore.isProduction())
.configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage';
    config.corejs = 3;
})
// Activer le support de Sass/SCSS avec node-sass
.enableSassLoader()
// Activer le support de Vue.js
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

// décommenter si vous utilisez TypeScript
//.enableTypeScriptLoader()

//  décommenter si vous utilisez React
//.enableReactPreset()

// décommnter pour activer les attributs integrity="..." sur les balises script et link
// nécessite le bundle WebpackEncoreBundle 1.4 ou supérieur
//.enableIntegrityHashes(Encore.isProduction())

// décommnter si vous avez des problèmes avec un plugin jQuery
//.autoProvidejQuery()


module.exports = Encore.getWebpackConfig();