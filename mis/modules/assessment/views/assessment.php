<script type="text/javascript">
$(document).ready(function(){
	$('#table1').dataTable( {
			"sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
			"bAutoWidth": false,
			'bFilter': false,
			"iDisplayLength": 15,
			"aLengthMenu": [[10,15, 25, 50, -1], [10,15, 25, 50, "All"]],
			"aaSorting": [],
			'bFilter': false,

			"oTableTools": {
				"sSwfPath": "<?php echo base_url() . "DataTables-1.9.4/media/swf/copy_csv_xls_pdf.swf"; ?>",
			},
		} );
		$('.dataTables_info').hide();
});
</script>
<?php
$isGrade = false;
if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) {
    $isGrade = true;
}
?>

<h1><?=$cpagetitle?> - <?=$innovation['name_of_enterprise']?></h1>
<ul class="option-tab">
<?php
if ($isGrade && $innovation['stage'] > '1') {
    $currentStage = $this->Mprogram_stage->getCurrentStage('1');
    $activity = $this->Mactivities->getActivityForGrading($innovation['id'], $currentStage);
    if (count($activity)) {?>
<li><a href="<?=site_url('grading/view/' . $activity['0']['id']);?>" class="button" >View Grading &amp; Feedback</a></li>
<?php }}?>
<?php if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) {?>
<li><a href="<?=site_url('assessment/create_document/' . $innovation['id'])?>" class="button" >Download the Assessment</a></li>

<?php }?>
</ul>
<br />
<br />
<?php $this->load->view('form_wizard');?>

	<!-- Paging style -->
<?php if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) {?>
<ul class="option-tab">
<li><a href="<?=site_url('assessment/next_grading/' . $innovation['id'])?>" class="button purple">Next ></a></li>
</ul>
<?php }?>
