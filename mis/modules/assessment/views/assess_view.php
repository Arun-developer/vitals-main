<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/grid.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/chosen.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/jquery.fancybox.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/datatables.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/mystyle.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/misstylesheet.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/green.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/style.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/styles.css"; ?>"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . "source/pre_assesst/js/jquery.fancybox.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "source/pre_assesst/js/simpletreemenu.js"; ?>"></script>
<script type="text/javascript">
    function export_xl()
    {
        var htmltable = document.getElementById('export_table');
        var html = htmltable.outerHTML;
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
    }
</script>
<style type="text/css">
    .fancybox-custom .fancybox-skin {
        box-shadow: 0 0 50px #222;
    }
</style>

<!-- Assign Assessor Ends -->

<section style="overfolw:visible" id="content">
    <section style="overfolw:visible;margin-left:0px!important;width:100%!important" class="clearfix">
        <section style="overfolw:visible" class="grid_12" id="main">

            <ul class="option-tab">
                <li><a class="button" href="<?php echo site_url('assessment/view_assesst_detail/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/export'); ?>">Download</a></li>
            </ul>
            <div class="clearfix"></div>
            <div class="table-tree">
                <table class="tree" width="100%" cellpadding="0" cellspacing="0" id="export_table" style="font-size:12px !important">

                    <tr>
                        <th width="150">Area</th>
                        <th width="100">Incubatee Score</th>
                        <th>NA</th>
                        <th>No - 0</th>
                        <th>Low - 1</th>
                        <th>Medium - 2</th>
                        <th>High - 3</th>
                    </tr>
                    <?php
                    if (isset($assesst)) {
                        $area_id = unserialize($assesst[0]['area_id']);
                        $score = unserialize($assesst[0]['score']);
                        $rational = unserialize($assesst[0]['rational']);
                        $risk = unserialize($assesst[0]['risk']);
                    }
                    $count_area = count($area);
                    foreach ($area as $area) {
                        ?>
                        <tr class="parent" id="row<?php echo $area['id']; ?>">
                            <td><strong><?php echo $area['Name']; ?></strong></td>
                            <td><?php
                                if (isset($score[$area['id']])) {
                                    echo $score[$area['id']];
                                } else {
                                    echo '';
                                }
                                ?>
                            </td>

                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <?php
                        $sub_category = $this->Massessment->getSubCategory($area['id']);
                        $sub_count = count($sub_category);
                        $i = 0;
                        if (isset($sub_assesst)) {
                            foreach ($sub_assesst as $sub) {
                                if ($area['id'] == $sub['area_id']) {
                                    $category_id = unserialize($sub['sub_category']);
                                    $sub_score = unserialize($sub['sub_score']);
                                    $add_score = unserialize($sub['add_score']);
                                }
                            }
                        }
                        foreach ($sub_category as $sub) {
                            $addscore = '';
                            if (isset($category_id) && in_array($sub['id'], $category_id)) {
                                $key = array_search($sub['id'], $category_id);
                                $subscore = $sub_score[$key];
                                $addscore = $add_score[$key];
                            }
                            $i++;
                            ?>
                            <tr class="child-row<?php echo $area['id']; ?> in-child">
                                <td><?php echo $sub['category']; ?></td>
                                <td>
                                    <?php
                                    if (isset($subscore) && $subscore != '-1') {
                                        echo $subscore;
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($addscore) && $addscore != '') {
                                        $reason = $this->Massessment->getReasons($addscore);
                                        echo $reason[0]['name'];
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $sub['no']; ?></td>
                                <td><?php echo $sub['low']; ?></td>
                                <td><?php echo $sub['medium']; ?></td>
                                <td><?php echo $sub['high']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr class="child-row<?php echo $area['id']; ?> in-child" style="background: none repeat scroll 0 0 #E7F9CF">
                            <td><strong>Rational</strong></td>
                            <td colspan="2"><?php
                                if (isset($rational[$area['id']])) {
                                    echo $rational[$area['id']];
                                } else {
                                    echo '';
                                }
                                ?></td>
                            <td><strong>Risk</strong></td>
                            <td colspan="3"><?php
                                if (isset($risk[$area['id']])) {
                                    echo $risk[$area['id']];
                                } else {
                                    echo '';
                                }
                                ?></td>
                        </tr>
                    <?php }
                    ?>

                    <tr class="parent" id="rowtotal">
                        <td><strong>Total</strong></td>
                        <td>
                            <?php
                            if (isset($assesst[0]['total_score'])) {
                                echo $assesst[0]['total_score'];
                            } else {
                                echo "";
                            }
                            ?>
                        </td>

                        <td colspan="5">&nbsp;</td>
                    </tr>

                </table>
            </div>

        </section>
    </section>
</section>
