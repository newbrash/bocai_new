webpackJsonp([2],{"06OY":function(t,e,s){var n=s("3Eo+")("meta"),a=s("EqjI"),o=s("D2L2"),r=s("evD5").f,i=0,c=Object.isExtensible||function(){return!0},l=!s("S82l")(function(){return c(Object.preventExtensions({}))}),u=function(t){r(t,n,{value:{i:"O"+ ++i,w:{}}})},d=t.exports={KEY:n,NEED:!1,fastKey:function(t,e){if(!a(t))return"symbol"==typeof t?t:("string"==typeof t?"S":"P")+t;if(!o(t,n)){if(!c(t))return"F";if(!e)return"E";u(t)}return t[n].i},getWeak:function(t,e){if(!o(t,n)){if(!c(t))return!0;if(!e)return!1;u(t)}return t[n].w},onFreeze:function(t){return l&&d.NEED&&c(t)&&!o(t,n)&&u(t),t}}},"4WTo":function(t,e,s){var n=s("NWt+");t.exports=function(t,e){var s=[];return n(t,!1,s.push,s,e),s}},"7Doy":function(t,e,s){var n=s("EqjI"),a=s("7UMu"),o=s("dSzd")("species");t.exports=function(t){var e;return a(t)&&("function"!=typeof(e=t.constructor)||e!==Array&&!a(e.prototype)||(e=void 0),n(e)&&null===(e=e[o])&&(e=void 0)),void 0===e?Array:e}},"7UMu":function(t,e,s){var n=s("R9M2");t.exports=Array.isArray||function(t){return"Array"==n(t)}},"9Bbf":function(t,e,s){"use strict";var n=s("kM2E");t.exports=function(t){n(n.S,t,{of:function(){for(var t=arguments.length,e=new Array(t);t--;)e[t]=arguments[t];return new this(e)}})}},"9C8M":function(t,e,s){"use strict";var n=s("evD5").f,a=s("Yobk"),o=s("xH/j"),r=s("+ZMJ"),i=s("2KxR"),c=s("NWt+"),l=s("vIB/"),u=s("EGZi"),d=s("bRrM"),h=s("+E39"),m=s("06OY").fastKey,f=s("LIJb"),v=h?"_s":"size",_=function(t,e){var s,n=m(e);if("F"!==n)return t._i[n];for(s=t._f;s;s=s.n)if(s.k==e)return s};t.exports={getConstructor:function(t,e,s,l){var u=t(function(t,n){i(t,u,e,"_i"),t._t=e,t._i=a(null),t._f=void 0,t._l=void 0,t[v]=0,void 0!=n&&c(n,s,t[l],t)});return o(u.prototype,{clear:function(){for(var t=f(this,e),s=t._i,n=t._f;n;n=n.n)n.r=!0,n.p&&(n.p=n.p.n=void 0),delete s[n.i];t._f=t._l=void 0,t[v]=0},delete:function(t){var s=f(this,e),n=_(s,t);if(n){var a=n.n,o=n.p;delete s._i[n.i],n.r=!0,o&&(o.n=a),a&&(a.p=o),s._f==n&&(s._f=a),s._l==n&&(s._l=o),s[v]--}return!!n},forEach:function(t){f(this,e);for(var s,n=r(t,arguments.length>1?arguments[1]:void 0,3);s=s?s.n:this._f;)for(n(s.v,s.k,this);s&&s.r;)s=s.p},has:function(t){return!!_(f(this,e),t)}}),h&&n(u.prototype,"size",{get:function(){return f(this,e)[v]}}),u},def:function(t,e,s){var n,a,o=_(t,e);return o?o.v=s:(t._l=o={i:a=m(e,!0),k:e,v:s,p:n=t._l,n:void 0,r:!1},t._f||(t._f=o),n&&(n.n=o),t[v]++,"F"!==a&&(t._i[a]=o)),t},getEntry:_,setStrong:function(t,e,s){l(t,e,function(t,s){this._t=f(t,e),this._k=s,this._l=void 0},function(){for(var t=this._k,e=this._l;e&&e.r;)e=e.p;return this._t&&(this._l=e=e?e.n:this._t._f)?u(0,"keys"==t?e.k:"values"==t?e.v:[e.k,e.v]):(this._t=void 0,u(1))},s?"entries":"values",!s,!0),d(e)}}},ALrJ:function(t,e,s){var n=s("+ZMJ"),a=s("MU5D"),o=s("sB3e"),r=s("QRG4"),i=s("oeOm");t.exports=function(t,e){var s=1==t,c=2==t,l=3==t,u=4==t,d=6==t,h=5==t||d,m=e||i;return function(e,i,f){for(var v,_,p=o(e),w=a(p),S=n(i,f,3),g=r(w.length),b=0,C=s?m(e,g):c?m(e,0):void 0;g>b;b++)if((h||b in w)&&(_=S(v=w[b],b,p),t))if(s)C[b]=_;else if(_)switch(t){case 3:return!0;case 5:return v;case 6:return b;case 2:C.push(v)}else if(u)return!1;return d?-1:l||u?u:C}}},BDhv:function(t,e,s){var n=s("kM2E");n(n.P+n.R,"Set",{toJSON:s("m9gC")("Set")})},GKov:function(t,e){},HpRW:function(t,e,s){"use strict";var n=s("kM2E"),a=s("lOnJ"),o=s("+ZMJ"),r=s("NWt+");t.exports=function(t){n(n.S,t,{from:function(t){var e,s,n,i,c=arguments[1];return a(this),(e=void 0!==c)&&a(c),void 0==t?new this:(s=[],e?(n=0,i=o(c,arguments[2],2),r(t,!1,function(t){s.push(i(t,n++))})):r(t,!1,s.push,s),new this(s))}})}},KBEs:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=s("Gu7T"),a=s.n(n),o=s("d7EF"),r=s.n(o),i=s("k8mJ"),c=s("lHA8"),l=s.n(c),u=s("c/Tr"),d=s.n(u),h=s("fZjL"),m=s.n(h),f=s("DOJ6"),v={props:{betsObj:[Array,Object],currentOdds:String,activeTab:[String,Number],value:Array},filters:{keyToCharacter:function(t){var e="";if(t.match(/_/))return t=t.split("_")[1];for(var s in f.jsks)if(s===t){e=f.jsks[s];break}return e||(e=t),e}},data:function(){return{normal:!1,handy:!1,showNum:!1,showSecondNum:!1,showNumAndOdds:!1,textareaValue:"",showSecondNumFirstValue:0,showSecondNumSecondValue:[],textareaFocus:!1}},computed:{normalShouldRender:function(){var t=void 0,e=this.currentOdds,s=this.betsObj;return"twoSame-twoSameDb"===e&&(t={"11*":1,"22*":2,"33*":3,"44*":4,"55*":5,"66*":6}),"threeSame-threeSameSg"===e&&(t={111:1,222:2,333:3,444:4,555:5,666:6}),"threeSame-threeSameDb"===e&&(t={111:"111",222:"222",333:"333",444:"444",555:"555",666:"666"}),"threeConAll-threeConAllCommom"===e&&(t={123:"123",234:"234",345:"345",456:"456"}),s||t},showNumShouldRender:function(){var t=void 0;return"twoSame-commom"===this.currentOdds&&(t=["11","22","33","44","55","66"]),t||6},normalShowOdds:function(){return!["twoSame-twoSameDb","threeSame-threeSameSg","threeSame-threeSameDb","threeConAll-threeConAllCommom"].includes(this.currentOdds)},toggleCheckAll:{get:function(){var t=this.value instanceof Array?this.value.length:0;return(this.normalShouldRender?m()(this.normalShouldRender).length:null)===t},set:function(t){var e=this;(this.value=[],t)&&m()(this.normalShouldRender).forEach(function(t){e.value.push(t)})}}},methods:{twoDiffrentdantuo:function(){if(this.showSecondNum){var t={first:this.showSecondNumFirstValue,second:this.showSecondNumSecondValue};this.$emit("input",t)}}},watch:{value:function(t){this.$emit("input",t)},textareaValue:function(t){var e=this;if(""!==t){var s=t.match(/([1-6]+)(?=\s|,|，|\n|$)/g).filter(function(t){var s=!1,n=!1;if("twoDiffrent-handy"===e.currentOdds&&(s=11<t&&t<66,n=t%11!=0),"twoSame-handy"===e.currentOdds&&(s=111<t&&t<666)){var a=t.toString().split("");n=2===d()(new l.a(a)).length}if("threeDiffrent-handy"===e.currentOdds&&(s=122<t&&t<655)){var o=t.toString().split("");n=!(o[0]===o[1]||o[0]===o[2])}return s&&n&&t}),n=d()(new l.a(s));this.value=n}else this.value=[]},showSecondNumFirstValue:function(t){"twoSame-commom"===this.currentOdds&&(t/=11);var e=this.showSecondNumSecondValue.indexOf(t);-1!==e&&this.showSecondNumSecondValue.splice(e,1),this.twoDiffrentdantuo()},showSecondNumSecondValue:function(t){var e=t[t.length-1];"twoSame-commom"===this.currentOdds&&(e*=11),e==this.showSecondNumFirstValue&&(this.showSecondNumFirstValue=null),this.twoDiffrentdantuo()},currentOdds:{handler:function(t){this.normal=["twoSame-twoSameDb","threeSame-threeSameSg","threeSame-threeSameDb","threeConAll-threeConAllCommom","sum-size"].includes(t),this.handy=["twoDiffrent-handy","twoSame-handy","threeDiffrent-handy"].includes(t),this.showNum=["twoDiffrent-commom","threeDiffrent-commom"].includes(t),this.showSecondNum=["twoDiffrent-dantuo","twoSame-commom"].includes(t),this.showNumAndOdds=["sum-sum"].includes(t),this.showSecondNumFirstValue=0,this.showSecondNumSecondValue=[]},immediate:!0}}},_={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"odds-main"},[s("div",{staticClass:"odds-right-tips",on:{click:function(e){t.$emit("ruleModalShow")}}},[t._v("玩法提示"),s("span",{staticClass:"iconfont icon-htbarrowright02"})]),t._v(" "),t._m(0),t._v(" "),t.showNum||t.showSecondNum?s("div",{staticClass:"odds bgc-fff"},[s("div",{staticClass:"odds-item-wrap flex justify-sa"},["twoDiffrent-dantuo"===t.currentOdds?s("span",{staticClass:"odds-item-title fontc-6 fz-12"},[t._v("拖码")]):t._e(),t._v(" "),"twoSame-commom"===t.currentOdds?s("span",{staticClass:"odds-item-title fontc-6 fz-12"},[t._v("二同号")]):t._e(),t._v(" "),["twoDiffrent-commom","threeDiffrent-commom"].includes(t.currentOdds)?s("span",{staticClass:"odds-item-title fontc-6 fz-12"},[t._v("号码")]):t._e(),t._v(" "),t._l(t.showNumShouldRender,function(e){return s("label",{staticClass:"odds-item showAllNum-item"},[t.showSecondNum?s("input",{directives:[{name:"model",rawName:"v-model",value:t.showSecondNumFirstValue,expression:"showSecondNumFirstValue"}],staticClass:"dent-bg-input hidden",attrs:{type:"radio"},domProps:{value:e,checked:t._q(t.showSecondNumFirstValue,e)},on:{change:function(s){t.showSecondNumFirstValue=e}}}):s("input",{directives:[{name:"model",rawName:"v-model",value:t.value,expression:"value"}],staticClass:"dent-bg-input hidden",attrs:{type:"checkbox"},domProps:{value:e,checked:Array.isArray(t.value)?t._i(t.value,e)>-1:t.value},on:{change:function(s){var n=t.value,a=s.target,o=!!a.checked;if(Array.isArray(n)){var r=e,i=t._i(n,r);a.checked?i<0&&(t.value=n.concat([r])):i>-1&&(t.value=n.slice(0,i).concat(n.slice(i+1)))}else t.value=o}}}),t._v(" "),s("div",{staticClass:"bg flex flow-col justify-ct"},[s("span",{staticClass:"odds-bets"},[t._v(t._s(e))])])])})],2),t._v(" "),t.showSecondNum?s("div",{staticClass:"odds-item-wrap flex justify-sa"},["twoSame-commom"===t.currentOdds?s("span",{staticClass:"odds-item-title fontc-6 fz-12"},[t._v("不同号")]):t._e(),t._v(" "),"twoDiffrent-dantuo"===t.currentOdds?s("span",{staticClass:"odds-item-title fontc-6 fz-12"},[t._v("拖码")]):t._e(),t._v(" "),t._l(6,function(e){return s("label",{staticClass:"odds-item showAllNum-item"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.showSecondNumSecondValue,expression:"showSecondNumSecondValue"}],staticClass:"dent-bg-input hidden",attrs:{type:"checkbox"},domProps:{value:e,checked:Array.isArray(t.showSecondNumSecondValue)?t._i(t.showSecondNumSecondValue,e)>-1:t.showSecondNumSecondValue},on:{change:function(s){var n=t.showSecondNumSecondValue,a=s.target,o=!!a.checked;if(Array.isArray(n)){var r=e,i=t._i(n,r);a.checked?i<0&&(t.showSecondNumSecondValue=n.concat([r])):i>-1&&(t.showSecondNumSecondValue=n.slice(0,i).concat(n.slice(i+1)))}else t.showSecondNumSecondValue=o}}}),t._v(" "),s("div",{staticClass:"bg flex flow-col justify-ct"},[s("span",{staticClass:"odds-bets"},[t._v(t._s(e))])])])})],2):t._e()]):t._e(),t._v(" "),t.handy?s("div",{staticClass:"odds bgc-fff"},[s("textarea",{directives:[{name:"model",rawName:"v-model",value:t.textareaValue,expression:"textareaValue"}],staticClass:"odds-textarea",class:t.textareaFocus?"odds-textarea-focus":"",attrs:{placeholder:"请手动输入号码"},domProps:{value:t.textareaValue},on:{focus:function(e){t.textareaFocus=!0},blur:function(e){t.textareaFocus=!1},input:function(e){e.target.composing||(t.textareaValue=e.target.value)}}}),t._v(" "),s("p",{staticClass:"textarea-tips fontc-9"},[t._v("每一注号码之间请用逗号[,]、空格[ ]、或者 换行 隔开。")])]):t._e(),t._v(" "),t.normal?s("div",{staticClass:"odds odds-normal flex bgc-fff"},t._l(t.normalShouldRender,function(e,n){return s("label",{staticClass:"odds-item"},[["threeConAll-threeConAllCommom","threeSame-threeSameDb"].includes(t.currentOdds)?s("input",{directives:[{name:"model",rawName:"v-model",value:t.toggleCheckAll,expression:"toggleCheckAll"}],staticClass:"dent-bg-input hidden",attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.toggleCheckAll)?t._i(t.toggleCheckAll,null)>-1:t.toggleCheckAll},on:{change:function(e){var s=t.toggleCheckAll,n=e.target,a=!!n.checked;if(Array.isArray(s)){var o=t._i(s,null);n.checked?o<0&&(t.toggleCheckAll=s.concat([null])):o>-1&&(t.toggleCheckAll=s.slice(0,o).concat(s.slice(o+1)))}else t.toggleCheckAll=a}}}):["threeSame-threeSameSg","twoSame-twoSameDb"].includes(t.currentOdds)?s("input",{directives:[{name:"model",rawName:"v-model",value:t.value,expression:"value"}],staticClass:"dent-bg-input hidden",attrs:{type:"checkbox"},domProps:{value:e,checked:Array.isArray(t.value)?t._i(t.value,e)>-1:t.value},on:{change:function(s){var n=t.value,a=s.target,o=!!a.checked;if(Array.isArray(n)){var r=e,i=t._i(n,r);a.checked?i<0&&(t.value=n.concat([r])):i>-1&&(t.value=n.slice(0,i).concat(n.slice(i+1)))}else t.value=o}}}):s("input",{directives:[{name:"model",rawName:"v-model",value:t.value,expression:"value"}],staticClass:"dent-bg-input hidden",attrs:{type:"checkbox"},domProps:{value:n,checked:Array.isArray(t.value)?t._i(t.value,n)>-1:t.value},on:{change:function(e){var s=t.value,a=e.target,o=!!a.checked;if(Array.isArray(s)){var r=n,i=t._i(s,r);a.checked?i<0&&(t.value=s.concat([r])):i>-1&&(t.value=s.slice(0,i).concat(s.slice(i+1)))}else t.value=o}}}),t._v(" "),s("div",{staticClass:"bg flex flow-col justify-ct"},[s("span",{staticClass:"odds-bets"},[t._v(t._s(t._f("keyToCharacter")(n)))]),t._v(" "),t.normalShowOdds?s("span",{staticClass:"odds-num font-theme"},[t._v("赔率:"+t._s(e))]):t._e()])])})):t._e(),t._v(" "),t.showNumAndOdds?s("div",{staticClass:"odds flex bgc-fff"},t._l(t.betsObj,function(e,n,a){return s("label",{staticClass:"odds-item showNumAndOdds-item"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.value,expression:"value"}],staticClass:"dent-bg-input hidden",attrs:{type:"checkbox"},domProps:{value:n,checked:Array.isArray(t.value)?t._i(t.value,n)>-1:t.value},on:{change:function(e){var s=t.value,a=e.target,o=!!a.checked;if(Array.isArray(s)){var r=n,i=t._i(s,r);a.checked?i<0&&(t.value=s.concat([r])):i>-1&&(t.value=s.slice(0,i).concat(s.slice(i+1)))}else t.value=o}}}),t._v(" "),s("div",{staticClass:"bg flex flow-col justify-ct"},[s("span",{staticClass:"odds-bets"},[t._v(t._s(t._f("keyToCharacter")(n)))])]),t._v(" "),s("span",{staticClass:"font-theme showAllNumAndNum"},[t._v(t._s(Number(e).toFixed(2)))])])})):t._e()])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"odds-left-tips"},[this._v("赔率: "),e("span",{staticClass:"font-theme"},[this._v("6.300")])])}]};var p=s("VU/8")(v,_,!1,function(t){s("GKov")},"data-v-2df7c638",null).exports,w={twoDiffrent:{twoDiffrent:{commom:"",handy:"",dantuo:""}},twoSame:{twoSameSg:{commom:"",handy:""},twoSameDb:{twoSameDb:""}},threeDiffrent:{threeDiffrent:{commom:"",handy:""}},threeSame:{threeSameSg:{threeSameSg:""},threeSameDb:{threeSameDb:""}},threeConAll:{threeConAllCommom:{threeConAllCommom:""}},sum:{sum:{size:"",sum:""}}},S=s("IfhF"),g={name:"jsks",mixins:[S.b,S.a,S.c],components:{dentGameHeader:i.a,dentGameRuleModal:function(){return s.e(54).then(s.bind(null,"KRcm"))},bets:p},data:function(){return{odds:{},jsksobj:w,currentOdds:"",default_gold:2,shouldCommit:[],totalBets:0,maxOdds:0,nextIssue:0,openLately:!1,ruleModalShow:!1}},computed:{betsObj:function(){var t=void 0;if(["sum-size","sum-sum"].includes(this.currentOdds)){var e=this.currentOdds.split("-"),s=r()(e,2),n=s[0],a=s[1];t=this.odds[n][a]}return t},handy:function(){return["twoDiffrent-handy","twoSame-handy","threeDiffrent-handy"].includes(this.currentOdds)},canEarn:function(){return this.maxOdds*this.default_gold}},mounted:function(){this.$parent.tabbarShow=!1,this.getOddsData({gameName:"jsks","断网了":!1})},methods:{sendOrderToPage:function(){var t=this;this.checkLogin(function(){t.currentOdds;var e=t.shouldCommit,s=t.currentOdds.split("-")[0],n={id:11,issue:t.nextIssue,zhuShu:t.totalBets,type:s,leiXin:t.currentOdds,gold:t.default_gold,allGold:0,number:e};t.shouldCommit=[],t.GLOBAL.jsks.order=n,t.$router.push({name:"dentGameWaiForPay",query:{getOrder:!0}})})},onClickOpr:function(t){switch(t){case 0:break;case 1:this.$router.push({name:"dentGameOpenLately",query:{key:"jsks",gameName:"江苏快三"}});break;case 2:this.$router.push("/dentGameOrder")}},onSwitch:function(t){this.currentOdds=t,this.shouldCommit=[]}},watch:{shouldCommit:{handler:function(t){var e,s,n=0,o=void 0;switch(this.currentOdds){case"twoDiffrent-commom":s=t.length,n=i(s,2);break;case"threeDiffrent-commom":!function(){var e=t.length;n=i(e,3)}();break;case"twoSame-commom":case"twoDiffrent-dantuo":e=t.second&&t.second.length,n=t.first&&e;break;case"threeSame-threeSameDb":case"threeConAll-threeConAllCommom":n=t.length&&1;break;default:n=t.length}function i(t,e){if(t<e)return 0;function s(t){return t<=1?1:t*s(t-1)}return s(t)/(s(t-e)*s(e))}(function(){var e=this;if(["twoSame-commom","twoSame-handy"].includes(this.currentOdds))o=this.odds.twoSame.twoSameSg;else if(["sum-size","sum-sum"].includes(this.currentOdds)){var s=this.currentOdds.split("-")[1],n=t.map(function(t){return e.odds.sum[s][t]});o=Math.max.apply(Math,a()(n))}else{var i=this.currentOdds.split("-"),c=r()(i,2),l=c[0],u=c[1];"number"==typeof this.odds[l]?o=this.odds[l]:this.odds[l]instanceof Object&&(o=this.odds[l][u])}}).call(this),this.maxOdds=o,this.totalBets=n},deep:!0}}},b={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"contanier"},[s("dentGameHeader",{attrs:{obj:t.jsksobj,gameName:"jsks",subType:"multipleSub",rightNormal:"true"},on:{onSubSelect:t.onSwitch,onClickRightIcon:t.onClickRightIcon,onClickOpr:t.onClickOpr}},[s("span",{attrs:{slot:"tips"},slot:"tips"},[t._v("玩法")])]),t._v(" "),s("div",{staticClass:"flex-wrap flex flow-col"},[s("div",{staticClass:"open flex bgc-fff"},[s("div",{staticClass:"time-left flex flow-col justify-sa"},[s("p",{staticClass:"fz12"},[t._v("距离8114期截止时间")]),t._v(" "),s("div",{staticClass:"font-theme"},[t._v("\n          "+t._s(t.timer.timeToOpen)+"\n        ")])]),t._v(" "),s("div",{staticClass:"open-num flex flow-col justify-sa",attrs:{dentHoverclass:"hoverclass"},on:{click:function(e){t.openLately=!t.openLately}}},[s("p",{staticClass:"flex"},[t._v("第8113期 "),s("span",{staticClass:"iconfont icon-arrow-down",class:t.openLately?"_arrow-down":""})]),t._v(" "),t._m(0)])]),t._v(" "),s("div",{staticClass:"open-lately",class:t.openLately?"open-lately-expand":""},[s("table",{staticStyle:{width:"120%"}},[t._m(1),t._v(" "),t._m(2),t._v(" "),s("tbody",[s("tr",[s("td",[t._v("8114期")]),t._v(" "),s("td",[s("openNum",{attrs:{arr:[42,19,29,7,39,9,41]}})],1),t._v(" "),s("td",[t._v("木")]),t._v(" "),s("td",[t._v("头0")]),t._v(" "),s("td",[t._v("尾8")])])])])]),t._v(" "),s("div",{staticClass:"odds-wrap flex flow-col"},[s("bets",{attrs:{betsObj:t.betsObj,currentOdds:t.currentOdds},on:{ruleModalShow:function(e){t.ruleModalShow=!0}},model:{value:t.shouldCommit,callback:function(e){t.shouldCommit=e},expression:"shouldCommit"}}),t._v(" "),s("transition",{attrs:{name:"popUp"}},[t.handy?s("div",{directives:[{name:"show",rawName:"v-show",value:t.totalBets,expression:"totalBets"}],staticClass:"bets-handy"},[s("transition-group",{attrs:{name:"betsDropin",tag:"div"}},t._l(t.shouldCommit,function(e,n){return s("div",{key:n,staticClass:"bets-handy-item"},[s("span",[t._v(t._s(e))]),n!==t.shouldCommit.length-1?s("span",[t._v(" , ")]):t._e()])}))],1):t._e()]),t._v(" "),s("transition",{attrs:{name:"slideUp"}},[s("div",{directives:[{name:"show",rawName:"v-show",value:t.totalBets,expression:"totalBets"}],staticClass:"bets-total flex justify-sb"},[s("div",[s("span",[t._v("共"),s("span",{staticClass:"font-theme"},[t._v(t._s(t.totalBets))]),t._v("注")]),t._v(" "),s("span",[t._v("共"),s("span",{staticClass:"font-theme"},[t._v(t._s(t.totalBets*t.default_gold))]),t._v("元")])]),t._v(" "),s("span",[t._v("单注最多可盈利"),s("span",{staticClass:"font-theme"},[t._v(t._s(t.canEarn))]),t._v("元")])])])],1),t._v(" "),s("div",{staticClass:"hecai-bottom flex justify-sb bgc-fff"},[t.totalBets?s("div",{staticClass:"hecai-btn random-btn"},[t._v("清空")]):s("div",{staticClass:"hecai-btn random-btn"},[t._v("机选")]),t._v(" "),s("div",{staticClass:"bets-per-gold"},[t._v("单注"),s("input",{directives:[{name:"model",rawName:"v-model",value:t.default_gold,expression:"default_gold"}],attrs:{type:"text"},domProps:{value:t.default_gold},on:{input:function(e){e.target.composing||(t.default_gold=e.target.value)}}}),t._v("元")]),t._v(" "),t.totalBets?s("div",{staticClass:"hecai-btn submit-btn cansubmit",on:{click:t.sendOrderToPage}},[t._v("确定")]):s("div",{staticClass:"hecai-btn submit-btn"},[t._v("确定")])])]),t._v(" "),s("dentGameRuleModal",{attrs:{ruleKey:"jsks-rules",currentOdds:t.currentOdds},model:{value:t.ruleModalShow,callback:function(e){t.ruleModalShow=e},expression:"ruleModalShow"}})],1)},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"dice-wrap flex justify-ct"},[e("img",{staticClass:"dice",attrs:{alt:"dice",src:""}}),this._v(" "),e("img",{staticClass:"dice",attrs:{alt:"dice",src:""}}),this._v(" "),e("img",{staticClass:"dice",attrs:{alt:"dice",src:""}})])},function(){var t=this.$createElement,e=this._self._c||t;return e("colgroup",[e("col",{attrs:{width:"18%"}}),this._v(" "),e("col",{attrs:{width:"40%"}}),this._v(" "),e("col",{attrs:{width:"14%"}}),this._v(" "),e("col",{attrs:{width:"14%"}}),this._v(" "),e("col",{attrs:{width:"14%"}})])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("thead",[s("tr",{staticClass:"bg-grey"},[s("th",[t._v("期次")]),t._v(" "),s("th",[t._v("开奖号码")]),t._v(" "),s("th",[t._v("和值")]),t._v(" "),s("th",[t._v("大小")]),t._v(" "),s("th",[t._v("单双")])])])}]};var C=s("VU/8")(g,b,!1,function(t){s("MXkH")},"data-v-bb264432",null);e.default=C.exports},LIJb:function(t,e,s){var n=s("EqjI");t.exports=function(t,e){if(!n(t)||t._t!==e)throw TypeError("Incompatible receiver, "+e+" required!");return t}},MXkH:function(t,e){},ioQ5:function(t,e,s){s("HpRW")("Set")},lHA8:function(t,e,s){t.exports={default:s("pPW7"),__esModule:!0}},m9gC:function(t,e,s){var n=s("RY/4"),a=s("4WTo");t.exports=function(t){return function(){if(n(this)!=t)throw TypeError(t+"#toJSON isn't generic");return a(this)}}},oNmr:function(t,e,s){s("9Bbf")("Set")},oeOm:function(t,e,s){var n=s("7Doy");t.exports=function(t,e){return new(n(t))(e)}},pPW7:function(t,e,s){s("M6a0"),s("zQR9"),s("+tPU"),s("ttyz"),s("BDhv"),s("oNmr"),s("ioQ5"),t.exports=s("FeBl").Set},qo66:function(t,e,s){"use strict";var n=s("7KvD"),a=s("kM2E"),o=s("06OY"),r=s("S82l"),i=s("hJx8"),c=s("xH/j"),l=s("NWt+"),u=s("2KxR"),d=s("EqjI"),h=s("e6n0"),m=s("evD5").f,f=s("ALrJ")(0),v=s("+E39");t.exports=function(t,e,s,_,p,w){var S=n[t],g=S,b=p?"set":"add",C=g&&g.prototype,y={};return v&&"function"==typeof g&&(w||C.forEach&&!r(function(){(new g).entries().next()}))?(g=e(function(e,s){u(e,g,t,"_c"),e._c=new S,void 0!=s&&l(s,p,e[b],e)}),f("add,clear,delete,forEach,get,has,set,keys,values,entries,toJSON".split(","),function(t){var e="add"==t||"set"==t;t in C&&(!w||"clear"!=t)&&i(g.prototype,t,function(s,n){if(u(this,g,t),!e&&w&&!d(s))return"get"==t&&void 0;var a=this._c[t](0===s?0:s,n);return e?this:a})}),w||m(g.prototype,"size",{get:function(){return this._c.size}})):(g=_.getConstructor(e,t,p,b),c(g.prototype,s),o.NEED=!0),h(g,t),y[t]=g,a(a.G+a.W+a.F,y),w||_.setStrong(g,t,p),g}},ttyz:function(t,e,s){"use strict";var n=s("9C8M"),a=s("LIJb");t.exports=s("qo66")("Set",function(t){return function(){return t(this,arguments.length>0?arguments[0]:void 0)}},{add:function(t){return n.def(a(this,"Set"),t=0===t?0:t,t)}},n)}});
//# sourceMappingURL=2.346710ee6b6cadbedb49.js.map