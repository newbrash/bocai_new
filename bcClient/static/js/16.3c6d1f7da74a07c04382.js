webpackJsonp([16],{"/Lyv":function(t,e,i){t.exports=function(t){var e={};function i(n){if(e[n])return e[n].exports;var s=e[n]={i:n,l:!1,exports:{}};return t[n].call(s.exports,s,s.exports,i),s.l=!0,s.exports}return i.m=t,i.c=e,i.i=function(t){return t},i.d=function(t,e,n){i.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:n})},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="",i(i.s=225)}({0:function(t,e){t.exports=function(t,e,i,n,s){var o,r=t=t||{},a=typeof t.default;"object"!==a&&"function"!==a||(o=t,r=t.default);var l,c="function"==typeof r?r.options:r;if(e&&(c.render=e.render,c.staticRenderFns=e.staticRenderFns),n&&(c._scopeId=n),s?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(s)},c._ssrRegister=l):i&&(l=i),l){var d=c.functional,u=d?c.render:c.beforeCreate;d?c.render=function(t,e){return l.call(e),u(t,e)}:c.beforeCreate=u?[].concat(u,l):[l]}return{esModule:o,exports:r,options:c}}},1:function(t,e){t.exports=i("7+uW")},117:function(t,e){},118:function(t,e){},143:function(t,e,i){var n=i(0)(i(65),i(187),function(t){i(117),i(118)},null,null);t.exports=n.exports},187:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"mint-msgbox-wrapper"},[i("transition",{attrs:{name:"msgbox-bounce"}},[i("div",{directives:[{name:"show",rawName:"v-show",value:t.value,expression:"value"}],staticClass:"mint-msgbox"},[""!==t.title?i("div",{staticClass:"mint-msgbox-header"},[i("div",{staticClass:"mint-msgbox-title"},[t._v(t._s(t.title))])]):t._e(),t._v(" "),""!==t.message?i("div",{staticClass:"mint-msgbox-content"},[i("div",{staticClass:"mint-msgbox-message",domProps:{innerHTML:t._s(t.message)}}),t._v(" "),i("div",{directives:[{name:"show",rawName:"v-show",value:t.showInput,expression:"showInput"}],staticClass:"mint-msgbox-input"},[i("input",{directives:[{name:"model",rawName:"v-model",value:t.inputValue,expression:"inputValue"}],ref:"input",attrs:{placeholder:t.inputPlaceholder},domProps:{value:t.inputValue},on:{input:function(e){e.target.composing||(t.inputValue=e.target.value)}}}),t._v(" "),i("div",{staticClass:"mint-msgbox-errormsg",style:{visibility:t.editorErrorMessage?"visible":"hidden"}},[t._v(t._s(t.editorErrorMessage))])])]):t._e(),t._v(" "),i("div",{staticClass:"mint-msgbox-btns"},[i("button",{directives:[{name:"show",rawName:"v-show",value:t.showCancelButton,expression:"showCancelButton"}],class:[t.cancelButtonClasses],on:{click:function(e){t.handleAction("cancel")}}},[t._v(t._s(t.cancelButtonText))]),t._v(" "),i("button",{directives:[{name:"show",rawName:"v-show",value:t.showConfirmButton,expression:"showConfirmButton"}],class:[t.confirmButtonClasses],on:{click:function(e){t.handleAction("confirm")}}},[t._v(t._s(t.confirmButtonText))])])])])],1)},staticRenderFns:[]}},2:function(t,e,i){"use strict";var n=i(1),s=i.n(n);i.d(e,"c",function(){return c}),e.a=function(t,e){if(!t)return;for(var i=t.className,n=(e||"").split(" "),s=0,o=n.length;s<o;s++){var r=n[s];r&&(t.classList?t.classList.add(r):d(t,r)||(i+=" "+r))}t.classList||(t.className=i)},e.b=function(t,e){if(!t||!e)return;for(var i=e.split(" "),n=" "+t.className+" ",s=0,o=i.length;s<o;s++){var a=i[s];a&&(t.classList?t.classList.remove(a):d(t,a)&&(n=n.replace(" "+a+" "," ")))}t.classList||(t.className=r(n))};var o=s.a.prototype.$isServer,r=(o||Number(document.documentMode),function(t){return(t||"").replace(/^[\s\uFEFF]+|[\s\uFEFF]+$/g,"")}),a=!o&&document.addEventListener?function(t,e,i){t&&e&&i&&t.addEventListener(e,i,!1)}:function(t,e,i){t&&e&&i&&t.attachEvent("on"+e,i)},l=!o&&document.removeEventListener?function(t,e,i){t&&e&&t.removeEventListener(e,i,!1)}:function(t,e,i){t&&e&&t.detachEvent("on"+e,i)},c=function(t,e,i){var n=function(){i&&i.apply(this,arguments),l(t,e,n)};a(t,e,n)};function d(t,e){if(!t||!e)return!1;if(-1!==e.indexOf(" "))throw new Error("className should not contain space.");return t.classList?t.classList.contains(e):(" "+t.className+" ").indexOf(" "+e+" ")>-1}},225:function(t,e,i){t.exports=i(33)},33:function(t,e,i){"use strict";var n=i(90);Object.defineProperty(e,"__esModule",{value:!0}),i.d(e,"default",function(){return n.a})},65:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(8);e.default={mixins:[n.a],props:{modal:{default:!0},showClose:{type:Boolean,default:!0},lockScroll:{type:Boolean,default:!1},closeOnClickModal:{default:!0},closeOnPressEscape:{default:!0},inputType:{type:String,default:"text"}},computed:{confirmButtonClasses:function(){var t="mint-msgbox-btn mint-msgbox-confirm "+this.confirmButtonClass;return this.confirmButtonHighlight&&(t+=" mint-msgbox-confirm-highlight"),t},cancelButtonClasses:function(){var t="mint-msgbox-btn mint-msgbox-cancel "+this.cancelButtonClass;return this.cancelButtonHighlight&&(t+=" mint-msgbox-cancel-highlight"),t}},methods:{doClose:function(){var t=this;this.value=!1,this._closing=!0,this.onClose&&this.onClose(),setTimeout(function(){t.modal&&"hidden"!==t.bodyOverflow&&(document.body.style.overflow=t.bodyOverflow,document.body.style.paddingRight=t.bodyPaddingRight),t.bodyOverflow=null,t.bodyPaddingRight=null},200),this.opened=!1,this.transition||this.doAfterClose()},handleAction:function(t){if("prompt"!==this.$type||"confirm"!==t||this.validate()){var e=this.callback;this.value=!1,e(t)}},validate:function(){if("prompt"===this.$type){var t=this.inputPattern;if(t&&!t.test(this.inputValue||""))return this.editorErrorMessage=this.inputErrorMessage||"输入的数据不合法!",this.$refs.input.classList.add("invalid"),!1;var e=this.inputValidator;if("function"==typeof e){var i=e(this.inputValue);if(!1===i)return this.editorErrorMessage=this.inputErrorMessage||"输入的数据不合法!",this.$refs.input.classList.add("invalid"),!1;if("string"==typeof i)return this.editorErrorMessage=i,!1}}return this.editorErrorMessage="",this.$refs.input.classList.remove("invalid"),!0},handleInputType:function(t){"range"!==t&&this.$refs.input&&(this.$refs.input.type=t)}},watch:{inputValue:function(){"prompt"===this.$type&&this.validate()},value:function(t){var e=this;this.handleInputType(this.inputType),t&&"prompt"===this.$type&&setTimeout(function(){e.$refs.input&&e.$refs.input.focus()},500)},inputType:function(t){this.handleInputType(t)}},data:function(){return{title:"",message:"",type:"",showInput:!1,inputValue:null,inputPlaceholder:"",inputPattern:null,inputValidator:null,inputErrorMessage:"",showConfirmButton:!0,showCancelButton:!1,confirmButtonText:"确定",cancelButtonText:"取消",confirmButtonClass:"",confirmButtonDisabled:!1,cancelButtonClass:"",editorErrorMessage:null,callback:null}}}},7:function(t,e,i){"use strict";e.a=function(t){for(var e=arguments,i=1,n=arguments.length;i<n;i++){var s=e[i]||{};for(var o in s)if(s.hasOwnProperty(o)){var r=s[o];void 0!==r&&(t[o]=r)}}return t}},8:function(t,e,i){"use strict";var n,s=i(1),o=i.n(s),r=i(7),a=i(9),l=1,c=[],d=function(t){return 3===t.nodeType&&(t=t.nextElementSibling||t.nextSibling,d(t)),t};e.a={props:{value:{type:Boolean,default:!1},transition:{type:String,default:""},openDelay:{},closeDelay:{},zIndex:{},modal:{type:Boolean,default:!1},modalFade:{type:Boolean,default:!0},modalClass:{},lockScroll:{type:Boolean,default:!0},closeOnPressEscape:{type:Boolean,default:!1},closeOnClickModal:{type:Boolean,default:!1}},created:function(){this.transition&&function(t){if(-1===c.indexOf(t)){var e=function(t){var e=t.__vue__;if(!e){var i=t.previousSibling;i.__vue__&&(e=i.__vue__)}return e};o.a.transition(t,{afterEnter:function(t){var i=e(t);i&&i.doAfterOpen&&i.doAfterOpen()},afterLeave:function(t){var i=e(t);i&&i.doAfterClose&&i.doAfterClose()}})}}(this.transition)},beforeMount:function(){this._popupId="popup-"+l++,a.a.register(this._popupId,this)},beforeDestroy:function(){a.a.deregister(this._popupId),a.a.closeModal(this._popupId),this.modal&&null!==this.bodyOverflow&&"hidden"!==this.bodyOverflow&&(document.body.style.overflow=this.bodyOverflow,document.body.style.paddingRight=this.bodyPaddingRight),this.bodyOverflow=null,this.bodyPaddingRight=null},data:function(){return{opened:!1,bodyOverflow:null,bodyPaddingRight:null,rendered:!1}},watch:{value:function(t){var e=this;if(t){if(this._opening)return;this.rendered?this.open():(this.rendered=!0,o.a.nextTick(function(){e.open()}))}else this.close()}},methods:{open:function(t){var e=this;this.rendered||(this.rendered=!0,this.$emit("input",!0));var n=i.i(r.a)({},this,t,this.$props);this._closeTimer&&(clearTimeout(this._closeTimer),this._closeTimer=null),clearTimeout(this._openTimer);var s=Number(n.openDelay);s>0?this._openTimer=setTimeout(function(){e._openTimer=null,e.doOpen(n)},s):this.doOpen(n)},doOpen:function(t){if(!this.$isServer&&(!this.willOpen||this.willOpen())&&!this.opened){this._opening=!0,this.visible=!0,this.$emit("input",!0);var e=d(this.$el),i=t.modal,s=t.zIndex;if(s&&(a.a.zIndex=s),i&&(this._closing&&(a.a.closeModal(this._popupId),this._closing=!1),a.a.openModal(this._popupId,a.a.nextZIndex(),e,t.modalClass,t.modalFade),t.lockScroll)){this.bodyOverflow||(this.bodyPaddingRight=document.body.style.paddingRight,this.bodyOverflow=document.body.style.overflow),n=function(){if(!o.a.prototype.$isServer){if(void 0!==n)return n;var t=document.createElement("div");t.style.visibility="hidden",t.style.width="100px",t.style.position="absolute",t.style.top="-9999px",document.body.appendChild(t);var e=t.offsetWidth;t.style.overflow="scroll";var i=document.createElement("div");i.style.width="100%",t.appendChild(i);var s=i.offsetWidth;return t.parentNode.removeChild(t),e-s}}();var r=document.documentElement.clientHeight<document.body.scrollHeight;n>0&&r&&(document.body.style.paddingRight=n+"px"),document.body.style.overflow="hidden"}"static"===getComputedStyle(e).position&&(e.style.position="absolute"),e.style.zIndex=a.a.nextZIndex(),this.opened=!0,this.onOpen&&this.onOpen(),this.transition||this.doAfterOpen()}},doAfterOpen:function(){this._opening=!1},close:function(){var t=this;if(!this.willClose||this.willClose()){null!==this._openTimer&&(clearTimeout(this._openTimer),this._openTimer=null),clearTimeout(this._closeTimer);var e=Number(this.closeDelay);e>0?this._closeTimer=setTimeout(function(){t._closeTimer=null,t.doClose()},e):this.doClose()}},doClose:function(){var t=this;this.visible=!1,this.$emit("input",!1),this._closing=!0,this.onClose&&this.onClose(),this.lockScroll&&setTimeout(function(){t.modal&&"hidden"!==t.bodyOverflow&&(document.body.style.overflow=t.bodyOverflow,document.body.style.paddingRight=t.bodyPaddingRight),t.bodyOverflow=null,t.bodyPaddingRight=null},200),this.opened=!1,this.transition||this.doAfterClose()},doAfterClose:function(){a.a.closeModal(this._popupId),this._closing=!1}}}},9:function(t,e,i){"use strict";var n=i(1),s=i.n(n),o=i(2),r=!1,a=function(){if(!s.a.prototype.$isServer){var t=c.modalDom;return t?r=!0:(r=!1,t=document.createElement("div"),c.modalDom=t,t.addEventListener("touchmove",function(t){t.preventDefault(),t.stopPropagation()}),t.addEventListener("click",function(){c.doOnModalClick&&c.doOnModalClick()})),t}},l={},c={zIndex:2e3,modalFade:!0,getInstance:function(t){return l[t]},register:function(t,e){t&&e&&(l[t]=e)},deregister:function(t){t&&(l[t]=null,delete l[t])},nextZIndex:function(){return c.zIndex++},modalStack:[],doOnModalClick:function(){var t=c.modalStack[c.modalStack.length-1];if(t){var e=c.getInstance(t.id);e&&e.closeOnClickModal&&e.close()}},openModal:function(t,e,n,l,c){if(!s.a.prototype.$isServer&&t&&void 0!==e){this.modalFade=c;for(var d=this.modalStack,u=0,h=d.length;u<h;u++){if(d[u].id===t)return}var f=a();if(i.i(o.a)(f,"v-modal"),this.modalFade&&!r&&i.i(o.a)(f,"v-modal-enter"),l)l.trim().split(/\s+/).forEach(function(t){return i.i(o.a)(f,t)});setTimeout(function(){i.i(o.b)(f,"v-modal-enter")},200),n&&n.parentNode&&11!==n.parentNode.nodeType?n.parentNode.appendChild(f):document.body.appendChild(f),e&&(f.style.zIndex=e),f.style.display="",this.modalStack.push({id:t,zIndex:e,modalClass:l})}},closeModal:function(t){var e=this.modalStack,n=a();if(e.length>0){var s=e[e.length-1];if(s.id===t){if(s.modalClass)s.modalClass.trim().split(/\s+/).forEach(function(t){return i.i(o.b)(n,t)});e.pop(),e.length>0&&(n.style.zIndex=e[e.length-1].zIndex)}else for(var r=e.length-1;r>=0;r--)if(e[r].id===t){e.splice(r,1);break}}0===e.length&&(this.modalFade&&i.i(o.a)(n,"v-modal-leave"),setTimeout(function(){0===e.length&&(n.parentNode&&n.parentNode.removeChild(n),n.style.display="none",c.modalDom=void 0),i.i(o.b)(n,"v-modal-leave")},200))}};!s.a.prototype.$isServer&&window.addEventListener("keydown",function(t){if(27===t.keyCode&&c.modalStack.length>0){var e=c.modalStack[c.modalStack.length-1];if(!e)return;var i=c.getInstance(e.id);i.closeOnPressEscape&&i.close()}}),e.a=c},90:function(t,e,i){"use strict";var n,s,o=i(1),r=i.n(o),a=i(143),l=i.n(a),c={title:"提示",message:"",type:"",showInput:!1,showClose:!0,modalFade:!1,lockScroll:!1,closeOnClickModal:!0,inputValue:null,inputPlaceholder:"",inputPattern:null,inputValidator:null,inputErrorMessage:"",showConfirmButton:!0,showCancelButton:!1,confirmButtonPosition:"right",confirmButtonHighlight:!1,cancelButtonHighlight:!1,confirmButtonText:"确定",cancelButtonText:"取消",confirmButtonClass:"",cancelButtonClass:""},d=function(t){for(var e=arguments,i=1,n=arguments.length;i<n;i++){var s=e[i];for(var o in s)if(s.hasOwnProperty(o)){var r=s[o];void 0!==r&&(t[o]=r)}}return t},u=r.a.extend(l.a),h=[],f=function(t){if(n){var e=n.callback;if("function"==typeof e&&(s.showInput?e(s.inputValue,t):e(t)),n.resolve){var i=n.options.$type;"confirm"===i||"prompt"===i?"confirm"===t?s.showInput?n.resolve({value:s.inputValue,action:t}):n.resolve(t):"cancel"===t&&n.reject&&n.reject(t):n.resolve(t)}}},p=function(){if(s||((s=new u({el:document.createElement("div")})).callback=f),(!s.value||s.closeTimer)&&h.length>0){var t=(n=h.shift()).options;for(var e in t)t.hasOwnProperty(e)&&(s[e]=t[e]);void 0===t.callback&&(s.callback=f),["modal","showClose","closeOnClickModal","closeOnPressEscape"].forEach(function(t){void 0===s[t]&&(s[t]=!0)}),document.body.appendChild(s.$el),r.a.nextTick(function(){s.value=!0})}},m=function(t,e){if("string"==typeof t?(t={title:t},arguments[1]&&(t.message=arguments[1]),arguments[2]&&(t.type=arguments[2])):t.callback&&!e&&(e=t.callback),"undefined"!=typeof Promise)return new Promise(function(i,n){h.push({options:d({},c,m.defaults||{},t),callback:e,resolve:i,reject:n}),p()});h.push({options:d({},c,m.defaults||{},t),callback:e}),p()};m.setDefaults=function(t){m.defaults=t},m.alert=function(t,e,i){return"object"==typeof e&&(i=e,e=""),m(d({title:e,message:t,$type:"alert",closeOnPressEscape:!1,closeOnClickModal:!1},i))},m.confirm=function(t,e,i){return"object"==typeof e&&(i=e,e=""),m(d({title:e,message:t,$type:"confirm",showCancelButton:!0},i))},m.prompt=function(t,e,i){return"object"==typeof e&&(i=e,e=""),m(d({title:e,message:t,showCancelButton:!0,showInput:!0,$type:"prompt"},i))},m.close=function(){s&&(s.value=!1,h=[],n=null)},e.a=m}})},"3p5s":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i("Gu7T"),s=i.n(n),o=i("mvHQ"),r=i.n(o),a=i("Dd8w"),l=i.n(a),c=(i("OgVB"),i("/Lyv")),d=i.n(c),u=(i("34+y"),i("X+yh")),h=i.n(u),f=i("fZjL"),p=i.n(f),m=i("DOJ6"),v={filters:{keyToCharacter:function(t){var e=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],i="",n="string"==typeof t;if(n&&t.match(/_/)&&(t=t.split("_")[1]),e&&n){var s="";[/tq/,/yq/,/zhq/].some(function(e){return t.match(e)&&(s=t.match(e)[0]),e.test(t)})&&(t=t.split(s)[1])}for(var o in m.hecai)if(o===t){i=m.hecai[o];break}return i||(i=t),i}},data:function(){return{odds:{},shengxiao:"",order:{},orderList:[],goldRemaining:0,timer:{},submitIng:!1}},computed:{allGold:function(){var t=0;return this.orderList.forEach(function(e){t+=1*e.gold}),t}},mounted:function(){this.$parent.tabbarShow=!1,this.shengxiao=this.$getLocalCache("six-shengxiao"),this.odds=this.$getLocalCache("six-odds"),this.goldRemaining=JSON.parse(localStorage.getItem("bc_userInfo")).gold;var t=this.GLOBAL.six.countdown;if(this.countTime(t,"timeToOpen"),this.orderList=this.GLOBAL.six.hecai_orderList||[],this.$route.query.getOrder){var e=this.GLOBAL.six.hecai_order;p()(e).length&&(this.order=e),console.log("用户下注信息："),console.dir(e)}this.dealOnMessage()},methods:{submit:function(){var t=this,e=JSON.parse(localStorage.getItem("bc_userInfo")),i=e.id;if(e.gold<this.allGold)h()({message:"余额不足哟",duration:1500});else{var n=this.orderList[0].issue,s=function(){t.senddata({data:{type:"create",game:"six",order:t.orderList,issue:n,id:i,createTime:(new Date).Format("yyyy-MM-dd hh:mm:ss"),allGold:t.orderList.length*t.orderList[0].gold}}),t.submitIng=!0},o=this.GLOBAL.hecaiHost;this.GLOBAL.gameSocketHand?s():this.createSocket(o,function(){s()})}},remove:function(t){this.orderList.splice(t,1),this.$set(this.GLOBAL.six,"hecai_order",this.orderList)},resetOrder:function(){var t=this;d.a.confirm("确定清空所有注单吗?","",{confirmButtonClass:"font-theme"}).then(function(e){t.GLOBAL.six.hecai_orderList=t.orderList=[]})},dealOnMessage:function(){var t=this;this.onmessage(function(e){if("pong"===(e=JSON.parse(e)).code&&t.senddata({data:{type:"ping"}}),e.create&&void 0!==e.remaining){t.submitIng=!1,t.GLOBAL.six.hecai_orderList=t.orderList=[];var i=JSON.parse(window.localStorage.getItem("bc_userInfo"));i=l()({},i,{gold:e.remaining}),t.$set(t.GLOBAL,"userInfo",i),window.localStorage.setItem("bc_userInfo",r()(i)),h()({message:"下注成功，可用余额为"+e.remaining,duration:1e3}),setTimeout(function(){t.$router.go(-1)},1e3)}!1===e.create&&(t.submitIng=!1,h()({message:"下注失败",duration:1e3}),setTimeout(function(){t.$router.go(-1)},1e3)),"期号发生了变更"===e.code&&(t.submitIng=!1,h()({message:"下注失败，期号发生了变更",duration:1500}),t.GLOBAL.six.hecai_orderList=t.orderList=[],t.GLOBAL.six.issue=e.issue,setTimeout(function(){t.$router.go(-1)},1500))})},countTime:function(t,e){var i=this;this.timer[e+"Interval"]=setInterval(function(){var n=t-(new Date).getTime(),s=void 0,o=void 0,r=void 0;function a(t){return t<10?"0"+t:t}n>=0?(s=a(Math.floor(n/1e3/60/60%24)),o=a(Math.floor(n/1e3/60%60)),r=a(Math.floor(n/1e3%60)),i.$set(i.timer,e,s+":"+o+":"+r)):clearInterval(i.timer[e+"timer"])},1e3)}},watch:{order:function(t){var e=[],i=this.order,n=i.type,o=i.leiXin,r=i.number,a=["zxbzh","lma","zhy"].includes(n),c="shx"===n,d="hq"===n,u="lqlw"===n,h="zhmgg"===n;function f(t,e,i){i=i||[],t.length;var n=t.slice(0),s=n.shift();return function t(n,s){var o,r=s.slice(0),a=e-n.length;if(0!=a){if(1==a)for(var l in s)(o=n.slice(0)).push(s[l]),i.push(o);a>1&&((o=n.slice(0)).push(r.shift()),t(o,r),n.length+r.length>=e&&t(n,r))}else i.push(n)}(s=s.constructor===Array?s:[s],n),n.length>=e?f(n,e,i):i}a||c||d||u||h?a?function(){var t=this,i=1*o.match(/\d+/)[0];f(r,i).forEach(function(i){var s=t.odds[n][o];e.push(l()({},t.order,{odds:s,number:i}))}),this.orderList=[].concat(s()(this.orderList),e),this.$set(this.GLOBAL.six,"hecai_orderList",this.orderList)}.call(this):c?function(){var t=this.odds[n][o];if("zq"===this.leiXin)for(var i in r)e.push(l()({},this.order,{odds:t,number:r[i]}));else for(var a in r)e.push(l()({},this.order,{odds:t,number:o+r[a]}));this.orderList=[].concat(s()(this.orderList),e),this.$set(this.GLOBAL.six,"hecai_orderList",this.orderList)}.call(this):d?(this.orderList=[].concat(s()(this.orderList),[this.order]),this.$set(this.GLOBAL.six,"hecai_order",this.orderList)):h?function(){var t=[];["zhy","zher","zhs","zhsi","zhw","zhl"].forEach(function(e,i){t.push(r[e]?r[e]:" | ")}),this.orderList=[].concat(s()(this.orderList),[l()({},this.order,{number:t})]),this.$set(this.GLOBAL.six,"hecai_orderList",this.orderList)}.call(this):u&&function(){var t=this,i=1*o.match(/\d+/)[0],n=o.match(/lq/);f(r,i).forEach(function(i){var s=0,o=t.shengxiao;s=n?i.includes(o)?t.order.odds[o]:t.order.odds["no"+o]:t.order.odds,e.push(l()({},t.order,{odds:s,number:i}))}),this.orderList=[].concat(s()(this.orderList),e),this.$set(this.GLOBAL.six,"hecai_orderList",this.orderList)}.call(this):function(){for(var t in r){var i=o?this.odds[n][o][r[t]]:this.odds[n][r[t]];e.push(l()({},this.order,{odds:i,number:r[t]}))}this.orderList=[].concat(s()(this.orderList),e),this.$set(this.GLOBAL.six,"hecai_orderList",this.orderList),console.log("保存下注信息："),console.dir(this.GLOBAL.six)}.call(this)}}},g={render:function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"contanier flex flow-col"},[i("header",{staticClass:"dent-header flex justify-sb fz-16"},[i("div",{staticClass:"isleft flex iconfont icon-left click-icon",attrs:{dentHoverclass:"hoverclass"},on:{click:function(e){t.$router.go(-1)}}}),t._v(" "),i("div",{staticClass:"iscenter flex justify-ct"},[t._v("投注单")]),t._v(" "),i("div",{staticClass:"isleft"})]),t._v(" "),i("div",{staticClass:"bets flex flow-col"},[i("p",{staticClass:"bets-time-left fontc-6"},[i("span",[t._v(t._s(t.order.issue))]),t._v("期投注截止时间：\n      "),i("span",{staticClass:"font-theme"},[t._v(t._s(t.timer.timeToOpen))])]),t._v(" "),i("div",{staticClass:"bets-ticket"}),t._v(" "),i("div",{staticClass:"ticket-wrap"},[i("transition-group",{attrs:{name:"ticketout",tag:"div"}},t._l(t.orderList,function(e,n){return i("div",{key:e.number,staticClass:"ticket-item flex justify-sb"},[i("div",{staticClass:"ticket-item-info flex flow-col"},[i("p",{staticClass:"fontc-6 fz-12"},[e.leiXin&&"hq"!==e.type?[i("span",[t._v(t._s(t._f("keyToCharacter")(e.type)))]),t._v("("),i("span",[t._v(t._s(t._f("keyToCharacter")(e.leiXin,!1)))]),t._v(")\n              ")]:[i("span",[t._v(t._s(t._f("keyToCharacter")(e.type)))]),t._v("("),i("span",[t._v(t._s(t._f("keyToCharacter")(e.type)))]),t._v(")\n              ")],t._v("\n              共"),i("span",{staticClass:"font-theme"},[t._v("1")]),t._v("注，共"),i("span",{staticClass:"font-theme"},[t._v(t._s(e.gold))]),t._v("元\n            ")],2),t._v(" "),e.number instanceof Array?i("p",{staticClass:"fz-16"},[t._l(e.number,function(n,s){return[i("span",[t._v(t._s(t._f("keyToCharacter")(n)))]),s!==e.number.length-1?i("span",[t._v(t._s(" , "))]):t._e()]})],2):"zhmt"===e.type?i("span",{staticClass:"fz-16"},[t._v(t._s(e.number.match(/\d+/)[0]))]):i("span",{staticClass:"fz-16"},[t._v(t._s(t._f("keyToCharacter")(e.number)))])]),t._v(" "),i("span",{staticClass:"iconfont icon-guanbi cancel-ticket",on:{click:function(e){t.remove(n)}}})])}))],1)]),t._v(" "),i("div",{staticClass:"hecai-bottom flex justify-sb bgc-fff"},[i("div",{staticClass:"hecai-btn random-btn",on:{click:t.resetOrder}},[t._v("清空")]),t._v(" "),i("div",{staticClass:"should-pay flex flow-col justify-sa fontc-3 fz-12"},[i("p",[t._v("合计"),t.orderList.length?i("span",{staticClass:"font-theme"},[t._v(t._s(t.allGold)+"元")]):t._e()]),t._v(" "),i("p",[t._v("可用余额"),i("span",{staticClass:"font-theme"},[t._v(t._s(t.goldRemaining))])])]),t._v(" "),t.orderList.length&&!t.submitIng?i("div",{staticClass:"hecai-btn submit-btn cansubmit",on:{click:t.submit}},[t._v("投注")]):i("div",{staticClass:"hecai-btn submit-btn"},[t._v("投注")])])])},staticRenderFns:[]};var y=i("VU/8")(v,g,!1,function(t){i("aM77")},"data-v-d50cb8b2",null);e.default=y.exports},OgVB:function(t,e){},aM77:function(t,e){}});
//# sourceMappingURL=16.3c6d1f7da74a07c04382.js.map