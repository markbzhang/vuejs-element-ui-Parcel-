<template>
  <div class="hello">
    <h1>777{{ msg }}</h1>
    <h2>Essential Links333333333</h2>
    <app-hello />
    <h3>4444</h3>

    <router-link :to="{ name: 'goodsshow', params: { userId: 123 }}">User</router-link>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  export default {
    name: 'HelloWorld',
    data () {
      return {
      }
    },
    computed: {
      ...mapGetters([
        'msg'
      ])
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
