<template>
    <div>
      <multiselect 
          v-model="bncc_component" 
          :options="options"
          :multiple="true"
          :close-on-select="false"
          :hide-selected="true"
          label="name"
          ></multiselect>
    </div>
</template>

<script>
  import Multiselect from 'vue-multiselect'

  export default {
    components: { Multiselect },
    data () {
      return {
        bncc_component: [],
        options: [
                {name:'list', value:"l"},
                {name: 'of', value:"o"},
                {name:'options', value:"op"}]
      }
    }
  }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
</style>