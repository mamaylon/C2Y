<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Blockly Demo: Fixed Blockly</title>
  <script src="/vendor/google-blockly/blockly_compressed.js"></script>
  <script src="/vendor/google-blockly/blocks_compressed.js"></script>
  <script src="/vendor/google-blockly/javascript_compressed.js"></script>
  <script src="/vendor/google-blockly/msg/js/pt-br.js"></script>
  <style>
    body {
      background-color: #fff;
      font-family: sans-serif;
    }
    h1 {
      font-weight: normal;
      font-size: 140%;
    }
  </style>
</head>
<body>
  <h1><a href="https://developers.google.com/blockly/">Blockly</a> &gt;
    <a href="../index.html">Demos</a> &gt; Fixed Blockly</h1>

  <p>This is a simple demo of injecting Blockly into a fixed-sized 'div' element.</p>

  <p>&rarr; More info on <a href="https://developers.google.com/blockly/guides/configure-blockly/web/fixed-size">injecting fixed-sized Blockly</a>&hellip;</p>

  <div id="blocklyDiv" style="height: 480px; width: 600px;"></div>
  <textarea name="" id="textarea" cols="30" rows="10"></textarea>

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
    `;
    var workspace = Blockly.inject('blocklyDiv', { toolbox: xmlString });
    workspace.addChangeListener(myUpdateFunction);
    function myUpdateFunction(event) {
      var code = Blockly.JavaScript.workspaceToCode(workspace);
      document.getElementById('textarea').value = code;
    }

  </script>

</body>
</html>