/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ([
/* 0 */,
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;!function(t,o){ true?!(__WEBPACK_AMD_DEFINE_FACTORY__ = (o),
		__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
		(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
		__WEBPACK_AMD_DEFINE_FACTORY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)):0}(this,function(){var o=!1;function t(t){this.opts=function(){for(var t=1;t<arguments.length;t++)for(var o in arguments[t])arguments[t].hasOwnProperty(o)&&(arguments[0][o]=arguments[t][o]);return arguments[0]}({},{onClose:null,onOpen:null,beforeOpen:null,beforeClose:null,stickyFooter:!1,footer:!1,cssClass:[],closeLabel:"Close",closeMethods:["overlay","button","escape"]},t),this.init()}function e(){this.modalBoxFooter&&(this.modalBoxFooter.style.width=this.modalBox.clientWidth+"px",this.modalBoxFooter.style.left=this.modalBox.offsetLeft+"px")}return t.prototype.init=function(){if(!this.modal)return function(){this.modal=document.createElement("div"),this.modal.classList.add("tingle-modal"),0!==this.opts.closeMethods.length&&-1!==this.opts.closeMethods.indexOf("overlay")||this.modal.classList.add("tingle-modal--noOverlayClose");this.modal.style.display="none",this.opts.cssClass.forEach(function(t){"string"==typeof t&&this.modal.classList.add(t)},this),-1!==this.opts.closeMethods.indexOf("button")&&(this.modalCloseBtn=document.createElement("button"),this.modalCloseBtn.type="button",this.modalCloseBtn.classList.add("tingle-modal__close"),this.modalCloseBtnIcon=document.createElement("span"),this.modalCloseBtnIcon.classList.add("tingle-modal__closeIcon"),this.modalCloseBtnIcon.innerHTML='<svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg"><path d="M.3 9.7c.2.2.4.3.7.3.3 0 .5-.1.7-.3L5 6.4l3.3 3.3c.2.2.5.3.7.3.2 0 .5-.1.7-.3.4-.4.4-1 0-1.4L6.4 5l3.3-3.3c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0L5 3.6 1.7.3C1.3-.1.7-.1.3.3c-.4.4-.4 1 0 1.4L3.6 5 .3 8.3c-.4.4-.4 1 0 1.4z" fill="#000" fill-rule="nonzero"/></svg>',this.modalCloseBtnLabel=document.createElement("span"),this.modalCloseBtnLabel.classList.add("tingle-modal__closeLabel"),this.modalCloseBtnLabel.innerHTML=this.opts.closeLabel,this.modalCloseBtn.appendChild(this.modalCloseBtnIcon),this.modalCloseBtn.appendChild(this.modalCloseBtnLabel));this.modalBox=document.createElement("div"),this.modalBox.classList.add("tingle-modal-box"),this.modalBoxContent=document.createElement("div"),this.modalBoxContent.classList.add("tingle-modal-box__content"),this.modalBox.appendChild(this.modalBoxContent),-1!==this.opts.closeMethods.indexOf("button")&&this.modal.appendChild(this.modalCloseBtn);this.modal.appendChild(this.modalBox)}.call(this),function(){this._events={clickCloseBtn:this.close.bind(this),clickOverlay:function(t){var o=this.modal.offsetWidth-this.modal.clientWidth,e=t.clientX>=this.modal.offsetWidth-15,s=this.modal.scrollHeight!==this.modal.offsetHeight;if("MacIntel"===navigator.platform&&0==o&&e&&s)return;-1!==this.opts.closeMethods.indexOf("overlay")&&!function(t,o){for(;(t=t.parentElement)&&!t.classList.contains(o););return t}(t.target,"tingle-modal")&&t.clientX<this.modal.clientWidth&&this.close()}.bind(this),resize:this.checkOverflow.bind(this),keyboardNav:function(t){-1!==this.opts.closeMethods.indexOf("escape")&&27===t.which&&this.isOpen()&&this.close()}.bind(this)},-1!==this.opts.closeMethods.indexOf("button")&&this.modalCloseBtn.addEventListener("click",this._events.clickCloseBtn);this.modal.addEventListener("mousedown",this._events.clickOverlay),window.addEventListener("resize",this._events.resize),document.addEventListener("keydown",this._events.keyboardNav)}.call(this),document.body.appendChild(this.modal,document.body.firstChild),this.opts.footer&&this.addFooter(),this},t.prototype._busy=function(t){o=t},t.prototype._isBusy=function(){return o},t.prototype.destroy=function(){null!==this.modal&&(this.isOpen()&&this.close(!0),function(){-1!==this.opts.closeMethods.indexOf("button")&&this.modalCloseBtn.removeEventListener("click",this._events.clickCloseBtn);this.modal.removeEventListener("mousedown",this._events.clickOverlay),window.removeEventListener("resize",this._events.resize),document.removeEventListener("keydown",this._events.keyboardNav)}.call(this),this.modal.parentNode.removeChild(this.modal),this.modal=null)},t.prototype.isOpen=function(){return!!this.modal.classList.contains("tingle-modal--visible")},t.prototype.open=function(){if(!this._isBusy()){this._busy(!0);var t=this;return"function"==typeof t.opts.beforeOpen&&t.opts.beforeOpen(),this.modal.style.removeProperty?this.modal.style.removeProperty("display"):this.modal.style.removeAttribute("display"),document.getSelection().removeAllRanges(),this._scrollPosition=window.pageYOffset,document.body.classList.add("tingle-enabled"),document.body.style.top=-this._scrollPosition+"px",this.setStickyFooter(this.opts.stickyFooter),this.modal.classList.add("tingle-modal--visible"),"function"==typeof t.opts.onOpen&&t.opts.onOpen.call(t),t._busy(!1),this.checkOverflow(),this}},t.prototype.close=function(t){if(!this._isBusy()){if(this._busy(!0),!1,"function"==typeof this.opts.beforeClose)if(!this.opts.beforeClose.call(this))return void this._busy(!1);document.body.classList.remove("tingle-enabled"),document.body.style.top=null,window.scrollTo({top:this._scrollPosition,behavior:"instant"}),this.modal.classList.remove("tingle-modal--visible");var o=this;o.modal.style.display="none","function"==typeof o.opts.onClose&&o.opts.onClose.call(this),o._busy(!1)}},t.prototype.setContent=function(t){return"string"==typeof t?this.modalBoxContent.innerHTML=t:(this.modalBoxContent.innerHTML="",this.modalBoxContent.appendChild(t)),this.isOpen()&&this.checkOverflow(),this},t.prototype.getContent=function(){return this.modalBoxContent},t.prototype.addFooter=function(){return function(){this.modalBoxFooter=document.createElement("div"),this.modalBoxFooter.classList.add("tingle-modal-box__footer"),this.modalBox.appendChild(this.modalBoxFooter)}.call(this),this},t.prototype.setFooterContent=function(t){return this.modalBoxFooter.innerHTML=t,this},t.prototype.getFooterContent=function(){return this.modalBoxFooter},t.prototype.setStickyFooter=function(t){return this.isOverflow()||(t=!1),t?this.modalBox.contains(this.modalBoxFooter)&&(this.modalBox.removeChild(this.modalBoxFooter),this.modal.appendChild(this.modalBoxFooter),this.modalBoxFooter.classList.add("tingle-modal-box__footer--sticky"),e.call(this),this.modalBoxContent.style["padding-bottom"]=this.modalBoxFooter.clientHeight+20+"px"):this.modalBoxFooter&&(this.modalBox.contains(this.modalBoxFooter)||(this.modal.removeChild(this.modalBoxFooter),this.modalBox.appendChild(this.modalBoxFooter),this.modalBoxFooter.style.width="auto",this.modalBoxFooter.style.left="",this.modalBoxContent.style["padding-bottom"]="",this.modalBoxFooter.classList.remove("tingle-modal-box__footer--sticky"))),this},t.prototype.addFooterBtn=function(t,o,e){var s=document.createElement("button");return s.innerHTML=t,s.addEventListener("click",e),"string"==typeof o&&o.length&&o.split(" ").forEach(function(t){s.classList.add(t)}),this.modalBoxFooter.appendChild(s),s},t.prototype.resize=function(){console.warn("Resize is deprecated and will be removed in version 1.0")},t.prototype.isOverflow=function(){return window.innerHeight<=this.modalBox.clientHeight},t.prototype.checkOverflow=function(){this.modal.classList.contains("tingle-modal--visible")&&(this.isOverflow()?this.modal.classList.add("tingle-modal--overflow"):this.modal.classList.remove("tingle-modal--overflow"),!this.isOverflow()&&this.opts.stickyFooter?this.setStickyFooter(!1):this.isOverflow()&&this.opts.stickyFooter&&(e.call(this),this.setStickyFooter(!0)))},{modal:t}});

/***/ })
/******/ 	]);
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var tingle_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(1);
/* harmony import */ var tingle_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(tingle_js__WEBPACK_IMPORTED_MODULE_0__);
// ES6 Modules or TypeScript


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
		// Destructure the 'wp.i18n' object to extract the '__' function.
		// The '__' function is typically used for internationalization (i18n) to translate strings in WordPress.
		const {
			__
		} = wp.i18n;

		// Initializes a modal specifically for displaying error messages, using tingle.js.
		// This modal is configured with options that make it suitable for alerting users to errors, with a customizable appearance and behavior.
		var errorModal = new (tingle_js__WEBPACK_IMPORTED_MODULE_0___default().modal)({
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
		var successModal = new (tingle_js__WEBPACK_IMPORTED_MODULE_0___default().modal)({
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

		// Show the custom modal with the response data
		var responseModal = new (tingle_js__WEBPACK_IMPORTED_MODULE_0___default().modal)({
			footer: false, // Disables the footer for the success modal.
			stickyFooter: false, // Keeps the sticky footer option disabled.
			closeMethods: ['overlay'], // Allows closing the modal through various user actions.
			onOpen: function () {
				//console.log('Success modal opened'); // Logs the opening of the success modal, useful for debugging.
			},
			onClose: function () {
				//console.log('Modal closed'); // Logs when the modal closes.
			},
			beforeClose: function () {
				return true; // Allows the modal to close, can be used for additional checks or cleanup before closure.
			}
		});

		// Initializes a modal dedicated to showing loading alerts during operations that require waiting, using tingle.js.
		// This modal is designed to provide visual feedback to the user that a process is ongoing and to prevent user actions by disabling close methods.
		var loadingModal = new (tingle_js__WEBPACK_IMPORTED_MODULE_0___default().modal)({
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


		/**
		 * Retrieves file data for a specific product and updates the page content.
		 * This function makes an AJAX request to a server-side script to get data
		 * related to a specific product, identified by its ID, and then updates the page content.
		 */
		function get_files() {
			// Calls the function to obtain the product ID
			let productId = getProductId();

			// Initiates an AJAX call to retrieve product-related data
			$.ajax({
				type: "POST", // Sets the method of the AJAX request to POST
				url: ajax_object.ajax_url, // URL where the AJAX request is sent
				data: {
					action: 'byrst_woocommerce_plugin_get_data_view', // The specific action for the AJAX handler to take
					security: ajax_object.nonce, // Security nonce for WordPress
					product_id: productId // The ID of the product
				},
				dataType: "json", // Specifies that the response should be in JSON format
				// Function to execute when the request is successful
				success: function (response) {
					// Check if the response has a specific message
					if (response.data.message == 'Loading content.') {
						var content = response.data.content; // Extract content from the response

						// Update the HTML of the element with ID 'byrst-content' with the received content
						$("#byrst-content").html(content);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					// Function to handle an error in the AJAX request
					var errorMessage;

					// Conditional checks to determine the type of error and set an appropriate message
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

					// Displays an error message using the centralized showErrorAlert function
					showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), errorMessage);
				}
			});
		}

		// Calls the get_files function when the page loads
		get_files();


		/**
		 * Retrieves the product ID from the product edit or creation page.
		 * This function is designed to be used in the context of a WordPress admin interface,
		 * specifically on pages where products are edited or created.
		 *
		 * @returns {number|null} The product ID if found, or null if not found.
		 */
		function getProductId() {
			// Selects the input element containing the product ID based on its name attribute
			var productIdInput = document.querySelector('input[name="post_ID"]');

			// Checks if the product ID input element exists on the page
			if (productIdInput) {
				// Parses the value of the input element to an integer
				var productId = parseInt(productIdInput.value);

				// Returns the parsed product ID
				return productId;
			}

			// Returns null if the product ID input element is not found
			return null;
		}

		$(document).on('click', '#byrst-gallery', function (e) {
			e.preventDefault(); // Prevent the button from performing its default action, like submitting a form

			let nextKey = null;
			let isLoading = false;

			// Display a loading modal while waiting for the AJAX response
			showLoadingAlert();

			function handleSuccessfulResponse(response) {
				// When the request completes, hide the loading alert
				hideLoadingAlert();

				// Only for Dev: The next line is for dev return a array 0
				//response.data.data = [];

				if (!response.success) {
					showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), response.data.message);
					return;
				}

				let tableRowsHtml = '';

				// Verificación si el array 'data' está vacío
				if (response.data.data.length === 0) {
					tableRowsHtml = `
							<tr>
								<td colspan="5" class="has-text-centered">
									<p>${__('You have no actived product 3D model yet.', 'byrst-3d-for-woocommerce')}</p>
									<p>${__('Please active your product 3D model(s) from Byrst app 3D model screen.', 'byrst-3d-for-woocommerce')}</p>
									<p>
										<img src="${ajax_object.model_3d_app_url}" class="is-responsive">
									</p>
								</td>
							</tr>
						`;
				} else {
					response.data.data.forEach(item => {
						// Determine the image URL based on the item type
						let typeImageHtml = getImageHtmlByType(item.type);

						tableRowsHtml += `
							<tr>
								<td data-title="${__('Model thumbnail', 'byrst-3d-for-woocommerce')}"><img src="${item.preview.thumbnail.url}" width="60"></td>    
								<td data-title="${__('Title', 'byrst-3d-for-woocommerce')}">${item.name}</td>
								<td data-title="${__('Description', 'byrst-3d-for-woocommerce')}">${item.desc}</td> 
								<td data-title="${__('Model type', 'byrst-3d-for-woocommerce')}">${typeImageHtml}</td>                    
								<td data-title="${__('Select', 'byrst-3d-for-woocommerce')}">
									<button class="btn-import button is-info" data-model-id="${item.sort_key}">${__('Select', 'byrst-3d-for-woocommerce')}</button>
								</td>
							</tr>
						`;
					});
				}

				responseModal.setContent(`
				<div class="columns">
					<div class="column"></div>
					<div class="column">
						<div class="buttons is-right">
							<button id="byrst-refresh" class="button">
								<div class="is-flex is-align-items-center is-justify-content-space-between">
									<img src="${ajax_object.refresh_url}" alt="Refresh" class="mr-2 refresh">
									<span>${__('Refresh','byrst-3d-for-woocommerce')}</span>
								</div>
							</button>
							<button id="byrst-cancel" class="button is-light">
								${__('Cancel','byrst-3d-for-woocommerce')}
							</button>
						</div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<h2 class="subtitle">${__('Byrst active model links for E-Commerce','byrst-3d-for-woocommerce')}</h2>
					</div>
				</div>
				<div class="columns">
					<div id="data-container" class="column" style="overflow-y: auto; max-height: 400px; width:100%;">
						<div class="table-container">
							<table class="table is-bordered is-hoverable is-fullwidth">
								<thead>
									<tr>
										<th>${__('Model thumbnail', 'byrst-3d-for-woocommerce')}</th>
										<th>${__('Title', 'byrst-3d-for-woocommerce')}</th>
										<th>${__('Description', 'byrst-3d-for-woocommerce')}</th>
										<th>${__('Model type', 'byrst-3d-for-woocommerce')}</th>
										<th>${__('Select', 'byrst-3d-for-woocommerce')}</th>
									</tr>
								</thead>
								<tbody id="data-table-body">
									${tableRowsHtml}
								</tbody>
							</table>
						</div>
					</div>
				</div>
				`);

				responseModal.open();

				// Asegura que el evento de desplazamiento solo se asigne una vez que el modal está completamente abierto
				// y el contenedor de datos es accesible
				$('#data-container').off('scroll').on('scroll', function () {
					let container = $(this);
					let scrollHeight = container[0].scrollHeight; // Altura total del contenido del contenedor
					let scrollTop = container.scrollTop(); // Cuánto se ha desplazado verticalmente
					let containerHeight = container.height(); // Altura visible del contenedor

					// Comprueba si el scroll está al final (o muy cerca del final)
					// Ajusta el valor '100' según sea necesario para determinar qué tan cerca del final
					// se considera que el scroll ha llegado para cargar más datos
					if (scrollHeight - scrollTop - containerHeight < 30) {
						// Aquí llamas a tu función para cargar más datos
						// Asegúrate de que no se ejecuta múltiples veces si ya se están cargando datos
						if (!isLoading) {
							isLoading = true; // Evita que se vuelva a llamar mientras se están cargando los datos
							loadMoreData(); // Función para cargar más datos
						}
					}
				});
			}

			function loadMoreData() {
				isLoading = true;
				// Perform the AJAX request
				$.ajax({
					type: 'POST',
					url: ajax_object.ajax_url,
					data: {
						action: 'byrst_woocommerce_plugin_get_data_models',
						security: ajax_object.nonce,
						nextKey: nextKey
					},
					success: function (response) {
						// Logic to append additional data to the table
						let newRowsHtml = '';
						response.data.data.forEach(item => {
							let typeImageHtml = getImageHtmlByType(item.type);
							newRowsHtml += `
							<tr>
								<td><img src="${item.preview.thumbnail.url}" width="60"></td>    
								<td>${item.name}</td>
								<td>${item.desc}</td>    
								<td>${typeImageHtml}</td>                    
								<td>
									<button class="btn-import button is-info" data-model-id="${item.sort_key}">${__('Select', 'byrst-3d-for-woocommerce')}</button>
								</td>
							</tr>
						`;
						});
						// Append the new rows to the table
						$('#data-table-body').append(newRowsHtml);

						// Una vez que los nuevos datos estén cargados y agregados al DOM, actualiza los botones
						updateButtons();

						// Check if nextKey exists in the response
						if (!response.data.nextKey) {
							nextKey = null; // Ensure that nextKey is set to null if it's not received.
						} else {
							nextKey = response.data.nextKey; // If it exists, update the value of nextKey
						}

						isLoading = false;
					},
					error: function (jqXHR, textStatus, errorThrown) {
						// Function to handle an error in the AJAX request
						var errorMessage;

						// Conditional checks to determine the type of error and set an appropriate message
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

						// Displays an error message using the centralized showErrorAlert function
						showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), errorMessage);

						isLoading = false;
					}
				});
			}

			function getImageHtmlByType(itemType) {
				switch (itemType) {
					case 'AIR_STICKER':
						return `<img src="${ajax_object.air_sticker_url}" class="air_sticker">`;
					case 'FULL_3D':
						return `<img src="${ajax_object.model_url}" class="full_3d"> 3D Model`;
					default:
						return `<img src="${ajax_object.null_url}" class="null">`;
				}
			}

			// The main AJAX call
			$.ajax({
				type: 'POST',
				url: ajax_object.ajax_url,
				data: {
					action: 'byrst_woocommerce_plugin_get_data_models',
					security: ajax_object.nonce
				},
				success: handleSuccessfulResponse,
				error: function (jqXHR, textStatus, errorThrown) {
					// Function to handle an error in the AJAX request
					var errorMessage;

					// Conditional checks to determine the type of error and set an appropriate message
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

					// Displays an error message using the centralized showErrorAlert function
					showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), errorMessage);

					isLoading = false;
				}
			});
		});

		// Attach a click event handler to buttons with the 'btn-import' class
		$(document).on('click', '.btn-import', function (e) {
			e.preventDefault(); // Prevent the button from performing its default action, like submitting a form

			// Retrieve the value of the data-model-id attribute from the clicked button
			let model_id = $(this).data('model-id');

			// Initiating an AJAX call using jQuery's $.ajax() method
			$.ajax({
				type: 'POST', // Set the HTTP request type to POST
				url: ajax_object.ajax_url, // The URL to which the AJAX request will be sent
				data: { // Data that will be sent to the server
					model_id: model_id, // The ID of the model
					action: 'byrst_woocommerce_plugin_get_data_model', // The AJAX action name
					security: ajax_object.nonce // A nonce for security verification on server-side
				},
				dataType: 'json', // Expecting a JSON formatted response from the server
				// Function to execute before the AJAX request is made
				beforeSend: function () {
					// Showing a SweetAlert2 loader to indicate that the request is in progress
					showLoadingAlert();
				},
				// Function to execute upon a successful response
				success: function (response) {
					hideLoadingAlert();
					responseModal.close();
					successModal.close();

					let model_android = response.data.models[0].url;
					let model_ios = response.data.models[1].url;
					let model_thumbnail = response.data.preview.thumbnail.url;
					let model_name = response.data.name;

					// Calls a function to get the product ID
					let productId = getProductId();

					// Another AJAX call inside the success function of the first AJAX call
					$.ajax({
						type: "POST",
						url: ajax_object.ajax_url,
						data: {
							product_id: productId,
							model_android: model_android,
							model_ios: model_ios,
							model_thumbnail: model_thumbnail,
							model_name: model_name,
							action: 'byrst_woocommerce_save_models_in_custom_fields', // The AJAX action name
							security: ajax_object.nonce // A nonce for security verification on server-side
						},
						dataType: "json",
						success: function (response) {
							// Set values to inputs here
							$('#byrst_woocommerce_plugin_file_android').val(model_android);
							$('#byrst_woocommerce_plugin_file_ios').val(model_ios);
							$('#byrst_woocommerce_plugin_file_poster').val(model_thumbnail);
							$('#byrst_woocommerce_plugin_file_alt').val(model_name);
						},
						error: function (jqXHR, textStatus, errorThrown) {
							// Function to handle an error in the AJAX request
							var errorMessage;

							// Conditional checks to determine the type of error and set an appropriate message
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

							// Displays an error message using the centralized showErrorAlert function
							showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), errorMessage);

							isLoading = false;
						}
					});
				},
				error: function (jqXHR, textStatus, errorThrown) {
					// Function to handle an error in the AJAX request
					var errorMessage;

					// Conditional checks to determine the type of error and set an appropriate message
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

					// Displays an error message using the centralized showErrorAlert function
					showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), errorMessage);

					isLoading = false;
				},
				// This function is called when an AJAX request is complete
				complete: function () {
					successModal.close();
					// Close the currently displayed SweetAlert2 loader
					hideLoadingAlert();

					// Utilize the custom showSuccessAlert function to display a success message
					showSuccessAlert(
						__('Saved', 'byrst-3d-for-woocommerce'), // Title of the success message (localized)
						__('The data of the 3D Model has been saved successfully!', 'byrst-3d-for-woocommerce'), // Text of the success message (localized)
						function () {
							// This callback function is executed after the user confirms the success message
							// Call the get_files function to retrieve files (assumed to be defined elsewhere in your code)
							get_files();
						}
					);
				}
			});
		});

		// Attaching a click event listener to the document for the element with the ID '#byrst-remove'
		$(document).on('click', '#byrst-remove', function (e) {
			e.preventDefault(); // Prevents the default action of the event (e.g., submitting a form)

			// Calls a function to get the product ID
			let productId = getProductId();

			// Initiating an AJAX request
			$.ajax({
				type: "POST", // Specifies the type of request
				url: ajax_object.ajax_url, // The URL to send the request to
				data: {
					product_id: productId, // Data to be sent to the server
					action: 'byrst_woocommerce_remove_models_in_custom_fields', // Action identifier for WordPress hook
					security: ajax_object.nonce // Security nonce for WordPress
				},
				dataType: "json", // Expected data type of the response
				// Function to be called before sending the request
				beforeSend: function () {
					// Displaying a SweetAlert2 loader to indicate that the request is in progress
					showLoadingAlert();
				},
				// Function to be called if the AJAX request is successful
				success: function (response) {
					hideLoadingAlert();
					// Clearing the value of the Android file input field
					$('#byrst_woocommerce_plugin_file_android').val('');
					// Clearing the value of the iOS file input field
					$('#byrst_woocommerce_plugin_file_ios').val('');
					// Clearing the value of the poster file input field
					$('#byrst_woocommerce_plugin_file_poster').val('');
					// Clearing the value of the alt text input field
					$('#byrst_woocommerce_plugin_file_alt').val('');

					// Displaying a success message to the user using the custom showSuccessAlert function
					showSuccessAlert(
						__('3D Model Removed', 'byrst-3d-for-woocommerce'), // Internationalized title for the success message
						__('The data of the 3D Model has been removed successfully!', 'byrst-3d-for-woocommerce'), // Internationalized text for the success message
						function () {
							// Callback function to be executed after the user confirms the success message
							// Calling a function to retrieve updated files
							get_files();
						}
					);
				},
				// Function to be called if the request fails
				error: function (jqXHR, textStatus, errorThrown) {
					// Function to handle an error in the AJAX request
					var errorMessage;

					// Conditional checks to determine the type of error and set an appropriate message
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

					// Displays an error message using the centralized showErrorAlert function
					showErrorAlert(__('Error', 'byrst-3d-for-woocommerce'), errorMessage);

					isLoading = false;
				},
			});
		});

		// Attaching a click event listener to the document for the element with the ID '#byrst-refresh'
		$(document).on('click', '#byrst-refresh', function (e) {
			e.preventDefault(); // Prevent the button from performing its default action, like submitting a form
			responseModal.close();
			// This block will execute when the button with ID '#byrst-refresh' is clicked
			hideLoadingAlert(); // Closes the currently displayed SweetAlert2 dialog
			$("#byrst-gallery").click(); // Programmatically triggers a click event on the element with the ID '#byrst-gallery'
		});

		// Attaching a click event listener to the document for the element with the ID '#byrst-cancel'
		$(document).on('click', '#byrst-cancel', function (e) {
			e.preventDefault(); // Prevent the button from performing its default action, like submitting a form
			responseModal.close();
			// This function will be executed when the element with ID '#byrst-cancel' is clicked
			hideLoadingAlert(); // Closes the currently displayed SweetAlert2 dialog
		});

		// Set up an event listener for click events on <tr> elements inside the #data-container.
		// This uses event delegation since <tr> elements might be dynamically added.
		$(document).on('click', '#data-container tr', function (e) {
			e.preventDefault(); // Prevent the default action, such as navigation or submission.

			// Disable all the buttons in the data container.
			$('#data-container .btn-import').prop('disabled', true).text('Select');

			// Remove the 'is-selected' class from all rows in the data container.
			$('#data-container tr').removeClass('is-selected');

			// Add the 'is-selected' class to the clicked row (this row).
			$(this).addClass('is-selected');

			// Enable the button and change its text to 'Add' in the clicked row.
			$(this).find('.btn-import').prop('disabled', false).text('Add');
		});

		// Function to update the state of buttons in the data container.
		function updateButtons() {
			// Disable all buttons by setting the 'disabled' property to true and changing their text to 'Select'.
			$('#data-container .btn-import').prop('disabled', true).text('Select');

			// Enable the button and change its text to 'Add' in the row that has the 'is-selected' class.
			$('#data-container tr.is-selected').find('.btn-import').prop('disabled', false).text('Add');
		}

		function getImageHtmlByType(itemType) {
			switch (itemType) {
				case 'AIR_STICKER':
					return `<img src="${ajax_object.air_sticker_url}" class="air_sticker">`;
				case 'FULL_3D':
					return `<img src="${ajax_object.model_url}" class="full_3d"> 3D Model`;
				default:
					return `<img src="${ajax_object.null_url}" class="null">`;
			}
		}
	});
})(jQuery);
}();
/******/ })()
;