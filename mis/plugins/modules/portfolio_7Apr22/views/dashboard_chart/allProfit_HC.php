<style type="text/css">
    #profitDiv_1, #profitDiv_2{height: 400px !important;}
    .ui-datepicker-calendar{display: none !important;}
    #ui-datepicker-div{width: auto;}
</style>

<div id="<?php echo $div_id; ?>"></div>
<input type="hidden" id="currency_val" value="<?= $this->session->userdata['currency']; ?>">

<script>

    var id_val = "<?php echo $div_id; ?>";
    var colors = ['#3365cc', '#dc3911'];
    var currency = $('#currency_val').val();
    var currency_text = '';
    if(currency == 'INR') {
        currency_text = "INR (In Lakhs)";
    } else {
        currency_text = "USD (In '000's)";
    }
    
    $('#' + id_val).highcharts({
    title: {
    text: 'Profit'
    },
            xAxis: {
            categories: <?php echo json_encode($categories_list); ?>
            },
            yAxis: {
            title: {
            text: currency_text
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
    type: 'column',
            name: 'Target',
            data: <?php echo json_encode($target_list, JSON_NUMERIC_CHECK); ?>,
            color: colors[0]
    }, {
    type: 'column',
            name: 'Actual',
            data: <?php echo json_encode($actual_list, JSON_NUMERIC_CHECK); ?>,
            color: colors[1]
    }]
    });
</script>