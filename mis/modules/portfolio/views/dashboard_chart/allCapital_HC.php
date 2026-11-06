<style type="text/css">
    #capitalDiv_1, #capitalDiv_2{height: 400px !important;}
    .ui-datepicker-calendar{display: none !important;}
    #ui-datepicker-div{width: auto;}
</style>

<div id="<?php echo $div_id; ?>"></div>
<input type="hidden" id="currency_val" value="<?= $this->session->userdata['currency']; ?>">

<script>

    var id_val = "<?php echo $div_id; ?>";
    var ftype = "<?php echo $ftype; ?>";
    var colors = ['#3365cc', '#dc3911'];
    var currency = $('#currency_val').val();
    var currency_text = '';
    if(currency == 'INR') {
        currency_text = "INR (In Lakhs)";
    } else {
        currency_text = "USD (In '000's)";
    }
    
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
            text: 'Follow-On Capital'
        },
        xAxis: {
            categories: <?php echo json_encode($categories_list); ?>,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: currency_text
            }
        },
        <?php if (php72_cmp($this->session->userdata['graph_label']) == 1) { ?>
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
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        series: arr
    });
</script>