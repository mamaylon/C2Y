<template>
  <me :user="user"/>
</template>

<script>
  import Me from './Me.vue'
  export default {
    name: 'User',
    components: {
      Me
    },
    data: _ => ({
      user: null
    }),
    created () {
      this.$http.get('/api/user/' + this.$route.params.id)
        .then(resp => {
          if (resp.data.error) {
            throw new Error(resp.data.error)
          }
          this.user = resp.body.data.user
        })
        .catch(err => {
          console.log('ERRRR', err)
        })
    }
  }
</script>
