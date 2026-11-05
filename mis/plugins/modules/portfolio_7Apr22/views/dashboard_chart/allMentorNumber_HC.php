<style type="text/css">
    #mentorNumber_1, #mentorNumber_2{height: 400px !important;}
    .ui-datepicker-calendar{display: block !important;}
    #ui-datepicker-div{width: auto;}
</style>

<div id="<?php echo $div_id; ?>"></div>

<script>
    var id_val = "<?php echo $div_id; ?>";
    var ftype = "<?php echo $ftype; ?>";
    var colors = ['#3365cc', '#dc3911'];
    var arr = [{
    name: 'Target',
            data: <?php echo json_encode($target_list, JSON_NUMERIC_CHECK); ?>,
            color: colors[0]
    }, {
    name: 'Actual',
            data: <?php echo json_encode($actual_list, JSON_NUMERIC_CHECK); ?>,
            color: colors[1]

    }];
    Highcharts.chart(id_val, {
    chart: {
    type: 'column'
    },
            title: {
            text: 'Mentor Numbers'
            },
            xAxis: {
            categories: <?php echo json_encode($categories_list); ?>,
                    crosshair: true
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Mentor Numbers'
                    }
            },
            tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
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
        },
                column: {
                pointPadding: 0,
                }
        },
<?php } else { ?>
        plotOptions: {
        column: {
        pointPadding: 0,
        }
        },
<?php } ?>
    series: arr
    });

</script>