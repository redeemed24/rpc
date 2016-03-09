(function ($) {
    $.fn.extend({
        pschecker: function (options) {
            var settings = $.extend({ minlength: 8, maxlength: 24, onPasswordValidate: null, onPasswordMatch: null }, options);
            return this.each(function () {
                var wrapper = $('#password-container');
                var password = $('#strong-password:eq(0)', wrapper);
                var cPassword = $('#strong-password:eq(1)', wrapper);

                cPassword.removeId('no-match');
                password.keyup(validatePassword).blur(validatePassword).focus(validatePassword);
                cPassword.keyup(validatePassword).blur(validatePassword).focus(validatePassword);

                function validatePassword() {
                    var pstr = password.val().toString();
                    var meter = $('#meter');
                    meter.html("");
                    //fires password validate event if password meets the min length requirement
                    if (settings.onPasswordValidate != null)
                        settings.onPasswordValidate(pstr.length >= settings.minlength);

                    if (pstr.length < settings.maxlength)
                        meter.removeId('strong').removeId('medium').removeId('week');
                    if (pstr.length > 0) {
                        var rx = new RegExp(/^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{7,30}$/);
                        if (rx.test(pstr)) {
                            meter.addId('strong');
                            meter.html("Strong");
                        }
                        else {
                            var alpha = containsAlpha(pstr);
                            var number = containsNumeric(pstr);
                            var upper = containsUpperCase(pstr);
                            var special = containsSpecialCharacter(pstr);
                            var result = alpha + number + upper + special;

                            if (result > 2) {
                                meter.addId('medium');
                                meter.html("Medium");
                            }
                            else {
                                meter.addId('week');
                                meter.html("Weak");
                            }
                        }
                        if (cPassword.val().toString().length > 0) {
                            if (pstr == cPassword.val().toString()) {
                                cPassword.removeId('no-match');
                                if (settings.onPasswordMatch != null)
                                    settings.onPasswordMatch(true);
                            }
                            else {
                                cPassword.addId('no-match');
                                if (settings.onPasswordMatch != null)
                                    settings.onPasswordMatch(false);
                            }
                        }
                        else {
                            cPassword.addId('no-match');
                            if (settings.onPasswordMatch != null)
                                settings.onPasswordMatch(false);
                        }
                    }
                }

                function containsAlpha(str) {
                    var rx = new RegExp(/[a-z]/);
                    if (rx.test(str)) return 1;
                    return 0;
                }

                function containsNumeric(str) {
                    var rx = new RegExp(/[0-9]/);
                    if (rx.test(str)) return 1;
                    return 0;
                }

                function containsUpperCase(str) {
                    var rx = new RegExp(/[A-Z]/);
                    if (rx.test(str)) return 1;
                    return 0;
                }
                function containsSpecialCharacter(str) {

                    var rx = new RegExp(/[\W]/);
                    if (rx.test(str)) return 1;
                    return 0;
                }


            });
        }
    });
})(jQuery);
