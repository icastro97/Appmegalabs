!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):t.Sweetalert2=e()}(this,function(){"use strict";function t(e){return(t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(e)}function e(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function n(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}function o(t,e,o){return e&&n(t.prototype,e),o&&n(t,o),t}function i(){return(i=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var n=arguments[e];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(t[o]=n[o])}return t}).apply(this,arguments)}function r(t){return(r=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function a(t,e){return(a=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}function s(t,e,n){return(s=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],function(){})),!0}catch(t){return!1}}()?Reflect.construct:function(t,e,n){var o=[null];o.push.apply(o,e);var i=new(Function.bind.apply(t,o));return n&&a(i,n.prototype),i}).apply(null,arguments)}function u(t,e,n){return(u="undefined"!=typeof Reflect&&Reflect.get?Reflect.get:function(t,e,n){var o=function(t,e){for(;!Object.prototype.hasOwnProperty.call(t,e)&&null!==(t=r(t)););return t}(t,e);if(o){var i=Object.getOwnPropertyDescriptor(o,e);return i.get?i.get.call(n):i.value}})(t,e,n||t)}var c=function(t){return Object.keys(t).map(function(e){return t[e]})},l=function(t){return Array.prototype.slice.call(t)},d=function(t){console.warn("".concat("SweetAlert2:"," ").concat(t))},p=function(t){console.error("".concat("SweetAlert2:"," ").concat(t))},f=[],m=function(t,e){var n;n='"'.concat(t,'" is deprecated and will be removed in the next major release. Please use "').concat(e,'" instead.'),-1===f.indexOf(n)&&(f.push(n),d(n))},g=function(t){return"function"==typeof t?t():t},h=function(t){return t&&Promise.resolve(t)===t},v=Object.freeze({cancel:"cancel",backdrop:"backdrop",close:"close",esc:"esc",timer:"timer"}),b=function(t){var e={};for(var n in t)e[t[n]]="swal2-"+t[n];return e},y=b(["container","shown","height-auto","iosfix","popup","modal","no-backdrop","toast","toast-shown","toast-column","fade","show","hide","noanimation","close","title","header","content","actions","confirm","cancel","footer","icon","image","input","file","range","select","radio","checkbox","label","textarea","inputerror","validation-message","progress-steps","active-progress-step","progress-step","progress-step-line","loading","styled","top","top-start","top-end","top-left","top-right","center","center-start","center-end","center-left","center-right","bottom","bottom-start","bottom-end","bottom-left","bottom-right","grow-row","grow-column","grow-fullscreen","rtl"]),w=b(["success","warning","info","question","error"]),C={previousBodyPadding:null},k=function(t,e){return t.classList.contains(e)},B=function(t,e,n){l(t.classList).forEach(function(e){-1===c(y).indexOf(e)&&-1===c(w).indexOf(e)&&t.classList.remove(e)}),e&&e[n]&&L(t,e[n])};function x(t,e){if(!e)return null;switch(e){case"select":case"textarea":case"file":return O(t,y[e]);case"checkbox":return t.querySelector(".".concat(y.checkbox," input"));case"radio":return t.querySelector(".".concat(y.radio," input:checked"))||t.querySelector(".".concat(y.radio," input:first-child"));case"range":return t.querySelector(".".concat(y.range," input"));default:return O(t,y.input)}}var S,P=function(t){if(t.focus(),"file"!==t.type){var e=t.value;t.value="",t.value=e}},A=function(t,e,n){t&&e&&("string"==typeof e&&(e=e.split(/\s+/).filter(Boolean)),e.forEach(function(e){t.forEach?t.forEach(function(t){n?t.classList.add(e):t.classList.remove(e)}):n?t.classList.add(e):t.classList.remove(e)}))},L=function(t,e){A(t,e,!0)},E=function(t,e){A(t,e,!1)},O=function(t,e){for(var n=0;n<t.childNodes.length;n++)if(k(t.childNodes[n],e))return t.childNodes[n]},T=function(t,e,n){n||0===parseInt(n)?t.style[e]="number"==typeof n?n+"px":n:t.style.removeProperty(e)},M=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"flex";t.style.opacity="",t.style.display=e},V=function(t){t.style.opacity="",t.style.display="none"},j=function(t,e,n){e?M(t,n):V(t)},q=function(t){return!(!t||!(t.offsetWidth||t.offsetHeight||t.getClientRects().length))},H=function(t){var e=window.getComputedStyle(t),n=parseFloat(e.getPropertyValue("animation-duration")||"0"),o=parseFloat(e.getPropertyValue("transition-duration")||"0");return n>0||o>0},I=function(){return document.body.querySelector("."+y.container)},R=function(t){var e=I();return e?e.querySelector(t):null},D=function(t){return R("."+t)},N=function(){return D(y.popup)},U=function(){var t=N();return l(t.querySelectorAll("."+y.icon))},_=function(){var t=U().filter(function(t){return q(t)});return t.length?t[0]:null},z=function(){return D(y.title)},W=function(){return D(y.content)},K=function(){return D(y.image)},F=function(){return D(y["progress-steps"])},Z=function(){return D(y["validation-message"])},Q=function(){return R("."+y.actions+" ."+y.confirm)},Y=function(){return R("."+y.actions+" ."+y.cancel)},$=function(){return D(y.actions)},J=function(){return D(y.header)},X=function(){return D(y.footer)},G=function(){return D(y.close)},tt=function(){var t=l(N().querySelectorAll('[tabindex]:not([tabindex="-1"]):not([tabindex="0"])')).sort(function(t,e){return(t=parseInt(t.getAttribute("tabindex")))>(e=parseInt(e.getAttribute("tabindex")))?1:t<e?-1:0}),e=l(N().querySelectorAll('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex="0"], [contenteditable], audio[controls], video[controls]')).filter(function(t){return"-1"!==t.getAttribute("tabindex")});return function(t){for(var e=[],n=0;n<t.length;n++)-1===e.indexOf(t[n])&&e.push(t[n]);return e}(t.concat(e)).filter(function(t){return q(t)})},et=function(){return!nt()&&!document.body.classList.contains(y["no-backdrop"])},nt=function(){return document.body.classList.contains(y["toast-shown"])},ot=function(){return"undefined"==typeof window||"undefined"==typeof document},it='\n <div aria-labelledby="'.concat(y.title,'" aria-describedby="').concat(y.content,'" class="').concat(y.popup,'" tabindex="-1">\n   <div class="').concat(y.header,'">\n     <ul class="').concat(y["progress-steps"],'"></ul>\n     <div class="').concat(y.icon," ").concat(w.error,'">\n       <span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span>\n     </div>\n     <div class="').concat(y.icon," ").concat(w.question,'"></div>\n     <div class="').concat(y.icon," ").concat(w.warning,'"></div>\n     <div class="').concat(y.icon," ").concat(w.info,'"></div>\n     <div class="').concat(y.icon," ").concat(w.success,'">\n       <div class="swal2-success-circular-line-left"></div>\n       <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>\n       <div class="swal2-success-ring"></div> <div class="swal2-success-fix"></div>\n       <div class="swal2-success-circular-line-right"></div>\n     </div>\n     <img class="').concat(y.image,'" />\n     <h2 class="').concat(y.title,'" id="').concat(y.title,'"></h2>\n     <button type="button" class="').concat(y.close,'">&times;</button>\n   </div>\n   <div class="').concat(y.content,'">\n     <div id="').concat(y.content,'"></div>\n     <input class="').concat(y.input,'" />\n     <input type="file" class="').concat(y.file,'" />\n     <div class="').concat(y.range,'">\n       <input type="range" />\n       <output></output>\n     </div>\n     <select class="').concat(y.select,'"></select>\n     <div class="').concat(y.radio,'"></div>\n     <label for="').concat(y.checkbox,'" class="').concat(y.checkbox,'">\n       <input type="checkbox" />\n       <span class="').concat(y.label,'"></span>\n     </label>\n     <textarea class="').concat(y.textarea,'"></textarea>\n     <div class="').concat(y["validation-message"],'" id="').concat(y["validation-message"],'"></div>\n   </div>\n   <div class="').concat(y.actions,'">\n     <button type="button" class="').concat(y.confirm,'">OK</button>\n     <button type="button" class="').concat(y.cancel,'">Cancel</button>\n   </div>\n   <div class="').concat(y.footer,'">\n   </div>\n </div>\n').replace(/(^|\n)\s*/g,""),rt=function(t){Xt.isVisible()&&S!==t.target.value&&Xt.resetValidationMessage(),S=t.target.value},at=function(e,n){e instanceof HTMLElement?n.appendChild(e):"object"===t(e)?st(n,e):e&&(n.innerHTML=e)},st=function(t,e){if(t.innerHTML="",0 in e)for(var n=0;n in e;n++)t.appendChild(e[n].cloneNode(!0));else t.appendChild(e.cloneNode(!0))},ut=function(){if(ot())return!1;var t=document.createElement("div"),e={WebkitAnimation:"webkitAnimationEnd",OAnimation:"oAnimationEnd oanimationend",animation:"animationend"};for(var n in e)if(e.hasOwnProperty(n)&&void 0!==t.style[n])return e[n];return!1}();function ct(t,e,n){j(t,n["showC"+e.substring(1)+"Button"],"inline-block"),t.innerHTML=n[e+"ButtonText"],t.setAttribute("aria-label",n[e+"ButtonAriaLabel"]),t.className=y[e],B(t,n.customClass,e+"Button"),L(t,n[e+"ButtonClass"])}var lt={promise:new WeakMap,innerParams:new WeakMap,domCache:new WeakMap},dt=function(t,e){var n=x(W(),t);if(n)for(var o in function(t){for(var e=0;e<t.attributes.length;e++){var n=t.attributes[e].name;-1===["type","value","style"].indexOf(n)&&t.removeAttribute(n)}}(n),e)"range"===t&&"placeholder"===o||n.setAttribute(o,e[o])},pt=function(t,e,n){t.className=e,n.inputClass&&L(t,n.inputClass),n.customClass&&L(t,n.customClass.input)},ft=function(t,e){t.placeholder&&!e.inputPlaceholder||(t.placeholder=e.inputPlaceholder)},mt={};mt.text=mt.email=mt.password=mt.number=mt.tel=mt.url=function(e){var n=O(W(),y.input);return"string"==typeof e.inputValue||"number"==typeof e.inputValue?n.value=e.inputValue:h(e.inputValue)||d('Unexpected type of inputValue! Expected "string", "number" or "Promise", got "'.concat(t(e.inputValue),'"')),ft(n,e),n.type=e.input,n},mt.file=function(t){var e=O(W(),y.file);return ft(e,t),e.type=t.input,e},mt.range=function(t){var e=O(W(),y.range),n=e.querySelector("input"),o=e.querySelector("output");return n.value=t.inputValue,n.type=t.input,o.value=t.inputValue,e},mt.select=function(t){var e=O(W(),y.select);if(e.innerHTML="",t.inputPlaceholder){var n=document.createElement("option");n.innerHTML=t.inputPlaceholder,n.value="",n.disabled=!0,n.selected=!0,e.appendChild(n)}return e},mt.radio=function(){var t=O(W(),y.radio);return t.innerHTML="",t},mt.checkbox=function(t){var e=O(W(),y.checkbox),n=x(W(),"checkbox");return n.type="checkbox",n.value=1,n.id=y.checkbox,n.checked=Boolean(t.inputValue),e.querySelector("span").innerHTML=t.inputPlaceholder,e},mt.textarea=function(t){var e=O(W(),y.textarea);return e.value=t.inputValue,ft(e,t),e};var gt=function(t,e){var n=F();if(!e.progressSteps||0===e.progressSteps.length)return V(n);M(n),n.innerHTML="";var o=parseInt(null===e.currentProgressStep?Xt.getQueueStep():e.currentProgressStep);o>=e.progressSteps.length&&d("Invalid currentProgressStep parameter, it should be less than progressSteps.length (currentProgressStep like JS arrays starts from 0)"),e.progressSteps.forEach(function(t,i){var r=function(t){var e=document.createElement("li");return L(e,y["progress-step"]),e.innerHTML=t,e}(t);if(n.appendChild(r),i===o&&L(r,y["active-progress-step"]),i!==e.progressSteps.length-1){var a=function(t){var e=document.createElement("li");return L(e,y["progress-step-line"]),t.progressStepsDistance&&(e.style.width=t.progressStepsDistance),e}(t);n.appendChild(a)}})},ht=function(t,e){!function(t,e){var n=N();T(n,"width",e.width),T(n,"padding",e.padding),e.background&&(n.style.background=e.background),n.className=y.popup,e.toast?(L([document.documentElement,document.body],y["toast-shown"]),L(n,y.toast)):L(n,y.modal),B(n,e.customClass,"popup"),"string"==typeof e.customClass&&L(n,e.customClass),A(n,y.noanimation,!e.animation)}(0,e),function(t,e){var n=I();n&&(function(t,e){"string"==typeof e?t.style.background=e:e||L([document.documentElement,document.body],y["no-backdrop"])}(n,e.backdrop),!e.backdrop&&e.allowOutsideClick&&d('"allowOutsideClick" parameter requires `backdrop` parameter to be set to `true`'),function(t,e){e in y?L(t,y[e]):(d('The "position" parameter is not valid, defaulting to "center"'),L(t,y.center))}(n,e.position),function(t,e){if(e&&"string"==typeof e){var n="grow-"+e;n in y&&L(t,y[n])}}(n,e.grow),B(n,e.customClass,"container"),e.customContainerClass&&L(n,e.customContainerClass))}(0,e),function(t,e){var n=J();B(n,e.customClass,"header"),gt(0,e),function(t,e){var n=lt.innerParams.get(t);if(n&&e.type===n.type&&_())B(_(),e.customClass,"icon");else if(function(){for(var t=U(),e=0;e<t.length;e++)V(t[e])}(),e.type)if(function(){for(var t=N(),e=window.getComputedStyle(t).getPropertyValue("background-color"),n=t.querySelectorAll("[class^=swal2-success-circular-line], .swal2-success-fix"),o=0;o<n.length;o++)n[o].style.backgroundColor=e}(),-1!==Object.keys(w).indexOf(e.type)){var o=R(".".concat(y.icon,".").concat(w[e.type]));M(o),B(o,e.customClass,"icon"),A(o,"swal2-animate-".concat(e.type,"-icon"),e.animation)}else p('Unknown type! Expected "success", "error", "warning", "info" or "question", got "'.concat(e.type,'"'))}(t,e),function(t,e){var n=K();if(!e.imageUrl)return V(n);M(n),n.setAttribute("src",e.imageUrl),n.setAttribute("alt",e.imageAlt),T(n,"width",e.imageWidth),T(n,"height",e.imageHeight),n.className=y.image,B(n,e.customClass,"image"),e.imageClass&&L(n,e.imageClass)}(0,e),function(t,e){var n=z();j(n,e.title||e.titleText),e.title&&at(e.title,n),e.titleText&&(n.innerText=e.titleText),B(n,e.customClass,"title")}(0,e),function(t,e){var n=G();B(n,e.customClass,"closeButton"),j(n,e.showCloseButton),n.setAttribute("aria-label",e.closeButtonAriaLabel)}(0,e)}(t,e),function(t,e){var n=W().querySelector("#"+y.content);e.html?(at(e.html,n),M(n,"block")):e.text?(n.textContent=e.text,M(n,"block")):V(n),function(t,e){for(var n=lt.innerParams.get(t),o=!n||e.input!==n.input,i=W(),r=["input","file","range","select","radio","checkbox","textarea"],a=0;a<r.length;a++){var s=y[r[a]],u=O(i,s);dt(r[a],e.inputAttributes),pt(u,s,e),o&&V(u)}if(e.input){if(!mt[e.input])return p('Unexpected type of input! Expected "text", "email", "password", "number", "tel", "select", "radio", "checkbox", "textarea", "file" or "url", got "'.concat(e.input,'"'));if(o){var c=mt[e.input](e);M(c)}}}(t,e),B(W(),e.customClass,"content")}(t,e),function(t,e){var n=$(),o=Q(),i=Y();e.showConfirmButton||e.showCancelButton?M(n):V(n),B(n,e.customClass,"actions"),ct(o,"confirm",e),ct(i,"cancel",e),e.buttonsStyling?function(t,e,n){L([t,e],y.styled),n.confirmButtonColor&&(t.style.backgroundColor=n.confirmButtonColor),n.cancelButtonColor&&(e.style.backgroundColor=n.cancelButtonColor);var o=window.getComputedStyle(t).getPropertyValue("background-color");t.style.borderLeftColor=o,t.style.borderRightColor=o}(o,i,e):(E([o,i],y.styled),o.style.backgroundColor=o.style.borderLeftColor=o.style.borderRightColor="",i.style.backgroundColor=i.style.borderLeftColor=i.style.borderRightColor="")}(0,e),function(t,e){var n=X();j(n,e.footer),e.footer&&at(e.footer,n),B(n,e.customClass,"footer")}(0,e)},vt=[],bt=function(){var t=N();t||Xt.fire(""),t=N();var e=$(),n=Q(),o=Y();M(e),M(n),L([t,e],y.loading),n.disabled=!0,o.disabled=!0,t.setAttribute("data-loading",!0),t.setAttribute("aria-busy",!0),t.focus()},yt={},wt=function(){return new Promise(function(t){var e=window.scrollX,n=window.scrollY;yt.restoreFocusTimeout=setTimeout(function(){yt.previousActiveElement&&yt.previousActiveElement.focus?(yt.previousActiveElement.focus(),yt.previousActiveElement=null):document.body&&document.body.focus(),t()},100),void 0!==e&&void 0!==n&&window.scrollTo(e,n)})},Ct={title:"",titleText:"",text:"",html:"",footer:"",type:null,toast:!1,customClass:"",customContainerClass:"",target:"body",backdrop:!0,animation:!0,heightAuto:!0,allowOutsideClick:!0,allowEscapeKey:!0,allowEnterKey:!0,stopKeydownPropagation:!0,keydownListenerCapture:!1,showConfirmButton:!0,showCancelButton:!1,preConfirm:null,confirmButtonText:"OK",confirmButtonAriaLabel:"",confirmButtonColor:null,confirmButtonClass:"",cancelButtonText:"Cancel",cancelButtonAriaLabel:"",cancelButtonColor:null,cancelButtonClass:"",buttonsStyling:!0,reverseButtons:!1,focusConfirm:!0,focusCancel:!1,showCloseButton:!1,closeButtonAriaLabel:"Close this dialog",showLoaderOnConfirm:!1,imageUrl:null,imageWidth:null,imageHeight:null,imageAlt:"",imageClass:"",timer:null,width:null,padding:null,background:null,input:null,inputPlaceholder:"",inputValue:"",inputOptions:{},inputAutoTrim:!0,inputClass:"",inputAttributes:{},inputValidator:null,validationMessage:null,grow:!1,position:"center",progressSteps:[],currentProgressStep:null,progressStepsDistance:null,onBeforeOpen:null,onAfterClose:null,onOpen:null,onClose:null,scrollbarPadding:!0},kt=["title","titleText","text","html","type","customClass","showConfirmButton","showCancelButton","confirmButtonText","confirmButtonAriaLabel","confirmButtonColor","confirmButtonClass","cancelButtonText","cancelButtonAriaLabel","cancelButtonColor","cancelButtonClass","buttonsStyling","reverseButtons","imageUrl","imageWidth","imageHeigth","imageAlt","imageClass","progressSteps","currentProgressStep"],Bt={customContainerClass:"customClass",confirmButtonClass:"customClass",cancelButtonClass:"customClass",imageClass:"customClass",inputClass:"customClass"},xt=["allowOutsideClick","allowEnterKey","backdrop","focusConfirm","focusCancel","heightAuto","keydownListenerCapture"],St=function(t){return Ct.hasOwnProperty(t)},Pt=function(t){return Bt[t]},At=function(t){St(t)||d('Unknown parameter "'.concat(t,'"'))},Lt=function(t){-1!==xt.indexOf(t)&&d('The parameter "'.concat(t,'" is incompatible with toasts'))},Et=function(t){Pt(t)&&m(t,Pt(t))},Ot=Object.freeze({isValidParameter:St,isUpdatableParameter:function(t){return-1!==kt.indexOf(t)},isDeprecatedParameter:Pt,argsToParams:function(e){var n={};switch(t(e[0])){case"object":i(n,e[0]);break;default:["title","html","type"].forEach(function(o,i){switch(t(e[i])){case"string":n[o]=e[i];break;case"undefined":break;default:p("Unexpected type of ".concat(o,'! Expected "string", got ').concat(t(e[i])))}})}return n},isVisible:function(){return q(N())},clickConfirm:function(){return Q()&&Q().click()},clickCancel:function(){return Y()&&Y().click()},getContainer:I,getPopup:N,getTitle:z,getContent:W,getImage:K,getIcon:_,getIcons:U,getCloseButton:G,getActions:$,getConfirmButton:Q,getCancelButton:Y,getHeader:J,getFooter:X,getFocusableElements:tt,getValidationMessage:Z,isLoading:function(){return N().hasAttribute("data-loading")},fire:function(){for(var t=arguments.length,e=new Array(t),n=0;n<t;n++)e[n]=arguments[n];return s(this,e)},mixin:function(t){return function(n){function s(){return e(this,s),this,!(t=r(s).apply(this,arguments))||"object"!=typeof t&&"function"!=typeof t?function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(this):t;var t}return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&a(t,e)}(s,n),o(s,[{key:"_main",value:function(e){return u(r(s.prototype),"_main",this).call(this,i({},t,e))}}]),s}(this)},queue:function(t){var e=this;vt=t;var n=function(t,e){vt=[],document.body.removeAttribute("data-swal2-queue-step"),t(e)},o=[];return new Promise(function(t){!function i(r,a){r<vt.length?(document.body.setAttribute("data-swal2-queue-step",r),e.fire(vt[r]).then(function(e){void 0!==e.value?(o.push(e.value),i(r+1,a)):n(t,{dismiss:e.dismiss})})):n(t,{value:o})}(0)})},getQueueStep:function(){return document.body.getAttribute("data-swal2-queue-step")},insertQueueStep:function(t,e){return e&&e<vt.length?vt.splice(e,0,t):vt.push(t)},deleteQueueStep:function(t){void 0!==vt[t]&&vt.splice(t,1)},showLoading:bt,enableLoading:bt,getTimerLeft:function(){return yt.timeout&&yt.timeout.getTimerLeft()},stopTimer:function(){return yt.timeout&&yt.timeout.stop()},resumeTimer:function(){return yt.timeout&&yt.timeout.start()},toggleTimer:function(){var t=yt.timeout;return t&&(t.running?t.stop():t.start())},increaseTimer:function(t){return yt.timeout&&yt.timeout.increase(t)},isTimerRunning:function(){return yt.timeout&&yt.timeout.isRunning()}});function Tt(){var t=lt.innerParams.get(this),e=lt.domCache.get(this);t.showConfirmButton||(V(e.confirmButton),t.showCancelButton||V(e.actions)),E([e.popup,e.actions],y.loading),e.popup.removeAttribute("aria-busy"),e.popup.removeAttribute("data-loading"),e.confirmButton.disabled=!1,e.cancelButton.disabled=!1}var Mt=function(){null!==C.previousBodyPadding&&(document.body.style.paddingRight=C.previousBodyPadding+"px",C.previousBodyPadding=null)},Vt=function(){if(k(document.body,y.iosfix)){var t=parseInt(document.body.style.top,10);E(document.body,y.iosfix),document.body.style.top="",document.body.scrollTop=-1*t}},jt=function(){return!!window.MSInputMethodContext&&!!document.documentMode},qt=function(){var t=I(),e=N();t.style.removeProperty("align-items"),e.offsetTop<0&&(t.style.alignItems="flex-start")},Ht=function(){"undefined"!=typeof window&&jt()&&window.removeEventListener("resize",qt)},It=function(){l(document.body.children).forEach(function(t){t.hasAttribute("data-previous-aria-hidden")?(t.setAttribute("aria-hidden",t.getAttribute("data-previous-aria-hidden")),t.removeAttribute("data-previous-aria-hidden")):t.removeAttribute("aria-hidden")})},Rt={swalPromiseResolve:new WeakMap};function Dt(t,e,n){e?_t(n):(wt().then(function(){return _t(n)}),yt.keydownTarget.removeEventListener("keydown",yt.keydownHandler,{capture:yt.keydownListenerCapture}),yt.keydownHandlerAdded=!1),delete yt.keydownHandler,delete yt.keydownTarget,t.parentNode&&t.parentNode.removeChild(t),E([document.documentElement,document.body],[y.shown,y["height-auto"],y["no-backdrop"],y["toast-shown"],y["toast-column"]]),et()&&(Mt(),Vt(),Ht(),It())}function Nt(t){var e=I(),n=N();if(n&&!k(n,y.hide)){var o=lt.innerParams.get(this),i=Rt.swalPromiseResolve.get(this),r=o.onClose,a=o.onAfterClose;E(n,y.show),L(n,y.hide),ut&&H(n)?n.addEventListener(ut,function(t){t.target===n&&function(t,e,n,o){k(t,y.hide)&&Dt(e,n,o),Ut(lt),Ut(Rt)}(n,e,nt(),a)}):Dt(e,nt(),a),null!==r&&"function"==typeof r&&r(n),i(t||{}),delete this.params}}var Ut=function(t){for(var e in t)t[e]=new WeakMap},_t=function(t){null!==t&&"function"==typeof t&&setTimeout(function(){t()})};function zt(t,e,n){var o=lt.domCache.get(t);e.forEach(function(t){o[t].disabled=n})}function Wt(t,e){if(!t)return!1;if("radio"===t.type)for(var n=t.parentNode.parentNode.querySelectorAll("input"),o=0;o<n.length;o++)n[o].disabled=e;else t.disabled=e}var Kt=function(){function t(n,o){e(this,t),this.callback=n,this.remaining=o,this.running=!1,this.start()}return o(t,[{key:"start",value:function(){return this.running||(this.running=!0,this.started=new Date,this.id=setTimeout(this.callback,this.remaining)),this.remaining}},{key:"stop",value:function(){return this.running&&(this.running=!1,clearTimeout(this.id),this.remaining-=new Date-this.started),this.remaining}},{key:"increase",value:function(t){var e=this.running;return e&&this.stop(),this.remaining+=t,e&&this.start(),this.remaining}},{key:"getTimerLeft",value:function(){return this.running&&(this.stop(),this.start()),this.remaining}},{key:"isRunning",value:function(){return this.running}}]),t}(),Ft={email:function(t,e){return/^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9-]{2,24}$/.test(t)?Promise.resolve():Promise.resolve(e||"Invalid email address")},url:function(t,e){return/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,63}\b([-a-zA-Z0-9@:%_+.~#?&\/=]*)$/.test(t)?Promise.resolve():Promise.resolve(e||"Invalid URL")}};function Zt(t,e){t.removeEventListener(ut,Zt),e.style.overflowY="auto"}var Qt,Yt={select:function(t,e,n){var o=O(t,y.select);e.forEach(function(t){var e=t[0],i=t[1],r=document.createElement("option");r.value=e,r.innerHTML=i,n.inputValue.toString()===e.toString()&&(r.selected=!0),o.appendChild(r)}),o.focus()},radio:function(t,e,n){var o=O(t,y.radio);e.forEach(function(t){var e=t[0],i=t[1],r=document.createElement("input"),a=document.createElement("label");r.type="radio",r.name=y.radio,r.value=e,n.inputValue.toString()===e.toString()&&(r.checked=!0);var s=document.createElement("span");s.innerHTML=i,s.className=y.label,a.appendChild(r),a.appendChild(s),o.appendChild(a)});var i=o.querySelectorAll("input");i.length&&i[0].focus()}},$t=Object.freeze({hideLoading:Tt,disableLoading:Tt,getInput:function(t){var e=lt.innerParams.get(t||this);return x(lt.domCache.get(t||this).content,e.input)},close:Nt,closePopup:Nt,closeModal:Nt,closeToast:Nt,enableButtons:function(){zt(this,["confirmButton","cancelButton"],!1)},disableButtons:function(){zt(this,["confirmButton","cancelButton"],!0)},enableConfirmButton:function(){m("Swal.disableConfirmButton()","Swal.getConfirmButton().removeAttribute('disabled')"),zt(this,["confirmButton"],!1)},disableConfirmButton:function(){m("Swal.enableConfirmButton()","Swal.getConfirmButton().setAttribute('disabled', '')"),zt(this,["confirmButton"],!0)},enableInput:function(){return Wt(this.getInput(),!1)},disableInput:function(){return Wt(this.getInput(),!0)},showValidationMessage:function(t){var e=lt.domCache.get(this);e.validationMessage.innerHTML=t;var n=window.getComputedStyle(e.popup);e.validationMessage.style.marginLeft="-".concat(n.getPropertyValue("padding-left")),e.validationMessage.style.marginRight="-".concat(n.getPropertyValue("padding-right")),M(e.validationMessage);var o=this.getInput();o&&(o.setAttribute("aria-invalid",!0),o.setAttribute("aria-describedBy",y["validation-message"]),P(o),L(o,y.inputerror))},resetValidationMessage:function(){var t=lt.domCache.get(this);t.validationMessage&&V(t.validationMessage);var e=this.getInput();e&&(e.removeAttribute("aria-invalid"),e.removeAttribute("aria-describedBy"),E(e,y.inputerror))},getProgressSteps:function(){return m("Swal.getProgressSteps()","const swalInstance = Swal.fire({progressSteps: ['1', '2', '3']}); const progressSteps = swalInstance.params.progressSteps"),lt.innerParams.get(this).progressSteps},setProgressSteps:function(t){m("Swal.setProgressSteps()","Swal.update()");var e=i({},lt.innerParams.get(this),{progressSteps:t});gt(0,e),lt.innerParams.set(this,e)},showProgressSteps:function(){var t=lt.domCache.get(this);M(t.progressSteps)},hideProgressSteps:function(){var t=lt.domCache.get(this);V(t.progressSteps)},_main:function(e){var n=this;!function(t){for(var e in t)At(e),t.toast&&Lt(e),Et()}(e);var o=i({},Ct,e);!function(t){t.inputValidator||Object.keys(Ft).forEach(function(e){t.input===e&&(t.inputValidator=Ft[e])}),t.showLoaderOnConfirm&&!t.preConfirm&&d("showLoaderOnConfirm is set to true, but preConfirm is not defined.\nshowLoaderOnConfirm should be used together with preConfirm, see usage example:\nhttps://sweetalert2.github.io/#ajax-request"),t.animation=g(t.animation),(!t.target||"string"==typeof t.target&&!document.querySelector(t.target)||"string"!=typeof t.target&&!t.target.appendChild)&&(d('Target parameter is not valid, defaulting to "body"'),t.target="body"),"string"==typeof t.title&&(t.title=t.title.split("\n").join("<br />"));var e=N(),n="string"==typeof t.target?document.querySelector(t.target):t.target;(!e||e&&n&&e.parentNode!==n.parentNode)&&function(t){var e;if((e=I())&&(e.parentNode.removeChild(e),E([document.documentElement,document.body],[y["no-backdrop"],y["toast-shown"],y["has-column"]])),ot())p("SweetAlert2 requires document to initialize");else{var n=document.createElement("div");n.className=y.container,n.innerHTML=it;var o,i,r,a,s,u,c,l,d,f="string"==typeof(o=t.target)?document.querySelector(o):o;f.appendChild(n),function(t){var e=N();e.setAttribute("role",t.toast?"alert":"dialog"),e.setAttribute("aria-live",t.toast?"polite":"assertive"),t.toast||e.setAttribute("aria-modal","true")}(t),function(t){"rtl"===window.getComputedStyle(t).direction&&L(I(),y.rtl)}(f),i=W(),r=O(i,y.input),a=O(i,y.file),s=i.querySelector(".".concat(y.range," input")),u=i.querySelector(".".concat(y.range," output")),c=O(i,y.select),l=i.querySelector(".".concat(y.checkbox," input")),d=O(i,y.textarea),r.oninput=rt,a.onchange=rt,c.onchange=rt,l.onchange=rt,d.oninput=rt,s.oninput=function(t){rt(t),u.value=s.value},s.onchange=function(t){rt(t),s.nextSibling.value=s.value}}}(t)}(o),Object.freeze(o),yt.timeout&&(yt.timeout.stop(),delete yt.timeout),clearTimeout(yt.restoreFocusTimeout);var r={popup:N(),container:I(),content:W(),actions:$(),confirmButton:Q(),cancelButton:Y(),closeButton:G(),validationMessage:Z(),progressSteps:F()};lt.domCache.set(this,r),ht(this,o),lt.innerParams.set(this,o);var a=this.constructor;return new Promise(function(e){var i=function(t){n.closePopup({value:t})},s=function(t){n.closePopup({dismiss:t})};Rt.swalPromiseResolve.set(n,e),o.timer&&(yt.timeout=new Kt(function(){s("timer"),delete yt.timeout},o.timer)),o.input&&setTimeout(function(){var t=n.getInput();t&&P(t)},0);for(var u=function(t){o.showLoaderOnConfirm&&a.showLoading(),o.preConfirm?(n.resetValidationMessage(),Promise.resolve().then(function(){return o.preConfirm(t,o.validationMessage)}).then(function(e){q(r.validationMessage)||!1===e?n.hideLoading():i(void 0===e?t:e)})):i(t)},c=function(t){var e=t.target,i=r.confirmButton,c=r.cancelButton,l=i&&(i===e||i.contains(e)),d=c&&(c===e||c.contains(e));switch(t.type){case"click":if(l)if(n.disableButtons(),o.input){var p=function(){var t=n.getInput();if(!t)return null;switch(o.input){case"checkbox":return t.checked?1:0;case"radio":return t.checked?t.value:null;case"file":return t.files.length?t.files[0]:null;default:return o.inputAutoTrim?t.value.trim():t.value}}();o.inputValidator?(n.disableInput(),Promise.resolve().then(function(){return o.inputValidator(p,o.validationMessage)}).then(function(t){n.enableButtons(),n.enableInput(),t?n.showValidationMessage(t):u(p)})):n.getInput().checkValidity()?u(p):(n.enableButtons(),n.showValidationMessage(o.validationMessage))}else u(!0);else d&&(n.disableButtons(),s(a.DismissReason.cancel))}},d=r.popup.querySelectorAll("button"),f=0;f<d.length;f++)d[f].onclick=c,d[f].onmouseover=c,d[f].onmouseout=c,d[f].onmousedown=c;if(r.closeButton.onclick=function(){s(a.DismissReason.close)},o.toast)r.popup.onclick=function(){o.showConfirmButton||o.showCancelButton||o.showCloseButton||o.input||s(a.DismissReason.close)};else{var m=!1;r.popup.onmousedown=function(){r.container.onmouseup=function(t){r.container.onmouseup=void 0,t.target===r.container&&(m=!0)}},r.container.onmousedown=function(){r.popup.onmouseup=function(t){r.popup.onmouseup=void 0,(t.target===r.popup||r.popup.contains(t.target))&&(m=!0)}},r.container.onclick=function(t){m?m=!1:t.target===r.container&&g(o.allowOutsideClick)&&s(a.DismissReason.backdrop)}}o.reverseButtons?r.confirmButton.parentNode.insertBefore(r.cancelButton,r.confirmButton):r.confirmButton.parentNode.insertBefore(r.confirmButton,r.cancelButton);var v,b,w,B,x=function(t,e){for(var n=tt(),o=0;o<n.length;o++)return(t+=e)===n.length?t=0:-1===t&&(t=n.length-1),n[t].focus();r.popup.focus()};yt.keydownTarget&&yt.keydownHandlerAdded&&(yt.keydownTarget.removeEventListener("keydown",yt.keydownHandler,{capture:yt.keydownListenerCapture}),yt.keydownHandlerAdded=!1),o.toast||(yt.keydownHandler=function(t){return function(t,e){if(e.stopKeydownPropagation&&t.stopPropagation(),"Enter"!==t.key||t.isComposing)if("Tab"===t.key){for(var o=t.target,i=tt(),u=-1,c=0;c<i.length;c++)if(o===i[c]){u=c;break}x(u,t.shiftKey?-1:1),t.stopPropagation(),t.preventDefault()}else-1!==["ArrowLeft","ArrowRight","ArrowUp","ArrowDown","Left","Right","Up","Down"].indexOf(t.key)?document.activeElement===r.confirmButton&&q(r.cancelButton)?r.cancelButton.focus():document.activeElement===r.cancelButton&&q(r.confirmButton)&&r.confirmButton.focus():"Escape"!==t.key&&"Esc"!==t.key||!0!==g(e.allowEscapeKey)||(t.preventDefault(),s(a.DismissReason.esc));else if(t.target&&n.getInput()&&t.target.outerHTML===n.getInput().outerHTML){if(-1!==["textarea","file"].indexOf(e.input))return;a.clickConfirm(),t.preventDefault()}}(t,o)},yt.keydownTarget=o.keydownListenerCapture?window:r.popup,yt.keydownListenerCapture=o.keydownListenerCapture,yt.keydownTarget.addEventListener("keydown",yt.keydownHandler,{capture:yt.keydownListenerCapture}),yt.keydownHandlerAdded=!0),n.enableButtons(),n.hideLoading(),n.resetValidationMessage(),o.toast&&(o.input||o.footer||o.showCloseButton)?L(document.body,y["toast-column"]):E(document.body,y["toast-column"]),"select"===o.input||"radio"===o.input?(v=n,b=o,w=W(),B=function(t){return Yt[b.input](w,function(t){var e=[];return"undefined"!=typeof Map&&t instanceof Map?t.forEach(function(t,n){e.push([n,t])}):Object.keys(t).forEach(function(n){e.push([n,t[n]])}),e}(t),b)},h(b.inputOptions)?(bt(),b.inputOptions.then(function(t){v.hideLoading(),B(t)})):"object"===t(b.inputOptions)?B(b.inputOptions):p("Unexpected type of inputOptions! Expected object, Map or Promise, got ".concat(t(b.inputOptions)))):-1!==["text","email","number","tel","textarea"].indexOf(o.input)&&h(o.inputValue)&&function(t,e){var n=t.getInput();V(n),e.inputValue.then(function(o){n.value="number"===e.input?parseFloat(o)||0:o+"",M(n),n.focus(),t.hideLoading()}).catch(function(t){p("Error in inputValue promise: "+t),n.value="",M(n),n.focus(),(void 0).hideLoading()})}(n,o),function(t){var e=I(),n=N();null!==t.onBeforeOpen&&"function"==typeof t.onBeforeOpen&&t.onBeforeOpen(n),t.animation&&(L(n,y.show),L(e,y.fade)),M(n),ut&&H(n)?(e.style.overflowY="hidden",n.addEventListener(ut,Zt.bind(null,n,e))):e.style.overflowY="auto",L([document.documentElement,document.body,e],y.shown),t.heightAuto&&t.backdrop&&!t.toast&&L([document.documentElement,document.body],y["height-auto"]),et()&&(t.scrollbarPadding&&null===C.previousBodyPadding&&document.body.scrollHeight>window.innerHeight&&(C.previousBodyPadding=parseInt(window.getComputedStyle(document.body).getPropertyValue("padding-right")),document.body.style.paddingRight=C.previousBodyPadding+function(){if("ontouchstart"in window||navigator.msMaxTouchPoints)return 0;var t=document.createElement("div");t.style.width="50px",t.style.height="50px",t.style.overflow="scroll",document.body.appendChild(t);var e=t.offsetWidth-t.clientWidth;return document.body.removeChild(t),e}()+"px"),function(){if(/iPad|iPhone|iPod/.test(navigator.userAgent)&&!window.MSStream&&!k(document.body,y.iosfix)){var t=document.body.scrollTop;document.body.style.top=-1*t+"px",L(document.body,y.iosfix),(n=I()).ontouchstart=function(t){var o;e=t.target===n||!((o=n).scrollHeight>o.clientHeight)},n.ontouchmove=function(t){e&&(t.preventDefault(),t.stopPropagation())}}var e,n}(),"undefined"!=typeof window&&jt()&&(qt(),window.addEventListener("resize",qt)),l(document.body.children).forEach(function(t){t===I()||function(t,e){if("function"==typeof t.contains)return t.contains(e)}(t,I())||(t.hasAttribute("aria-hidden")&&t.setAttribute("data-previous-aria-hidden",t.getAttribute("aria-hidden")),t.setAttribute("aria-hidden","true"))}),setTimeout(function(){e.scrollTop=0})),nt()||yt.previousActiveElement||(yt.previousActiveElement=document.activeElement),null!==t.onOpen&&"function"==typeof t.onOpen&&setTimeout(function(){t.onOpen(n)})}(o),o.toast||(g(o.allowEnterKey)?o.focusCancel&&q(r.cancelButton)?r.cancelButton.focus():o.focusConfirm&&q(r.confirmButton)?r.confirmButton.focus():x(-1,1):document.activeElement&&"function"==typeof document.activeElement.blur&&document.activeElement.blur()),r.container.scrollTop=0})},update:function(t){var e={};Object.keys(t).forEach(function(n){Xt.isUpdatableParameter(n)?e[n]=t[n]:d('Invalid parameter to update: "'.concat(n,'". Updatable params are listed here: https://github.com/sweetalert2/sweetalert2/blob/master/src/utils/params.js'))});var n=i({},lt.innerParams.get(this),e);ht(this,n),lt.innerParams.set(this,n),Object.defineProperties(this,{params:{value:i({},this.params,t),writable:!1,enumerable:!0}})}});function Jt(){if("undefined"!=typeof window){"undefined"==typeof Promise&&p("This package requires a Promise library, please include a shim to enable it in this browser (See: https://github.com/sweetalert2/sweetalert2/wiki/Migration-from-SweetAlert-to-SweetAlert2#1-ie-support)"),Qt=this;for(var t=arguments.length,e=new Array(t),n=0;n<t;n++)e[n]=arguments[n];var o=Object.freeze(this.constructor.argsToParams(e));Object.defineProperties(this,{params:{value:o,writable:!1,enumerable:!0,configurable:!0}});var i=this._main(this.params);lt.promise.set(this,i)}}Jt.prototype.then=function(t){return lt.promise.get(this).then(t)},Jt.prototype.finally=function(t){return lt.promise.get(this).finally(t)},i(Jt.prototype,$t),i(Jt,Ot),Object.keys($t).forEach(function(t){Jt[t]=function(){var e;if(Qt)return(e=Qt)[t].apply(e,arguments)}}),Jt.DismissReason=v,Jt.version="8.11.6";var Xt=Jt;return Xt.default=Xt,Xt}),"undefined"!=typeof window&&window.Sweetalert2&&(window.swal=window.sweetAlert=window.Swal=window.SweetAlert=window.Sweetalert2);