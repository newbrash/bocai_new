webpackJsonp([46],{"2yeY":function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a={components:{dentGameHeader:s("k8mJ").a},data:function(){return{gdTrend:[],statistics:{},issueNum:30,order:"desc",site:"one",chartsModal:!1}},mounted:function(){this.$parent.tabbarShow=!1,this.getOddsData()},methods:{getSiteData:function(t,e){this.senddata({data:{type:"trend",game:"GD",issueCount:t,site:e}})},getOddsData:function(){var t=this;this.checkGameSocket(function(){t.dealOnMessage(),t.getSiteData(30,1)})},dealOnMessage:function(){var t=this;this.onmessage(function(e){if("pong"!==(e=JSON.parse(e)).code){if(e.gdTrend&&e.statistics){t.gdTrend=e.gdTrend;for(var s=e.statistics.statistics,a=[],n=0;n<4;n++)a[n]=[];for(var i=0;i<11;i++)for(var o=0;o<4;o++){a[o][i]=s[i+1][["show","avgOmit","maxOmit","maxShow"][o]]}t.statistics=a}}else t.senddata({data:{type:"ping"}})})},onselect:function(t){},onClickRightIcon:function(){this.toggleModal("chartsModal")},toggleModal:function(t){this[t]=!this[t]},drawline:function(){var t,e,s,a,n=document.getElementById("table");if(!document.getElementById("dentTableCanvas")){var i='<canvas id="dentTableCanvas" width="'+n.offsetWidth+'" height="'+n.offsetHeight+'" style="position: absolute;left: 0;top: 0; z-index: 1;"></canvas>';n.insertAdjacentHTML("beforebegin",i)}!function(t){var e=t.points,s=t.ballWidth,a=t.ballHeight,n=document.getElementById("dentTableCanvas"),i=n.getContext("2d");n.height=n.height,i.lineWidth=1,i.strokeStyle="#e64600",i.beginPath(),i.moveTo(e[0].left+s,e[0].top+a);for(var o=1;o<e.length;o++)i.lineTo(e[o].left+s,e[o].top+a);i.stroke()}((t=n.querySelectorAll(".openball"),e=t[0].parentNode.offsetWidth/2,s=t[0].parentNode.offsetHeight/2,a=[],t.forEach(function(t){a.push({left:t.parentNode.offsetLeft,top:t.parentNode.offsetTop})}),{points:a,ballWidth:e,ballHeight:s}))}},watch:{issueNum:function(){this.getSiteData(this.issueNum,1)},site:function(t){this.gdTrend=[];var e=["one","two","three","four","five"].indexOf(t)+1;this.getSiteData(30,e)},gdTrend:function(){var t=this;this.$nextTick(function(){t.drawline()})},order:function(){this.gdTrend=this.gdTrend.reverse()}}},n={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"container"},[s("dentGameHeader",{attrs:{obj:{"基本走势":"","定位胆":""},subType:"normal",rightCharts:"true"},on:{onselect:t.onselect,onClickRightIcon:t.onClickRightIcon}}),t._v(" "),s("div",{staticClass:"ex-header flex flow-col"},[s("table",{staticClass:"fixheader"},[s("COLGROUP",[s("col",{attrs:{width:"21.6%"}}),t._v(" "),t._l(11,function(t){return s("col",{attrs:{width:78.4/11+"%"}})})],2),t._v(" "),s("thead",[s("tr",[s("th",[t._v("期号")]),t._v(" "),t._l(11,function(e){return s("th",[t._v(t._s(1===e.toString().length?"0"+e:e))])})],2)])],1),t._v(" "),s("div",{staticClass:"table-main flex flow-col"},[s("div",{staticClass:"table-main-wrap"},[s("table",{attrs:{id:"table"}},[s("COLGROUP",[s("col",{attrs:{width:"21.6%"}}),t._v(" "),t._l(11,function(t){return s("col",{attrs:{width:78.4/11+"%"}})})],2),t._v(" "),s("tbody",t._l(t.gdTrend,function(e){return s("tr",{class:e%2==0?"bg-grey":""},[s("td",[t._v(t._s(e.expect))]),t._v(" "),t._l(11,function(a){return s("td",[0==e[t.site]["num"+a]?[s("div",{staticClass:"openball"},[t._v("\n                    "+t._s(a>9?a:"0"+a))])]:s("div",[t._v(t._s(e[t.site]["num"+a]))])],2)})],2)}))],1)]),t._v(" "),s("table",{staticClass:"count"},[s("COLGROUP",[s("col",{attrs:{width:"21.6%"}}),t._v(" "),t._l(11,function(t){return s("col",{attrs:{width:78.4/11+"%"}})})],2),t._v(" "),s("tbody",[s("tr",[s("td",[t._v("出现次数")]),t._v(" "),t._l(t.statistics[0],function(e){return s("td",[t._v("\n              "+t._s(e)+"\n            ")])})],2),t._v(" "),s("tr",[s("td",[t._v("平均遗漏")]),t._v(" "),t._l(t.statistics[1],function(e){return s("td",[t._v("\n              "+t._s(e)+"\n            ")])})],2),t._v(" "),s("tr",[s("td",[t._v("最大遗漏")]),t._v(" "),t._l(t.statistics[2],function(e){return s("td",[t._v("\n              "+t._s(e)+"\n            ")])})],2),t._v(" "),s("tr",[s("td",[t._v("最大连出")]),t._v(" "),t._l(t.statistics[3],function(e){return s("td",[t._v("\n              "+t._s(e)+"\n            ")])})],2)])],1)]),t._v(" "),s("div",{staticClass:"flex ball"},t._l({"一":"one","二":"two","三":"three","四":"four","五":"five"},function(e,a,n){return s("label",{staticClass:"ball-item",class:t.site===e?"current-ball":""},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.site,expression:"site"}],staticClass:"dent-hide-input",attrs:{type:"radio"},domProps:{value:e,checked:t._q(t.site,e)},on:{change:function(s){t.site=e}}}),t._v("\n        第"+t._s(a)+"球\n      ")])})),t._v(" "),t._m(0)]),t._v(" "),s("transition",{attrs:{name:"fadein"}},[s("div",{directives:[{name:"show",rawName:"v-show",value:t.chartsModal,expression:"chartsModal"}],staticClass:"charts-mask",on:{click:function(e){if(e.target!==e.currentTarget)return null;t.toggleModal("chartsModal")}}},[s("div",{staticClass:"modal",class:t.chartsModal?"modal-show":""},[s("div",{staticClass:"modal-title"},[t._v("\n          走势图设置\n        ")]),t._v(" "),s("div",{staticClass:"modal-body"},[s("div",{staticClass:"setup"},[s("p",{staticClass:"fontc-6"},[t._v("期数：")]),t._v(" "),s("div",{staticClass:"flex justify-sa"},t._l([30,50,100],function(e){return s("label",[s("input",{directives:[{name:"model",rawName:"v-model",value:t.issueNum,expression:"issueNum"}],staticClass:"dent-radio",attrs:{type:"radio"},domProps:{value:e,checked:t._q(t.issueNum,e)},on:{change:function(s){t.issueNum=e}}}),t._v(t._s(e)+"期")])}))]),t._v(" "),s("div",{staticClass:"setup"},[s("p",{staticClass:"fontc-6"},[t._v("排序：")]),t._v(" "),s("div",{staticClass:"flex justify-sa"},t._l([{text:"顺序显示",order:"asc"},{text:"倒序显示",order:"desc"}],function(e){return s("label",[s("input",{directives:[{name:"model",rawName:"v-model",value:t.order,expression:"order"}],staticClass:"dent-radio",attrs:{type:"radio"},domProps:{value:e.order,checked:t._q(t.order,e.order)},on:{change:function(s){t.order=e.order}}}),t._v(t._s(e.text))])}))])]),t._v(" "),s("div",{staticClass:"modal-btn flex"},[s("a",{staticClass:"modal-btn-cancle fontc-9",attrs:{dentHoverclass:"hoverclass"},on:{click:function(e){t.toggleModal("chartsModal")}}},[t._v("取消")]),t._v(" "),s("a",{staticClass:"modal-btn-confrim",attrs:{dentHoverclass:"hoverclass"},on:{click:function(e){t.toggleModal("chartsModal")}}},[t._v("确认")])])])])])],1)},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"time-to-open"},[this._v("\n      • "),e("span",{staticClass:"font-grey"},[this._v("距20181005010期截止 : ")]),e("span",{staticClass:"font-theme"},[this._v("00 : 06 : 14")])])}]};var i=s("VU/8")(a,n,!1,function(t){s("Y4s/")},"data-v-0dac31a5",null);e.default=i.exports},"Y4s/":function(t,e){}});
//# sourceMappingURL=46.18c14544a3d82be1c511.js.map