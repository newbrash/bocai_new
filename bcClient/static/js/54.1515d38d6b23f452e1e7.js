webpackJsonp([54],{KRcm:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=s("fZjL"),n=s.n(a),l={props:{ruleKey:String,currentOdds:String,value:Boolean},computed:{ruleObj:function(){return this.$getLocalCache(this.ruleKey)},currentRule:function(){var t=this.ruleObj;return t&&n()(t).length&&t[this.currentOdds]}},methods:{closeModal:function(){this.$emit("input",!1)}}},i={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("transition",{attrs:{name:"fadeIn"}},[s("div",{directives:[{name:"show",rawName:"v-show",value:t.value,expression:"value"}],staticClass:"modal-mask",on:{click:function(e){return e.target!==e.currentTarget?null:t.closeModal(e)}}},[s("div",{staticClass:"modal example-modal"},[s("div",{staticClass:"modal-title"},[t._v("\n        玩法规则\n      ")]),t._v(" "),s("div",{staticClass:"modal-body"},[s("div",{staticClass:"example-tips"},[s("p",{staticClass:"example-title"},[s("span",{staticClass:"iconfont icon-idea font-theme"}),t._v("玩法提示")]),t._v(" "),t.currentRule?s("p",{staticClass:"example-content"},[t._v("\n            "+t._s(t.currentRule.tips)+"\n          ")]):t._e()]),t._v(" "),s("div",{staticClass:"example-tips"},[s("p",{staticClass:"example-title"},[s("span",{staticClass:"iconfont icon-jihua font-theme"}),t._v("中奖说明")]),t._v(" "),t.currentRule?s("p",{staticClass:"example-content"},[t._v("\n            "+t._s(t.currentRule.rule)+"\n          ")]):t._e()]),t._v(" "),s("div",{staticClass:"example-tips"},[s("p",{staticClass:"example-title"},[s("span",{staticClass:"iconfont icon-case font-theme"}),t._v("范例")]),t._v(" "),t.currentRule?s("p",{staticClass:"example-content"},[t._v("\n            "+t._s(t.currentRule.case)+"\n          ")]):t._e()])])])])])},staticRenderFns:[]};var c=s("VU/8")(l,i,!1,function(t){s("Q6RP")},"data-v-aee1b1c4",null);e.default=c.exports},Q6RP:function(t,e){}});
//# sourceMappingURL=54.1515d38d6b23f452e1e7.js.map