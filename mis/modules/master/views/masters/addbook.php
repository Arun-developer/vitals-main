<?php
$form_type = $this->uri->segment(3);
$this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - ' . ucfirst($form_type) . ' Book'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'books_master')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/books_master'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= ucfirst($form_type); ?> Books Master</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if (isset($editid) && $editid != '') { ?>
                                <li <?php if (!isset($editid)) { ?>class="activeTabs" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/books_master/add'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                <li class="edit"><a href="javascript:void(0)" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="inputplan-structureall plan-structure-new ">
                        <form id="books_form" method="post" action="<?php echo base_url() . 'index.php/master/addBooks'; ?>" autocomplete="off">
                            <?php
                            if (isset($editid) && $editid != '') {
                                $disabled = 'disabled';
                                $dis_hide = 'display-hide';
                            } else {
                                $disabled = '';
                                $dis_hide = '';
                            }
                            ?>
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Category <span class="text-danger">*</span></label>
                                        <select name="master_id" id="master_id" class="form-control additionalInput" <?= $disabled; ?>>
                                            <option value="">--Select Category--</option>
                                            <?php
                                            foreach ($books_category as $bcate) {
                                                if (isset($editid) && $editid != '') {
                                                    if ($booksList[0]['master_id'] == $bcate['master_id']) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                                <option value="<?= $bcate['master_id'] ?>" <?= $selected; ?>><?= $bcate['master_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Book Number <span class="text-danger">*</span></label>
                                        <?php
                                        $nxt_bookno = $booksList[0]['book_id'] + 1;
                                        $generate_bookno = 'VIF/' . sprintf("%04s", $nxt_bookno);
                                        ?>
                                        <input type="text" class="form-control additionalInput" readonly name="book_number" id="book_number" value="<?php echo isset($editid) && $editid != '' ? $booksList[0]['book_number'] : $generate_bookno; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Book Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="book_name" id="book_name" value="<?php echo isset($editid) && $editid != '' ? $booksList[0]['book_name'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Author</label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="author" id="author" value="<?php echo isset($editid) && $editid != '' ? $booksList[0]['author'] : ''; ?>" >
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select class="form-control programmeInput additionalInput" <?= $disabled; ?>  name="status" id="status" >
                                        <option value="">--Select--</option>
                                        <option <?php
                                        if (isset($booksList[0]['status'])) {
                                            if ($booksList[0]['status'] == '1') {
                                                echo"selected";
                                            }
                                        }
                                        ?> value="1">Active</option>
                                        <option <?php
                                        if (isset($booksList[0]['status'])) {
                                            if ($booksList[0]['status'] == '0') {
                                                echo"selected";
                                            }
                                        }
                                        ?> value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links saveLinkView <?= $dis_hide; ?>">
                                            <li><input type="submit" value="Add" class="wdt_100 vital_yellow_btn"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/master/books_master'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="edit_id" id="edit_id" value="<?php echo isset($editid) ? $editid : '' ?>" />
                            <input type="hidden" name="type" id="type" value="<?php echo isset($type) ? $type : '' ?>" />
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">
    $('#books_form').validate({
        rules: {
            master_id: "required",
            book_number: "required",
            book_name: "required"

        },
        messages: {
            master_id: "Select category",
            book_number: "Enter number",
            book_name: "Enter name"
        }
    });

    $(document).ready(function () {
        setDatepicker();
    });

    $('.summaryEdit').click(function () {
        $(".additionalInput").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

</script>

</body>
</html>