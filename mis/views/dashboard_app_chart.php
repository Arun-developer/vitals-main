<script type="text/javascript">
    google.charts.load('current', {
    'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
    var data = google.visualization.arrayToDataTable([
    ['Sectors', 'Count'],
<?php
foreach ($sector_count as $row) {
    echo "['" . ucfirst($row['sector_name']) . "', " . $row['count(*)'] . "],";
}
?>
    ]);
    var options = {
    title: 'Applications By Sector',
            colors: ['#3366cc', '#dc3912', '#ff9900', '#595c5f', '#943eb7', '#e25785', '#0099c6', '#109618', '#ec8f6e', '#673e22', '#ffff00'],
            titleTextStyle: {
            color: '#333333',
                    fontSize: 18,
                    bold: false,
            },
            width: 500,
            height: 400,
            fontSize: 10,
            pieSliceText: 'value-and-percentage'
    };
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {
    'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(donorChart);
    function donorChart() {
    var data = google.visualization.arrayToDataTable([
    ['Donors', 'Count']
<?php
foreach ($donors as $row) {
    echo ", ['" . ucfirst($row['donor_name']) . "', " . $row['count'] . "]";
}
?>
    ]);
    var options = {
    title: 'Deals in PA/RD - By Donor',
            titleTextStyle: {
            color: '#333333',
                    fontSize: 18,
                    bold: false,
            },
            width: 500,
            height: 400,
            fontSize: 10,
            pieSliceText: 'value-and-percentage'
    };
    var chart = new google.visualization.PieChart(document.getElementById('donorchart'));
    chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
    Highcharts.chart('container', {

    chart: {
    type: 'column'
    },
            title: {
            text: 'Applications By Sector - Stage/Status'
            },
            xAxis: {
<?php if ($this->session->userdata('partner_id') == '10') { ?>
                max: 4,
                        tickPositions: [0, 1, 2, 3, 4],
<?php } ?>
            categories: [ <?php foreach ($sector_details as $row) { ?> "<?php echo $row['sector']; ?>", <?php } ?> ],
                    labels: {
                    formatter: function() {
                    return typeof this.value !== 'number' ? this.value : ''
                    }
                    }
            },
            yAxis: {
            allowDecimals: false,
                    min: 0,
                    title: {
                    text: 'Number of Applications'
                    }
            },
            tooltip: {
            formatter: function() {
            return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
            },
            plotOptions: {
            column: {
            stacking: 'normal'
            }
            },
            series: [{
            name: 'Open in Application Stage',
                    data: [<?php
foreach ($applicationStage as $row) {
    echo $row['Open_count'];
    ?>,
<?php } ?>
                    ],
                    stack: 'application'
            }, {
            name: 'Closed in Application Stage',
                    data: [<?php
foreach ($applicationStage as $row) {
    echo $row['Close_count'];
    ?>,
<?php } ?>
                    ],
                    stack: 'application'
            }, {
            name: 'Open in PA/RD Stage',
                    data: [<?php
foreach ($PA_RD_stage as $row) {
    echo $row['Open_count'];
    ?>,
<?php } ?>
                    ],
                    stack: 'PA_RD'
            }, {
            name: 'Closed in PA/RD Stage',
                    data: [<?php
foreach ($PA_RD_stage as $row) {
    echo $row['Close_count'];
    ?>,
<?php } ?>
                    ],
                    stack: 'PA_RD'
            }]
    });
    });</script>


<script type="text/javascript">
    $(document).ready(function() {
    Highcharts.chart('city_graph', {

    chart: {
    type: 'column'
    },
            title: {
            text: 'Applications by City and Sectors'
            },
            xAxis: {
            categories: [<?php foreach ($city as $row) { ?> '<?php echo $row['city']; ?>', <?php } ?>]
            },
            yAxis: {
            allowDecimals: false,
                    min: 0,
                    title: {
                    text: 'Number of Applications'
                    }
            },
            tooltip: {
            formatter: function() {
            return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
            },
            plotOptions: {
            column: {
            stacking: 'normal'
            }
            },
            series: [
<?php if ($this->session->userdata('partner_id') == '10') { ?>
                {
                name: 'Agriculture & Fish',
                        data: [<?php
    foreach ($agriculture_fish as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }, {
                name: 'Fishery',
                        data: [<?php
    foreach ($fishery as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }, {
                name: 'Textile',
                        data: [<?php
    foreach ($textile as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }, {
                name: 'Dairy',
                        data: [<?php
    foreach ($dairy as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }, {
                name: 'Others',
                        data: [<?php
    foreach ($others as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }
<?php } else { ?>
                {
                name: 'Healthcare',
                        data: [<?php
    foreach ($healthcare as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }, {
                name: 'Agri Business',
                        data: [<?php
    foreach ($agri_business as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }, {
                name: 'Education',
                        data: [<?php
    foreach ($education as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }, {
                name: 'Others',
                        data: [<?php
    foreach ($others as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }, {
                name: 'CleanTech',
                        data: [<?php
    foreach ($clean_tech as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }, {
                name: 'Energy',
                        data: [<?php
    foreach ($energy as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }, {
                name: 'Skill Development',
                        data: [<?php
    foreach ($skill_dev as $row) {
        echo $row['all_count'];
        ?>, <?php } ?>],
                }
<?php } ?>
            ]
    });
    });
</script>