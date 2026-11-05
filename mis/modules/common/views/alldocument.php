<?php
$nullLink = 'javascript:void(0);';
$form_name = 'query_list';
$stageArray = array('Innovation', 'Assessment', 'Presentation', 'Screening', 'Terms');
?>
<h1><?= $cpagetitle . '-' . $innovation['name_of_enterprise'] ?></h1>
<br />
<form id="company_list" action="<?= site_url('common/alldocument/view_list/' . $innovation['id']) ?>" method="post" name="<?= $form_name ?>">
    <div class="searchBox" style="display:<?= (isset($_REQUEST['section'])) ? 'block' : 'none'; ?>;"  >
        <dl class="inline">
            <dt><label for="section">Stages</label></dt>
            <dd>
                <select name="section[]"  multiple="multiple">

                    <?php
                    $stageAr = (isset($_REQUEST['section'])) ? $_REQUEST['section'] : array();
                    sort($stageArray);
                    foreach ($stageArray as $st):
                        ?>
                        <option value="<?= $st ?>" <?= (php72_in_array($st, $stageAr)) ? 'selected' : ''; ?>><?= $st; ?> </option><?php
                    endforeach;
                    ?>
                </select>
            </dd>
        </dl>
        <div class="buttons">

            <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
            <button type="reset" class="button white">Reset</button>
        </div>

    </div>
</form>

<div id="uploads" style="display:none;">
    <div align="center" id="upload_form" style="height:220px;width:420px" >
        <h1>Upload Document</h1>
        <form action="<?php echo site_url('common/alldocument/upload_document/' . $innovation['id']); ?>" autocomplete="off" enctype="multipart/form-data" id="upload" class="uploadform" method="post">
            <input type="hidden" name="innovation" id="innovation" value="<?= $innovation['id']; ?>"/>
            <input type="hidden" name="uploader_name" value="<?= $this->session->userdata('emp_name'); ?>"/>
            <table class="gtable">
                <tr>
                    <td><label for="document_name">Document Description:</label></td></td>
                    <td><input type="text" name="document_name" id="document_name"/></td></td>
                </tr>
                <tr>
                    <td><label for="uploader_name">Document</label></td>
                    <td><input type="file" name="upload_document">
                        <label for="upload_document" generated="true" class="error"></label>
                    </td>
                </tr>
            </table>
            <div>
                <input type="submit" name="txtsubmit" class="button" id="txtsub" value="Submit"/>
            </div>
        </form>
    </div>
</div>

<div style=" float:right; text-align:right;width:100%;">
    <a id="upload_form" href="#upload_form" class="fancybox button" >Upload Document</a>
</div>
<br />
<br/>

<table class="gtable sortable">
    <thead>
        <tr>
            <th><a href="<?= $nullLink ?>" field="alert" class="sortlink">Document Description</a></th>
            <th><a href="<?= $nullLink ?>" field="alert" class="sortlink">Uploaded By</a></th>
            <th><a href="<?= $nullLink ?>" field="created_by" class="sortlink">Document Name</a></th>
            <th><a href="<?= $nullLink ?>" field="created_by" class="sortlink">Date Uploaded</a></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (php72_count($innovationDoc)) {
            ?>
                                                                                                                                                                                                                                                                                                                    <!--<tr class="odd"><td colspan="10" align="center"><b>INNOVATION</b></td></tr>-->
            <?php
            $i = 'odd';
            foreach ($innovationDoc as $row):
                $i = ($i == 'odd') ? 'even' : 'odd';
                $path = base_url() . "uploads/innovaton/supporting_documents/";
                ?>
                <tr class="<?= $i ?>">
                    <td></td>
                    <td><a href="<?= $path . $row['business_plan_document'] ?>" target="_blank" ><?= $row['business_plan_document'] ?></a></td>
                    <td></td>
                </tr>
                <?php
            endforeach;
        }

        if (php72_count($innovationsupportDoc)) {
            $path = base_url() . "uploads/innovaton/supporting_documents/";
            $i = 'odd';
            foreach ($innovationsupportDoc as $row):
                $i = ($i == 'odd') ? 'even' : 'odd';
                ?>
                <tr class="<?= $i ?>">

                    <td><?php echo $row['document_type_value'] ?></td>
                    <td></td>
                    <td><a href="<?= $path . $row['document'] ?>" target="_blank" ><?= $row['document'] ?></a></td>
                    <td></td>


                </tr>
                <?php
            endforeach;
        }

        if (php72_count($assesmentDoc)) {
            ?>
            <?php
            $path = base_url() . "uploads/assessment/";
            $i = 'odd';
            foreach ($assesmentDoc as $row):
                $i = ($i == 'odd') ? 'even' : 'odd';
                ?>
                <tr class="<?= $i ?>">

                    <td><?php echo "Document"; ?></td>
                    <td></td>
                    <td><a href="<?= $path . $row['documents'] ?>" target="_blank" ><?= $row['documents'] ?></a></td>
                    <td></td>
                </tr>
                <?php
            endforeach;
        }

        if (php72_count($presentDoc)) {
            ?>
            <?php
            $path = base_url() . "uploads/presentation/";
            $i = 'odd';
            foreach ($presentDoc as $row):
                $i = ($i == 'odd') ? 'even' : 'odd';
                ?>
                <tr class="<?= $i ?>">

                    <td><?php echo "Document"; ?></td>
                    <td></td>
                    <td><a href="<?= $path . $row['document'] ?>" target="_blank" ><?= $row['document'] ?></a></td>
                    <td></td>
                </tr>
                <?php
            endforeach;
        }

        if (php72_count($screeningDoc)) {
            ?>
            <?php
            $path = base_url() . "uploads/screening/";
            $i = 'odd';
            foreach ($screeningDoc as $row):
                $i = ($i == 'odd') ? 'even' : 'odd';
                ?>
                <tr class="<?= $i ?>">

                    <td><?php echo "Document"; ?></td>
                    <td></td>
                    <td><a href="<?= $path . $row['answer'] ?>" target="_blank" ><?= $row['answer'] ?></a></td>
                    <td></td>
                </tr>
                <?php
            endforeach;
        }

        if (php72_count($signDoc)) {
            ?>
            <?php
            $path = base_url() . "uploads/agreement/";
            $i = 'odd';
            foreach ($signDoc as $row):
                $i = ($i == 'odd') ? 'even' : 'odd';
                ?>
                <tr class="<?= $i ?>">
                    <td><?php echo "Document"; ?></td>
                    <td></td>
                    <td><a href="<?= $path . $row['signed_document'] ?>" target="_blank" ><?= $row['signed_document'] ?></a></td>
                    <td></td>
                </tr>
                <?php
            endforeach;
        }
        ?>
        <?php
        $path = base_url() . "uploads/upload_document/";
        $i = 'odd';
        foreach ($generaldocument as $row):
            $i = ($i == 'odd') ? 'even' : 'odd';
            ?>
            <tr class="<?= $i ?>">
                <td><?= $row['purpose_of_document']; ?></td>
                <td><?= ucfirst($row['uploader_name']); ?></td>
                <td><a href="<?= $path . $row['documents']; ?>" target="_blank" ><?= $row['documents']; ?></a></td>
                <td><?= date('d-M-y', strtotime($row['created_date'])); ?></td>
            </tr>
        <?php endforeach; ?>
        <?php
        foreach ($files as $key => $value):
            $i = ($i == 'odd') ? 'even' : 'odd';
            $doc = end(explode('/', $value));
            if ($doc != "." && $doc != ".." && $doc != "index.html" && $doc != "Thumbs.db") {
                ?>
                <tr class="<?= $i ?>">
                    <td><?php echo "Document"; ?></td><td></td>
                    <td></td>
                    <td><a href="<?= $value ?>" target="_blank" ><?= $doc; ?></a></td>
                    <td></td>
                </tr>
                <?php
            }
        endforeach;
        ?>
    </tbody>
</table>
<!-- Paging style -->

<!--Document Tree List Start -->

<!-- Menu Start -->

<style>
    .gtable td {
        padding: 6px 5px !important;
        width: 0%;
    }
    .gtable thead tr th {
        text-align: left !important;
    }
    label.error {
        display: block;
    }
</style>

<script type="text/javascript">
    $('#assign_incharge').on('click', function () {
        Populate();
    });

    var isAdmin = "<?php echo $this->session->userdata('isAdmin'); ?>";
    var isPartner = "<?php echo $this->session->userdata('partner_id'); ?>";
    var isAssociate = "<?php echo $innovation['isAssociate']; ?>";
    if ((isAssociate != '1' && isAdmin != 'Yes') || isPartner == '') {
        $("#docUpload").attr("disabled", true);
    }

    $.validator.addMethod("maxfilesize", function (value, element) {
        return this.optional(element) || (element.files && element.files[0] && element.files[0].size <= 10008250);
    }, $.format('The file size cannot exceed 10MB.'));

    $('.uploadform').validate({
        rules: {
            upload_document: {
                required: true,
                maxfilesize: true
            }
        }
    });
</script>