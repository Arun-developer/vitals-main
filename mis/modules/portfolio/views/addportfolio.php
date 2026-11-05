<?php
$form_name = 'searchPage';
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => 'Add to Portfolio', 'port_action' => 'add_portfolio', 'page_table' => 'datatable', 'module' => 'dt_responsive'));
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <?php if ($search_value != '') { ?>
                    <p class="aprvd-deals">Showing search results for '<?= $search_value; ?>'</p>
                <? } else { ?>
                    <p class="aprvd-deals">Approved Deals</p>
                <?php } ?>
                <div class="Diagnostic-graph">
                    <div id="accordion" class="vil-Deals table-responsive portfolio-table">
                        <table class="table display responsive nowrap" id="port_data">
                            <thead>
                                <tr>
                                    <th>INV ID</th>
                                    <th>Incubatee</th>
                                    <th>Entrepreneur</th>
                                    <!-- <th width="20%">Source type</th> -->
                                    <th>Sector</th>
                                    <th>Stage</th>
                                    <th>Status</th>
                                    <th>Source Type</th>
                                    <th>Phone number</th>
                                    <th>Program</th>
                                    <th>Email</th>
                                    <th>Assign In-Charge</th>
                                    <th>Applied To Partners</th>
                                    <th>Copied Date</th>
                                    <th>City</th>
                                    <th>Submitted Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>

            </div>
        </div>
    </div>
</div>
</div>
</div>


<div class="modal" id="actionModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100">Do you want to merge the company or add it to the portfolio?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="actionForm" id="actionForm" action="<?php echo base_url() . 'index.php/portfolio/update_merge_company'; ?>" method="post">
                   <div class="row">
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label>Company Lists <span></span></label>
                            </div>
                        </div>
						<input type="hidden" name="current_inv_id"  id="current_inv_id"/>
                        <div class="col-12 col-lg-8 col-md-8">
                            <div class="form-group">
                                <select name="company_id" id="company_ids" class="form-control required">
                                    <option value="">-Select-</option>
										<?php foreach($getCompanyList as $lists) { ?>
											<option value="<?php echo $lists->id ?>"><?php echo $lists->name; ?></option>
										<?php } ?>
								</select>
									<div id="display_company_err"></div>
                            </div>
                        </div>
                    </div>

                    <div class="asseSummary_btns">
                        <input type="reset" value="Merge" id="Merge" name="txtReset" class="vital_bordered_btn wdt_100" />
                        <input style="width: 126px !important;" id="add_to_portfolio" type="submit" value="Add To Portfolio" class="vital_yellow_btn wdt_100" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    a[aria-expanded="true"] {
        background: transparent !important;
        border-left: none !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#port_data').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "paging": true,
            "ordering": true,
            "info": false,
            "searching": false,
            "pageLength": 10,
            "lengthChange": false,
            "stateSave": false,
            responsive: {
                details: {
                    type: 'column',
                    target: -1
                }
            },
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/portfolio/DTaddportfolio",
                "data": {"search_value": "<?php echo $search_value; ?>"},
                "type": "POST"
            },
            columnDefs: [
                {className: 'none', "targets": 6},
                {className: 'none', "targets": 7},
                {className: 'none', "targets": 8},
                {className: 'none', "targets": 9},
                {className: 'none', "targets": 10},
                {className: 'none', "targets": 11},
                {className: 'none', "targets": 12},
                {className: 'none', "targets": 13},
                {className: 'none', "targets": 14},
                {"width": "5%", "targets": 0},
                {"width": "15%", "targets": 1},
                {"width": "20%", "targets": 2},
                {"width": "15%", "targets": 3},
                {"width": "15%", "targets": 4},
                {"width": "15%", "targets": 5},
                {"width": "5%", "targets": 6},
                {"width": "10%", "targets": 7},
                {
                    className: 'control',
                    orderable: false,
                    targets: -1
                },
                {
                    'targets': 6,
                    'orderable': false
                }],
            //                            fixedColumns: true
            //                            "displayStart": 2
        });
    });
    $('[data-toggle="collapse"]').click(function () {
        $('.collapse.in').collapse('hide');
    });
    $(document).on('click', '.add-portbtn', function () {
        localStorage.setItem('onboardPop', 1);
    });

	$('#Merge').on('click', function () {
	
		var company_id = $('#company_ids').val();
		var current_inv_id = $('#current_inv_id').val();
		
		$("#add_to_portfolio").attr('disabled', true);
		$("#Merge").attr('disabled', true);
		$("#display_company_err").html('');
		if(company_id==''){
			$("#add_to_portfolio").attr('disabled', false);
			$("#Merge").attr('disabled', false);
			$("#display_company_err").html('<label for="current_inv_id" class="error">Select Company</label>');
			return false;	
		}	
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/portfolio/update_merge_company",
			data: {
				company_id: company_id,
				current_inv_id:current_inv_id
			},
			dataType: 'json',
			success: function (msg) {
				if (msg.status == 1) {
					window.location = "<?php echo base_url(); ?>index.php/portfolio/company_data/" + msg.innvId;
				}
			}
		});
		return false;	
	});


	$('#add_to_portfolio').on('click', function () {
			$("#display_company_err").html('');
			var innvId = $('#current_inv_id').val();
			$(".control a").css("pointer-events", "none");
			$("#portbtn_" + innvId).attr('disabled', true);
			$("#add_to_portfolio").attr('disabled', true);
			$("#Merge").attr('disabled', true);
			$("#portbtn_" + innvId).addClass('opacity5');
			$("#portbtn_" + innvId).css("pointer-events", "none");
		   $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>index.php/portfolio/addInnvPool",
				data: {
					inv_id: innvId
				},
				dataType: 'json',
				success: function (msg) {
					if (msg == 1) {
						window.location = "<?php echo base_url(); ?>index.php/portfolio/company_data/" + innvId;
					}
				}
			});
			
		return false;	

	});
	
	
    function addInnvPool(innvId) {
		$('#current_inv_id').val(innvId);
		$('#actionModal').modal('show');
		
        /* $(".control a").css("pointer-events", "none");
        $("#portbtn_" + innvId).attr('disabled', true);
        $("#portbtn_" + innvId).addClass('opacity5');
        $("#portbtn_" + innvId).css("pointer-events", "none");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/addInnvPool",
            data: {
                inv_id: innvId
            },
            dataType: 'json',
            success: function (msg) {
                if (msg == 1) {
                    window.location = "<?php echo base_url(); ?>index.php/portfolio/company_data/" + innvId;
                }
            }
        }); */
    }
</script>

</body>
</html>