<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();
?>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/jquery_ui/css/ui-lightness/jquery-ui-1.8.13.custom.css">
<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/jquery_ui/css/ui-lightness/ui.dropdownchecklist.themeroller.css">
<script type="text/javascript" src="<?=base_url();?>source/jquery_ui/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>source/jquery_ui/js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>source/jquery_ui/js/ui.dropdownchecklist.js"></script>
  <script type="text/javascript">
        $(document).ready(function() {
            $("#users").dropdownchecklist({ emptyText: "Please select ...", width: 150,firstItemChecksAll: true });
            $("#usergroup").dropdownchecklist({ emptyText: "Please select ...", width: 150,firstItemChecksAll: true });
         });
			</script>
<script language="javascript"> 
function move(tbFrom, tbTo) 
{
 var arrFrom = new Array(); var arrTo = new Array(); 
 var arrLU = new Array();
 var i;
 for (i = 0; i < tbTo.options.length; i++) 
 {
  arrLU[tbTo.options[i].text] = tbTo.options[i].value;
  arrTo[i] = tbTo.options[i].text;
 }
 var fLength = 0;
 var tLength = arrTo.length;
 for(i = 0; i < tbFrom.options.length; i++) 
 {
  arrLU[tbFrom.options[i].text] = tbFrom.options[i].value;
  if (tbFrom.options[i].selected && tbFrom.options[i].value != "") 
  {
   arrTo[tLength] = tbFrom.options[i].text;
   tLength++;
  }
  else 
  {
   arrFrom[fLength] = tbFrom.options[i].text;
   fLength++;
  }
}

tbFrom.length = 0;
tbTo.length = 0;
var ii;

for(ii = 0; ii < arrFrom.length; ii++) 
{
  var no = new Option();
  no.value = arrLU[arrFrom[ii]];
  no.text = arrFrom[ii];
  tbFrom[ii] = no;
}

for(ii = 0; ii < arrTo.length; ii++) 
{
 var no = new Option();
 no.value = arrLU[arrTo[ii]];
 no.text = arrTo[ii];
 tbTo[ii] = no;
}
}
</script>
<style>
table td { vertical-align: top }
dd { padding-bottom: 15px }
</style>
</head>
<h1><?=$cpagetitle ?></h1>
<!--start table-content  -->
<div align="right">
    <a href="<?=site_url('mainmaster/useraccess/addmodule')?>" class="button fancybox">Add Module</a>&nbsp;
    <a href="<?=site_url('mainmaster/useraccess/addsubmodule')?>" class="button fancybox">Add Sub Module</a>&nbsp;
    <a href="<?=site_url('mainmaster/useraccess/adduser')?>" class="button fancybox">Add User</a>&nbsp;
</div>
<br/>
 <div id="user-grid" class="gtable sortable">
<form name="combo_box">
<input type="text" id="list2" value=""/>
     <table width="100%" class="items">
	<thead>
	<tr>
	<th><a href="<?=$nullLink?>" field="label">Users</a></th>
        <th><a href="<?=$nullLink?>" field="label">Action</a></th>
        <th><a href="<?=$nullLink?>" field="label">User Groups</a></th>
        <th><a href="<?=$nullLink?>" field="label">View Rights</a></th>
        <th><a href="<?=$nullLink?>" field="label">Users in Groups</a></th>
	</tr>
    </thead>
	<tbody>
            <tr>
                <td>
                    <div>
                       <select multiple="multiple"  name="FromLB" id="users" onchange="selectuser();">
                            <option>(all)</option>
                        <?php 
                        foreach($userlist as $row1)
                        {?>
                           <option value="<?php echo $row1['id'];?>"><?php echo $row1['user_name'];?></option>
                        <?php }?>
                        </select>
                    </div>
                </td>
                <td align="center" valign="middle">
                <input type="button" class="button" onClick="passvalue(this.form.list2);move(this.form.FromLB,this.form.ToLB)" 
                value="Add"/>
                <input type="button" class="button" onClick="move(this.form.ToLB,this.form.FromLB)" 
                value="Remove"/>
                </td>
                <td>
                <div>
               <select multiple="multiple"  id="usergroup">
                    <option>(all)</option>
	<?php
	if(count($users))
	{    
		$r=1;
		foreach($users as $row)
		{
                    ?>
                   <option value="<?php echo $row['userg_id'];?>"><?php echo $row['userg_name'];?>  </option>
                   <?php } ?>
                  </select>
                </div>   
                        </td>
                        <td>
                            <input type="button" class="button" value="viewrights" onclick="changepage();"/>
                        </td>
                        <td>
                            <div>
                                <select multiple="mulitple" size="10" name="ToLB" id="usermember" class="sel_tolb" style="width:150px">
                                </select>
                            </div>
                        </td>
                        </tr>
			<?php 
	}
	else
	{ ?>
		<tr>
		<td colspan='9' align='center'>No Records found!</td>
		</tr>
	<?
	} ?>
	</tbody>
        
	</table>
</form>
	</div>   

<script type="text/javascript">
    
                $(window).load(function(){
                    $('#usergroup').change(function(){userselect($(this))});
                });
 function userselect(obj)
		 {
                         var t = obj.nextAll('select').find('.sel_tolb').attr('class');
			 var groupid=obj.val();
			 var datas = $.ajax({	
				type: "POST",
				url: "<?php echo site_url('mainmaster/useraccess/get');?>",
				data: {'groupid':groupid,'isajax':true},
				dataType:'json',
				success: function(datas) {
                                   var m = populateSelectbox(datas);
                                   obj.parents('tr').find('.sel_tolb').html(m);
				}
			});
		 }
		   function populateSelectbox(optArray)  { 	
		  
			var option = '<option value="">Select</option>';
			$.each(optArray,function(i){ 
				option +='<option value="'+optArray[i].id+'">'+optArray[i].user_name+'</option>';
			});
			return option;
		 }
                 var master = $('#usergroup option:selected');
		 if(master){
			userselect(master);
		 }

    function passvalue(obj)
    {
        var name = obj.value;
        var usergroup = document.getElementById('usergroup').value;
        var datas = $.ajax({
                    type:"POST",
                    url: "<?php echo site_url('mainmaster/useraccess/updateuser');?>",
                    data:{'groupid':usergroup,'userid':name,'isajax':true},
                    dataType:'json',
                    success:function(datas)
                    {
                        return true;
                    }
        });
    }
    function changepage()
    {
        var userid = document.getElementById('usergroup').value;
        window.location="<?php echo site_url('mainmaster/useraccess/viewrights')?>/"+userid;
    }
	function selectuser()
	{
		document.getElementById('list2').value = "";
		var sel = document.getElementById("users");
		var listLength = sel.options.length;
		var sep = "";
		for(var i=0;i<listLength;i++){
		if(sel.options[i].selected)
		{
			document.getElementById("list2").value += sep + sel.options[i].value;
			sep = ",";
		}
		}
	}
 </script>

            
         