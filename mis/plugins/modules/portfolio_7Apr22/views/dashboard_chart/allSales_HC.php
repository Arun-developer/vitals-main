<style type="text/css">
    #salesDiv_1, #salesDiv_2{height: 400px !important;}
    .ui-datepicker-calendar{display: none !important;}
    #ui-datepicker-div{width: auto;}
</style>

<?php
// $annual = array("1" => 'Q1', "2" => 'Q2', "3" => 'Q3', "4" => 'Q4', "5" => 'Annual');
// $page_title = array();
// $page_title[] = 'Sales';
// if($sector_name != '') {
// 	$page_title[] = $sector_name;
// }
// if($current_quarter != '') {
// 	$page_title[] = $annual[$current_quarter];
// }
// if($current_year != '') {
// 	$page_title[] = $current_year;
// }
// $title = implode(' - ', $page_title);
?>

<div id="<?php echo $div_id; ?>"></div>

<script>

    $('#product_sales_value').removeClass('product_sales_value');

    var id_val = "<?php echo $div_id; ?>";
    var colors = ['#3365cc', '#dc3911'];
    $('#' + id_val).highcharts({
        title: {
            text: '<?php echo $heading; ?>'
        },
        xAxis: {
            categories: <?php echo json_encode($categories_list); ?>
        },
        yAxis: {
            title: {
                text: "<?php echo $yaxis_text; ?>"
            }
        },
        <?php if ($this->session->userdata['graph_label'] == 1) { ?>
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    label: {
                        enabled: false
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'normal',
                            textShadow: 'none',
                            fontSize: '10',
                            verticalAlign: 'bottom',
                            y: 40
                        },
                        formatter: function () {
                            return this.y;
                        },
                    },
                }
            },
        <?php } ?>
        series: [{
            name: 'Target',
            data: <?php echo json_encode($target_list, JSON_NUMERIC_CHECK); ?>,
            color: colors[0]
        }, {
            name: 'Actual',
            data: <?php echo json_encode($actual_list, JSON_NUMERIC_CHECK); ?>,
            color: colors[1]
        }]
    });
</script>