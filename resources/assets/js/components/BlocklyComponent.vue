<template>
  <section class="container has-text-centered margin-bottom">
    <div class="margin-bottom" id="blocklyDiv" style="height: 460px; width: 600px; margin: auto"></div>
    <div class="columns">
      <div class="column is-8 is-offset-2">
        <pre><code id="code" class="language-javascript"></code></pre>
      </div>
    </div>
  </section>
</template>

<script>
  var xmlString = `
  <xml>
    <block type="controls_if"></block>
    <block type="logic_compare"></block>
    <block type="controls_repeat_ext"></block>
    <block type="math_number"></block>
    <block type="math_arithmetic"></block>
    <block type="text"></block>
    <block type="text_print"></block>
  </xml>
  `
  var workspace = null
  function myUpdateFunction(event) {
    var code = Blockly.JavaScript.workspaceToCode(workspace)
    var el = document.getElementById('code')
    el.innerText = code
  }
  export default {
    mounted () {
      workspace = Blockly.inject('blocklyDiv', { toolbox: xmlString })
      workspace.addChangeListener(myUpdateFunction)
    }
  }
</script>

<style lang="sass">
</style>