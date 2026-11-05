<style type="text/css">
    #capitalDiv_1, #capitalDiv_2{height: 400px !important;}
    .ui-datepicker-calendar{display: none !important;}
    #ui-datepicker-div{width: auto;}
</style>

<div id="<?php echo $div_id; ?>"></div>

<script>

    var id_val = "<?php echo $div_id; ?>";
    var colors = ['#3365cc', '#dc3911'];
    $('#' + id_val).highcharts({
    title: {
    text: 'Follow-On Capital'
    },
            xAxis: {
            categories: <?php echo json_encode($categories_list); ?>
            },
            yAxis: {
            title: {
            text: 'Rupees (in lakhs)'
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