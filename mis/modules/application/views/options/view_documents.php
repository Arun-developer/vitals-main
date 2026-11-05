<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'View Documents - ' . $innovation['name_of_enterprise'], 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'view_document', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <!-- <span><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-angle-left"></i> Back</a></span> -->
                        <h4><?= $innovation['name_of_enterprise']; ?></h4>
                    </div>
                </div>
                <div class="tab-slider--navform">
                    <ul class="tab-slider--tabsform">
                        <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/application/view_documents/' . $application_id; ?>">All Documents</a></li>
                        <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/application/upload_document/' . $application_id; ?>">Upload Document</a></li>
                    </ul>
                </div>

                <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new vital_windowScroll">
                            <div class="table_configcontentnew pad-bt0">
                                <div class="row">
                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                        <table class="table table-hover dt-responsive" id="viewTable">
                                            <thead>
                                                <tr>
                                                    <th>Document Name</th>
                                                    <th>Document Description</th>
                                                    <th>Uploaded BY</th>
                                                    <th>Date Uploaded</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no_data = 0;
                                                if (php72_count($innovationDoc)) {
                                                    $i = 'odd';
                                                    foreach ($innovationDoc as $row):
                                                        if ($row['business_plan_document'] != '') {
                                                            $i = ($i == 'odd') ? 'even' : 'odd';
                                                            $path = base_url() . "uploads/innovaton/supporting_documents/";
                                                            ?>
                                                            <tr class="<?= $i ?>">
                                                                <td><a href="<?= $path . $row['business_plan_document'] ?>" target="_blank" ><?= $row['business_plan_document'] ?></a></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <?php
                                                            $no_data = 1;
                                                        }
                                                    endforeach;
                                                }

                                                if (php72_count($innovationsupportDoc)) {
                                                    $path = base_url() . "uploads/innovaton/supporting_documents/";
                                                    $i = 'odd';
                                                    foreach ($innovationsupportDoc as $row):
                                                        $i = ($i == 'odd') ? 'even' : 'odd';
                                                        ?>
                                                        <tr class="<?= $i ?>">
                                                            <td><a href="<?= $path . $row['document'] ?>" target="_blank" ><?= $row['document'] ?></a></td>
                                                            <td><?php echo $row['document_type_value'] ?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                    $no_data = 1;
                                                }

                                                if (php72_count($assesmentDoc)) {
                                                    $path = base_url() . "uploads/assessment/";
                                                    $i = 'odd';
                                                    foreach ($assesmentDoc as $row):
                                                        $i = ($i == 'odd') ? 'even' : 'odd';
                                                        ?>
                                                        <tr class="<?= $i ?>">
                                                            <td><a href="<?= $path . $row['documents'] ?>" target="_blank" ><?= $row['documents'] ?></a></td>
                                                            <td><?php echo "Document"; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                    $no_data = 1;
                                                }

                                                if (php72_count($presentDoc)) {
                                                    $path = base_url() . "uploads/presentation/";
                                                    $i = 'odd';
                                                    foreach ($presentDoc as $row):
                                                        $i = ($i == 'odd') ? 'even' : 'odd';
                                                        ?>
                                                        <tr class="<?= $i ?>">
                                                            <td><a href="<?= $path . $row['document'] ?>" target="_blank" ><?= $row['document'] ?></a></td>
                                                            <td><?php echo "Document"; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                    $no_data = 1;
                                                }

                                                if (php72_count($screeningDoc)) {
                                                    $path = base_url() . "uploads/screening/";
                                                    $i = 'odd';
                                                    foreach ($screeningDoc as $row):
                                                        $i = ($i == 'odd') ? 'even' : 'odd';
                                                        ?>
                                                        <tr class="<?= $i ?>">
                                                            <td><a href="<?= $path . $row['answer'] ?>" target="_blank" ><?= $row['answer'] ?></a></td>
                                                            <td><?php echo "Document"; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                    $no_data = 1;
                                                }

                                                if (php72_count($signDoc)) {
                                                    $path = base_url() . "uploads/agreement/";
                                                    $i = 'odd';
                                                    foreach ($signDoc as $row):
                                                        $i = ($i == 'odd') ? 'even' : 'odd';
                                                        ?>
                                                        <tr class="<?= $i ?>">
                                                            <td><a href="<?= $path . $row['signed_document'] ?>" target="_blank" ><?= $row['signed_document'] ?></a></td>
                                                            <td><?php echo "Document"; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                    $no_data = 1;
                                                }

                                                if (php72_count($generaldocument)) {
                                                    $path = base_url() . "uploads/upload_document/";
                                                    $i = 'odd';
                                                    foreach ($generaldocument as $row):
                                                        $i = ($i == 'odd') ? 'even' : 'odd';
                                                        ?>
                                                        <tr class="<?= $i ?>">
                                                            <td><a href="<?= $path . $row['documents']; ?>" target="_blank" ><?= $row['documents']; ?></a></td>
                                                            <td><?= $row['purpose_of_document']; ?></td>
                                                            <td><?= ucfirst($row['uploader_name']); ?></td>
                                                            <td><?= date('d-M-y', strtotime($row['created_date'])); ?></td>
                                                        </tr>
                                                        <?php
                                                    endforeach;
                                                    $no_data = 1;
                                                }

                                                if (php72_count($files)) {
                                                    foreach ($files as $key => $value):
                                                        $i = ($i == 'odd') ? 'even' : 'odd';
                                                        $doc = end(explode('/', $value));
                                                        if ($doc != "." && $doc != ".." && $doc != "index.html" && $doc != "Thumbs.db") {
                                                            ?>
                                                            <tr class="<?= $i ?>">
                                                                <td><a href="<?= $value ?>" target="_blank" ><?= $doc; ?></a></td>
                                                                <td><?php echo "Document"; ?></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    endforeach;
                                                    $no_data = 1;
                                                }
                                                ?>

                                                <?php if ($no_data == 0) { ?>
                                                    <tr class="odd">
                                                        <td valign="top" colspan="4" class="dataTables_empty text-center">No data available in table</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
        </div>
    </div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#viewTable').DataTable({
            "ordering": true,
            "info": false,
            "searching": false,
            "lengthChange": false
        });
    });
</script>

</body>
</html>