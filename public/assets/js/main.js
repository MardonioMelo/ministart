/*
 *Configurações da lib RequireJS
 */

var baseUrl = window.location.protocol + "//" + window.location.host + "/";

requirejs.config({
    baseUrl: baseUrl + 'public/assets/',
    paths: {
        jquery: "libs/jquery/jquery-3.5.0.min",
        bootstrap4: "libs/bootstrap-4/js/bootstrap.bundle.min",
        // Scripts Especificos de cada módulo
        home: "js/home",
        panel: "js/panel"
    },
    shim: {
        'bootstrap4': {
            deps: ['jquery']
        },

    },
    map: {}
});