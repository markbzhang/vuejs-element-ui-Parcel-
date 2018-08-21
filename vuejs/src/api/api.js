import axios from 'axios';
var qs = require('qs');
var cookies = require('vue-cookies');



const front_end_cms_baseUrl = 'http://www.zhangbing.club/';


axios.defaults.headers.common['Authorization'] = cookies.get("Authorization"); //get from cookie
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';   
axios.defaults.timeout = 10000; //10s



const authCgi = (params)=>{

    return axios({
        method: 'post',
        url: front_end_cms_baseUrl+'phptest/vuecgi_2.php',
        data: qs.stringify(params)
      });

};


const getGoodsTest = (params) => {
    return axios({
        method: 'post',
        url: front_end_cms_baseUrl+'phptest/vuecgi_1.php',
        data: qs.stringify(params)
      });
};




export default {
    authCgi,
    getGoodsTest
}