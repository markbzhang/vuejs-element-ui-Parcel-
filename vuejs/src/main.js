import Vue from 'vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import App from './App'
import router from './router'
import './components/index.js'
import store from './store'
import VueCookies from 'vue-cookies';



Vue.use(ElementUI);
Vue.use(VueCookies);

//https://www.npmjs.com/package/vue-cookies  用法


Vue.config.productionTip = false
/* eslint-disable no-new */




import api from "./api/api";

//判断是否有token,没有则拒绝访问
router.beforeEach((to,from,next) => {

    let Authorization = '';
    //先赋值
    let foundStr = '&token=';
    let n = window.location.href.indexOf('token=');
    if(n !== -1)
    {
        Authorization = window.location.href.substr(n+foundStr.length-1);
        if(typeof(Authorization) != 'undefined' && Authorization != '')    VueCookies.set('Authorization',Authorization);    
    }
   

    if(to.path != '/notauth'){
        let token = Authorization || VueCookies.get('Authorization');
        if(token == null || token == ''){
          next({path:'/notauth'});
        }else{
          api.authCgi({'Authorization':token}).then(function(response){
              if(response.data.code != 200){
                next({path:'/notauth'});
              }else
              {
                next();
                //验证顺利通过后台
              }
          }).catch(function(err){
            next({path:'/notauth'});
          });
        }
    }else{
      next();
    }
})

//除了路由url进行后台验证，还有每个cgi请求，都会验证，具体操作是 每个cgi请求都带上 header头Authorization ，后台进行验证  


new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app-box');


