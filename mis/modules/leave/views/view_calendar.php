<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Villgro MIS</title>
    <!-- <link rel="stylesheet" href="http://192.168.1.200:8095/vital/source/portfolio_assets/css/new-portfolio.css"> -->

</head>

<body>
    <?php
        $this->load->view('header.php', array('page' => 'master'));

function getDates($year, $format, $timezone='UTC', $day)
{
    $days = array();
    $startDate = new DateTime("{$year}-01-01 " . $day, new DateTimezone($timezone));
    $year++;
    $endDate = new DateTime("{$year}-01-01", new DateTimezone($timezone));
    $int = new DateInterval('P7D');
    foreach(new DatePeriod($startDate, $int, $endDate) as $d) {
        $days[] = $d->format($format);
    }

    return $days;
}



 ?>

    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('master_sidemenu.php', array('page' => 'holiday')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <span><a href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Calendar Events</h4>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">

                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12">
                                                        <div id="calendar"></div>
<?php
$lists = array();
$dates = array();
          // start: '2020-06-06',
          // end: '2020-06-08',
          // overlap: false,
          // display: 'background',
          // color: '#ff9f89'
          foreach($weekdays as $wk){
            if(php72_cmp($wk['monday']) == 3){
                $dates[] = getDates('2020', 'Y-m-d', 'Asia/Kolkata', 'Monday');
            }
                        if(php72_cmp($wk['tuesday']) == 3){
                $dates[] = getDates('2020', 'Y-m-d', 'Asia/Kolkata', 'Tuesday');
            }
                        if(php72_cmp($wk['wednesday']) == 3){
                $dates[] = getDates('2020', 'Y-m-d', 'Asia/Kolkata', 'Wednesday');
            }
                        if(php72_cmp($wk['thursday']) == 3){
                $dates[] = getDates('2020', 'Y-m-d', 'Asia/Kolkata', 'Thursday');
            }
                        if(php72_cmp($wk['friday']) == 3){
                $dates[] = getDates('2020', 'Y-m-d', 'Asia/Kolkata', 'Friday');
            }
                        if(php72_cmp($wk['saturday']) == 3){
                $dates[] = getDates('2020', 'Y-m-d', 'Asia/Kolkata', 'Saturday');
            }
                        if(php72_cmp($wk['sunday']) == 3){
                $dates[] = getDates('2020', 'Y-m-d', 'Asia/Kolkata', 'Sunday');
            }
          }
          // echo count($dates);
          $i = 0;
          foreach($dates as $dt_list){
            foreach($dt_list as $dt){
            $lists[$i]['start'] = $dt;
            $lists[$i]['overlap'] = false;
            $lists[$i]['display'] = 'background';
            $lists[$i]['color'] = '#ff9f89';
          // print_r($dt);
          $i++;
      }
      }
      $j = count($lists);
      // print_r($lists);
      foreach($holiday_detail as $holis){
            $lists[$j]['title'] = $holis['holiday_name'];
            $lists[$j]['start'] = $holis['date'];
            $j++;
      }

      // foreach($lists as $k => $list_json){
      $arr = json_encode($lists);
      // }
 ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </main>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script type="text/javascript">
 
    $(document).ready(function () {
            // $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });


  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialDate: new Date(),
      editable: true,
      selectable: true,
      businessHours: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: <?php echo $arr; ?>
    });

    calendar.render();
  });
    </script>
</body>


</html>