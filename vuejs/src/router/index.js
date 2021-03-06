import Vue from 'vue'
import Router from 'vue-router'
// import HelloWorld from '../views/HelloWorld/HelloWorld.vue'
// 此种方式引入即可实现路由懒加载
const HelloWorld =  () => import('../views/HelloWorld/HelloWorld.vue');
const GoodsShow = () => import('../views/GoodsShow.vue');
const Notauth = () => import('../views/Notauth.vue');


Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/notauth',
      name: 'notauth',
      component: Notauth
    },
    {
      path:'/goodsshow',
      name:'goodsshow',
      component: GoodsShow
    }
  ]
})


