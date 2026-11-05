<?php

$this->load->model("master/Mchecklist");

$data['checkList'] = $this->Mchecklist->getCheckList();

if (isset($innovation))
{  
	if(!is_array($innovation)) {  

		$id = $innovation;

	} else {	

		$id = $innovation['id'];	

	}

	$status = $innovation['status'];	

	$grading_status = $innovation['grading_status'];	

	$stage = $innovation['stage'];

	$isAssociate =  $innovation['isAssociate'];

	$criteria = NULL;

	$isAuth = false; 

	if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || $isAssociate)
	{
		$isAuth = true;
	}

	$currentTab = $this->uri->segment('1'); 

	

#Get Details By innovation whether Datas are exists	

$this->load->model("screening/Mscreening");

$data = $this->Mscreening->getNdaListByInnovation($id);

$resultChecklist = $this->Mscreening->getCheckListByInnovation($id);

$resultdueDeligence = $this->Mscreening->getDueDelligenceByInnovation($id);

$resultDocsProduce = $this->Mscreening->getDocsProduceByInnovation($id);

$resultAssesment = $this->Mscreening->getAssessmentsDetails($id);

$resultPeopletoMeet = $this->Mscreening->getInnovationPeopleByStatus($id);

$resultGrading = $this->Mscreening->getGradingFeedbackByInnovation($id);

$resultPre_IC = $this->Mscreening->getpre_ic_ByInnovation($id);

$result_Assessment = $this->Mscreening->getAssessmentStatusByInnovation($id);
?>


<div class="boxed menu">

    <h2>Incubation Stages</h2>

    <section>

        <ul>

            <li class="<?=($currentTab == 'scouting')?'selected':'';?>">

                <a href="<?=site_url('scouting/innovation_details/'.$id);?>">Innovation Details</a>

            </li>

            <?php if(($stage>=1) && ($this->session->userdata('user_type') != 'incubatee')){?>

            <li class="<?=($currentTab == 'assessment')?'selected':'';?>"><a
                    href="<?=site_url('assessment/view_list/'.$id);?>">Preliminary Assessment</a></li>

            <?php } ?>

            <?php if($stage>2){?>

            <li class="<?=($currentTab == 'presentation')?'selected':'';?>"><a
                    href="<?=site_url('presentation/view/'.$id);?>">Innovator Presentation</a></li>

            <?php } ?>

            <?php if($stage>=4){?>

            <li class="<?=($currentTab == 'screening')?'selected':'';?>"><a
                    href="<?=site_url('screening/form/'.$id);?>">Detailed Diligence</a>

                <ul>

                    <?php

					if(!empty($resultChecklist)) {

							if(!empty($data['checkList'])) {  ?>

                    <li><a href="<?=site_url('screening/view_checklist/'.$id);?>" class="fancybox">View Document
                            Checklist</a></li>

                    <?php }  if(empty($data['checkList']))   { ?>

                    <li><a href="<?=site_url('screening/assign_checklist/'.$id);?>" class="fancybox">Assign Document
                            Checklist</a></li>

                    <?php } 

						}  if(!empty($resultdueDeligence['0']['invite_code'])) {           ?>

                    <li><a href="<?=site_url('screening/invite_prescreen/'.$id);?>">Invite for Detailed Diligence</a>
                    </li>

                    <?php } if(!empty($data)) { ?>

                    <li><a href="<?=site_url('screening/nda_list/'.$id);?>">NDA Documents</a></li>

                    <?php } 

							if(!empty($resultAssesment)) {

					?>

                    <li><a href="<?=site_url('screening/assessform/'.$id.'/'.$criteria.'m1'.'/'.'11');?>">Detailed
                            Assessment</a></li>

                    <?php } ?>

                    <?php if(!empty($resultPeopletoMeet)) {	?>

                    <li><a href="<?=site_url('screening/view_peoplelist/'.$id.'/');?>">Site visit Schedule</a></li>

					<?php  } ?>
					
                </ul>

            </li>

            <?php } ?>

            <?php if($stage>=5){?>

            <li class="<?=($currentTab == 'incubation')?'selected':'';?>"><a
                    href="<?=site_url('seedfunding/view/'.$id);?>">Incubation</a></li>

            <li class="<?=($currentTab == 'IncubationProgress')?'selected':'';?>"><a
                    href="<?=site_url('incubationprogress/form/'.$id);?>">Incubation Progress</a></li>

            <li class="<?=($currentTab == 'IncubationProgress')?'selected':'';?>"><a
                    href="<?=site_url('reports/progress_report/form/'.$id.'/Financial Performance');?>">Progress
                    Report</a></li>

            <?php } ?>



        </ul>

    </section>
</div>


<?php if($this->session->userdata('user_type') != 'incubatee') { ?>
<div class="boxed menu">

    <h2>Options</h2>

    <section>

        <ul>

            <?php 

	if($isAuth){

		if($status == '1'){

			?>

            <li><a href="<?=site_url('scouting/action/hold/'.$id);?>" class="fancybox">Hold</a></li>

            <?php

		} 

		if($status != '3' && $grading_status == '0'){

			?>

            <li><a href="<?=site_url('scouting/action/close/'.$id);?>" class="fancybox">Close</a></li>

            <?php

		} 

		if($status == '2')

		{

			?>

            <li><a href="<?=site_url('scouting/action/follow/'.$id);?>" class="fancybox">Follow</a></li>

            <?php 

		}

		if($status == '3')

		{

			?>

            <li><a href="<?=site_url('scouting/action/resume/'.$id);?>" class="fancybox">Resume</a></li>

            <?php

		}

		?>

            <li><a href="<?=site_url('scouting/assign_incharge/'.$id);?>" class="fancybox">Assign Incharge</a></li>

            <?php 

	} ?>



            <li><a href="<?=site_url('scouting/action_history/'.$id);?>" class="fancybox">Action History</a></li>

            <li><a href="<?=site_url('common/mail/history/'.$id);?>">Mail</a></li>

            <li><a href="<?=site_url('grading/grading_innovation/'.$id);?>">View Grading Results</a></li>

            <li><a href="<?=site_url('scouting/innovation_pool/similar/'.$id);?>" target="_blank">View Similar
                    Innovation</a></li>

            <li><a href="<?=site_url('common/alldocument/view_list/'.$id);?>" target="_blank">View Documents</a></li>

        </ul>

    </section>

</div>

<?php }  } ?>