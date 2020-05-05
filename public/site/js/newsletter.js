/*
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
*/

(function ($) {
    "use strict";

    /* Newsletter Form */
    $("#newsletterForm").validator().on("submit", function (event) {
        if (event.isDefaultPrevented()) {
            // handle the invalid form...
            nformError();
            nsubmitMSG(false, "Por favor, informe seu melhor e-mail!");
        } else {
            // everything looks good!
            event.preventDefault();
            nsubmitForm();
        }
    });

    function nsubmitForm() {
        // initiate variables with form content
        var email = $("#nemail").val();
        $.ajax({
            type: "POST",
            url: "/newsletter",
            data: "email=" + email,
            dataType: 'JSON',
            success: function (result) {

                if (result.success) {
                    nformSuccess(result.error);
                } else {
                    nformError();
                    nsubmitMSG(false, result.error);
                }
            }
        });
    }

    function nformSuccess(text = '') {
        $("#newsletterForm")[0].reset();
        nsubmitMSG(true, text);
        $("input").removeClass('notEmpty'); // resets the field label after submission
    }

    function nformError() {
        $("#newsletterForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $(this).removeClass();
        });
    }

    function nsubmitMSG(valid, msg) {
        var msgClasses;
        if (valid) {
            msgClasses = "text-center alert alert-success";
        } else {
            msgClasses = "text-center tada animated alert alert-danger";
        }
        $("#nmsgSubmit").removeClass().addClass(msgClasses).text(msg);
    }

})(jQuery);