<template>
  <footer class="is-white has-shadow" style="border-top: thin solid #ddd">
    <span>C2Y! Ensina© 2018</span>
    <span>Iniciado por <a target="_blank" href="https://github.com/zerodois">Felipe J. L. Rita</a> e continuado por <a target="_blank" href="https://github.com/mamaylon">Maylon Macedo</a> </span>
  </footer>
</template>

<script>
  export default {
  }
</script>

<style scoped>
  footer {
    padding: 0.2em 1em;
    /* position: absolute; */
    /*bottom: 0;*/
    width: 100%;
    display: flex;
    font-size: 0.8em;
    background-color: white;
    margin-bottom: 0 !important;
  }
  span:first-child {
    flex: 1;
  }
  span + span {
    font-size: 0.7rem;
  }
</style>