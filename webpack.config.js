const Encore = require('@symfony/webpack-encore');


// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

// webpack define plugin
// const webpack = require('webpack');
// new webpack.DefinePlugin({
//     __VUE_OPTIONS_API__: false,
//     __VUE_PROD_DEVTOOLS__: false,
//   });

Encore    
    // le repertoire où les assets compilés seront stockés
    .setOutputPath('public/build/')
    // le repertoire public utilisé par le serveur web pour accéder au repertoire de sortie
    .setPublicPath('/build')
    // uniquement nécessaire pour les CDN ou déploiement dans un sous-répertoire
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Chaque entrée va générer un fichier JavaScript (e.g. app.js)
     * ajouter un fichier CSS (e.g. app.css) si votre JavaScript importe du CSS.
     * 
     * Je pointe ici vers le fichier app.js qui importe les autres fichiers JS et CSS
     * pour l'application Vue.
     */
    .addEntry('app', './assets/app.js')
    //.addEntry('app', './Vue/src/main.js')

    // activer le bridge Stimulus de Symfony UX (utilisé dans assets/bootstrap.js)
    // .enableStimulusBridge('./assets/controllers.json')

    // Lorsque cette option est activée, Webpack sépare vos fichiers en morceaux plus petits pour une meilleure optimisation.
    .splitEntryChunks()

    // demandera un tag script supplémentaire pour runtime.js
    // mais vous voudrez probablement ceci, sauf si vous construisez une application monopage
    .enableSingleRuntimeChunk()

    /*
     * Configurez les fonctionnalités de Webpack en fonction de vos besoins.
     * 
     * Activer et configurer d'autres fonctionnalités ci-dessous. Pour une liste complète des fonctionnalités, voir:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // activer le hash dans le nom des fichiers (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // activer et configurer les polyfills @babel/preset-env
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // Déclarer le loader de Vue.js et de Sass (pour les fichiers .vue)
    // .enableVueLoader()
    .enableVueLoader(() => {}, { runtimeCompilerBuild: false })

    // enables Sass/SCSS support
    .enableSassLoader()

    // décommenter si vous utilisez TypeScript
    //.enableTypeScriptLoader()

    //  décommenter si vous utilisez React
    //.enableReactPreset()

    // décommnter pour activer les attributs integrity="..." sur les balises script et link
    // nécessite le bundle WebpackEncoreBundle 1.4 ou supérieur
    //.enableIntegrityHashes(Encore.isProduction())

    // décommnter si vous avez des problèmes avec un plugin jQuery
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
