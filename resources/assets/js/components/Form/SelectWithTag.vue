<template>
  <select :value="vModel" @change="setValue($event.target.value)" class="multipleSelect" multiple="true">
     <option v-for="(resp, index) in bncc_components"
        :value="resp.value"
        :key="index">{{ resp.text }}</option>   
  </select>
</template>

<script>
  import 'fastselect/dist/fastselect.min.css'

  export default {
    props: [ 'place', 'url','vModel'],
    methods: {
        setValue(val) {
            this.error.clear();
            this.$emit('input', val);
        }
    },
    mounted: function() 
    {
      let self = this
      self.$http.get(this.url)
        .then(resp => (self.bncc_components = resp.body));

      $.Fastselect.defaults = 
      {
          elementClass: 'fstElement',
          singleModeClass: 'fstSingleMode',
          noneSelectedClass: 'fstNoneSelected',
          multipleModeClass: 'fstMultipleMode',
          queryInputClass: 'fstQueryInput',
          queryInputExpandedClass: 'fstQueryInputExpanded',
          fakeInputClass: 'fstFakeInput',
          controlsClass: 'fstControls',
          toggleButtonClass: 'fstToggleBtn',
          activeClass: 'fstActive',
          itemSelectedClass: 'fstSelected',
          choiceItemClass: 'fstChoiceItem',
          choiceRemoveClass: 'fstChoiceRemove',
          userOptionClass: 'fstUserOption',

          resultsContClass: 'fstResults',
          resultsOpenedClass: 'fstResultsOpened',
          resultsFlippedClass: 'fstResultsFilpped',
          groupClass: 'fstGroup',
          itemClass: 'fstResultItem',
          groupTitleClass: 'fstGroupTitle',
          loadingClass: 'fstLoading',
          noResultsClass: 'fstNoResults',
          focusedItemClass: 'fstFocused',

          matcher: null,

          url: null,
          loadOnce: false,
          apiParam: 'query',
          initialValue: null,
          clearQueryOnSelect: true,
          minQueryLength: 1,
          focusFirstItem: false,
          flipOnBottom: true,
          typeTimeout: 150,
          userOptionAllowed: false,
          valueDelimiter: ',',
          maxItems: null,

          parseData: null,
          onItemSelect: null,
          onItemCreate: null,
          onMaxItemsReached: null,

          placeholder: this.place,
          searchPlaceholder: 'Search options',
          noResultsText: 'Nada encontrado :(',
          userOptionPrefix: 'Add '

      };

      var vm = this
      var $select = $('.multipleSelect');
      $select.fastselect();

    },
    data () {
      return {
        bncc_components: []
      }
    }
  }
</script>

<style scoped lang="sass">
</style>