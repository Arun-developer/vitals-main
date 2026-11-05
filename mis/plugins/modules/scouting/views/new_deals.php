<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Villgro MIS</title>

        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    </head>

    <body>

        <?php
        $form_name = 'searchPage';
        ?>
        <div class="newdeal-header">
            <div class="vil-sub_menu mydeal-bread">
                <div class="deal-title">
                    <h4><a href="index.html"><i class="fas fa-chevron-left"></i></a> Innovation Pool - All Innovations - Villgro India From Partner <span>
                            <select>
                                <option>Select Partner</option>
                                <option>Villgro India</option>
                                <option>Startup Oasis</option>
                                <option>IIM Calcutta</option>
                                <option>KITT</option>
                                <option>SIIC, IITK</option>
                            </select>
                        </span></h4>
                </div>
                <div class="deal-options">
                    <div>
                        <ul>
                            <li><a href="" class="btn btn-success">Show Search</a></li>
                            <li><a href="" class="btn btn-success">Hide Search</a></li>
                            <li><a href="" class="btn btn-success">Global Search</a></li>
                            <li><a href="" class="btn btn-success">Export Summary</a></li>
                            <li><a href="" class="btn btn-success">Export Applications</a></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <div class="deal-checkupbox">
                        <ul>
                            <li>Include Applications: <span>(?)</span></li>
                            <li><input type="checkbox"> Draft</li>
                            <li><input type="checkbox"> Registered</li>
                            <li><input type="checkbox"> Deleted</li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <form id="search" action="<?= base_url() . 'index.php/scouting/ui_new_deal'; ?>" method="post" name="<?= $form_name ?>" autocomplete="off">
        </form>

        <div class="vi-dashboard" style="width: 140%;margin-left: -20%;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="Diagnostic-graph">
                            <div id="accordion" class="vil-Deals table-responsive portfolio-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="20%">INV ID</th>
                                            <th width="20%">Incubatee</th>
                                            <th width="20%">Entrepreneur</th>
                                            <th width="20%">Source type</th>
                                            <th width="20%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;

                                        foreach ($innovationList['aaData'] as $row) {
                                            $parts = explode('_', $row['1']);
                                            ?>
                                            <tr>
                                                <td width="20%">
                                                    <div class="input-group">
                                                        <input type="checkbox" class="check_box"
                                                               aria-label="Checkbox for following text input">
                                                        <span><?php echo $row['1']; ?></span>
                                                    </div>
                                                </td>
                                                <td title="<?php echo $row['2']; ?>" width="20%"><?php echo $row['2']; ?></td>
                                                <td title="<?php echo $row['3']; ?>" width="20%"><?php echo strlen($row['3']) > 30 ? substr($row['3'], 0, 30) . "..." : $row['3']; ?></td>
                                                <td width="20%"><?php echo $row['4']; ?></td>
                                                <td width="20%" class="panel">
                                                    <a href="javascript:" data-toggle="collapse"
                                                       data-target="#collapse<?php echo $parts[0]; ?>"
                                                       data-parent="#accordion" aria-expanded="false" aria-controls="collapse"
                                                       class="text-warning table-toggle"><i class="fas fa-info"></i></a>
                                                    <a href="#" class="text-success"><i class="fas fa-download"></i></a>
                                                    <a href="#" class="text-primary"><i class="far fa-clone"></i></a>
                                                </td>
                                            </tr>
                                            <tr id="collapse<?php echo $parts[0]; ?>" class="collapse"
                                                aria-labelledby="headingOne" data-parent="#accordion">
                                                <td colspan="5" class="table-innercard">
                                                    <table width="100%">
                                                        <tr>
                                                            <td style="background-color:#82e0ad;">
                                                                <h4>Application Details</h4>
                                                                <ul>
                                                                    <li>Sector : <?php echo $row['5']; ?><span></span>
                                                                    </li>
                                                                    <li>Stage : <?php echo $row['6']; ?><span></span>
                                                                    </li>
                                                                    <li>Phone Number :
                                                                        <?php echo $row['14']; ?><span></span></li>
                                                                </ul>
                                                            </td>
                                                            <td style="background-color:#9becc0;">
                                                                <h4>&nbsp;</h4>
                                                                <ul>
                                                                    <li>Status : <?php echo $row['8']; ?><span></span>
                                                                    </li>
                                                                    <li>Email : <?php echo $row['13']; ?><span></span>
                                                                    </li>
                                                                    <li>Assign in-charge :
                                                                        <?php echo $row['12']; ?><span></span></li>
                                                                </ul>
                                                            </td>
                                                            <td style="background-color:#b0f1cd;">
                                                                <h4>&nbsp;</h4>
                                                                <ul>
                                                                    <li>Program :
                                                                        <?php echo $row['6']; ?><span></span></li>
                                                                    <li>Applied to partners :
                                                                        <?php echo $row['11']; ?><span></span></li>
                                                                    <li>Copied Date :
                                                                        <?php echo $row['9']; ?><span></span></li>
                                                                </ul>
                                                            </td>
                                                            <td style="background-color:#cfffe4;">
                                                                <h4>&nbsp;</h4>
                                                                <ul>
                                                                    <li>City : <?php echo $row['10']; ?><span></span></li>
                                                                    <li>Submitted Date :
                                                                        <?php echo $row['15']; ?><span></span></li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>

                                        <?php if (empty($innovationList)) { ?>
                                            <tr>
                                                <td colspan="5" align="center">No records found !</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="pull-right">
                            <?php echo $this->pagination->create_links_new($form_name); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-1.9.1.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>

    <script>
                $('[data-toggle="collapse"]').click(function () {
                    $('.collapse.in').collapse('hide');
                });
    </script>
    <style>
        a[aria-expanded="true"] {
            background: transparent !important;
            border-left: none !important;
        }
    </style>

</html>