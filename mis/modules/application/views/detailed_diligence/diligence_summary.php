<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Detailed Assessment - ' . $innovation['name_of_enterprise'])); ?>
<?php $eic_action_date = date('d-m-Y', strtotime($eic_app[0]['modified_date'])); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'diligence_summary', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content vital_windowScroll">
                <?php $this->load->view('detailed_diligence/diligence_options.php', array('application_id' => $application_id, 'title' => 'Summary', 'inv_id' => $inv_id_format, 'stage' => $stage_name, 'status' => $status_name, 'incharge' => $assign_incharge, 'enterprise_name' => $innovation['name_of_enterprise'], 'sector' => $sector[0]['sector'], 'sub_sector' => $subsector, 'assign_to' => $assign_to, 'eic_date' => $eic_action_date)); ?>

                <?php
                $app_date = $iic_date = $nda_date = $quest_date = $site_date = $eic_date = '-';
                $iic_action = $eic_action = 'approved';
                $doc_rec_val = $asses_val = '-';

                $docs_type = array('1', '2', '3', '4', '5', '6');
                for ($i = 0; $i < php72_count($all_docs); $i++) {
                    $get_docs[$all_docs[$i]['doc_type']] = $all_docs[$i]['doc_type'];
                }
                $avail_docs = php72_array_keys($get_docs);

                if (!empty($all_docs) && !array_diff($docs_type, $avail_docs)) {
                    $doc_rec = 'green';
                    $doc_rec_val = 'Yes';
                }

                if ($application_date[0]['submitted_date'] != '0000-00-00') {
                    $app_date = date('d-M-Y', strtotime($application_date[0]['submitted_date']));
                }

                if ($iic_val[0]['internal_status'] != '') {
                    $iic_date = date('d-M-Y', strtotime($iic_val[0]['modified_date']));
                    $iic_action = $iic_val[0]['internal_status'] == 'Accept' ? 'approved' : 'rejected';
                }
                if ($nda_signed[0]['id'] != '') {
                    $nda_date = date('d-M-Y', strtotime($nda_signed[0]['created_at']));
                }
                if ($quest_res[0]['id'] != '') {
                    $quest_date = date('d-M-Y', strtotime($quest_res[0]['created_at']));
                }
                if ($site_plan[0]['id'] != '') {
                    $site_date = date('d-M-Y', strtotime($site_plan[0]['created_at']));
                }
                if ($assessment[0]['id'] != '') {
                    $asses_val = 'Yes';
                }

                if ($eic_app != '' && (($innovation['status'] == '17' || $innovation['status'] == '20') || ($innovation['stage'] == '12' && $innovation['status'] == '12'))) {
                    $eic_action = 'approved';
                    $eic_date = date('d-M-Y', strtotime($eic_app[0]['modified_date']));
                } else if ($eic_app != '' && $innovation['status'] == '18') {
                    $eic_action = 'rejected';
                    $eic_date = date('d-M-Y', strtotime($eic_app[0]['modified_date']));
                }
                ?>

                <div class="row">
                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                        <table class="table table-hover dataTable dt-responsive">
                            <thead style="background: #2a7d47;">
                                <tr>
                                    <th>Application submitted</th>
                                    <th>IIC <?= $iic_action; ?></th>
                                    <th>NDA signed</th>
                                    <th>Documents received</th>
                                    <th>DD questionnaire received</th>
                                    <th>Site visit plan created</th>
                                    <th>DD assessment in progress</th>
                                    <th>EIC <?= $eic_action; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= $app_date; ?></td>
                                    <td class="text-center"><?= $iic_date; ?></td>
                                    <td class="text-center"><?= $nda_date; ?></td>
                                    <td class="text-center"><?= $doc_rec_val; ?></td>
                                    <td class="text-center"><?= $quest_date; ?></td>
                                    <td class="text-center"><?= $site_date; ?></td>
                                    <td class="text-center"><?= $asses_val; ?></td>
                                    <td class="text-center"><?= $eic_date; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>


</body>
</html>