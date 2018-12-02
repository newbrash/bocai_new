<template>
  <div class="container">
    <!-- 导航栏 -->
    <dentGameHeader v-on:onselect="onselect"
                    v-on:onClickRightIcon="chartsModal=true"
                    :obj="select"
                    subType="normal"
                    rightCharts="true">
    </dentGameHeader>

    <div class="ex-header flex flow-col">
      <!-- 定位胆 -->
      <template v-if="currentTable=== '定位胆'">
        <div class="total flex justify-ct flow-col">
          <!-- 表格主体 -->
          <template v-if="dwdTableData.trend">
            <!-- 固定表头 -->
            <table class="fixheader"
                   style="position: sticky;top: 0;z-index: 2;">
              <colgroup>
                <col width="75px">
                <col v-for="n in 10"
                     width="30px">
              </colgroup>
              <thead>
                <tr>
                  <th>期号</th>
                  <th v-for="n in 10">{{n-1}}</th>
                </tr>
              </thead>
            </table>
            <div class="table-main-wrap">
              <!-- 固定表格主体 -->
              <table class="canvas-table"
                     style="margin-top: -1px;">
                <colgroup>
                  <col width="75px">
                  <col v-for="n in 10"
                       width="30px">
                </colgroup>
                <tbody>
                  <tr v-for="(tr,index) in dwdTableData.trend"
                      :class="index%2 === 1?'bg-grey':''">
                    <td>{{tr.expect}}</td>
                    <td v-for="index in 10">
                      <div :class="tr[index-1] === 0 ? 'openball' : ''">
                        {{ (tr[index-1] === 0 ? index-1 : tr[index-1]) | filter_toTwo }}
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <!-- 固定表脚 -->
              <table style="position: sticky;bottom: 0;z-index: 1;">
                <colgroup>
                  <col width="75px">
                  <col v-for="n in 10"
                       width="30px">
                </colgroup>
                <tfoot v-if="dwdTableData.statistics"
                       class="bg-yellow">
                  <tr>
                    <td>出现次数</td>
                    <td v-for="value in  dwdTableData.statistics.times">
                      {{ value }}
                    </td>
                  </tr>
                  <tr>
                    <td>平均遗漏</td>
                    <td v-for="value in  dwdTableData.statistics.averageLose">
                      {{ value }}
                    </td>
                  </tr>
                  <tr>
                    <td>最大遗漏</td>
                    <td v-for="value in  dwdTableData.statistics.maxLose">
                      {{ value }}
                    </td>
                  </tr>
                  <tr>
                    <td>最大连出</td>
                    <td v-for="value in  dwdTableData.statistics.maxOut">
                      {{ value }}
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </template>
          <mt-spinner v-else
                      color="#e62b00"
                      type="fading-circle"></mt-spinner>
        </div>
        <!-- 位数 -->
        <div class="ball-wrap flex">
          <label v-for="(value,key) in {'万位':'万位','千位':'千位','百位':'百位','十位':'十位','个位':'个位'}"
                 :class="site===value?'current-ball':''"
                 class="ball-item">
            <input type="radio"
                   :value="value"
                   v-model="site"
                   class="dent-hide-input">
            {{value}}
          </label>
        </div>
      </template>

      <!-- 大小单双 -->
      <template v-if="currentTable=== '大小单双'">
        <div class="total flex justify-ct flow-col">
          <!-- 表格主体 -->
          <template v-if="daxdsTableData.trend">
            <div class="table-main-wrap">
              <!-- 固定表头 -->
              <table class="fixheader"
                     style="position: sticky;top: 0;z-index: 2;">
                <colgroup>
                  <col width="75px">
                  <col width="100px">
                  <template v-for="n in 5">
                    <col v-for="n in 4"
                         width="25px">
                  </template>
                </colgroup>
                <thead>
                  <tr>
                    <th rowspan="2">期号</th>
                    <th rowspan="2">开奖号码</th>
                    <th v-for="item in ['万位','千位','百位','十位','个位']"
                        colspan="4">{{item}}</th>
                  </tr>
                  <tr>
                    <template v-for="n in 5">
                      <th v-for="item in ['大','小','单','双']">{{item}}</th>
                    </template>
                  </tr>
                </thead>
              </table>
              <!-- 固定表格主体 -->
              <table class="canvas-table"
                     style="margin-top: -1px;">
                <colgroup>
                  <col width="75px">
                  <col width="100px">
                  <template v-for="n in 5">
                    <col v-for="n in 4"
                         width="25px">
                  </template>
                </colgroup>
                <tbody>
                  <tr v-for="(tr,index) in daxdsTableData.trend"
                      :class="index%2 === 1?'bg-grey':''">
                    <td>{{tr.expect}}</td>
                    <td>
                      <span v-for="span in tr.open_code"
                            class="font-theme"
                            style="margin: 0 .5vw;">{{span}}</span>
                    </td>
                    <template v-for="(key,index) in ['wan','qian','bai','shi','ge']">
                      <td :class="tr[key+'_da'] === 0 && dxdsClass(index)">{{ toDxds(tr[key+'_da'], 0) }}</td>
                      <td :class="tr[key+'_xiao'] === 0 && dxdsClass(index)">{{ toDxds(tr[key+'_xiao'], 1) }}</td>
                      <td :class="tr[key+'_dan'] === 0 && dxdsClass(index)">{{ toDxds(tr[key+'_dan'], 2) }}</td>
                      <td :class="tr[key+'_shuang'] === 0 && dxdsClass(index)">{{ toDxds(tr[key+'_shuang'], 3) }}</td>
                    </template>
                  </tr>
                </tbody>
              </table>
              <!-- 固定表脚 -->
              <table style="position: sticky;bottom: 0;z-index: 1;">
                <colgroup>
                  <col width="175px">
                  <template v-for="n in 5">
                    <col v-for="n in 4"
                         width="25px">
                  </template>
                </colgroup>
                <tfoot class="bg-yellow">
                  <tr>
                    <td>出现次数</td>
                    <td v-for="value in  daxdsTableData.statistics.times">
                      {{ value }}
                    </td>
                  </tr>
                  <tr>
                    <td>平均遗漏</td>
                    <td v-for="value in  daxdsTableData.statistics.averageLose">
                      {{ value }}
                    </td>
                  </tr>
                  <tr>
                    <td>最大遗漏</td>
                    <td v-for="value in  daxdsTableData.statistics.maxLose">
                      {{ value }}
                    </td>
                  </tr>
                  <tr>
                    <td>最大连出</td>
                    <td v-for="value in  daxdsTableData.statistics.maxOut">
                      {{ value }}
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </template>
          <mt-spinner v-else
                      color="#e62b00"
                      type="fading-circle"></mt-spinner>
        </div>
      </template>

      <!-- 距离下期开奖 -->
      <div class="time-to-open">
        • <span class="font-grey">距{{nextIssue}}期截止 : </span><span class="font-theme">{{timer.timeToOpen}}</span>
      </div>
    </div>

    <!-- 走势图设置弹窗 -->
    <transition name="fadein">
      <div @click.self="chartsModal=false"
           class="charts-mask"
           v-show="chartsModal">
        <div class="modal">
          <div class="modal-title">
            走势图设置
          </div>

          <div class="modal-body">
            <!-- 选择期数 -->
            <div class="setup">
              <p class="fontc-6">期数：</p>
              <div class="flex justify-sa">
                <label v-for="item in [30,50,100]"
                       class="flex">
                  <input type="radio"
                         class="dent-radio"
                         v-model="issueNum"
                         :value="item">{{item}}期</label>
              </div>
            </div>
            <!-- 选择排序 -->
            <div class="setup">
              <p class="fontc-6">排序：</p>
              <div class="flex justify-sa">
                <label v-for="item in [{text:'顺序显示',order:'asc'},{text:'倒序显示',order:'desc'}]"
                       class="flex">
                  <input type="radio"
                         class="dent-radio"
                         v-model="order"
                         :value="item.order">{{item.text}}</label>
              </div>
            </div>

          </div>

          <div class="modal-btn flex">
            <a @click="chartsModal=false"
               dentHoverclass="hoverclass"
               class="modal-btn-cancle fontc-9">取消</a>
            <a @click="chartsModal=false"
               dentHoverclass="hoverclass"
               class="modal-btn-confrim">确认</a>
          </div>
        </div>
      </div>
    </transition>

  </div>
</template>

<script>
import dentGameHeader from "@/components/common/dentGameHeader";
import { countDownFunc } from "@/mixins/mixins";

export default {
  mixins: [countDownFunc],
  components: {
    dentGameHeader
  },
  filters: {
    // 键值转成中文
    keyToCharacter: function(value) {
      let character = "";
      value = value.toLowerCase();
      if (value.match(/_/)) value = value.split("_")[1];
      for (let key in keyToCharacter) {
        if (key === value) {
          character = keyToCharacter[key];
          break;
        }
      }
      !character && (character = value);
      return character;
    }
  },
  data() {
    return {
      gameKey: "bjpk10",
      /* 数据相关 */
      select: { 定位胆: "dingDanWei", 大小单双: "daxiaodanshuang" },
      dwdTableData: {}, //定位胆 走势图数据
      daxdsTableData: {}, //大小单双 走势图数据

      /* 状态相关 */
      currentTable: "定位胆", //当前走势图
      chartsModal: false, //走势图设置弹窗
      issueNum: 30, //当前期数
      order: "desc", //正反序
      site: "万位" // 定位胆位数
    };
  },
  mounted: function() {
    this.$parent.tabbarShow = false;
    this.nextIssue = this.GLOBAL.bjpk10.nextIssue;
    //从全局变量读取并且启动倒计时
    let { countdown, interval } = this.GLOBAL.bjpk10;
    countdown && this.mixins_countTime(countdown, interval, "timeToOpen");

    this.getOddsData();
  },
  methods: {
    onselect(index) {
      this.currentTable = index;
      let type, weishu;

      if (index === "大小单双") {
        type = "daxiaodanshuang";
        weishu = "大小单双";
      }
      if (index === "定位胆") {
        type = "dingDanWei";
        weishu = "万位";
      }
      this.getData(type, this.issueNum, weishu);
    },

    getData(type, size, weishu) {
      let data = {
        type,
        size,
        game: "cjssc",
        weishu
      };
      this.senddata({ data });
    },

    //请求 赔率 数据
    getOddsData() {
      this.checkGameSocket(() => {
        this.dealOnMessage(); //已经创建连接 监听返回的信息
      });
    },

    //处理返回的数据
    dealOnMessage() {
      this.onmessage(res => {
        //基本走势
        if (
          ["万位", "千位", "百位", "十位", "个位"].includes(res.type) &&
          typeof res === "object"
        ) {
          this.dwdTableData = res.trendInfo;
        }

        if (res.type === "大小单双" && typeof res === "object") {
          this.daxdsTableData = res.trendInfo;
        }
      });
    },

    //数字为0时 ，为开奖号码
    toDxds(value, index) {
      let temp = { 0: "大", 1: "小", 2: "单", 3: "双" };

      return value === 0 ? temp[index] : value;
    },

    dxdsClass(index) {
      let temp = { 0: "font-red", 1: "font-blue", 2: "font-green" };

      return temp[index % 3];
    }
  },
  watch: {
    //倒序数组
    // order(){
    //   if(this.currentTable === '基本走势'){
    //     this.basicTableData.reverse();
    //   };
    //   if(this.currentTable === '和值'){
    //     this.sumTableData.table.reverse();
    //   }
    // },

    //更改期数
    // issueNum(){
    //   this.onselect(this.currentTable);
    // },

    //改变球数的时候 发起新的请求
    site(site) {
      this.getData("dingDanWei", this.issueNum, site);
    },

    //表格渲染完成连线
    dwdTableData: {
      handler() {
        this.$nextTick(() => {
          this.$drawline({ selector: ".canvas-table" });
        });
      },
      deep: true
    }
  }
};
</script>

<style scoped>
.bg-hong {
  background: #ec0909;
}
.bg-lan {
  background: #0e86e3;
}
.bg-lv {
  background: #12c231;
}
.bg-yellow {
  background: #edffd1;
}
.fontc-hong {
  color: #ec0909;
}
.fontc-lan {
  color: #0e86e3;
}
.fontc-lv {
  color: #12c231;
}
.container {
  padding-top: 13.8vw;
  background: #fff;
  font-family: pingfang sc normal;
  font-size: 12px;
}
.ex-header {
  height: calc(100vh - 13.8vw);
}
table {
  table-layout: fixed;
  width: 100%;
  border-spacing: 0;
  border-collapse: collapse;
  font-size: 12px;
}
th,
td {
  padding: 1.6vw 0;
  border: solid #dcdcdc;
  border-width: 1px;
  font-weight: normal;
  color: #858da3;
}
.font-red {
  color: #cc0000;
}
.font-blue {
  color: #0e86e3;
}
.font-green {
  color: #38be4f;
}
.dent-radio {
  margin-right: 1vw;
  appearance: none;
  outline: none;
}
.dent-radio::after {
  content: "";
  position: relative;
  box-sizing: border-box;
  display: block;
  width: 4vw;
  height: 4vw;
  background-color: #eeeeee;
  border: 1px solid #dedee2;
  border-radius: 50%;
  text-align: center;
  transition: background 0.5s;
}

.dent-radio:checked:after {
  content: "";
  background: #e64600;
  border: 2px solid #fff;
  box-shadow: 0 0 0 1px #dedee2;
}

.total {
  flex: 1;
  width: 100%;
  overflow: auto;
}

/* 表头 */
.fixheader {
  background: #e5e5e5;
}
/* 表格主体 */
#table,
.table-main-wrap {
  flex: 1;
  position: relative;
}
.charts {
  flex: 1;
}
.table-main {
  flex: 1;
  margin-top: -1px;
  background: #ffffff;
}
.table-main-wrap {
  flex: 1;
  width: 100%;
  overflow: auto;
}
.animalTfootWrap {
  height: 32vw;
}
.fontc-3 {
  color: #333;
}
.bg-grey {
  background: #f8f8f8;
}
.openball {
  position: relative;
  z-index: 1;
  width: 6.4vw;
  height: 6.4vw;
  background: #e64600;
  line-height: 6.4vw;
  color: #fff;
  border-radius: 50%;
}
/* tab */
.charts-tab-item {
  flex: 1;
  background: #e5e5e5;
  line-height: 6vw;
  color: #4e4e4e;
}
.current-tab {
  background: #e64600;
  color: #fff;
}
/* 下期开奖 */
.charts-tab {
  width: 100%;
}
.time-to-open {
  width: 100%;
  height: 14vw;
  background: #fff;
  text-align: left;
  line-height: 14vw;
  font-size: 14px;
  text-indent: 20px;
}
.font-grey {
  color: #606060;
}

/* 球数 */
.ball-wrap {
  width: 100%;
  overflow: auto;
}
.ball-item {
  flex: none;
  width: 75px;
  background: #e5e5e5;
  line-height: 8vw;
  color: #4e4e4e;
}
.current-ball {
  background: #e64600;
  color: #fff;
}
.dent-hide-input {
  display: none;
}

/* 走势图弹窗 */
.charts-mask {
  position: fixed;
  z-index: 2;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.1);
  color: #333;
}
.modal {
  background-color: #fff;
  width: 84%;
  border-radius: 6px;
  font-size: 16px;
  text-align: left;
  user-select: none;
  backface-visibility: hidden;
  transform: translate3d(0, 0, 0);
  transition: 0.35s;
  overflow: hidden;
}
.fadein-enter-active,
.fadein-leave-active {
  will-change: opacity;
  transition: opacity 500ms;
}
.fadein-enter,
.fadein-leave-to {
  opacity: 0;
}
.fadein-enter .modal {
  transform: translate3d(0, 50%, 0);
}
.fadein-leave-active .modal {
  transform: translate3d(0, 50%, 0);
}
.modal-title {
  border-bottom: 1px solid #e7e7e7;
  line-height: 50px;
  text-align: center;
}
.modal-body {
  padding: 10px;
}
.modal-btn {
  border-top: 1px solid #dedede;
  padding: 10px;
}
.modal-btn a {
  flex: 1;
  margin: 0 2vw;
  text-align: center;
  line-height: 10vw;
  border-radius: 4px;
}
.modal-btn .modal-btn-cancle {
  background: #e5e5e5;
  color: #9c9c9c;
}
.modal-btn .modal-btn-confrim {
  background: #e64600;
  color: #ffffff;
}
.setup {
  font-size: 14px;
  line-height: 8vw;
}
</style>
