define(['jquery', 'panel'], function ($) {


    //Executar funções conforme link
    switch (true) {

        case getUrl('panel', 0):
            $('p').append('ok');
            console.log('panel');
            break;

        case getUrl('home', 1):

            break;

        case getUrl('politica', 1):

            break;

        default:
            console.log("Página desconhecida!");
            break;
    }

});
