// ES6 Modules
import { resolveDpr } from "@google/model-viewer/lib/utilities";
import tingle from "tingle.js";

(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).on('load', function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practice to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $(function () {
        // Destructure the 'wp.i18n' object to extract the '__' function for internationalization in WordPress.
        const {
            __
        } = wp.i18n;

        // Check if the radio button with ID 'byrst_woocommerce_plugin_ar2' is checked.
        if ($('#byrst_woocommerce_plugin_ar2').is(':checked')) {
            // If checked, hide various configuration elements related to this setting.
            $('.cmb2-id-byrst-woocommerce-plugin-ar-modes').hide();
            $('.cmb2-id-byrst-woocommerce-plugin-ar-scale').hide();
            $('.cmb2-id-byrst-woocommerce-plugin-ar-placement').hide();
            $('.cmb2-id-byrst-woocommerce-plugin-xr-environment').hide();
            $('#cmb2-id-byrst-woocommerce-plugin-ar-settings').hide();
            $('.cmb2-id-byrst-woocommerce-plugin-ar-button').hide();
        }

        // Check if the radio button with ID 'byrst_woocommerce_plugin_ar_button2' is checked.
        if ($('#byrst_woocommerce_plugin_ar_button2').is(':checked')) {
            // If checked, hide button-related configuration elements.
            $('.cmb2-id-byrst-woocommerce-plugin-ar-button-text').hide();
            $('.cmb2-id-byrst-woocommerce-plugin-ar-button-background-color').hide();
            $('.cmb2-id-byrst-woocommerce-plugin-ar-button-text-color').hide();
        }

        $('#byrst_woocommerce_plugin_btn').on('change', function () {
            $('#submit-cmb').click();
        });

        // Detectar cambios en los radio buttons del grupo específico
        $('input[name="byrst_woocommerce_plugin_single_product_tabs"]').on('change', function () {
            // Verifica si un radio button específico está seleccionado
            // Reemplaza 'valor_especifico' con el valor del radio button que quieres comprobar
            if ($('input[name="byrst_woocommerce_plugin_single_product_tabs"]:checked').val() === 'yes') {
                // Acción a realizar cuando el radio button específico está seleccionado
                // Por ejemplo, hacer clic en un botón con el ID 'id_del_otro_boton'
                $('#submit-cmb').click();
            } else {
                // Acción opcional a realizar cuando otro radio button está seleccionado
                $('#submit-cmb').click();
            }
        });

        // Hide the element with ID 'byrst-button-pair'.
        $('#byrst-button-pair').prop('disabled', true);

        // Initializes a modal specifically for displaying error messages, using tingle.js.
        // This modal is configured with options that make it suitable for alerting users to errors, with a customizable appearance and behavior.
        var errorModal = new tingle.modal({
            footer: true, // Enables the footer area of the modal, allowing for additional content like buttons.
            stickyFooter: false, // Disables sticky footer, meaning the footer does not stay visible when scrolling the modal content.
            closeMethods: ['overlay'], // Allows the modal to be closed by clicking the overlay, pressing a button, or hitting the escape key.
            onOpen: function () {
                //console.log('Error modal opened'); // Logs to the console when the error modal is opened, useful for debugging.
            },
            onClose: function () {
                //console.log('Error modal closed'); // Logs to the console when the error modal is closed.
            },
            beforeClose: function () {
                return true; // Allows the modal to close, can be used to perform checks or cleanup before the modal closes.
            }
        });

        // Adds a confirmation button to the footer of the error modal.
        // This button provides a clear, user-friendly way to acknowledge and dismiss the error message.
        errorModal.addFooterBtn('OK', 'tingle-btn tingle-btn--primary', function () {
            errorModal.close(); // Closes the error modal when the button is clicked.
        });

        // Declares a variable to hold the current callback function to be executed after the success modal closes.
        // This allows for dynamic assignment and execution of callbacks based on the application's state or user actions.
        var currentSuccessCallback = null;

        // Initializes a modal for displaying success messages, configured similarly to the error modal but without a footer,
        // indicating that success messages might not require explicit user acknowledgement to close.
        var successModal = new tingle.modal({
            footer: false, // Disables the footer for the success modal.
            stickyFooter: false, // Keeps the sticky footer option disabled.
            closeMethods: ['overlay'], // Allows closing the modal through various user actions.
            onOpen: function () {
                //console.log('Success modal opened'); // Logs the opening of the success modal, useful for debugging.
            },
            onClose: function () {
                //console.log('Modal closed'); // Logs when the modal closes.
                // Executes the current success callback function if it's defined, then resets the callback to prevent repeated calls.
                if (typeof currentSuccessCallback === 'function') {
                    currentSuccessCallback();
                    currentSuccessCallback = null;
                }
            },
            beforeClose: function () {
                return true; // Allows the modal to close, can be used for additional checks or cleanup before closure.
            }
        });


        // Initializes a modal dedicated to showing loading alerts during operations that require waiting, using tingle.js.
        // This modal is designed to provide visual feedback to the user that a process is ongoing and to prevent user actions by disabling close methods.
        var loadingModal = new tingle.modal({
            closeMethods: [], // Disables methods to close the modal, such as clicking outside or pressing the ESC key, to prevent interrupting the loading process.
            cssClass: ['loading-modal'] // Applies custom CSS classes for styling the loading modal, allowing for visual customization.
        });

        // Sets the content of the loading modal, typically including a message and possibly a visual indicator like a spinner.
        // This content informs the user that processing is taking place and that they should wait.
        const modalContent = `
		<div style="text-align: left;">
    			<h2>${__('Processing...', 'byrst-3d-for-woocommerce')}</h2>
    			<p>${__('Please wait.', 'byrst-3d-for-woocommerce')}</p>
		</div>`;

		// Estableciendo el contenido en el modal
		loadingModal.setContent(modalContent);

        // This function is used to display the loading alert to the user by opening the modal.
        // It can be called at the beginning of operations that take a noticeable amount of time to complete, providing immediate feedback that the process has started.
        function showLoadingAlert() {
            loadingModal.open();
        }

        // This function is used to hide the loading alert once the operation requiring the wait is completed.
        // By closing the modal, it informs the user that they can now continue interacting with the application.
        function hideLoadingAlert() {
            loadingModal.close();
        }

        // This function is designed to display a modal alert with an error message using tingle.js.
        // It serves as a centralized way to show error alerts throughout an application,
        // ensuring a consistent appearance and behavior for error messaging.
        // The function accepts two parameters, errorTitle and errorMessage, which are used to set the modal's content dynamically.
        // This allows for flexibility in displaying different error messages as needed.
        function showErrorAlert(errorTitle, errorMessage) {
            // Sets the content of the error modal dynamically based on the provided title and message,
            // ensuring the displayed message is relevant to the specific error condition.
            errorModal.setContent(`<h1>${errorTitle}</h1><p>${errorMessage}</p>`);
            // Opens the modal, displaying the error message to the user.
            errorModal.open();
        }


        // This function displays a modal alert with a success message using tingle.js. 
        // It allows for dynamic content by accepting a title and message as parameters, 
        // and optionally takes a callback function to execute additional logic after the modal is closed.
        // The modal's content is set based on the provided title and message,
        // and it automatically closes after a short delay (1.2 seconds), 
        // after which any provided callback function is executed.
        function showSuccessAlert(successTitle, successMessage, callback = null) {
            // Sets the current callback function to the one provided, or null if none is provided.
            currentSuccessCallback = callback;

            // Sets the modal content using the provided title and message, wrapping them in HTML tags.
            successModal.setContent(`<h1>${successTitle}</h1><p>${successMessage}</p>`);
            // Opens the modal to display to the user.
            successModal.open();

            // Optionally: closes the modal automatically after a set time period (1200 milliseconds/1.2 seconds).
            setTimeout(() => {
                successModal.close();
                // If a callback function was provided, it is executed after the modal closes.
                if (callback) {
                    callback();
                }
            }, 1200);
        }


        // This function validates input elements with the class 'input-ios' to ensure they only contain alphanumeric characters. 
        // It concatenates the values of these inputs and checks if the concatenated result is exactly 5 characters long.
        // If all inputs are valid and the concatenated string meets the length requirement, it displays a success alert using a centralized alert function,
        // enables a specific button, and returns the concatenated string. 
        // If the validation fails due to invalid input or the concatenated string does not meet the length requirement, 
        // it either displays an error alert or disables the button, depending on the type of validation failure.
        function verifyAndConcatenate() {
            // Initialize a variable for the concatenated value.
            var concatenatedValue = '';
            // Initialize a flag to track if all inputs are valid.
            var isValid = true;

            // Iterate over each input element with class 'input-ios'.
            $('.input-ios').each(function () {
                // Get the current input's value.
                var value = $(this).val();
                // Check if the value contains only alphanumeric characters.
                if (/^[a-zA-Z0-9]*$/.test(value)) {
                    // If valid, append the value to the concatenated string.
                    concatenatedValue += value;
                } else {
                    // If invalid, set the isValid flag to false.
                    isValid = false;
                }
            });

            // If all values are valid, check additional conditions.
            if (isValid) {
                // Check if the concatenated string is exactly 5 characters long.
                if (concatenatedValue.length === 5) {
                    // Display a success message using the centralized function.
                    showSuccessAlert(
                        'Success', // Sets the title of the success message.
                        'Valid code entered.' // Sets the content of the success message.
                    );

                    $('#byrst-button-pair').prop('disabled', false); // Enables the button with the ID 'byrst-button-pair'

                    return concatenatedValue; // Returns the valid concatenated value
                } else {
                    $('#byrst-button-pair').prop('disabled', true); // Disables the button if the condition is not met
                }
            } else {
                // Display an error alert if any input is invalid.
                showErrorAlert(
                    'Error', // Sets the title of the error message.
                    'Only numbers and letters are allowed.' // Sets the content of the error message.
                );
            }
        }

        // Bind an 'input' event handler to all elements with class 'input-ios'.
        $('.input-ios').on('input', function () {
            // Transform the value of the input to uppercase and get the updated value.
            var currentValue = $(this).val($(this).val().toUpperCase()).val();

            // Call the verifyAndConcatenate function on input change.
            verifyAndConcatenate();

            if (currentValue.length >= this.maxLength) {
                // If input reaches its maximum length, move focus to the next input field.
                $(this).closest('.control').next('.control').find('.input-ios').focus();
            } else if (currentValue.length === 0) {
                // If input is empty, move focus to the previous input field.
                $(this).closest('.control').prev('.control').find('.input-ios').focus();
            }
        });

        // Binds a click event handler to the button with the ID 'byrst-button-pair'.
        $('#byrst-button-pair').click(function (e) {
            e.preventDefault(); // Prevents the default action of the button, such as submitting a form.

            // Obtain the validated claimId
            var claimId = verifyAndConcatenate(); // Calls a custom function to validate and concatenate input values.

            // Show a loading alert using tingle.js
            showLoadingAlert(); // Displays a loading alert to inform the user that processing is taking place.

            // Perform an AJAX request to a server
            $.ajax({
                type: "POST", // Specifies the method of the request as POST.
                url: ajax_object_settings.ajax_url, // Defines the URL to which the request is sent.
                data: {
                    action: 'byrst_settings_save_claim_id_and_token', // Data specifying the action to be performed on the server.
                    security: ajax_object_settings.security, // Includes a security nonce for verification to prevent CSRF attacks.
                    claim_id: claimId // Sends the validated claimId as part of the request.
                },
                dataType: "json", // Indicates that the response should be in JSON format.
                success: function (response) {
                    // Hide the loading alert
                    hideLoadingAlert(); // Hides the loading alert once the AJAX request is completed.

                    // Handles a successful AJAX request
                    if (response.success) {
                        // If the server response indicates success, display a success message.
                        showSuccessAlert(__('Success', 'byrst-3d-for-woocommerce'), response.data.message, function () {
                            $("#submit-cmb").click(); // Optionally, trigger another action after showing the success alert, like reloading the page.
                        });
                    } else {
                        // If the server response indicates failure, display an error message.
                        showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), response.data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Hide the loading alert
                    hideLoadingAlert(); // Hides the loading alert if the AJAX request itself fails.

                    // Handles errors from the AJAX request
                    var errorMessage; // Initializes a variable to hold the error message.

                    // Conditional checks to determine the type of error based on the jqXHR status and set an appropriate message
                    if (jqXHR.status === 0) {
                        errorMessage = __('Not connect: Verify Network.', 'byrst-3d-for-woocommerce');
                    } else if (jqXHR.status == 404) {
                        errorMessage = __('Requested page not found [404].', 'byrst-3d-for-woocommerce');
                    } else if (jqXHR.status == 500) {
                        errorMessage = __('Internal Server Error [500].', 'byrst-3d-for-woocommerce');
                    } else if (textStatus === 'parsererror') {
                        errorMessage = __('Requested JSON parse failed.', 'byrst-3d-for-woocommerce');
                    } else if (textStatus === 'timeout') {
                        errorMessage = __('Time out error.', 'byrst-3d-for-woocommerce');
                    } else if (textStatus === 'abort') {
                        errorMessage = __('AJAX request aborted.', 'byrst-3d-for-woocommerce');
                    } else {
                        errorMessage = __('Uncaught Error:', 'byrst-3d-for-woocommerce') + jqXHR.responseText;
                    }

                    // Displays an error message using the showErrorAlert function
                    showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), errorMessage); // Uses a centralized function to display an error alert.
                }
            });
        });

        // Attaching a click event listener to the element with the ID 'byrst-button-unpair'.
        $('#byrst-button-unpair').click(function (e) {
            e.preventDefault(); // Prevents the default action of the button, such as submitting a form.

            // Executes an AJAX POST request
            $.ajax({
                type: "POST", // Specifies the method of the request.
                url: ajax_object_settings.ajax_url, // URL for the AJAX request, usually a WordPress AJAX handler URL.
                data: {
                    action: 'byrst_settings_remove_claim_id_and_token', // Data specifying the action to be called in WordPress.
                    security: ajax_object_settings.security, // Security nonce for verification purposes.
                },
                dataType: "json", // Specifies that the response should be in JSON format.

                // Function to handle the response upon a successful request.
                success: function (response) {
                    if (response.success) {
                        // Shows a success alert using the centralized showSuccessAlert function
                        // if the AJAX request was successful and returned a success status.
                        showSuccessAlert(
                            __('Success', 'byrst-3d-for-woocommerce'), // Title of the success alert (localized).
                            response.data.message, // Message displayed in the alert, from the AJAX response.
                            function () {
                                location.reload(); // Reloads the page after the alert is closed.
                            }
                        );
                    } else {
                        // Shows an error alert using the centralized showErrorAlert function
                        // if the AJAX request was successful but returned a failure status.
                        showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), response.data.message);
                    }
                },

                // Error handler for the AJAX request.
                error: function (jqXHR, textStatus, errorThrown) {
                    // Determines the error message based on the failure reason.
                    var errorMessage;
                    if (jqXHR.status === 0) {
                        errorMessage = __('Not connect: Verify Network.', 'byrst-3d-for-woocommerce');
                    } else if (jqXHR.status == 404) {
                        errorMessage = __('Requested page not found [404].', 'byrst-3d-for-woocommerce');
                    } else if (jqXHR.status == 500) {
                        errorMessage = __('Internal Server Error [500].', 'byrst-3d-for-woocommerce');
                    } else if (textStatus === 'parsererror') {
                        errorMessage = __('Requested JSON parse failed.', 'byrst-3d-for-woocommerce');
                    } else if (textStatus === 'timeout') {
                        errorMessage = __('Time out error.', 'byrst-3d-for-woocommerce');
                    } else if (textStatus === 'abort') {
                        errorMessage = __('AJAX request aborted.', 'byrst-3d-for-woocommerce');
                    } else {
                        errorMessage = __('Uncaught Error:', 'byrst-3d-for-woocommerce') + jqXHR.responseText;
                    }

                    // Shows an error alert using the centralized showErrorAlert function
                    // if the AJAX request itself failed.
                    showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), errorMessage);
                }
            });
        });
    });
})(jQuery);