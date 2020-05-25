$(document).ready(function () {
    $('#registerForm').submit(function (e) {
        e.preventDefault();

        const emailEl = $("#email");
        const usernameEl = $("#username");
        const emailValue = emailEl.val();
        const endpoint = "https://open.kickbox.com/v1/disposable/";

        if (emailValue.length > 0 && emailEl.hasClass('valid') && usernameEl.hasClass('valid')) {
            $.ajax({
                url: endpoint + encodeURIComponent(emailValue),
                success: function (data) {
                    if (!data.disposable) {
                        $.ajax({
                            type: "POST",
                            url: 'register',
                            data: {
                                username: usernameEl.val(),
                                email: emailEl.val(),
                                gRecaptchaResponse: $('#gRecaptchaResponse').val()
                            },
                            success: function (data) {
                                if (data.error) {
                                    showErrorMessage(data.errorMessage);
                                } else {
                                    window.location.href = '/home';
                                }
                            }
                        });
                    } else {
                        showErrorMessage('Choose a non-disposable email');
                    }
                }
            });
        }
    }).validate({
        rules: {
            username: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            }
        }
    });

    const showErrorMessage = (errorMessage) => {
        $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-danger").slideUp(500);
        });
        $('.alert-message').text(errorMessage);
        $('#email').removeClass('valid').addClass('error');
    }
});