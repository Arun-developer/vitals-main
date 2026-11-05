<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Villgro</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>source/template/js/chart/jquery-1.12.4.js"></script>
        <script src="<?php echo base_url(); ?>source/template/js/chart/jquery-ui.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>source/template/js/chart/jquery-ui.css">
            <script type="text/javascript" src="<?php echo base_url(); ?>source/template/js/chart/loader.js"></script>

            <script src="<?php echo base_url(); ?>source/template/js/chart/export-data.js"></script>
            <script src="<?php echo base_url(); ?>source/template/js/chart/highcharts.js"></script>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>source/template/js/chart/datatables.min.css"/>
            <script type="text/javascript" src="<?php echo base_url(); ?>source/template/js/chart/datatables.min.js"></script>

            <script type="text/javascript">

                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                /*----- Getting values for Pie chart-------*/
                function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Sectors', 'Count']
<?php
foreach ($sector_count as $row) {
    echo ", ['" . ucfirst($row['sector_name']) . "', " . $row['count(*)'] . "]";
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

                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(donorChart);
                /*----- Getting values chart based on donors-------*/
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

                /*----- Getting values for chart based on stage/status-------*/
                $(document).ready(function(){
                Highcharts.chart('container', {

                chart: {
                type: 'column'
                },
                        title: {
                        text: 'Applications By Sector - Stage/Status'
                        },
                        xAxis: {
                        min: 2,
<?php if ($this->session->userdata('partner_id') == '10') { ?>
                            max: 4,
<?php } else { ?>
                            max: 6,
<?php } ?>
                        tickPositions: [0, 1, 2, 3],
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
                        formatter: function () {
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
    ?>, <?php } ?>],
                                stack: 'application'
                        }, {
                        name: 'Closed in Application Stage',
                                data: [<?php
foreach ($applicationStage as $row) {
    echo $row['Close_count'];
    ?>, <?php } ?>],
                                stack: 'application'
                        }, {
                        name: 'Open in PA/RD Stage',
                                data: [<?php
foreach ($PA_RD_stage as $row) {
    echo $row['Open_count'];
    ?>, <?php } ?>],
                                stack: 'PA_RD'
                        }, {
                        name: 'Closed in PA/RD Stage',
                                data: [<?php
foreach ($PA_RD_stage as $row) {
    echo $row['Close_count'];
    ?>, <?php } ?>],
                                stack: 'PA_RD'
                        }]
                });
                });
            </script>





            <script type="text/javascript">
                /*----- Getting values for chart based on city-------*/
                $(document).ready(function(){
                Highcharts.chart('city_graph', {

                chart: {
                type: 'column'
                },
                        title: {
                        text: 'Applications by City and Sectors'
                        },
                        xAxis: {
                        categories: [ <?php foreach ($city as $row) { ?> '<?php echo $row['city']; ?>', <?php } ?> ]
                        },
                        yAxis: {
                        allowDecimals: false,
                                min: 0,
                                title: {
                                text: 'Number of Applications'
                                }
                        },
                        tooltip: {
                        formatter: function () {
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

    </head>
    <body>

        <h2>Dashboard Report</h2>

        <div class="clearfix"></div>

        <?php
        $curDate = date("d-m-Y");
        $last_three_months = date("d-m-Y", strtotime("-2 months"));
        ?>

        <div class="searchBox">
            <dl class="inline">
                <dt><label for="created_date">Registered Date</label></dt>
                <dd>
                    <input class="input_date" type="text" id="from_date"/> -
                    <input class="input_date" type="text" id="to_date" />
                </dd>

                <dt><label for="submitted_date">Submitted Date</label></dt>
                <dd>
                    <input class="input_date" type="text" id="sub_from_date" value="<?php echo $last_three_months; ?>" /> -
                    <input class="input_date" type="text" id="sub_to_date" value="<?php echo $curDate; ?>"/>
                </dd>

                <dt><label for="program">Select Program</label></dt>
                <dd>
                    <select class="search_select" name="program" id="program">
                        <?php if ($this->session->userdata('partner_id') != '10') { ?>
                            <option value="pitch">Pitch</option>
                        <?php } ?>
                        <option value="incubation">Incubation</option>
                    </select>
                </dd>

                <dt><label for="stage">Select Stage (Only for Application By Employee)</label></dt>
                <dd>
                    <select class="search_select" name="stage" id="stage">
                        <option value="">-Select-</option>
                        <option value="7">Application</option>
                        <option value="8">PA/RD</option>
                    </select>
                </dd>

            </dl>


            <div class="buttons">
                <button type="submit" class="button" value="Search" id="searchFilter" name="searchFilter">Search</button>
                <a type="reset" href="javascript:window.location.href=window.location.href" id="txtReset" class="button white">Reset</a>
            </div>

        </div>

        <div class="chart_dashboard" style="height:800px;">

            <!-- Displaying the charts -->

            <div style="height:400px;">
                <div id="piechart" style="width:50%; float:left;"></div>
                <div id="donorchart" style="width:50%; float:left;"></div>
            </div>
            <div style="height:400px;">
                <div id="container" style="width:50%; float:left;"></div>
                <div id="city_graph" style="width:50%; float:left;"></div>
            </div>

        </div>

        <h2 style="text-align:center;color:#333333;">Applications by Employee</h2>

        <table id="incharge_status" style="width:100%" class="gtable sortable display">
            <thead>
                <tr>
                    <th>Assigned Incharge</th>
                    <th>Open Status</th>
                    <th>Closed Status</th>
                    <th>Open IIC <br> Approved</th>
                    <th>Closed IIC <br> Rejected</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody align="center">
            </tbody>

        </table>
    </body>

    <script>
        $(document).ready(function(){
        $('#searchFilter').click();
        });
        $('#incharge_status').DataTable({
        "aaSorting": [],
                "bPaginate": false,
                "ajax": {
                url : "<?php echo site_url("chart/getDataTableValues") ?>",
                        type : 'POST'
                },
        });
        $(function() {
        $("#from_date, #to_date ,#sub_from_date, #sub_to_date").datepicker({ dateFormat: 'dd-mm-yy' });
        });
        $('#searchFilter').click(function(){

        /*-----Getting search values for all three charts ------*/
        var program = $('#program option:selected').text();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var sub_from_date = $('#sub_from_date').val();
        var sub_to_date = $('#sub_to_date').val();
        if (program == 'Incubation' || program == 'Livelihoods') {
        $('#city_graph').hide();
        $("#container").removeAttr("style").css({'width':'50%', 'margin':'0 auto'});
        } else {
        $('#city_graph').show();
        $("#container").removeAttr("style").css({'width':'50%', 'float':'left'});
        }

        $.ajax({
        type: "POST",
                url: '<?php echo base_url(); ?>index.php/chart/dashboardPieChart',
                data: {from_date:from_date, to_date:to_date, program:program, sub_from_date:sub_from_date, sub_to_date:sub_to_date},
                dataType :'html',
                success: function(result){
                $('#piechart').html(result);
                $('#container').html(result);
                $('#city_graph').html(result);
                },
        });
        });
        $('#searchFilter').click(function(){

        /*-----Getting search values for assign incharge counts on datatable ------*/
        var program = $('#program option:selected').text();
        var stage = $('#stage').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var sub_from_date = $('#sub_from_date').val();
        var sub_to_date = $('#sub_to_date').val();
        $.ajax({
        type: "POST",
                url: '<?php echo base_url(); ?>index.php/chart/getDataTableValues',
                data: {from_date:from_date, stage:stage, to_date:to_date, program:program, sub_from_date:sub_from_date, sub_to_date:sub_to_date},
                dataType :'json',
                success: function(result){
                $("#incharge_status").dataTable({"bDestroy":true}).fnDestroy();
                $('#incharge_status').dataTable({
                'data': result.data,
                        "aaSorting": [],
                        "bPaginate": false
                });
                },
        });
        });

    </script>
    <style type="text/css">
        table.dataTable tbody tr:last-child td{
            background-color: #868c79 !important;
            color: #fff;
        }
        .search_select{
            padding: 3px;
            border-radius: 3px;
            border: 1px solid #ccc;
            background: #fff url(../images/input-bg.gif) 0 0 repeat-x;
        }
        .input_date{
            border: 1px solid #ccc;
            padding: 4px 5px;
            background: #fff url(../images/input-bg.gif) 0 0 repeat-x;
            border-radius: 3px;
        }
        dl.inline dd {
            float: left;
            width: 75%;
            margin: 0 0 15px;
        }
        dl.inline dt {
            clear: both;
            width: 25%;
            float: left;
            text-align: right;
        }
        dl.inline dt label {
            margin-right: 12px;
            font: 11px Tahoma, sans-serif;
            font-weight: bold;
            color: #555;
        }
        div.buttons {
            margin: 20px 0 10px 25%;
        }
    </style>
</html>

