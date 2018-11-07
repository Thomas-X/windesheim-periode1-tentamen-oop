<script>
	var JSDATA = {};
  <?php
  // Usage:
  // View::render('page.index', ['options' =>
  // [ 'javascript_data' => [
  //      'notifications' => ['sample data']
  // ]
  // ]])
  if (isset($options)) {
      foreach ($options['javascript_data'] as $key => $jsData) {
          $val = json_encode(mb_convert_encoding($jsData, "UTF-8", "UTF-8"), JSON_UNESCAPED_SLASHES);
          echo "JSDATA.{$key} = {$val};\n";
      }
  }

  ?>
</script>