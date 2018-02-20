<!DOCTYPE html>
<html lang="ptBR">
  <head>
    <title>C2Y! - Computing to You!</title>
    <link rel="stylesheet" href="/vendor/prism/themes/prism.css">
    <link rel="stylesheet" href="/assets/css/light-bootstrap-dashboard.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/icomoon/style.css">
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <div id="app">
      <app-component></app-component>
    </div>
  </body>
</html>
<script>
  window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token()
  ]); ?>;
  window.User = {!! $user !!}
</script>
<script src="/vendor/prism/prism.js"></script>
<script src="/vendor/google-blockly/blockly_compressed.js"></script>
<script src="/vendor/google-blockly/blocks_compressed.js"></script>
<script src="/vendor/google-blockly/javascript_compressed.js"></script>
<script src="/vendor/google-blockly/msg/js/pt-br.js"></script>
<script src="/assets/js/chartist.min.js"></script>
<script src="/assets/js/demo.js"></script>
<script src="/js/app.js"></script>
