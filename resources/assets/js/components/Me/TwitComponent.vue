<template>
  <article class="media">
    <figure class="media-left">
      <p class="image is-64x64" style="margin-top: 10px">
        <img :src="comment.user.photo">
      </p>
    </figure>
    <div class="media-content">
      <div class="content">
        <p>
          <strong>{{ comment.user.name }}</strong> <small>{{ date }}</small>
          <br>
          {{ comment.body }}
        </p>
      </div>
    </div>
  </article>
</template>

<script>
  export default {
    props: ['comment'],
    data () {
      return {
        date: ''
      }
    },
    mounted () {
      let diff = Math.floor(Math.abs(new Date() - new Date(this.comment.created_at.replace(/-/g,'/'))) / 1000)
      let days = Math.floor(diff/86400)
      let h = Math.floor(diff/3600)
      console.log(this.comment.created_at)
      if (days > 30)
        this.date = `${days/30}mes${days/30 > 1 ? 'es' : ''}`
      else if (days > 0)
        this.date = `${days}dia${days > 1 ? 's' : ''}`
      else if (h > 0)
        this.date = `${h}hora${h > 1 ? 's' : ''}`
      else
        this.date = `${Math.floor(diff/60)}minuto${Math.floor(diff/60) > 1 ? 's' : ''}`
    }
  }
</script>