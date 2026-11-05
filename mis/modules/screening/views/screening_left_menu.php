<?php 

$isAuth = false;
if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) )
{
	$isAuth = true;
}

$innovation = $this->uri->segment("3");
$this->load->model('screening/Mscreening_documents');
$this->load->model('screening/Mscreening');
$innovationChecklist = $this->Mscreening_documents->getAssignedChecklist($innovation);

$criteria = $this->uri->segment("4");

$fieldsList = $this->Mscreening->getFiledsAnswerList($innovation,$criteria);
$checklist = isset($innovationChecklist['0']);

if(isset($innovation))
{
	$isAuth = true;
	
$this->load->model("screening/Mscreening");
$data = $this->Mscreening->getNdaListByInnovation($innovation);
$resultChecklist = $this->Mscreening->getCheckListByInnovation($innovation);
$resultdueDeligence = $this->Mscreening->getDueDelligenceByInnovation($innovation);
$resultDocsProduce = $this->Mscreening->getDocsProduceByInnovation($innovation);
$resultAssesment = $this->Mscreening->getAssessmentsDetails($innovation);
$resultPeopletoMeet = $this->Mscreening->getInnovationPeopleByStatus($innovation);
$resultGrading = $this->Mscreening->getGradingFeedbackByInnovation($innovation);
$resultPre_IC = $this->Mscreening->getpre_ic_ByInnovation($innovation);
$result_Assessment = $this->Mscreening->getAssessmentStatusByInnovation($innovation);
?>
<div class="boxed menu">
	<h2>Detailed Diligence</h2>
    <section>
        <ul>
			<?php 	
			if(empty($resultChecklist)) {
			
				if($checklist != "") {  ?>
						<li><a href="<?=site_url('screening/view_checklist/'.$innovation);?>" class="fancybox">View Document Checklist</a></li>
				<?php }  
				if($checklist == "")   { ?>
						<li><a href="<?=site_url('screening/assign_checklist/'.$innovation);?>" class="fancybox">Assign Document Checklist</a></li>
				<?php } 			
			}				
					if(empty($resultdueDeligence)) {
					?>
        	<li><a href="<?=site_url('screening/invite_prescreen/'.$innovation);?>">Invite for detailed diligence</a></li>
			
            <?php   }			
			
				if(empty($data)) {
			?>
			<li><a href="<?=site_url('screening/nda_list/'.$innovation);?>">NDA Documents</a></li>
			<?php }
						if(!empty($result_Assessment)) {
					?>
            <li><a href="<?=site_url('screening/pre_ic/'.$innovation);?>">Incubation Committee</a></li>
			<?php 
						}
			
					?>
					
			<?php
     if($isAuth) { ?>
		<?php 
				if((empty($resultAssesment)) AND (empty($resultDocsProduce)))  {	?>
					<li><a href="<?=site_url('screening/assessform/'.$innovation.'/'.'m1'.'/'.'11');?>" >View Detailed Assessment Sheet</a></li>
				<?php  } 
				if(count($resultPeopletoMeet) == '0') {		?>		
					<li><a href="<?=site_url('screening/view_peoplelist/'.$innovation.'/');?>">Site visit Schedule</a></li>
				<?php 	} ?>
				<li><a href="<?php echo site_url('screening/peopleform/'.$innovation);?>">Add Site visit Schedule</a> </li>
		<!--End Assesment -->	
		<li><a href="<?=site_url('seedfunding/activities/view_list/'.$innovation);?>">Incubation Plan</a></li>
	   <li><a href="<?=site_url('grading/next_grading/'.$innovation)?>">Next > Grading &amp; Feedback</a></li>
    <?php 	
    }else{
        $currentStage = $this->Mprogram_stage->getCurrentStage('4');
        $activity = $this->Mactivities->getActivityForGrading($innovation['id'],$currentStage);
        if(count($activity)){ ?>
        <li><a href="<?=site_url('grading/view/'.$activity['0']['id']);?>" >View Grading &amp; Feedback</a></li>
        <?php }}
    ?>
		</ul>
	</section>
</div>
<?php


} ?>
