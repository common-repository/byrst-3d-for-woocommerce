/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ([
/* 0 */,
/* 1 */
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   CAPPED_DEVICE_PIXEL_RATIO: function() { return /* binding */ CAPPED_DEVICE_PIXEL_RATIO; },
/* harmony export */   assertIsArCandidate: function() { return /* binding */ assertIsArCandidate; },
/* harmony export */   clamp: function() { return /* binding */ clamp; },
/* harmony export */   debounce: function() { return /* binding */ debounce; },
/* harmony export */   deserializeUrl: function() { return /* binding */ deserializeUrl; },
/* harmony export */   isDebugMode: function() { return /* binding */ isDebugMode; },
/* harmony export */   resolveDpr: function() { return /* binding */ resolveDpr; },
/* harmony export */   step: function() { return /* binding */ step; },
/* harmony export */   throttle: function() { return /* binding */ throttle; },
/* harmony export */   timePasses: function() { return /* binding */ timePasses; },
/* harmony export */   toFullUrl: function() { return /* binding */ toFullUrl; },
/* harmony export */   waitForEvent: function() { return /* binding */ waitForEvent; }
/* harmony export */ });
/* harmony import */ var _constants_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(2);
/* @license
 * Copyright 2019 Google LLC. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the 'License');
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an 'AS IS' BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

const deserializeUrl = (url) => (!!url && url !== 'null') ? toFullUrl(url) : null;
const assertIsArCandidate = () => {
    if (_constants_js__WEBPACK_IMPORTED_MODULE_0__.IS_WEBXR_AR_CANDIDATE) {
        return;
    }
    const missingApis = [];
    if (!_constants_js__WEBPACK_IMPORTED_MODULE_0__.HAS_WEBXR_DEVICE_API) {
        missingApis.push('WebXR Device API');
    }
    if (!_constants_js__WEBPACK_IMPORTED_MODULE_0__.HAS_WEBXR_HIT_TEST_API) {
        missingApis.push('WebXR Hit Test API');
    }
    throw new Error(`The following APIs are required for AR, but are missing in this browser: ${missingApis.join(', ')}`);
};
/**
 * Converts a partial URL string to a fully qualified URL string.
 *
 * @param {String} url
 * @return {String}
 */
const toFullUrl = (partialUrl) => {
    const url = new URL(partialUrl, window.location.toString());
    return url.toString();
};
/**
 * Returns a throttled version of a given function that is only invoked at most
 * once within a given threshold of time in milliseconds.
 *
 * The throttled version of the function has a "flush" property that resets the
 * threshold for cases when immediate invocation is desired.
 */
const throttle = (fn, ms) => {
    let timer = null;
    const throttled = (...args) => {
        if (timer != null) {
            return;
        }
        fn(...args);
        timer = self.setTimeout(() => timer = null, ms);
    };
    throttled.flush = () => {
        if (timer != null) {
            self.clearTimeout(timer);
            timer = null;
        }
    };
    return throttled;
};
const debounce = (fn, ms) => {
    let timer = null;
    return (...args) => {
        if (timer != null) {
            self.clearTimeout(timer);
        }
        timer = self.setTimeout(() => {
            timer = null;
            fn(...args);
        }, ms);
    };
};
/**
 * @param {Number} edge
 * @param {Number} value
 * @return {Number} 0 if value is less than edge, otherwise 1
 */
const step = (edge, value) => {
    return value < edge ? 0 : 1;
};
/**
 * @param {Number} value
 * @param {Number} lowerLimit
 * @param {Number} upperLimit
 * @return {Number} value clamped within lowerLimit..upperLimit
 */
const clamp = (value, lowerLimit, upperLimit) => Math.max(lowerLimit, Math.min(upperLimit, value));
// The DPR we use for a "capped" scenario (see resolveDpr below):
const CAPPED_DEVICE_PIXEL_RATIO = 1;
/**
 * This helper analyzes the layout of the current page to decide if we should
 * use the natural device pixel ratio, or a capped value.
 *
 * We cap DPR if there is no meta viewport (suggesting that user is not
 * consciously specifying how to scale the viewport relative to the device
 * screen size).
 *
 * The rationale is that this condition typically leads to a pathological
 * outcome on mobile devices. When the window dimensions are scaled up on a
 * device with a high DPR, we create a canvas that is much larger than
 * appropriate to accommodate for the pixel density if we naively use the
 * reported DPR.
 *
 * This value needs to be measured in real time, as device pixel ratio can
 * change over time (e.g., when a user zooms the page). Also, in some cases
 * (such as Firefox on Android), the window's innerWidth is initially reported
 * as the same as the screen's availWidth but changes later.
 *
 * A user who specifies a meta viewport, thereby consciously creating scaling
 * conditions where <model-viewer> is slow, will be encouraged to live their
 * best life.
 */
const resolveDpr = (() => {
    // If true, implies that the user is conscious of the viewport scaling
    // relative to the device screen size.
    const HAS_META_VIEWPORT_TAG = (() => {
        var _a;
        // Search result pages sometimes do not include a meta viewport tag even
        // though they are certainly modern and work properly with devicePixelRatio.
        if ((_a = document.documentElement.getAttribute('itemtype')) === null || _a === void 0 ? void 0 : _a.includes('schema.org/SearchResultsPage')) {
            return true;
        }
        if (window.self !== window.top) {
            // iframes can't detect the meta viewport tag, so assume the top-level
            // page has one.
            return true;
        }
        const metas = document.head != null ?
            Array.from(document.head.querySelectorAll('meta')) :
            [];
        for (const meta of metas) {
            if (meta.name === 'viewport') {
                return true;
            }
        }
        return false;
    })();
    if (!HAS_META_VIEWPORT_TAG) {
        console.warn('No <meta name="viewport"> detected; <model-viewer> will cap pixel density at 1.');
    }
    return () => HAS_META_VIEWPORT_TAG ? window.devicePixelRatio :
        CAPPED_DEVICE_PIXEL_RATIO;
})();
/**
 * Debug mode is enabled when one of the two following conditions is true:
 *
 *  1. A 'model-viewer-debug-mode' query parameter is present in the current
 *     search string
 *  2. There is a global object ModelViewerElement with a debugMode property set
 *     to true
 */
const isDebugMode = (() => {
    const debugQueryParameterName = 'model-viewer-debug-mode';
    const debugQueryParameter = new RegExp(`[?&]${debugQueryParameterName}(&|$)`);
    return () => (self.ModelViewerElement &&
        self.ModelViewerElement.debugMode) ||
        (self.location && self.location.search &&
            self.location.search.match(debugQueryParameter));
})();
const timePasses = (ms = 0) => new Promise(resolve => setTimeout(resolve, ms));
/**
 * @param {EventTarget|EventDispatcher} target
 * @param {string} eventName
 * @param {?Function} predicate
 */
const waitForEvent = (target, eventName, predicate = null) => new Promise(resolve => {
    function handler(event) {
        if (!predicate || predicate(event)) {
            resolve(event);
            target.removeEventListener(eventName, handler);
        }
    }
    target.addEventListener(eventName, handler);
});

/***/ }),
/* 2 */
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   HAS_INTERSECTION_OBSERVER: function() { return /* binding */ HAS_INTERSECTION_OBSERVER; },
/* harmony export */   HAS_RESIZE_OBSERVER: function() { return /* binding */ HAS_RESIZE_OBSERVER; },
/* harmony export */   HAS_WEBXR_DEVICE_API: function() { return /* binding */ HAS_WEBXR_DEVICE_API; },
/* harmony export */   HAS_WEBXR_HIT_TEST_API: function() { return /* binding */ HAS_WEBXR_HIT_TEST_API; },
/* harmony export */   IS_ANDROID: function() { return /* binding */ IS_ANDROID; },
/* harmony export */   IS_AR_QUICKLOOK_CANDIDATE: function() { return /* binding */ IS_AR_QUICKLOOK_CANDIDATE; },
/* harmony export */   IS_CHROMEOS: function() { return /* binding */ IS_CHROMEOS; },
/* harmony export */   IS_FIREFOX: function() { return /* binding */ IS_FIREFOX; },
/* harmony export */   IS_IOS: function() { return /* binding */ IS_IOS; },
/* harmony export */   IS_IOS_CHROME: function() { return /* binding */ IS_IOS_CHROME; },
/* harmony export */   IS_IOS_SAFARI: function() { return /* binding */ IS_IOS_SAFARI; },
/* harmony export */   IS_MOBILE: function() { return /* binding */ IS_MOBILE; },
/* harmony export */   IS_OCULUS: function() { return /* binding */ IS_OCULUS; },
/* harmony export */   IS_SAFARI: function() { return /* binding */ IS_SAFARI; },
/* harmony export */   IS_SCENEVIEWER_CANDIDATE: function() { return /* binding */ IS_SCENEVIEWER_CANDIDATE; },
/* harmony export */   IS_WEBXR_AR_CANDIDATE: function() { return /* binding */ IS_WEBXR_AR_CANDIDATE; },
/* harmony export */   IS_WKWEBVIEW: function() { return /* binding */ IS_WKWEBVIEW; }
/* harmony export */ });
/* @license
 * Copyright 2019 Google LLC. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the 'License');
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an 'AS IS' BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
// NOTE(cdata): The HAS_WEBXR_* constants can be enabled in Chrome by turning on
// the appropriate flags. However, just because we have the API does not
// guarantee that AR will work.
const HAS_WEBXR_DEVICE_API = navigator.xr != null &&
    self.XRSession != null && navigator.xr.isSessionSupported != null;
const HAS_WEBXR_HIT_TEST_API = HAS_WEBXR_DEVICE_API &&
    self.XRSession.prototype.requestHitTestSource != null;
const HAS_RESIZE_OBSERVER = self.ResizeObserver != null;
const HAS_INTERSECTION_OBSERVER = self.IntersectionObserver != null;
const IS_WEBXR_AR_CANDIDATE = HAS_WEBXR_HIT_TEST_API;
const IS_MOBILE = (() => {
    const userAgent = navigator.userAgent || navigator.vendor || self.opera;
    let check = false;
    // eslint-disable-next-line
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i
        .test(userAgent) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i
            .test(userAgent.substr(0, 4))) {
        check = true;
    }
    return check;
})();
const IS_CHROMEOS = /\bCrOS\b/.test(navigator.userAgent);
const IS_ANDROID = /android/i.test(navigator.userAgent);
// Prior to iOS 13, detecting iOS Safari was relatively straight-forward.
// As of iOS 13, Safari on iPad (in its default configuration) reports the same
// user-agent string as Safari on desktop MacOS. Strictly speaking, we only care
// about iOS for the purposes if selecting for cases where Quick Look is known
// to be supported. However, for API correctness purposes, we must rely on
// known, detectable signals to distinguish iOS Safari from MacOS Safari. At the
// time of this writing, there are no non-iOS/iPadOS Apple devices with
// multi-touch displays.
// @see https://stackoverflow.com/questions/57765958/how-to-detect-ipad-and-ipad-os-version-in-ios-13-and-up
// @see https://forums.developer.apple.com/thread/119186
// @see https://github.com/google/model-viewer/issues/758
const IS_IOS = (/iPad|iPhone|iPod/.test(navigator.userAgent) && !self.MSStream) ||
    (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
// @see https://developer.chrome.com/multidevice/user-agent
const IS_SAFARI = /Safari\//.test(navigator.userAgent);
const IS_FIREFOX = /firefox/i.test(navigator.userAgent);
const IS_OCULUS = /OculusBrowser/.test(navigator.userAgent);
const IS_IOS_CHROME = IS_IOS && /CriOS\//.test(navigator.userAgent);
const IS_IOS_SAFARI = IS_IOS && IS_SAFARI;
const IS_SCENEVIEWER_CANDIDATE = IS_ANDROID && !IS_FIREFOX && !IS_OCULUS;
const IS_WKWEBVIEW = Boolean(window.webkit && window.webkit.messageHandlers);
// If running in iOS Safari proper, and not within a WKWebView component instance, check for ARQL feature support.
// Otherwise, if running in a WKWebView instance, check for known ARQL compatible iOS browsers, including:
// Chrome (CriOS), Edge (EdgiOS), Firefox (FxiOS), Google App (GSA), DuckDuckGo (DuckDuckGo).
// All other iOS browsers / apps will fail by default.
const IS_AR_QUICKLOOK_CANDIDATE = (() => {
    if (IS_IOS) {
        if (!IS_WKWEBVIEW) {
            const tempAnchor = document.createElement('a');
            return Boolean(tempAnchor.relList && tempAnchor.relList.supports && tempAnchor.relList.supports('ar'));
        }
        else {
            return Boolean(/CriOS\/|EdgiOS\/|FxiOS\/|GSA\/|DuckDuckGo\//.test(navigator.userAgent));
        }
    }
    else {
        return false;
    }
})();

/***/ }),
/* 3 */
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
/* harmony import */ var _google_model_viewer_lib_utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(1);
/* harmony import */ var tingle_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(3);
/* harmony import */ var tingle_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(tingle_js__WEBPACK_IMPORTED_MODULE_1__);
// ES6 Modules



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
        var errorModal = new (tingle_js__WEBPACK_IMPORTED_MODULE_1___default().modal)({
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
        var successModal = new (tingle_js__WEBPACK_IMPORTED_MODULE_1___default().modal)({
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
        var loadingModal = new (tingle_js__WEBPACK_IMPORTED_MODULE_1___default().modal)({
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
}();
/******/ })()
;