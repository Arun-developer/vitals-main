<?php

$pre_ic_status = array('Pending','Approved','Rejected');

?>

<ul class="tabs">

    <?php foreach($criteriaList as $row):?>

    <li class="<?=($criteria == $row['id'])?'selected':'';?>">

        <a href="<?=site_url('screening/form/'.$this->uri->segment('3').'/'.$row['id']);?>"><?=$row['master_name']?></a>

    </li>

    <?php endforeach; ?>

    <li class="<?=($this->uri->segment('2') == 'company')?'selected':'';?>">

        <?php 

	 $boardList = $this->Mcompany->getBoardList($innovation['id']);

	 		if(empty($boardList)) {

	  ?>

        <a href="<?=site_url('screening/getcompany/'.$this->uri->segment('3'));?>">Company</a>

        <?php } else {?>

        <a href="<?=site_url('screening/getCompanyDetails/'.$this->uri->segment('3'));?>">Company</a>

        <?php } ?>

    </li>

</ul>

<br />



<ul class="tabs" style="float:left">

    <li class="<?=($this->uri->segment('2') == 'documents')?'selected':'';?>">

        <a href="<?=site_url('screening/documents/'.$this->uri->segment('3'));?>">Documents</a>

    </li>

    <?php if($this->uri->segment('2') == 'documents' && $this->uri->segment('3') != $innovation['id']){ 

	?>

    <li class="<?=($this->uri->segment('2') == 'final')?'selected':'';?>" id="isChecked">

        <a href="#" class="button"
            style="background:url('<?php echo base_url();?>source/template/images/icons/btnbk.png') repeat-x; color:white; height:12px !important; "
            id="isComplete">Submit</a>

    </li>

    <?php 

	} 

	

	$this->load->model("Mscreening");

	$isIncubateeCompleted= $this->Mscreening->isCompleted($this->uri->segment('3'));

	$isApproved =  $this->Mscreening->checkIsApproved($innovation['id']);

	if(@$isIncubateeCompleted['0']['accept_status'] == '1') 

	{ 

	if(($this->session->userdata('user_type') != "incubatee") && ($this->session->userdata('user_type') != ""))  { 

      	if(!empty($isApproved['innovation'])) { ?>

    <a href="<?=site_url('screening/pre_ic/'.$this->uri->segment('3'));?>" class="button"
        style="background:url('<?php echo base_url();?>source/template/images/icons/btnbk.png') repeat-x; color:white; height:12px;">Approve</a>

    <?php } } if($this->uri->segment('2') == 'documents'){ 

	?>

    <?php 

	} 

	}
	
	if($innovation['ic_status'] == '1')

	{?>

    <li class="<?=($this->uri->segment('2') == 'agreement')?'selected':'';?>">

        <a href="<?=site_url('screening/agreement/'.$this->uri->segment('3'));?>">Agreement</a>

    </li>

    <?php }?>

</ul>

<?php  ?>

<input type="hidden" value="1" name="statusValue" id="statusID" />

<div id="ajaxreturn"></div>

<input type="hidden" value="<?php echo $innovation['name_of_enterprise']; ?>" name="name_enterprenur"
    id="enterprenurID" />

<?php

$isAuth = false;

if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || $innovation['isAssociate'])
{
	$isAuth = true;
}
?>



<script type="text/javascript">
$('#isChecked').click(function() {
    var answer = confirm("Please Confirm the information again,Before you Submit")

    navigator.notification.alert("message", callback, "title", "button title");

    if (answer) {

        var status = $("#statusID").val();

        var userID = $("#enterprenurID").val();

        $.ajax({

            'url': "<?php echo site_url('screening/form/49');?>",

            data: {
                'statusValue': status,
                'isView': true,
                'name_enterprenur': userID
            },

            'type': 'POST',

            'success': function(datas)
            {

                document.getElementById("ajaxreturn").innerHTML = datas;

                var htm = '<input type="text" value="' + datas + '" id="ajaxreturn">';

                $('#ajaxreturn').append(htm);

                $('#ajaxreturn').html(datas);

            }

        });

    }

});
</script>