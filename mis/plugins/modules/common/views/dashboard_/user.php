<h1><?php echo $cpagetitle; ?></h1>
<div class="clear"></div>
<div class="boxNotice">
 <h2> Assigned Innovations:</h2>
  <ul>
    <li>No. of entries : <a href="<?=site_url('scouting/innovation_pool/assigned/entry');?>" ><strong><?=$entryInnovations?></strong></a></li>
    <li>No. of Leads : <a href="<?=site_url('scouting/innovation_pool/lead');?>" ><strong><?=$leadInnovations?></strong></a></li>
     <li>Total No. of Assigned Innovation : <a href="<?php echo site_url('scouting/innovation_pool/');?>" ><strong><?=$activeInnovations?></strong></strong>
     </li>
  </ul>
</div>


<style type="text/css">
.boxNotice
{
  background: none repeat scroll 0 0 #fff;
  border: 2px solid #ECECEC;;
  color: #000000;
  padding: 10px;
  width:47%;
  float:left;
  margin-left:2px;
  margin-bottom:10px;
 
	
}
.boxNotice h2
{
	color:#333 !important;
	padding-bottom:5px;
	font-size:14px !important;
}
.boxNotice li
{
	list-style:none;
	margin:5px 0px;
	padding:7px;
	background-color:#FFF;
	border:1px solid #EBEBEB;
}
.hf
{
	width:45%;
}
.fr
{
	float:right;
}
div.code {
  background: none repeat scroll 0 0 #F5F8FA;
  border: 2px solid #D7E8F0;
  color: #000000;
  font-family: "Courier New",Courier,monospace;
  font-size: 12px;
  line-height: 14px;
  padding: 10px;
}
</style>