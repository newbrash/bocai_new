webpackJsonp([1],{"3RpH":function(t,e){},"HiD+":function(t,e){},NHnr:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=s("mvHQ"),o=s.n(n),i=s("7+uW");console.log("APP_VUE");var a={name:"App",data:function(){return{transitionName:""}},components:{},watch:{$route:function(t,e){console.log("to-meta-index: "+t.meta.index+"; from-meta-index: "+e.meta.index),t.meta.index>e.meta.index?(console.log("left"),this.transitionName="slide-left"):(console.log("right"),this.transitionName="slide-right")}}},c={render:function(){var t=this.$createElement,e=this._self._c||t;return e("div",{attrs:{id:"app"}},[e("div",{staticClass:"main"},[e("router-view")],1)])},staticRenderFns:[]};var l,r=s("VU/8")(a,c,!1,function(t){s("3RpH")},null,null).exports,d=s("/ocq"),h=s("fZjL"),u=s.n(h),f=s("Au9i"),m=s.n(f),g=s("bOdI"),L=s.n(g),b=(l={tmxiaodan:"特小单",tmdadan:"特大单",tmxiaoshuang:"特小双",tmdashuang:"特大双",hexiaodan:"合小单",hexiaoshuang:"合小双",hedadan:"合大单",hedashuang:"合大双",lm:"两面",lmtedan:"特单",lmteshuang:"特双",lmteda:"特大",lmtexiao:"特小",lmtehedan:"特合单",lmteheshuang:"特合双",lmteheda:"特合大",lmtehexiao:"特合小",lmteweida:"特尾大",lmteweixiao:"特尾小",lmtetianqiao:"特天肖",lmtediqiao:"特地肖",lmteqianqiao:"特前肖",lmtehouqiao:"特后肖",lmtejiaqin:"特家肖",lmteyeshou:"特野肖",lmzongdan:"总单",lmzongshuang:"总双",lmzongda:"总大",lmzongxiao:"总小",qmwx:"七码五行",qm:"七码",qmd0sh7:"单0双7",qmd1sh6:"单1双6",qmd2sh5:"单2双5",qmd3sh4:"单3双4",qmd4sh3:"单4双3",qmd5sh2:"单5双2",qmd6sh1:"单6双1",qmd7sh0:"单7双0",qmd0x7:"大0小7",qmd1x6:"大1小6",qmd2x5:"大2小5",qmd3x4:"大3小4",qmd4x3:"大4小3",qmd5x2:"大5小2",qmd6x1:"大6小1",qmd7x0:"大7小0",wx:"五行",wxjin:"金",wxmu:"木",wxshui:"水",wxhuo:"火",wxtu:"土",wsh:"尾数",twsh:"头尾数",twsht0:"头0",twsht1:"头1",twsht2:"头2",twsht3:"头3",twsht4:"头4",twshw0:"尾0",twshw1:"尾1",twshw2:"尾2",twshw3:"尾3",twshw4:"尾4",twshw5:"尾5",twshw6:"尾6",twshw7:"尾7",twshw8:"尾8",twshw9:"尾9",zhtwsh:"正特尾数",zhtwshw0:"尾0",zhtwshw1:"尾1",zhtwshw2:"尾2",zhtwshw3:"尾3",zhtwshw4:"尾4",zhtwshw5:"尾5",zhtwshw6:"尾6",zhtwshw7:"尾7",zhtwshw8:"尾8",zhtwshw9:"尾9",sb:"色波",ssb:"三色波",bb:"半波",bbhd_hong:"红单",bbhsh_hong:"红双",bbhda_hong:"红大",bbhx_hong:"红小",bblvd_lv:"绿单",bblvsh_lv:"绿双",bblvda_lv:"绿大",bblvx_lv:"绿小",bbld_lan:"蓝单",bblsh_lan:"蓝双",bblda_lan:"蓝大",bblx_lan:"蓝小",bbb:"半半波",bbbhdad_hong:"红大单",bbbhdash_hong:"红大双",bbbhxd_hong:"红小单",bbbhxsh_hong:"红小双",bbblvdad_lv:"绿大单",bbblvdash_lv:"绿大双",bbblvxd_lv:"绿小单",bbblvxsh_lv:"绿小双",bbbldad_lan:"蓝大单",bbbldash_lan:"蓝大双",bbblxd_lan:"蓝小单",bbblxsh_lan:"蓝小双",qsb:"七色波",qsbhj:"和局",hq:"合肖",ysh:"野兽",jq:"家禽",dan:"单",shuang:"双",qq:"前肖",houq:"后肖",tq:"天肖",dq:"地肖",shx:"生肖",zhq:"正肖",yq:"一肖",zq:"总肖",zq234q:"234肖",zq5q:"5肖",zq6q:"6肖",zq7q:"7肖",zqzqd:"总肖单",zqzqsh:"总肖双",shu:"鼠",niu:"牛",hu:"虎",tu:"兔",long:"龙",she:"蛇",ma:"马",yang:"羊",hou:"猴",ji:"鸡",gou:"狗",zhu:"猪",zxbzh:"自选不中",zxbzh5bzh:"五不中",zxbzh6bzh:"六不中",zxbzh7bzh:"七不中",zxbzh8bzh:"八不中",zxbzh9bzh:"九不中",zxbzh10bzh:"十不中",zxbzh11bzh:"十一不中",zxbzh12bzh:"十二不中",lqlw:"连肖连尾","2lq":"二连肖","3lq":"三连肖","4lq":"四连肖","5lq":"五连肖","2lw":"二连尾","3lw":"三连尾","4lw":"四连尾","5lw":"五连尾",lw0:"尾0",lw1:"尾1",lw2:"尾2",lw3:"尾3",lw4:"尾4",lw5:"尾5",lw6:"尾6",lw7:"尾7",lw8:"尾8",lw9:"尾9",lma:"连码","4lmasiqzh":"四全中","3lmasqzh":"三全中","3lmaszher":"三中二","2lmaerqzh":"二全中","2lmaerzht":"二中特","2lmatch":"特串",zhmgg:"正码过关"},L()(l,"dan","单"),L()(l,"shuang","双"),L()(l,"da","大"),L()(l,"xiao","小"),L()(l,"hedan","合单"),L()(l,"heshuang","合双"),L()(l,"heda","合大"),L()(l,"hexiao","合小"),L()(l,"weida","尾大"),L()(l,"weixiao","尾小"),L()(l,"hong","红波"),L()(l,"lv","绿波"),L()(l,"lan","蓝波"),L()(l,"zhm1-6","正码1-6"),L()(l,"zh1","正码一"),L()(l,"zh2","正码二"),L()(l,"zh3","正码三"),L()(l,"zh4","正码四"),L()(l,"zh5","正码五"),L()(l,"zh6","正码六"),L()(l,"zhmt","正码特"),L()(l,"zhyt","正一特"),L()(l,"zhert","正二特"),L()(l,"zhst","正三特"),L()(l,"zhsit","正四特"),L()(l,"zhwt","正五特"),L()(l,"zhlt","正六特"),L()(l,"zhm","正码"),L()(l,"tm","特码"),L()(l,"zhy","中一"),L()(l,"zhy5zh1","五中一"),L()(l,"zhy6zh1","六中一"),L()(l,"zhy7zh1","七中一"),L()(l,"zhy8zh1","八中一"),L()(l,"zhy9zh1","九中一"),L()(l,"zhy10zh1","十中一"),l),v={props:{rightCharts:Boolean,rightNormal:Boolean,rightOrder:Boolean,obj:Object},data:function(){return{modalShow:!1,basicModal:!1,select:""}},filters:{keyToCharacter:function(t){var e="";for(var s in b)if(s===t){e=b[s];break}return e||(e=t),e}},computed:{},methods:{clickCenter:function(){this.modalShow=!this.modalShow,this.$emit("onClickCenter")},onClickOpr:function(t){this.basicModal=!this.basicModal,this.$emit("onClickOpr",t)}},watch:{select:function(t){this.modalShow=!1,this.$emit("onselect",t)},obj:{handler:function(){(this.obj instanceof Object||this.obj instanceof Array)&&(this.select=u()(this.obj)[0])},immediate:!0}}},p={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("header",{staticClass:"flex justify-sb",attrs:{id:"dent-head"}},[s("span",{staticClass:"iconfont icon-left click-icon",attrs:{dentHoverclass:"title-hoverclass"},on:{click:function(e){t.$router.go(-1)}}}),t._v(" "),s("div",{staticClass:"flex"},[s("div",{staticClass:"tips"},[t._t("tips")],2),t._v(" "),s("div",{staticClass:"dent-dropdown flex",attrs:{dentHoverclass:"title-hoverclass"},on:{click:t.clickCenter}},[s("span",[t._v(t._s(t._f("keyToCharacter")(t.select)))]),t._v(" "),s("span",{staticClass:"iconfont icon-arrow-down down-icon",class:t.modalShow?"modalShow":""})])]),t._v(" "),s("div",{staticClass:"flex"},[t.rightOrder?s("span",{staticClass:"iconfont icon-storeCar1",staticStyle:{"font-size":"6vw"},attrs:{dentHoverclass:"title-hoverclass"},on:{click:function(e){t.$emit("onClickRightOrder")}}}):t._e(),t._v(" "),t.rightNormal?s("span",{staticClass:"iconfont icon-caidan click-icon",attrs:{dentHoverclass:"title-hoverclass"},on:{click:function(e){if(e.target!==e.currentTarget)return null;t.basicModal=!t.basicModal}}}):t._e(),t._v(" "),t.rightCharts?s("span",{staticClass:"iconfont icon-chilun click-icon",attrs:{dentHoverclass:"title-hoverclass"},on:{click:function(e){t.$emit("onClickRightIcon")}}}):t._e()]),t._v(" "),t.obj?[s("transition",{attrs:{name:"modalShow"}},[s("div",{directives:[{name:"show",rawName:"v-show",value:t.modalShow,expression:"modalShow"}],staticClass:"modal-mask",on:{click:function(e){t.modalShow=!t.modalShow}}},[s("div",{staticClass:"dent-head-modal flex"},t._l(t.obj,function(e,n,o){return s("label",{key:o,staticClass:"dent-head-modal-item"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.select,expression:"select"}],staticClass:"hidden",attrs:{type:"radio"},domProps:{value:n,checked:t._q(t.select,n)},on:{change:function(e){t.select=n}}}),t._v(" "),s("span",{staticClass:"iconfont",attrs:{dentHoverclass:"span-hoverclass"}},[t._v(t._s(t._f("keyToCharacter")(n)))])])}))])])]:t._e(),t._v(" "),s("transition",{attrs:{name:"modalShow"}},[s("div",{directives:[{name:"show",rawName:"v-show",value:t.basicModal,expression:"basicModal"}],staticClass:"modal-mask",on:{click:function(e){if(e.target!==e.currentTarget)return null;t.basicModal=!t.basicModal}}},[s("div",{staticClass:"basic-opr fontc-3"},t._l([{icon:"icon-stock",text:"走势图"},{icon:"icon-jiangbei",text:"近期开奖"},{icon:"icon-jilu",text:"购彩记录"},{icon:"icon-shuoming",text:"玩法说明"}],function(e,n){return s("div",{staticClass:"basic-opr-item",attrs:{dentHoverclass:"hoverclass"},on:{click:function(e){t.onClickOpr(n)}}},[s("span",{staticClass:"fontc-6 iconfont",class:e.icon}),t._v(" "+t._s(e.text)+"\n        ")])}))])])],2)},staticRenderFns:[]};var O=s("VU/8")(v,p,!1,function(t){s("RHYI")},"data-v-6c8333ce",null).exports,A={props:{tabObj:Object,value:[String,Number],type:String,flex:Boolean},filters:{keyToCharacter:function(t){var e="";for(var s in b)if(s===t){e=b[s];break}return!e&&(e=t),e}},data:function(){return{style:{left:0,width:"21.6vw"},needShowOdds:!1}},methods:{onCLickHq:function(t,e,s){this.$emit("input",t.zhl)},onSwitch:function(t,e,s){this.$emit("input",s),this.setLineAnimate(s)},setLineAnimate:function(t){this.flex?this.style.left=t/u()(this.tabObj).length*100+"%":this.style.left=21.6*t+"vw"}},mounted:function(){this.flex&&(this.style.width=1/u()(this.tabObj).length*100+"%")},watch:{value:function(t){this.setLineAnimate(t)},type:{handler:function(t){this.needShowOdds=["zxbzh","lma","zhy"].includes(t)},immediate:!0}}},_={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"switch flex",class:"hq"===t.type?"hq-switch":""},["hq"===t.type?t._l(t.tabObj,function(e,n,o){return s("label",{key:o,staticClass:"hq-switch-item switch-item flex flow-col justify-ct",on:{click:function(s){t.onCLickHq(e,n,o)}}},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.value,expression:"value"}],staticClass:"hidden",attrs:{type:"radio"},domProps:{value:e.zhl,checked:t._q(t.value,e.zhl)},on:{change:function(s){t.value=e.zhl}}}),t._v(" "),s("span",{staticClass:"hq-switch-span",attrs:{dentHoverclass:"hqhoverclass"}},[t._v(t._s(t._f("keyToCharacter")(n)))])])}):t.needShowOdds?t._l(t.tabObj,function(e,n,o){return s("div",{key:o,staticClass:"switch-item flex flow-col justify-ct",attrs:{dentHoverclass:"hoverclass"},on:{click:function(s){t.onSwitch(e,n,o)}}},[s("span",{staticClass:"fz-16"},[t._v(t._s(t._f("keyToCharacter")(n)))]),t._v(" "),e instanceof Object?s("span",{staticClass:"font-theme fz-12"},[t._l(e,function(e){return[t._v("\n          "+t._s(e)+"\n        ")]})],2):s("span",{staticClass:"font-theme fz-12"},[t._v(t._s(e))])])}):t._l(t.tabObj,function(e,n,o){return s("div",{key:o,staticClass:"switch-item flex flow-col justify-ct",class:{"switch-item-flex":t.flex,"font-theme":t.value===o},attrs:{dentHoverclass:"hoverclass"},on:{click:function(s){t.onSwitch(e,n,o)}}},[s("span",{staticClass:"fz-16"},[t._v(t._s(t._f("keyToCharacter")(n)))])])}),t._v(" "),"hq"!==t.type?s("div",{staticClass:"switch-line",style:t.style}):t._e()],2)},staticRenderFns:[]};var w=s("VU/8")(A,_,!1,function(t){s("ScK9")},"data-v-413db399",null).exports,y={props:{betsObj:[Array,Object],type:String,currentSubOdds:String,activeTab:[String,Number],value:Array,haoma:Object},filters:{keyToCharacter:function(t,e,s){var n="";for(var o in t.match(/_/)&&(t=t.split("_")[1]),b)if(o===t){n=b[o];break}return n||(n=t),n},numToCharacter:function(t){return["一","二","三","四","五","六"][t]}},data:function(){return{normal:!1,needToShowNum:!1,showAllNum:!1,showAllNumAndNum:!1,getColor:!1,zhmggValue:{zhy:"",zher:"",zhs:"",zhsi:"",zhw:"",zhl:""}}},computed:{needScroll:function(){return["zhmgg","zhm","tm","lm","hq"].includes(this.currentSubOdds)?"odds-main-ovfa":""}},methods:{getColorFunc:function(t){return{hong:"font_red",lan:"font_blue",lv:"font_green"}[t.split("_")[1]]},changebets:function(t,e){console.log(12200);var s=void 0,n=e.toString(),o=this.currentSubOdds,i=this.type;s=this.type?{key:n,value:t.target.value,type:i,leiXin:o}:{key:n,value:t.target.value,type:o,leiXin:""},this.$emit("changebets",s)}},watch:{value:function(t){this.$emit("input",t)},zhmggValue:{handler:function(t){this.$emit("input",t)},deep:!0},currentSubOdds:{handler:function(t){this.normal=["lm","qm","twsh","zhtwsh","bb","bbb","qsb","ssb","zq","2lw","3lw","4lw","5lw","zh1","zh2","zh3","zh4","zh5","zh6"].includes(t),this.needToShowNum=["wx","tq","yq","zhq","2lq","3lq","4lq","5lq","hq"].includes(t),this.showAllNum=["zxbzh10bzh","zxbzh11bzh","zxbzh12bzh","zxbzh5bzh","zxbzh6bzh","zxbzh7bzh","zxbzh8bzh","zxbzh9bzh","2lmaerqzh","2lmaerzht","4lmasiqzh","3lmasqzh","3lmaszher","2lmatch","zhy5zh1","zhy6zh1","zhy7zh1","zhy8zh1","zhy9zh1","zhy10zh1"].includes(t),this.showAllNumAndNum=["zhert","zhlt","zhsit","zhst","zhwt","zhyt","zhm","tm"].includes(t),["bb","bbb","qsb","ssb","zh1","zh2","zh3","zh4","zh5","zh6","zhmgg"].includes(t)&&(this.getColor=!0)},immediate:!0}}},G={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"odds-main",class:t.needScroll},[t.normal?s("div",{staticClass:"odds flex bgc-fff"},t._l(t.betsObj,function(e,n){return s("label",{key:n,staticClass:"odds-item"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.value,expression:"value"}],staticClass:"dent-bg-input hidden",attrs:{type:"checkbox"},domProps:{value:n,checked:Array.isArray(t.value)?t._i(t.value,n)>-1:t.value},on:{change:function(e){var s=t.value,o=e.target,i=!!o.checked;if(Array.isArray(s)){var a=n,c=t._i(s,a);o.checked?c<0&&(t.value=s.concat([a])):c>-1&&(t.value=s.slice(0,c).concat(s.slice(c+1)))}else t.value=i}}}),t._v(" "),s("div",{staticClass:"bg flex flow-col justify-ct",class:t.getColor&&t.getColorFunc(n)},[s("span",{staticClass:"odds-bets"},[t._v(t._s(t._f("keyToCharacter")(n,t.type,t.currentSubOdds)))]),t._v(" "),s("span",{staticClass:"odds-num font-th  eme"},[t._v("赔率: "),s("input",{staticStyle:{"text-align":"center",width:"60px","border-radius":"30%"},attrs:{type:"number"},domProps:{value:e},on:{change:function(e){t.changebets(e,n)}}})])])])})):t._e(),t._v(" "),t.needToShowNum?s("div",{staticClass:"odds flex bgc-fff"},t._l(t.betsObj,function(e,n){return s("label",{key:n,staticClass:"odds-item wx-odds-item "},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.value,expression:"value"}],staticClass:"dent-bg-input hidden",attrs:{type:"checkbox"},domProps:{value:n,checked:Array.isArray(t.value)?t._i(t.value,n)>-1:t.value},on:{change:function(e){var s=t.value,o=e.target,i=!!o.checked;if(Array.isArray(s)){var a=n,c=t._i(s,a);o.checked?c<0&&(t.value=s.concat([a])):c>-1&&(t.value=s.slice(0,c).concat(s.slice(c+1)))}else t.value=i}}}),t._v(" "),s("div",{staticClass:"bg flex flow-col justify-ct"},[s("span",{staticClass:"odds-bets"},[t._v(t._s(t._f("keyToCharacter")(n)))]),t._v(" "),s("span",{staticClass:"odds-num font-theme"},[t._v("赔率:\n          "),s("input",{staticStyle:{"text-align":"center",width:"60px","border-radius":"30%"},attrs:{type:"text"},domProps:{value:e},on:{change:function(e){t.changebets(e,n)}}})]),t._v(" "),"qmwx"===t.type?s("div",{staticClass:"wx-num flex"},t._l(t.haoma.wx[n],function(e){return s("span",{key:e},[t._v(t._s(1===e.toString().length?"0"+e:e))])})):"shx"===t.type||"lqlw"===t.type||"hq"===t.currentSubOdds?s("div",{staticClass:"wx-num flex"},t._l(t.haoma.animals[n],function(e){return s("span",{key:e},[t._v(t._s(1===e.toString().length?"0"+e:e))])})):t._e()])])})):t._e(),t._v(" "),t.showAllNum?s("div",{staticClass:"odds flex bgc-fff"},[t.betsObj instanceof Object?t._l(t.betsObj,function(e,n){return s("p",{key:n,staticStyle:{color:"red"}},[t._v("修改赔率："),s("input",{staticStyle:{"margin-left":"10px"},attrs:{type:"number"},domProps:{value:e},on:{change:function(e){t.changebets(e,"")}}})])}):s("p",{staticStyle:{color:"red"}},[t._v("修改赔率："),s("input",{staticStyle:{"margin-left":"10px"},attrs:{type:"number"},domProps:{value:t.betsObj},on:{change:function(e){t.changebets(e,"")}}})])],2):t._e(),t._v(" "),t.showAllNumAndNum?s("div",{staticClass:"odds flex bgc-fff"},t._l(t.betsObj,function(e,n,o){return s("label",{key:n,staticClass:"odds-item showAllNum-item"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.value,expression:"value"}],staticClass:"dent-bg-input hidden",attrs:{type:"checkbox"},domProps:{value:n,checked:Array.isArray(t.value)?t._i(t.value,n)>-1:t.value},on:{change:function(e){var s=t.value,o=e.target,i=!!o.checked;if(Array.isArray(s)){var a=n,c=t._i(s,a);o.checked?c<0&&(t.value=s.concat([a])):c>-1&&(t.value=s.slice(0,c).concat(s.slice(c+1)))}else t.value=i}}}),t._v(" "),s("div",{staticClass:"bg flex flow-col justify-ct"},[s("span",{staticClass:"odds-bets"},[t._v(t._s(1===(o+1).toString().length?"0"+(o+1):o+1))])]),t._v(" "),s("span",{staticClass:"font-theme showAllNumAndNum"},[s("input",{staticStyle:{"text-align":"center",width:"40px","border-radius":"30%"},attrs:{type:"number"},domProps:{value:e},on:{change:function(e){t.changebets(e,n)}}})])])})):t._e(),t._v(" "),"zhmgg"==t.currentSubOdds?t._l(t.betsObj,function(e,n,o){return s("div",{key:n,staticClass:"odds odds-zhmgg flex bgc-fff"},[s("div",{staticClass:"zhmgg"},[t._v("正码"+t._s(t._f("numToCharacter")(o)))]),t._v(" "),t._l(e,function(e,o){return s("label",{key:o,staticClass:"odds-item"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.zhmggValue[n],expression:"zhmggValue[objKey]"}],staticClass:"dent-bg-input hidden",attrs:{type:"radio"},domProps:{value:o,checked:t._q(t.zhmggValue[n],o)},on:{change:function(e){t.$set(t.zhmggValue,n,o)}}}),t._v(" "),s("div",{staticClass:"bg flex flow-col justify-ct",class:t.getColor&&t.getColorFunc(o)},[s("span",{staticClass:"odds-bets"},[t._v(t._s(t._f("keyToCharacter")(o,t.type,t.currentSubOdds)))]),t._v(" "),s("span",{staticClass:"odds-num font-theme"},[t._v("赔率:               \n            "),t._v(" "),s("input",{staticStyle:{"text-align":"center",width:"60px","border-radius":"30%"},attrs:{type:"text"},domProps:{value:e},on:{change:function(e){t.changebets(e,o)}}})])])])})],2)}):t._e()],2)},staticRenderFns:[]};var z={components:{dentGameHeader:O,switchTab:w,bets:s("VU/8")(y,G,!1,function(t){s("HiD+")},"data-v-e38fd9ea",null).exports},filters:{keyToCharacter:function(t){var e="";for(var s in b)if(s===t){e=b[s];break}return!e&&(e=t),e}},data:function(){return{shengxiao:"",odds:{},haoma:{},currentOdds:"lm",shouldCommit:[],modifiedArray:[],showTip:!1,activeTab:0}},computed:{needSwitch:function(){return["qmwx","wsh","sb","shx","zxbzh","lqlw","lma","zhm1-6","zhmt","zhy"].includes(this.currentOdds)},currentSubOdds:function(){var t="",e=this.odds,s=this.currentOdds,n=this.activeTab;return t="lqlw"===s?u()(e.lqlw.show)[n]:this.needSwitch&&u()(e[s])[n],t}},mounted:function(){this.$parent.tabbarShow=!1,this.getOddsData()},activated:function(){this.$parent.tabbarShow=!1},methods:{onSwitch:function(t){this.currentOdds=t,this.canEarn=this.totalBets=this.activeTab=0,this.shouldCommit=[]},getOddsData:function(){var t=this;this.$axios.get("https://bc.gd-dent.com/bcweb/Index/Settingodds/settingSix",{}).then(function(e){t.odds=e.data.odds,t.haoma=e.data.haoma,console.log(e),200===e.status?console.log("获取成功"):console.log("获取失败")})},changebets:function(t){console.log(t),console.log(140),this.modifiedArray.push(t)},submit:function(){this.$axios.post("https://bc.gd-dent.com/bcweb/Index/Settingodds/settingSix",{odds:this.modifiedArray}).then(function(t){t=t.data;console.log(222222222222),console.log(t),1===t.code&&(Object(f.Toast)({message:"修改成功",iconClass:"icon icon-success"}),console.log("修改成功"))})}}},x={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"contanier"},[s("dentGameHeader",{attrs:{obj:t.odds},on:{onselect:t.onSwitch,onClickRightOrder:function(e){t.$router.push({name:"6hecaiwaiForPay",query:{getOrder:!1}})},onClickOpr:t.onClickOpr}},[s("span",{attrs:{slot:"tips"},slot:"tips"},[t._v("玩法")])]),t._v(" "),s("div",{staticClass:"flex-wrap flex flow-col"},[t.needSwitch&&"lqlw"!==t.currentOdds?s("switchTab",{attrs:{tabObj:t.odds[t.currentOdds],type:t.currentOdds},model:{value:t.activeTab,callback:function(e){t.activeTab=e},expression:"activeTab"}}):t.needSwitch&&"lqlw"===t.currentOdds?s("switchTab",{attrs:{tabObj:t.odds.lqlw.show,type:t.currentOdds},model:{value:t.activeTab,callback:function(e){t.activeTab=e},expression:"activeTab"}}):t._e(),t._v(" "),s("div",{staticClass:"odds-wrap flex flow-col",class:Object.keys(t.odds).length?"":"justify-ct"},[Object.keys(t.odds).length?[t.needSwitch?[s("mt-tab-container",{attrs:{swipeable:"true"},model:{value:t.activeTab,callback:function(e){t.activeTab=e},expression:"activeTab"}},t._l(t.odds.lqlw.show,function(e,n,o){return"lqlw"===t.currentOdds?s("mt-tab-container-item",{key:o,attrs:{id:o}},[t.activeTab===o?s("bets",{attrs:{betsObj:e,type:t.currentOdds,activeTab:t.activeTab,haoma:t.haoma,currentSubOdds:t.currentSubOdds},on:{changebets:t.changebets,oddsTips:function(e){t.oddsTips=!0}},model:{value:t.shouldCommit,callback:function(e){t.shouldCommit=e},expression:"shouldCommit"}}):t._e()],1):t._l(t.odds[t.currentOdds],function(e,n,o){return s("mt-tab-container-item",{key:o,attrs:{id:o}},[t.activeTab===o?s("bets",{attrs:{betsObj:e,type:t.currentOdds,activeTab:t.activeTab,haoma:t.haoma,currentSubOdds:t.currentSubOdds},on:{changebets:t.changebets,oddsTips:function(e){t.oddsTips=!0}},model:{value:t.shouldCommit,callback:function(e){t.shouldCommit=e},expression:"shouldCommit"}}):t._e()],1)})}))]:"hq"===t.currentOdds?[s("bets",{attrs:{betsObj:t.odds.hq.show,haoma:t.haoma,currentSubOdds:t.currentOdds},on:{changebets:t.changebets,oddsTips:function(e){t.oddsTips=!0}},model:{value:t.shouldCommit,callback:function(e){t.shouldCommit=e},expression:"shouldCommit"}})]:[s("bets",{attrs:{betsObj:t.odds[t.currentOdds],haoma:t.haoma,currentSubOdds:t.currentOdds},on:{changebets:t.changebets,oddsTips:function(e){t.oddsTips=!0}},model:{value:t.shouldCommit,callback:function(e){t.shouldCommit=e},expression:"shouldCommit"}})]]:s("mt-spinner",{attrs:{color:"#e62b00",type:"fading-circle"}})],2),t._v(" "),s("div",{staticClass:"hecai-bottom flex justify-sb bgc-fff"},[s("mt-button",{staticStyle:{left:"150px","background-color":"#eade43"},on:{click:t.submit}},[t._v("提交")])],1)],1)],1)},staticRenderFns:[]};var B=s("VU/8")(z,x,!1,function(t){s("qOzh")},"data-v-3c9c30f8",null).exports;console.log("ROOTER_INDEX.JS"),i.default.use(d.a);var k=new d.a({routes:[{path:"/",name:"6hecai",meta:{index:1,keepAlive:!0},component:B}]}),S=(s("d8/S"),s("mtWM")),C=s.n(S),q=s("cF7b"),I=s.n(q);console.log("GLOBAL_VUE");var N={radioTextList:[],userInfo:{},sysNews:{},appInfo:{logo_src:"",app_name:"",error_str:""},logoHost:"http://bc.gd-dent.com/bcweb/public/",Host:"http://bc.gd-dent.com",socketHand:"",socketHost:"ws://192.168.2.133:8080",msgList:[],msgLength:0,friendLists:{friends:{},strange:{},system:{}},friendMsgNum:[],friendInfo:{},sanGongInfo:{},gameGongHost:"ws://192.168.2.100:2525",connectionId:"",hecai:{issue:null,countdown:0,hecai_order:{},hecai_orderList:{},hecai_recentInfo:{},hecai_gameHistory:{}},hecaiImg:"static/gameIcon/liuhecai.png",ObjToString:function(t){return o()(t)},gameOrNot:!1,gameSocketHand:""},T=s("VU/8")(N,null,!1,null,null,null).exports;i.default.use(m.a),i.default.prototype.$axios=C.a,i.default.use(I.a),i.default.prototype.GLOBAL=T,i.default.config.devtools=!0,new i.default({el:"#app",router:k,components:{App:r},template:"<App/>",created:function(){this.isMobile()||(this.GLOBAL.appInfo.error_str||(this.GLOBAL.appInfo.error_str="对不起，请通过手机访问！"),this.$messagebox.alert(this.GLOBAL.appInfo.error_str),this.$router.push("/error")),null!=localStorage.getItem("bc_appInfo")&&this.setGlobalAttribute(this.GLOBAL.appInfo,JSON.parse(localStorage.getItem("bc_appInfo"))),null!=localStorage.getItem("bc_userInfo")&&this.setGlobalAttribute(this.GLOBAL.userInfo,JSON.parse(localStorage.getItem("bc_userInfo"))),null!=localStorage.getItem("bc_friendInfo")&&(console.log(localStorage.getItem("bc_friendInfo")),this.setGlobalAttribute(this.GLOBAL.friendInfo,JSON.parse(localStorage.getItem("bc_friendInfo"))),console.log(this.GLOBAL.friendInfo)),i.default.prototype.setLocalCache=function(t,e){try{window.localStorage[t]=o()(e),console.log("%c设置 "+t+" 缓存成功:\n","color:red;font-size:13px;"),console.dir(e)}catch(t){console.log("%c设置缓存失败:","color:red;font-size:13px;",t)}},i.default.prototype.getLocalCache=function(t){try{var e=window.localStorage[t]&&JSON.parse(window.localStorage[t]);void 0!==e?(console.log("%c读取 "+t+" 缓存成功:\n","color:red;font-size:13px;"),console.dir(e)):console.log("%c 未读取到 "+t+" 缓存信息，可能没有设置","color:red;font-size:13px;")}catch(t){console.log("%c 读取缓存失败:\n","color:red;font-size:13px;",t)}},i.default.prototype.removeLocalCache=function(t){try{window.localStorage.removeItem(t),console.log("%c 移除 "+t+" 缓存成功:","color:red;font-size:13px;")}catch(e){console.log("%c 移除 "+t+" 缓存失败:","color:red;font-size:13px;",e)}},i.default.prototype.clearLocalCache=function(){try{window.localStorage.clear(),console.log("%c 清空缓存成功","color:red;font-size:13px;")}catch(t){console.log("%c 清空缓存失败:","color:red;font-size:13px;",t)}}},watch:{}}),window.addEventListener("click",function(t){var e=t.target,s=e.getAttribute&&e.getAttribute("dentHoverclass");s||(e=e.parentNode).getAttribute&&(s=e.getAttribute("dentHoverclass")),s&&(clearTimeout(e.timer),e.classList.add(s),e.timer=setTimeout(function(){e.classList.remove(s),clearTimeout(e.timer)},500))}),Date.prototype.Format=function(t){var e={"M+":this.getMonth()+1,"d+":this.getDate(),"h+":this.getHours(),"m+":this.getMinutes(),"s+":this.getSeconds(),"q+":Math.floor((this.getMonth()+3)/3),S:this.getMilliseconds()};for(var s in/(y+)/.test(t)&&(t=t.replace(RegExp.$1,(this.getFullYear()+"").substr(4-RegExp.$1.length))),e)new RegExp("("+s+")").test(t)&&(t=t.replace(RegExp.$1,1==RegExp.$1.length?e[s]:("00"+e[s]).substr((""+e[s]).length)));return t},console.log("MAIN")},RHYI:function(t,e){},ScK9:function(t,e){},cF7b:function(t,e){e.install=function(t,e){console.log("---------------options---------------"),console.log(e),console.log("---------------options---------------");var s=function(){},n=!1,o="",i=0;t.prototype.checkLogin=function(t){this.GLOBAL.userInfo.id?this.GLOBAL.gameOrNot?this.checkGameSocket(t):this.checkSocket(t):this.$router.push("/login")},t.prototype.checkGameSocket=function(t){this.GLOBAL.gameSocketHand&&3!=this.GLOBAL.gameSocketHand.readyState?t&&t():(console.log("trying to create gamesocket..."),this.createSocket(this.GLOBAL.gameGongHost,t))},t.prototype.checkSocket=function(t){this.GLOBAL.socketHand&&3!=this.GLOBAL.socketHand.readyState?(console.log("socket is listening!"),this.getUserInfo(),t&&t()):(console.log("I try to create a socket"),this.createSocket(!1,t))},t.prototype.isMobile=function(){return!0},t.prototype.showDate=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",s=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"";if(s)return new Date(1e3*s).toLocaleString();var n=new Date;if(t&&e){var o=new Date(1e3*Number(t)),i=new Date(1e3*Number(e));return console.log("time2-time1:"+(i.getTime()-o.getTime())),(i.getTime()-o.getTime())/1e3>=1800&&((n.getTime()-i.getTime())/1e3<=86400?i.toLocaleDateString()!=n.toLocaleDateString()?"昨天 "+i.toLocaleTimeString():i.toLocaleTimeString():i.toLocaleString())}if(t&&!e)return"今天 "+(o=new Date(1e3*Number(t))).toLocaleTimeString();if(!t&&e){i=new Date(1e3*Number(e));return(Number(n.getTime())-Number(i.getTime()))/1e3<=86400?n.toLocaleDateString()==i.toLocaleDateString()?"今天"+i.toLocaleTimeString():"昨天 "+i.toLocaleTimeString():i.toLocaleString()}return Math.ceil(Number(n.getTime())/1e3)},t.prototype.getUserInfo=function(){if(this.GLOBAL.userInfo.id&&!this.GLOBAL.loginStatus){var t={con_id:this.GLOBAL.connectionId,send_id:this.GLOBAL.userInfo.id,nickname:this.GLOBAL.userInfo.nickname,type:"handle",rType:1,fType:0};this.senddata(t)}},t.prototype.setGlobalAttribute=function(t,e){for(var s in e){var n=Object.prototype.toString.call(e[s]);if("[object Object]"==n||"[object Array]"==n){try{this.$set(t,s,{})}catch(e){this.$set(t,s.toString(),{})}this.setGlobalAttribute(t[s],e[s])}else try{this.$set(t,s,e[s])}catch(n){this.$set(t,s.toString(),e[s])}}},t.prototype.senddata=function(t,e,a){console.log("sending Socket");var c=this.GLOBAL.ObjToString(t),l=this;console.log("sendText:"+c),console.log("gameOrNot:"+this.GLOBAL.gameOrNot),this.GLOBAL.gameOrNot?(console.log("@@@@@@@@@@@@@@@@@@@game@@@@@@@@@@@@@@@@@@@"),this.GLOBAL.gameSocketHand&&1==this.GLOBAL.gameSocketHand.readyState?(e&&(console.log("（game）设置发送数据回掉函数"),s=e,n=!0,a&&(o=a)),this.GLOBAL.gameSocketHand.send(c)):i<5?(i++,this.checkGameSocket(function(){l.senddata(t,e,a)})):(i=0,this.$messagebox.alert("网络堵塞！"),e&&e(!1))):(console.log("@@@@@@@@@@@@@@@@@@@user@@@@@@@@@@@@@@@@@@@@"),this.GLOBAL.socketHand&&1==this.GLOBAL.socketHand.readyState?(e&&(console.log("设置发送数据回掉函数"),s=e,n=!0,a&&(o=a)),this.GLOBAL.socketHand.send(c)):i<5?(i++,l.senddata(t,e,a)):(i=0,this.$messagebox.alert("网络堵塞！"),e&&e(!1)))},t.prototype.closeSocket=function(){if(console.log("closing Socket"),this.GLOBAL.socketHand){var t={send_id:this.GLOBAL.userInfo.id,nickname:"",get_id:"",fname:"",msg:"I am leaving",type:"close",rType:1,fType:0,con_id:this.GLOBAL.connectionId};this.senddata(t),this.GLOBAL.socketHand.close(),this.GLOBAL.socketHand="",this.GLOBAL.socketStatus=!1}},t.prototype.createSocket=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",s=this;t?(this.GLOBAL.gameOrNot=!0,this.GLOBAL.gameSocketHand=new WebSocket(t),this.GLOBAL.gameSocketHand.onopen=function(t){e&&e(t)}):(this.GLOBAL.gameOrNot=!1,this.GLOBAL.socketHand=new WebSocket(this.GLOBAL.socketHost),this.GLOBAL.socketHand.onopen=function(t){console.log("openning socket..."),s.GLOBAL.socketStatus=!0;var n={type:"getAppInfo",send_id:"",con_id:s.GLOBAL.connectionId};s.senddata(n),s.getUserInfo(),e&&e()}),console.log("creating socket...")},t.prototype.onmessage=function(t){console.log("onmessage....");var e=this;this.GLOBAL.gameOrNot?(console.log("@@@@@@@@@@@@@@@game@@@@@@@@@@@@@@"),this.GLOBAL.gameSocketHand.onmessage=function(i){var a="";i.data&&(a=JSON.parse(i.data),console.log("recived.gameData => {"),console.log(a),console.log("}")),t&&t(i.data);var c=a||!1;n&&(!o||o&&c&&c.type==o)&&(s(c,e),n=!1,o="")}):(console.log("@@@@@@@@@@@@@@@user@@@@@@@@@@@@@@"),this.GLOBAL.socketHand.onmessage=function(i){var a="";if(i.data)switch(a=JSON.parse(i.data),console.log("reciveData => {"),console.log(a),console.log("}"),a.type){case"ConnectionSuccess":e.GLOBAL.connectionId=a.connectionId;break;case"handle":!function(t,e){if(-1==t.send_id)return void e.$messagebox.alert(t.msg);e.$forceUpdate(),e.GLOBAL.connectionId=t.con_id;var s=t.userMsgs;for(var n in e.GLOBAL.msgLength=0,s)"system"==n?(e.GLOBAL.friendMsgNum[n]?e.GLOBAL.friendMsgNum[n]=s[n]:e.$set(e.GLOBAL.friendMsgNum,n,s[n]),e.GLOBAL.msgLength+=s[n]):(e.GLOBAL.friendMsgNum[n]?e.GLOBAL.friendMsgNum[n]=s[n].length:e.$set(e.GLOBAL.friendMsgNum,n,s[n].length),e.GLOBAL.msgLength+=s[n].length,e.GLOBAL.msgList[n]?e.GLOBAL.msgList[n]=s[n]:(e.$set(e.GLOBAL.msgList,n,[]),e.setGlobalAttribute(e.GLOBAL.msgList[n],s[n])));e.setGlobalAttribute(e.GLOBAL.friendLists,t.friendsList),e.GLOBAL.loginStatus=!0,e.GLOBAL.friendInfo.info&&(console.log(e.GLOBAL.friendInfo),2==e.GLOBAL.friendInfo.status?e.GLOBAL.friendInfo.info.connectionID=e.GLOBAL.friendLists.strange[e.GLOBAL.friendInfo.info.id].connectionID:e.GLOBAL.friendInfo.info.connectionID=e.GLOBAL.friendLists.friends[e.GLOBAL.friendInfo.info.id].connectionID)}(a,e);break;case"heart":a={con_id:e.GLOBAL.connectionId,msg:"I accept the heart",type:"heart",rType:1,fType:0};e.senddata(a);break;case"addFriendRequest":!function(t,e){if(t.fInfo)console.log("add friends success notice!"),e.$set(e.GLOBAL.friendLists.friends,t.fInfo.id,[]),e.setGlobalAttribute(e.GLOBAL.friendLists.friends[t.fInfo.id],t.fInfo),e.$set(e.GLOBAL.msgList,t.fInfo.id,[]),e.$set(e.GLOBAL.msgList[t.fInfo.id],0,[]),e.setGlobalAttribute(e.GLOBAL.msgList[t.fInfo.id][0],t.msg),e.$set(e.GLOBAL.friendMsgNum,t.fInfo.id,1);else{console.log("add friends request notice!");var s=1,n=e.GLOBAL.friendLists;e.GLOBAL.friendLists={};var o={};for(var i in o[t.msg.id+"@0"]=t.msg,n.system)n.system[i]&&(o[n.system[i].id+"@"+s]=n.system[i],s++);n.system=o,console.log(n),e.setGlobalAttribute(e.GLOBAL.friendLists,n),console.log(e.GLOBAL.friendLists),e.GLOBAL.friendMsgNum.system?e.GLOBAL.friendMsgNum.system++:e.$set(e.GLOBAL.friendMsgNum,"system",1),console.log(e.GLOBAL.friendMsgNum.system)}e.GLOBAL.msgLength?e.GLOBAL.msgLength+=1:e.$set(e.GLOBAL,"msgLength",1);console.log(e.GLOBAL.msgLength),e.$forceUpdate()}(a,e);break;case"onlineNotice":!function(t,e){e.GLOBAL.friendLists[t.fType][t.index]&&(console.log("===============onlineNotice==============="),console.log(t),console.log("===============onlineNotice==============="),e.GLOBAL.friendLists[t.fType][t.index].on_status=t.status,e.GLOBAL.friendLists[t.fType][t.index].connectionID=t.connectionID,e.GLOBAL.friendInfo.info&&e.GLOBAL.friendInfo.info.id==t.index&&(e.GLOBAL.friendInfo.info.connectionID=t.connectionID))}(a,e);break;case"deleteFriendNotice":!function(t,e){var s={id:t.msg.send_id,head:e.GLOBAL.friendLists.friends[t.msg.send_id].head,on_status:e.GLOBAL.friendLists.friends[t.msg.send_id].on_status,nickname:e.GLOBAL.friendLists.friends[t.msg.send_id].nickname,content:t.msg.content,flag:t.msg.flag,status:t.msg.status,mid:t.msg.mid};e.GLOBAL.friendLists.friends[t.msg.send_id]=null,e.GLOBAL.msgList[t.msg.send_id]=null,e.GLOBAL.msgLength-=e.GLOBAL.friendMsgNum[t.msg.send_id],e.GLOBAL.friendMsgNum[t.msg.send_id]=null;var n=e.GLOBAL.friendLists.system.length;e.GLOBAL.friendLists.system[t.msg.send_id+"@"+n]=s,e.GLOBAL.friendMsgNum.system?e.GLOBAL.friendMsgNum.system++:e.GLOBAL.friendMsgNum.system=1;e.GLOBAL.msgLength++,e.$forceUpdate()}(a,e);break;case"PassFriendRequest":!function(t,e){t=t.data,console.log("<passRequest>"),console.log(t),console.log("</passRequest>"),e.$set(e.GLOBAL.friendLists.friends,t.fInfo.id,{}),e.setGlobalAttribute(e.GLOBAL.friendLists.friends[t.fInfo.id],t.fInfo),e.GLOBAL.friendLists.strange[t.fInfo.id]&&(e.GLOBAL.friendLists.strange[t.fInfo.id]=null);var s={};if(e.GLOBAL.msgList[t.fInfo.id]){var n=e.GLOBAL.msgList[t.fInfo.id],o=0;for(var i in e.GLOBAL.msgList[t.fInfo.id]={},n)n[i]&&(s[o]=n[i],o++);s[o]=t.msg}else e.$set(e.GLOBAL.msgList,t.fInfo.id,{}),s[0]=t.msg;e.setGlobalAttribute(e.GLOBAL.msgList[t.fInfo.id],s),e.GLOBAL.msgLength++,e.GLOBAL.friendMsgNum[t.fInfo.id]?e.GLOBAL.friendMsgNum[t.fInfo.id]++:e.$set(e.GLOBAL.friendMsgNum,t.fInfo.id,1);e.$forceUpdate()}(a,e);break;case"RefuseFriendRequest":!function(t,e){var s=e.GLOBAL.friendLists,n={},o=1;for(var i in e.GLOBAL.friendLists={},n[t.msg.id+"@0"]=t.msg,s.system)s.system[i]&&(n[s.system[i].id+"@"+o]=s.system[i],o++);s.system=n,e.setGlobalAttribute(e.GLOBAL.friendLists,s),e.GLOBAL.msgLength++,e.GLOBAL.friendMsgNum.system?e.GLOBAL.friendMsgNum.system++:e.$set(e.GLOBAL.friendMsgNum,"system",1);e.$forceUpdate()}(a,e);break;case"text":!function(t,e){var s={};if(t.data.msg){if(s=t.data.msg,t.data.userInfo){var n=t.data.userInfo;e.GLOBAL.friendLists.strange?e.GLOBAL.friendLists.strange[n.id]||(e.$set(e.GLOBAL.friendLists.strange,n.id,{}),e.setGlobalAttribute(e.GLOBAL.friendLists.strange[n.id],n)):(e.$set(e.GLOBAL.friendLists,"strange",{}),e.$set(e.GLOBAL.friendLists.strange,n.id,{}),e.setGlobalAttribute(e.GLOBAL.friendLists.strange[n.id],n))}}else s=t.data;e.GLOBAL.msgLength++,console.log("msgLenght="+e.GLOBAL.msgLength),e.GLOBAL.friendMsgNum[s.send_id]?e.GLOBAL.friendMsgNum[s.send_id]++:e.$set(e.GLOBAL.friendMsgNum,s.send_id,1);var o=0,i={};if(console.log(e.GLOBAL.msgList[s.send_id]),e.GLOBAL.msgList[s.send_id]){var a=e.GLOBAL.msgList[s.send_id];for(var c in e.GLOBAL.msgList[s.send_id]={},a)a[c]&&(i[o]=a[c],o++);i[o]=s}else e.$set(e.GLOBAL.msgList,s.send_id,{}),i[o]=s;e.setGlobalAttribute(e.GLOBAL.msgList[s.send_id],i),e.$forceUpdate()}(a,e);break;case"appInfoAndSysNews":!function(t,e){t.appInfo!=e.GLOBAL.appInfo&&(e.GLOBAL.appInfo=t.appInfo,localStorage.setItem("bc_appInfo",e.GLOBAL.ObjToString(e.GLOBAL.appInfo)));e.GLOBAL.sysNews=t.sysNews,e.$forceUpdate()}(a,e);break;case"redbagRecivedNotice":!function(t,e){console.log("redbagSrc_before => {"),console.log("red_id:"+t.red_id),console.log(e.GLOBAL.redbagsrc),console.log("}");var s="(@redbag"+t.red_id+"redbag@)";for(var n in e.GLOBAL.msgList[t.friend_id])if(-1!=e.GLOBAL.msgList[t.friend_id][n].content.indexOf(s)){e.GLOBAL.msgList[t.friend_id][n].content="false:"+e.GLOBAL.msgList[t.friend_id][n].content,console.log("content => {"),console.log(e.GLOBAL.msgList[t.friend_id][n]),console.log("}"),e.$forceUpdate();break}console.log("redbagSrc_after => {"),console.log("red_id:"+t.red_id),console.log(e.GLOBAL.redbagsrc),console.log("}")}(a,e);break;case"recivedTransferNotice":!function(t,e){var s=e.GLOBAL.msgList[t.friend_id],n="(@transfer#"+t.transfer_id+"-"+t.transfer_gold+"#transfer@)";for(var o in s){if(-1!=s[o].content.indexOf(n)){e.GLOBAL.msgList[t.friend_id][o].content="false:"+s[o].content,e.$forceUpdate(),console.log("changeTransferStatus => {"),console.log("index:"+o),console.log("content:"+e.GLOBAL.msgList[t.friend_id][o].content),console.log("}");break}console.log("origilTransferStatus => {"),console.log("index:"+o),console.log("content:"+s[o].content),console.log("}")}}(a,e);break;case"radioText":e.radioText(a)}t&&t(i.data);var c=a||!1;n&&(!o||o&&c&&c.type==o)&&(s(c,e),n=!1,o="")})},t.prototype.radioText=function(t){var e=new Object;this.$set(e,"text",t.content),this.$set(e,"send_user",t.send_user),this.$set(e,"send_id",t.send_id),this.GLOBAL.radioTextList.push(e),this.$forceUpdate()},t.prototype.updateMsgList=function(t){var e={id:"",send_id:this.GLOBAL.userInfo.id,get_id:this.GLOBAL.friendInfo.info.id,time:this.showDate(),status:this.GLOBAL.friendInfo.status,content:t,flag:1,chatType:!0,send_status:!0},s={},n=0;if(this.GLOBAL.msgList[e.get_id]){var o=this.GLOBAL.msgList[e.get_id];for(var i in this.GLOBAL.msgList[e.get_id]={},o)o[i]&&(s[n]=o[i],n++);s[n]=e}else s[n]=e,this.$set(this.GLOBAL.msgList,e.get_id,{});return console.log("----------------------------------------------"),console.log(s),console.log("----------------------------------------------"),this.setGlobalAttribute(this.GLOBAL.msgList[e.get_id],s),e.time}},console.log("BASE_JS")},"d8/S":function(t,e){},qOzh:function(t,e){}},["NHnr"]);
//# sourceMappingURL=app.5e7e53ba80d78c8bc1c2.js.map