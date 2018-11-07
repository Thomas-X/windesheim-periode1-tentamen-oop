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
//          if (gettype($jsData) == 'array') {
//              $j = array_map('strval', $jsData);
//              $val = json_encode(mb_convert_encoding($j, "UTF-8", "UTF-8"), JSON_UNESCAPED_SLASHES);
//          } else {
              $val = json_encode($jsData, JSON_UNESCAPED_SLASHES);
//          }
          echo "JSDATA.{$key} = {$val};\n";
      }
  }

  ?>
</script>