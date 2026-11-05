<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>Villgro Organization Chart</title>
    <link rel="stylesheet" href="<?= base_url(); ?>/source/org-chart/css/jquery.jOrgChart.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/source/org-chart/css/custom.css" />

    <script type="text/javascript" src="<?= base_url(); ?>/source/template/js/custom.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/source/org-chart/prettify.js"></script>

    <!-- jQuery includes -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js">
    </script>

    <script src="<?= base_url(); ?>/source/org-chart/jquery.jOrgChart.js"></script>

    <script>
    jQuery(document).ready(function() {
        $("#org").jOrgChart({
            chartElement: '#chart',
            dragAndDrop: true
        });
    });
    </script>
</head>

<body onload="prettyPrint();">
    <div class="topbar">
        <div class="topbar-inner">
            <div class="container">
                <h1>Villgro Organisation Chart</h1>
                <ul class="nav">
                </ul>
            </div>
        </div>
    </div>
    <?php 
    $refs = array();
    $list = array();
    foreach($structure as $data):
        $thisref = &$refs[ $data['id'] ];

        $thisref['parent_id'] = $data['parnt'];
        $thisref['title'] = $data['title']."-".$data['emp_name'];

        if ($data['parnt']== 0) {
            $list[ $data['id'] ] = &$thisref;
        } else {
            $refs[ $data['parnt'] ]['children'][ $data['id'] ] = &$thisref;
        }
    endforeach;
  function toUL($arr){
  $html = '<ul id="org" style="display:none">'.PHP_EOL;
  foreach ($arr as $v){
    $html .= '<li>' . $v['title'];
    if (php72_array_key_exists('children', $v)){
      $html .= toUL($v['children']);
    }
    $html .= '</li>'.PHP_EOL;
  }
  $html .= '</ul>'.PHP_EOL;
  return $html;
}

// build the list and output it    
echo toUL($list);
?>

    <div id="chart" class="orgChart"></div>

    <script>
    jQuery(document).ready(function() {

        /* Custom jQuery for the example */
        $("#show-list").click(function(e) {
            e.preventDefault();

            $('#list-html').toggle('fast', function() {
                if ($(this).is(':visible')) {
                    $('#show-list').text('Hide underlying list.');
                    $(".topbar").fadeTo('fast', 0.9);
                } else {
                    $('#show-list').text('Show underlying list.');
                    $(".topbar").fadeTo('fast', 1);
                }
            });
        });

        $('#list-html').text($('#org').html());

        $("#org").bind("DOMSubtreeModified", function() {
            $('#list-html').text('');

            $('#list-html').text($('#org').html());

            prettyPrint();
        });
    });
    </script>

</body>

</html>