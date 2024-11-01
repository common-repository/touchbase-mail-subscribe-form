// Shortcode Form jQuery Plugin

(function ($) {

    $.fn.touchbaseForm = function (methodOrOptions) {

        // Permanence for in $.each
        var call = methodOrOptions,
            callArguments = arguments;

        var methods = {
            init: function () {
                var $this = $(this),
                    $email = $this.find('input[name="email"]'),
                    $success = $this.find('.touchbasemail-subscribe-form-success'),
                    $error = $this.find('.touchbasemail-subscribe-form-error'),
                    $response = $this.find('.touchbasemail-subscribe-form-error-response'),
                    $submit = $this.find('input[type="submit"]');

                // Prevent double init calls.
                if($this.data('touchbasemail-subscribe-form-plugin')) {
                    console.log('[touchbasemail-subscribe-form] Preventing duplicate instance for this form.');
                    return;
                }
                $this.data('touchbasemail-subscribe-form-plugin', true);

                $email.keyup(function () {
                    $error.hide();
                });

                $email.change(function () {
                    $error.hide();
                });

                $this.submit(function (e) {
                    $error.hide();

                    // Disable default form action
                    e.preventDefault();

                    // Some quick sanity
                    if ($email.val() === '') {
                        $error.show();
                        return false;
                    }

                    // Disable button
                    $submit.prop('disabled', true);


                    // Send subscribe request to Touchbase
                    $.ajax({
                        url: 'https://clients.touchbasemail.net/api/v1/subscriptions/new',
                        dataType: 'json',
                        type: 'post',
                        data: $this.serialize(),
                        success: function (obj) {

                            // Re-enable button
                            $submit.prop('disabled', false);

                            if (obj.id > 0) {
                                // Show success message
                                $email.val('');
                                $success.show();
                                $success.delay(1500).fadeOut();
                            } else {
                                // Display error
                                console.log('[touchbasemail-subscribe-form] Subscribe error: ', obj);
                                $response.text(obj.error);
                                $error.show();
                            }

                        },
                        error: function (xhr, err) {

                            // Re-enable button
                            $submit.prop('disabled', false);

                            // Try to parse error
                            try {
                                var obj = JSON.parse(xhr.responseText);

                                // Show parsed error message
                                console.log('[touchbasemail-subscribe-form] Subscribe error: ', xhr, err);
                                $response.text(obj.error);
                                $error.show();
                            } catch (e) {
                                // Fall back to generic error message
                                console.log('[touchbasemail-subscribe-form] Subscribe error: ', xhr, err, e);
                                $response.text('');
                                $error.show();
                            }
                        }
                    });
                });
            }
        };

        // As the plugin can be applied to multiple elements
        return this.each(function () {
            if (methods[call]) {
                return methods[call].apply(this, Array.prototype.slice.call(callArguments, 1));
            } else if (typeof call === 'object' || !call) {
                // Default to "init"
                return methods.init.apply(this, callArguments);
            } else {
                $.error('[touchbasemail-subscribe-form] Method ' + call + ' does not exist on jQuery.touchbaseForm');
            }
        });

    };

    // Automatically apply to forms
    $(document).ready(function () {
        $('.touchbasemail-subscribe-form').touchbaseForm();
    });
}(jQuery));
