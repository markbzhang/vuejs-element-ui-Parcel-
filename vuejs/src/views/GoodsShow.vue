
<style scoped>
 .el-col {
    margin-left: 20px;
 
  }

  .center{
   text-align: center;
  }

</style>



<template>
  <div>
    <el-row :gutter="20">
        <el-col :span="3">
            <el-select v-model="selectFood" placeholder="请选择">
              <el-option
                v-for="item in foodsList"
                :key="item.value"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
        </el-col>
        <el-col :span="5">
            <el-date-picker
              v-model="selectDate"
              type="daterange"
              align="right"
              unlink-panels
              range-separator="至"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
              :picker-options="pickerTimeOpt">
            </el-date-picker>
        </el-col>
        <el-col :span="3">
            <el-input
                    placeholder="请输入站长相关"
                    v-model="input23" >
                <i slot="prefix" class="el-input__icon el-icon-search"></i>
            </el-input>
        </el-col>

        <el-col :span="3">
          <el-button type="primary" icon="el-icon-search">搜索</el-button>
        </el-col>
    </el-row>

      <el-row>
          <el-col :span="24">

                        
                <el-table
                :data="tableData"
                style="width: 100%">


                <el-table-column
                  label="ID"
                  width="80">
                  <template slot-scope="scope">
                      <span>{{ scope.row.id }}</span>
                  </template>
                </el-table-column>


                <el-table-column
                  type="index">
                </el-table-column>


                <el-table-column
                  label="日期"
                  width="180">
                  <template slot-scope="scope">
                    <i class="el-icon-time"></i>
                    <span style="margin-left: 10px">{{ scope.row.date }}</span>
                  </template>
                </el-table-column>

                <el-table-column
                  label="姓名"
                  width="180">
                  <template slot-scope="scope">
                      <span>{{ scope.row.name }}</span>
                  </template>
                </el-table-column>

                <el-table-column
                  label="地址"
                  width="300">
                  <template slot-scope="scope">
                      <span>{{ scope.row.address }}</span>
                  </template>
                </el-table-column>

                <el-table-column label="操作">
                  <template slot-scope="scope">
                    <el-button
                      size="mini"
                      @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button
                      size="mini"
                      type="danger"
                      @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                  </template>
                </el-table-column>
              </el-table>
                          

          </el-col>
      </el-row>


      <el-row style="background:#F2F6FC">
          <el-col :span="24" class="center">

                  <div class="block">
                    <el-pagination
                      @size-change="handleSizeChange"
                      @current-change="handleCurrentChange"
                      :current-page="currentPage"
                      :page-sizes="[10, 20, 30, 50 , 100]"
                      :page-size="10"
                      layout="total, sizes, prev, pager, next, jumper"
                      :total="totalCount">
                    </el-pagination>
                  </div>

          </el-col>
      </el-row>

  </div>
</template>

<script>


import api from "../api/api";

  export default {
    name: 'GoodsShow',
    data () {
      return {
        tableData:[],
        foodsList: [],
        selectFood:'',
        pickerTimeOpt: {
          shortcuts: [{
            text: '最近一周',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit('pick', [start, end]);
            }
          }, {
            text: '最近一个月',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
              picker.$emit('pick', [start, end]);
            }
          }, {
            text: '最近三个月',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
              picker.$emit('pick', [start, end]);
            }
          }]
        },
        selectDate:'',
        currentPage:1,
        pageSize:10,
        totalCount:0
      }
    },
    mounted () {
        this.initData();//初始化数据
    },
    methods : {
        initData(){
            var that = this;
          
            let params = {
               currentPage:that.currentPage,
               pageSize: that.pageSize
            }

            api.getGoodsTest(params).then(function (response) {
                // console.log(response);
                let data  = response.data.data;
                  
               if(response.data.code == 200){
                that.tableData = data.data;
                that.totalCount = data.totalCount;
                that.currentPage = data.currentPage;
                that.pageSize = data.pageSize;
               }
            })
            .catch(function (error) {
               console.log(error);
            });


            this.foodsList = [{
              value: '选项1',
              label: '黄金糕'
            }, {
              value: '选项2',
              label: '双皮奶'
            }, {
              value: '选项3',
              label: '蚵仔煎'
            }, {
              value: '选项4',
              label: '龙须面'
            }, {
              value: '选项5',
              label: '北京烤鸭'
            }];  
        },
        handleEdit(index, row) {
          console.log(index, row);
        },
        handleDelete(index, row) {
          console.log(index, row);
        },
        handleSizeChange(val) {
          // console.log(`每页 ${val} 条`);
          this.pageSize = val;
        },
        handleCurrentChange(val) {
            // console.log(`当前页: ${val}`);
            this.currentPage = val;
            let that = this;
            
            let params = {
               currentPage:that.currentPage,
               pageSize: that.pageSize
            }
            api.getGoodsTest(params).then(function (response) {
              // console.log(response);
               let data = response.data.data;
            
               if(response.data.code == 200){

                that.tableData = data.data;
                that.totalCount = data.totalCount;
                that.currentPage = data.currentPage;
                that.pageSize = data.pageSize;
               }
            })
            .catch(function (error) {
              console.log(error);
            });
        }
    }

  }
</script>


