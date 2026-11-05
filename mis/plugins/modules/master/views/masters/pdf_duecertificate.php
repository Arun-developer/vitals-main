<html>
<head>
</head>
<style>
body {font-family: Helvetica, Arial, sans-serif; color:#333;}
.pdf-page {height:100%; margin:10px -13px -20px -10px; padding:30px;}
.pdf-page p {width:100%; margin:0 0 20px 0;}

h1 {color: #FFFFFF; background-color: #014c67;}
h2 {color: #c41030;}
h3 {color: #014c67; font-size:14px}
h4 {color: #014c67; background-color: #e5edf0; font-size:14px; font-weight:normal; padding:3px 3px 4px 5px; margin-bottom:3px; padding-bottom:4px;}
h5 {color: #c41030;}

img {width:100%; height:100%;}
table{width:100%}
.highlight {background-color:#e6edf0; color:#014c67; padding:10px;}
.main_certify td
{
 border-right:1px solid #333;
 border-bottom:1px solid #333;
}
.main_certify
{
border-left:1px solid #333;
 border-top:1px solid #333;
}
</style>
<body>

<!--div class="pdf-page" -->
<p align="center"><strong><u>NO DUE CERTIFICATE</u></strong></p>
<p align="center"><strong><u>Accounts In charge</u></strong></p>
<p>This is to state that there are no  dues pending for settlement under the name of <?= $username[0]['user_name']; ?>.</p>
<p>&nbsp;</p>
<table width="100%" cellspacing="2" cellpadding="5">
   <tr>
      <td width="50%" align="left"><strong>Date:&nbsp;<?=date("d/m/Y");?></strong></td>
      <td width="50%" align="right"><strong> Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
   </tr>
   <tr>
      <td align="left"><strong>Place:</strong></td>
      <td>&nbsp;</td>
   </tr>
</table>
<br>
<p align="center"><strong><u>Administration</u></strong></p>
  <p align="left"> This is to state that there are no  dues pending for settlement under the name of&nbsp;  <?= $username[0]['user_name']; ?>.</p>
  <table width="100%" cellspacing="0" cellpadding="5" class="main_certify" >
     <tr>
        <td width="5%"><strong>S.No.</strong></td>
        <td width="13%"><strong>Description</strong></td>
        <td width="28%"><strong>Details<br>
(brand name, user id, password etc)</strong></td>
        <td width="23%"><strong>Whether returned/ obtained</strong></td>
        <td width="31%"><strong>Remarks(including any damage caused to assets, if any)</strong></td>
     </tr>
	

	<?php
	 $t= 0;
	 foreach($description as $key=>$value):
	 ++$t;
	 ?>
	 	<tr>
        <td><?=$t?>&nbsp;</td>
        <td><?=$description[$key]?>&nbsp;</td>
        <td><?=$details[$key]?>&nbsp;</td>
		<td><?=$obtain[$key]?>&nbsp;</td>
		<td><?=$remarks[$key]?>&nbsp;</td>
        </tr>
	 <?php 
	 endforeach;
	 ?>
  </table>
  <br/>
  <br/>
<table width="100%" cellspacing="2" cellpadding="5">
   <tr>
      <td width="51%" align="left"><strong>Date:&nbsp; <?=date("d/m/Y");?></strong></td>
      <td width="49%" align="right"><strong> Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
   </tr>
   <tr>
      <td align="left"><strong>Place:</strong></td>
      <td>&nbsp;</td>
   </tr>
</table>

<!--/div-->


</body>
</html>