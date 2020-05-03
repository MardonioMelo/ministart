define(['jquery', 'bootstrap4'], function ($) {

    importCSS = function (link_css) {
        $('head').append('<link rel="stylesheet" type="text/css" href="' + link_css + '">');
    };

    //Função para ler URL
    getUrl = function (str, position) {
        var result = false;
        var vars;
        var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('/');
        vars = url.filter(function (el) {
            return el !== "";
        });
        vars.splice(0, 2);
        if (str === vars[position]) {
            result = true;
        }
        return result;
    };
});
