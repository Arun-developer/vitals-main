<script type="text/javascript">
$(document).ready(function() {
    $.metadata.setType("attr", "validate");
    $("#membersuggest").validate();
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("#twoCarDiv").hide();
    $("#threeCarDiv").show();

    $("input[name$='mentor']").click(function() {
        var test = $(this).val();

        if (test === "Villgro") {
            $('#companyvill').val(test);
            $("#twoCarDiv").hide();
            $("#threeCarDiv").show();
        } else {
            $('#companyout').val(test);
            $("#twoCarDiv").show();
            $("#threeCarDiv").hide();
        }

    });
});
</script>
<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();

$form_name = 'membersuggestsubmit';
$nullLink = 'javascript:void(0);';

$sector = isset($_REQUEST["sector"])?$_REQUEST["sector"]:"";
$experience = isset($_REQUEST["experience"])?$_REQUEST["experience"]:"";

?>

<h1>
    <?=$cpagetitle ?>
</h1>
<div>

    <div style=" float:right;"> <a class="button"
            href="<?=site_url('mentor/mentorDetail/'.$innovationid.'/'.$id);?>">Back to Details</a> &nbsp;&nbsp; </div>
    <br>
    &nbsp;&nbsp;<b>Villgro</b>
    <input type="radio" name="mentor" value="Villgro" checked="checked" />
    &nbsp;&nbsp;&nbsp; <b>Outside</b>
    <input type="radio" name="mentor" value="Outside" />
    <div id="twoCarDiv">
        <form name="membersuggest" id="membersuggest" enctype="multipart/form-data"
            action="<?=site_url('boardmember/suggestmember/'.$innovationid);?>" method="post">
            <fieldset>
                <legend>Search Board Members</legend>
                <dt>
                    <label for="source_type">Sector</label>
                </dt>
                <dd>
                    <input type="text" value="<?php echo $sector; ?>" name="sector" id="sector" />
                </dd>
                <dt>
                    <label for="source_type">Experience</label>
                </dt>
                <dd>
                    <input type="text" value="<?php echo $experience; ?>" id="experience" name="experience" />
                </dd>
                </dl>
                <div class="buttons1" align="left">
                    <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
                    ������
                    <button type="submit" class="button white" value="Search" name="txtSubmit">Reset</button>
                </div>
            </fieldset>
        </form>
        <br />
        <br />
        <!--start table-content  -->
        <div id="user-grid" class="gtable sortable">
            <form name="membersuggestsubmit" enctype="multipart/form-data"
                action="<?=site_url('mentor/suggestSubmit/'.$innovationid.'/'.$id);?>" method="post" id="lineitemForm">
                <input type="hidden" name="ordertype" value="<?=$ordertype?>" />
                <input type="hidden" name="orderby" value="<?=$orderby?>" />
                <input type="hidden" name="company" id="companyout" value="" />
                <table id="table1" class="gtable sortable">
                    <thead>
                        <tr>
                            <th><input id="check_all" type="checkbox" /></th>
                            <th>MentorName</th>
                            <th><a href="<?=$nullLink?>" field="sector" class="sortlink">Sector</a></th>
                            <th>Company</th>
                            <th>Experience</th>
                            <th>Email</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody id="lineitemTable">
                        <?php 
		
			 if(count($searchmember))
			{    
					$rowtype = 'odd';
					foreach($searchmember as $row):
					if(!in_array($row['id'],$assign))
					{
					?>
                        <tr class="<?=$rowtype = ($rowtype == 'odd')?'even':'odd';?>">
                            <td><input type="checkbox" name="check[]" value=<?php echo $row['id']; ?> /></td>
                            <td align="left" valign="middle" width="235"><?=$row['first_name']?>
                            </td>
                            <td align="left" valign="middle"><?=$row['sector']?> </td>
                            <td align="left" valign="middle">
                                <input type="hidden" name="company" value=<?php echo $row['company'];  ?> />
                                <?=$row['company'];?>
                            </td>
                            <td align="left" valign="middle"><?=$row['experience']?></td>
                            <td align="left" valign="middle"><?=$row['email']?></td>
                            <td align="left" valign="middle"><a class="fancybox"
                                    href="<?=site_url('boardmember/masterMemberDetail/'.$row['id']);?>">View Profile</a>
                            </td>
                        </tr>
                        <?php 
					}
					  endforeach;
			}
			else
			{ ?>
                        <tr>
                            <td colspan='7' align='center'>No Records found!</td>
                        </tr>
                        <?php
			} ?>
                        <br />
                    </tbody>

                </table>
                <br />
                <div align="right">
                    <td style="float:right;"><input type="submit" name="txtSubmit" value="Assign" class="button" /></td>
                </div>
            </form>
        </div>
    </div>


    <div id="threeCarDiv">
        <form name="membersuggestsubmit" enctype="multipart/form-data"
            action="<?=site_url('mentor/suggestSubmit/'.$innovationid.'/'.$id);?>" method="post" id="lineitemForm">

            <fieldset>
                <legend>Search Board Members</legend>
                <dt>
                    <label for="source_type">Sector</label>
                </dt>
                <dd>
                    <input type="text" value="<?php echo $sector; ?>" name="sector" id="sector" />
                </dd>
                <dt>
                    <label for="source_type">Experience</label>
                </dt>
                <dd>
                    <input type="text" value="<?php echo $experience; ?>" id="experience" name="experience" />
                </dd>
                </dl>
                <div class="buttons1" align="left">
                    <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
                    ������
                    <button type="submit" class="button white" value="Search" name="txtSubmit">Reset</button>
                </div>
            </fieldset>

            <br />
            <br />
            <!--start table-content  -->
            <div id="user-grid" class="gtable sortable">

                <input type="hidden" name="ordertype" value="<?=$ordertype?>" />
                <input type="hidden" name="orderby" value="<?=$orderby?>" />
                <input type="hidden" name="company" id="companyvill" value="" />
                <table id="table1" class="gtable sortable">
                    <thead>
                        <tr>
                            <th><input id="check_all" type="checkbox" /></th>
                            <th>MentorName</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody id="lineitemTable">
                        <?php 
	
		 if(count($emplist))
		{    
				$rowtype = 'odd';
				$company="Villgro";
				foreach($emplist as $row):
				?>
                        <tr class="<?=$rowtype = ($rowtype == 'odd')?'even':'odd';?>">
                            <td><input type="checkbox" name="check[]" value=<?php echo $row['emp_number']; ?> /></td>
                            <td align="left" valign="middle" width="235"><?=$row['emp_firstname']?>
                            </td>
                            <td align="left" valign="middle"><?= $company;?>
                                <input type="hidden" name="company" value=<?php echo $company; ?> />

                            </td>
                            <td align="left" valign="middle"><?=$row['emp_work_email']?></td>
                            <td align="left" valign="middle"><a class="fancybox"
                                    href="<?=site_url('mentor/mastermentorDetail/'.$row['emp_number'].'/'.$company);?>">View
                                    Profile</a> </td>
                        </tr>
                        <?php 
				  endforeach;
		}
		else
		{ ?>
                        <tr>
                            <td colspan='7' align='center'>No Records found!</td>
                        </tr>
                        <?php
		} ?>
                        <br />
                    </tbody>

                </table>
                <br />
                <div align="right">
                    <td style="float:right;"><input type="submit" name="txtSubmit" value="Assign" class="button" /></td>
                </div>
        </form>

    </div>

</div>