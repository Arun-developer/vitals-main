<html>
<head>
</head>
<style>
body {font-family: Helvetica, Arial, sans-serif; color:#333; font-size:10px;}
.pdf-page {height:100%; margin:40px -13px -20px -10px; padding:30px;}
.pdf-page p {width:100%; margin:0 0 20px 0;}
.front-page {height:100%; margin:0px 0px 0px 0px;}
h1 {color: #FFFFFF; background-color: #014c67; font-weight:100; font-size:18px; padding:5px;}
h2 {color: #c41030; font-weight:100; font-size:16px;}
h3 {color: #014c67; font-size:12px}
h4 {color: #014c67; background-color: #e5edf0; font-size:12px; font-weight:normal; padding:3px 3px 4px 5px; margin-bottom:3px; padding-bottom:4px;}
h5 {color: #c41030;}

img{width:560px;}

.highlight {background-color:#e6edf0; color:#014c67; padding:10px;}
</style>
<body>
<script type="text/php">
        if ( isset($pdf) ) {
              // Open the object: all drawing commands will
					// go to the object instead of the current page
					//$frontpage = $pdf->open_object();
					//$pdf->image("img/facthometop.jpg", "jpg", 0, 0, 615, 183);
					//$pdf->image("img/facthomebottom.jpg", "jpg", 0, 575, 615, 244);
					//$font = Font_Metrics::get_font("Helvetica");
					//$pdf->page_text(40, 170, <?php echo @$templateValues["cpagetitle"]; ?>, $font,26, array(0,0,0));
					//$pdf->close_object();
					//$pdf->add_object($frontpage,"add");
					//$pdf->new_page();

					$header = $pdf->open_object();
					$pdf->image("img/header.jpg", "jpg", 0, 0, 615, 65);
					$pdf->image("img/footer.jpg", "jpg", 0, 760, 615, 33);
					$font = Font_Metrics::get_font("Helvetica", "bold");
					$pdf->page_text(575, 735, "{PAGE_NUM}", $font,16, array(0,0,0));
					$pdf->close_object();
					$pdf->add_object($header, "all");

        }
        </script>

<div class="front-page">
<script type="text/php">
$frontpage = $pdf->open_object();
$pdf->image("img/inter-0.png", "png", 0, 0, 615, 800);
$pdf->close_object();
$pdf->add_object($frontpage,"add");
</script>
</div>
<?php if($intermedAccountSetupExists == "Yes") { ?>
<div class="front-page">
<script type="text/php">
$frontpage = $pdf->open_object();
$pdf->image("img/inter-1.png", "png", 0, 0, 615, 800);
$pdf->close_object();
$pdf->add_object($frontpage,"add");
</script>
</div>
<div class="pdf-page">
    <h1>Company Set Up</h1>
    <h2>Company/Sole Adviser Details</h2>

<table width="100%">
    <tr bgcolor="#f9f9f9">
      <td width="50%">Title</td>
      <td width="50%"><?php echo @$accountRow["ctitle"]; ?></td>
    </tr>
    <tr>
      <td>Forename(s)</td>
      <td><?php echo @$accountRow["cforename"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Surname</td>
      <td><?php echo @$accountRow["csurname"]; ?></td>
    </tr>
    <tr>
      <td>Position</td>
      <td><?php echo @$accountRow["cposition"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Company Name </td>
      <td><?php echo @$accountRow["ccompany"]; ?></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><?php echo @$accountRow["caddress1"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>&nbsp;</td>
      <td><?php echo @$accountRow["caddress2"]; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo @$accountRow["caddress3"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>City</td>
      <td><?php echo @$accountRow["ccity"]; ?></td>
    </tr>
    <tr>
      <td>Country</td>
      <td><?php echo @$accountRow["ccountry"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Post Code</td>
      <td><?php echo @$accountRow["cpostcode"]; ?></td>
    </tr>
    <tr>
      <td>Telephone Home </td>
      <td><?php echo @$accountRow["ctelehome"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Telephone Business </td>
      <td><?php echo @$accountRow["ctelebusiness"]; ?></td>
    </tr>
    <tr>
      <td>Facsimile</td>
      <td><?php echo @$accountRow["cfacsimile"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Mobile</td>
      <td><?php echo @$accountRow["cmobile"]; ?></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><?php echo @$accountRow["cemail"]; ?></td>
    </tr>
</table>

      <h2>Type of Company</h2>

<table width="100%">
    <tr bgcolor="#f9f9f9">
      <td width="80%">Accountant</td>
      <td width="20%"><?php if(@$accountRow["ccategory"] == "Accountant") echo "Yes"; else echo "No"; ?></td>
    </tr>
    <tr>
      <td>Solicitor</td>
      <td><?php if(@$accountRow["ccategory"] == "Solicitor") echo "Yes"; else echo "No";    ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>FSA Authorised Firm</td>
      <td><?php if(@$accountRow["ccategory"] == "FSA Authorised Firm") echo "Yes"; else echo "No";    ?></td>
    </tr>
    <tr>
      <td>Regulated Authorised Firm (Offshore)</td>
      <td><?php if(@$accountRow["ccategory"] == "Regulated Authorised Firm") echo "Yes"; else echo "No";    ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Regulator for Authorised Firms (Offshore)</td>
      <td><?php echo @$accountRow["cregulator"]; ?></td>
    </tr>
    <tr>
      <td>FSA Reference Number</td>
      <td><?php echo @$accountRow["cfsarefno"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>FSA Reference Number</td>
      <td><?php echo @$accountRow["cfsarefno"]; ?></td>
    </tr>
</table>

</div>
<div class="pdf-page">
      <h2>Order Execution Policy Consent Section</h2>

<p>I/we acknowledge that I/we have been made aware of and accept the nature, policy and processes which SPGO has in place for providing best execution as described in the Order Execution Policy and that, in the absence of any express instructions from me/us, SPGO shall have full discretion to choose a relevant venue from its current list of venues for executing any order or orders (which may include dealing on a principal-to-principal basis with me/us), or to elect to transmit any order to another entity for execution but in doing so shall assess and balance a range of all relevant factors, including those set out in this disclosure statement which, in its reasonable determination, SPGO considers relevant to achieving the best result for me/us.</p>

      <h4>Consent to execute orders outside a Regulated Market or Multilateral Trading Facility</h4>

<table width="100%">
    <tr>
      <td width="80%">I have read and understood SPGO's Order Execution Policy and give consent for SPGO to execute orders outside a Regulated Market or Multilateral Trading Facility.</td>
      <td width="20%"><?php if(@$accountRow["cexecuteorder"] == "Yes") echo "Yes"; else echo "No"; ?>
</td>
    </tr>
</table>
      <h4>Limit Order Agreement</h4>

<table width="100%">
    <tr>
      <td width="80%">You agree that, unless you notify us to the contrary, we shall not immediately make public any Limit order in respect of shares admitted to trading on a Regulated market which is not immediately executed under prevailing market conditions.</td>
      <td width="20%"><?php if(@$accountRow["climitorder"] == "Yes") echo "Yes"; else echo "No"; ?>
      </td>
    </tr>
</table>

<h4>Business Level Account Fee</h4>

<p>These Business Level Account fee details will be applied to all client accounts where you indicate Business Level Account fees should be levied.</p>

<table width="100%">
    <tr>
      <td>Fee rate to apply</td>
      <td><?php echo @$accountRow["caccfeerate"]; ?>%</td>
    </tr>
</table>

    <h4>Charge frequency:</h4>

<table width="100%">
    <tr>
      <td>Half Yearly</td>
      <td><?php if(@$accountRow["caccchargefreq"] == "Half Yearly") echo "Yes"; else echo "No"; ?>
      </td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Quarterly</td>
      <td><?php if(@$accountRow["caccchargefreq"] == "Quarterly") echo "Yes"; else echo "No"; ?>
      </td>
    </tr>

</table>

        <h4>Fee Payment Bank Account:</h4>

<table width="100%">
    <tr>
      <td width="80%">Bank/Building Society Name</td>
      <td width="20%"><?php echo @$accountRow["bname"]; ?>
      </td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Sort Code</td>
      <td><?php echo @$accountRow["bsortcode1"]."-".@$accountRow["bsortcode2"]."-".@$accountRow["bsortcode3"]; ?>
      </td>
    </tr>
    <tr>
      <td>Branch</td>
      <td><?php echo @$accountRow["bbranch"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Account Name</td>
      <td><?php echo @$accountRow["baccountname"]; ?></td>
    </tr>
   <tr bgcolor="#f9f9f9">
      <td>Account Number</td>
      <td><?php echo @$accountRow["baccountno"]; ?></td>
    </tr>
	<tr bgcolor="#f9f9f9">
      <td>Building Society Roll No(only for Building Society Accounts)</td>
      <td><?php echo @$accountRow["bsocietyrollno"]; ?></td>
    </tr>
</table>
</div>
    <?php } ?>
    <?php if($intermedAdviserSetupExists == "Yes") { ?>
<div class="front-page">
<script type="text/php">
$frontpage = $pdf->open_object();
$pdf->image("img/inter-2.png", "png", 0, 0, 615, 800);
$pdf->close_object();
$pdf->add_object($frontpage,"add");
</script>
</div>

<div class="pdf-page">
    <h1>Adviser/Third Party Set Up</h1>
    <h4>Adviser/Third Party Set Up Details</h4>

    <table width="100%">
    <tr>
      <td width="50%">Title</td>
      <td width="50%"><?php echo @$adviserRow["atitle"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Forename(s)</td>
      <td><?php echo @$adviserRow["aforename"] ?></td>
    </tr>
    <tr>
      <td>Surname</td>
      <td><?php echo @$adviserRow["asurname"] ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Position</td>
      <td><?php echo @$adviserRow["aposition"] ?></td>
    </tr>
    <tr>
      <td>Current Permanent Address</td>
      <td><?php echo @$adviserRow["aaddress1"] ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo @$adviserRow["aaddress2"] ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo @$adviserRow["aaddress3"] ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>City</td>
      <td><?php echo @$adviserRow["acity"] ?></td>
    </tr>
    <tr>
      <td>Country</td>
      <td><?php echo @$adviserRow["acountry"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Postcode</td>
      <td><?php echo @$adviserRow["apostcode"] ?></td>
    </tr>
    <tr>
      <td>Telephone Home </td>
      <td><?php echo @$adviserRow["atelehome"] ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Telephone Business </td>
      <td><?php echo @$adviserRow["atelebusiness"] ?></td>
    </tr>
    <tr>
      <td>Facsimile</td>
      <td><?php echo @$adviserRow["afacsimile"] ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Mobile</td>
      <td><?php echo @$adviserRow["amobile"] ?></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><?php echo @$adviserRow["aemail"] ?>
      </td>
    </tr>
</table>
<h4>Investment Knowledge and Experience</h4>
<table width="100%">
        <tr>
          <td width="50%">How many years experience do you have in relation to Structured Products/Investments?</td>
          <td><?php echo @$adviserRow["aexpyears"] ?> years</td>
        </tr>
        <tr bgcolor="#f9f9f9">
          <td colspan="2">What is your level of investment knowledge in relation to Structured Products/Investments?</td>
        </tr>
        <tr>
          <td>Sophisticated</td>
          <td><?php if(@$adviserRow["ainvknowledge"] == "Sophisticated") echo "Yes"; else echo "No"; ?></td>
        </tr>
        <tr>
          <td>Good</td>
          <td><?php if(@$adviserRow["ainvknowledge"] == "Good") echo "Yes"; else echo "No"; ?></td>
        </tr>
        <tr>
          <td>Limited</td>
          <td><?php if(@$adviserRow["ainvknowledge"] == "Limited") echo "Yes"; else echo "No"; ?></td>
        </tr>
        <tr>
          <td>Poor</td>
          <td><?php if(@$adviserRow["ainvknowledge"] == "Poor") echo "Yes"; else echo "No"; ?></td>
        </tr>
      </table>
      <h4>Adviser Level Fee</h4>
    <p>These Adviser Level Account fee details will be used for each clients’ investment wrapper/s where fees are selected to be applied according to the Adviser Level Account fee</p>

<table width="100%">
    <tr>
      <td>Fee rate to apply</td>
      <td><?php echo @$adviserRow["afeerate"]; ?>%</td>
    </tr>
</table>

      <h4>Charge frequency:</h4>

<table width="100%">
    <tr>
      <td width="80%">Half Yearly</td>
      <td width="20%"><?php if(@$adviserRow["achargefreq"] == "Half Yearly") echo "Yes"; else echo "No"; ?>
      </td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Quarterly</td>
      <td><?php if(@$adviserRow["achargefreq"] == "Quarterly") echo "Yes"; else echo "No"; ?>
      </td>
    </tr>

</table>

<h4>Fee Payment Bank Account:</h4>

<table width="100%">
    <tr>
      <td width="80%">Bank/Building Society Name</td>
      <td width="20%"><?php echo @$adviserRow["bname"]; ?>
      </td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Sort Code</td>
      <td><?php echo @$adviserRow["bsortcode1"]."-".@$adviserRow["bsortcode2"]."-".@$adviserRow["bsortcode3"]; ?>
      </td>
    </tr>
    <tr>
      <td>Branch</td>
      <td><?php echo @$adviserRow["bbranch"]; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Account Name</td>
      <td><?php echo @$adviserRow["baccountname"]; ?></td>
    </tr>
   <tr bgcolor="#f9f9f9">
      <td>Account Number</td>
      <td><?php echo @$adviserRow["baccountno"]; ?></td>
    </tr>
	<tr bgcolor="#f9f9f9">
      <td>Building Society Roll No(only for Building Society Accounts)</td>
      <td><?php echo @$adviserRow["bsocietyrollno"]; ?></td>
    </tr>
</table></div>
    <?php } ?>

<?php if($directInvSingleExists == "Yes" || $directInvJointExists == "Yes"){ ?>
<div class="front-page">
<script type="text/php">
$frontpage = $pdf->open_object();
$pdf->image("img/inter-3.png", "png", 0, 0, 615, 800);
$pdf->close_object();
$pdf->add_object($frontpage,"add");
</script>
</div>

<div class="pdf-page">

  <h1>Client Details Form</h1>
  <p>Before we can act for you on a continuing basis, this form must be fully completed, with a hard copy signed and dated and then returned to SPGO.</p>

  <h2>Adviser/Thirdparty Selection Section</h2>

<table width="100%">
    <tr>
      <td width="30%">Adviser/Thirdparty:</td>
      <td width="70%"><strong><?php echo @$directDetail["adviser"]; ?></strong></td>
    </tr>
</table>

    <h4>Investment Wrapper Selection</h4>

<table width="100%">
 <tr>
    <td width="40%">Investment Wrapper type, (Please select one or more)</td>
    <td bgcolor="#f9f9f9" width="60%">

    <?php
if($directInvSingleExists == "Yes") {
    echo "<img src='".base_url()."img/checkedcheckbox.png' style='width:14px;height:14px'>";
}else{
   echo "<img src='".base_url()."img/uncheckedcheckbox.png' style='width:14px;height:14px'>";
}
?>
      Direct Investment Account</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#f9f9f9">

    <?php
if($directInvJointExists == "Yes") {
    echo "<img src='".base_url()."img/checkedcheckbox.png' style='width:14px;height:14px'>";
}else{
   echo "<img src='".base_url()."img/uncheckedcheckbox.png' style='width:14px;height:14px'>";
}
?>
      Joint Direct Investment Account</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#f9f9f9">

    <?php
if($directWHSippExists == "Yes") {
    echo "<img src='".base_url()."img/checkedcheckbox.png' style='width:14px;height:14px'>";
}else{
   echo "<img src='".base_url()."img/uncheckedcheckbox.png' style='width:14px;height:14px'>";
}
?>
      WH Ireland SIPP Investment Wrapper</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#f9f9f9">

    <?php
if($directExtSippExists == "Yes") {
    echo "<img src='".base_url()."img/checkedcheckbox.png' style='width:14px;height:14px'>";
}else{
   echo "<img src='".base_url()."img/uncheckedcheckbox.png' style='width:14px;height:14px'>";
}
?>
      External SIPP Investment Wrapper</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#f9f9f9">

    <?php
if($directISAInvExists == "Yes") {
    echo "<img src='".base_url()."img/checkedcheckbox.png' style='width:14px;height:14px'>";
}else{
   echo "<img src='".base_url()."img/uncheckedcheckbox.png' style='width:14px;height:14px'>";
}
?>
      ISA Investment Wrapper</td>
  </tr>
</table>

<table width="100%">
  <tr>
    <td width="50%"><h4>Client Details Section</h4></td>
    <td width="50%"><h4>Joint Account Details Section </h4></td>
  </tr>
  <tr>
    <td width="50%"><strong>(a) Sole or first named account holder</strong></td>
    <td width="50%"><strong>(b) Second named account holder</strong></td>
  </tr>
</table>

<table width="100%">
  <tr>
    <td width="25%">Title</td>
    <td width="25%"><strong><?php echo $directDetail["title"]; ?></strong></td>
    <td width="25%">Title</td>
    <td width="25%"><strong><?php echo $directDetail["jtitle"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
    <td>Forename(s)</td>
    <td><strong><?php echo $directDetail["forename"]; ?></strong></td>
            <td>Forename(s)</td>
            <td><strong><?php echo $directDetail["jforename"]; ?></strong></td>
  </tr>
  <tr>
    <td>Surname</td>
    <td><strong><?php echo $directDetail["surname"]; ?></strong></td>
            <td>Surname</td>
            <td><strong><?php echo $directDetail["jsurname"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
    <td>Current Permanent Address*</td>
    <td><strong><?php echo $directDetail["cpermanentaddr1"]; ?></strong></td>
            <td>Current Permanent Address*</td>
            <td><strong><?php echo $directDetail["jcpermanentaddr1"]; ?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong><?php echo $directDetail["cpermanentaddr2"]; ?></strong></td>
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["jcpermanentaddr2"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
    <td>&nbsp;</td>
    <td><strong><?php echo $directDetail["cpermanentaddr3"]; ?></strong></td>
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["jcpermanentaddr3"]; ?></strong></td>
  </tr>
  <tr>
    <td>City</td>
    <td><strong><?php echo $directDetail["city"]; ?></strong></td>
            <td>City</td>
            <td><strong><?php echo $directDetail["jcity"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
	<td>Country</td>
	<td><strong><?php echo $directDetail["country"]; ?></strong></td>
            <td>Country</td>
            <td><strong><?php echo $directDetail["jcountry"]; ?></strong></td>
  </tr>
  <tr>
            <td>Post Code</td>
            <td><strong><?php echo $directDetail["postcode"]; ?></strong></td>
            <td>Post Code</td>

            <td><strong><?php echo $directDetail["jpostcode"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Telephone Home</td>
            <td><strong><?php echo $directDetail["telehome"]; ?></strong></td>
            <td>Telephone Home</td>
            <td><strong><?php echo $directDetail["jtelehome"]; ?></strong></td>
  </tr>
  <tr>
            <td>Telephone Business</td>
            <td><strong><?php echo $directDetail["telebusiness"]; ?></strong></td>
            <td>Telephone Business</td>
            <td><strong><?php echo $directDetail["jtelebusiness"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Facsimile</td>
            <td><strong><?php echo $directDetail["facsimile"]; ?></strong></td>
            <td>Facsimile</td>
            <td><strong><?php echo $directDetail["jfacsimile"]; ?></strong></td>
  </tr>
  <tr>
            <td>Mobile</td>
            <td><strong><?php echo $directDetail["mobile"]; ?></strong></td>
            <td>Mobile</td>
            <td><strong><?php echo $directDetail["jmobile"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Email</td>
            <td><strong><?php echo $directDetail["email"]; ?></strong></td>
            <td>Email</td>
            <td><strong><?php echo $directDetail["jemail"]; ?></strong></td>
  </tr>
  <tr>
            <td>Date of Birth</td>
            <td><strong><?php echo $directDetail["dob"]; ?></strong></td>
            <td>Date of Birth</td>
            <td><strong><?php echo $directDetail["jdob"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Occupation, or if retired, former Occupation</td>
            <td><strong><?php echo $directDetail["occupation"]; ?></strong></td>
            <td>Occupation, or if retired, former Occupation</td>
            <td><strong><?php echo $directDetail["joccupation"]; ?></strong></td>
  </tr>

  <tr>
            <td>Nationality</td>
            <td><strong><?php echo $directDetail["nationality"]; ?></strong></td>
            <td>Nationality</td>
            <td><strong><?php echo $directDetail["jnationality"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Marital Status</td>
            <td><strong>
             <?php echo $directDetail["marital"]; ?></strong></td>
            <td>Marital Status</td>
            <td><strong>
			<?php echo $directDetail["jmarital"]; ?></strong></td>
  </tr>
    <tr>
            <td>Gender</td>
            <td><strong><?php echo $directDetail["gender"]; ?></strong></td>
            <td>Gender</td>
            <td><strong><?php echo $directDetail["jgender"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>National Insurance Number (For a foreign national leave box blank)</td>
            <td><strong><?php echo $directDetail["insuranceno"]; ?></strong></td>
            <td>National Insurance Number (For a foreign national leave box blank)</td>
            <td><strong><?php echo $directDetail["jinsuranceno"]; ?></strong></td>
  </tr>
  <tr>
            <td>Country of Residence</td>
            <td><strong><?php echo $directDetail["countryresidence"]; ?></strong></td>
            <td>Country of Residence</td>
            <td><strong><?php echo $directDetail["jcountryresidence"]; ?></strong></td>
  </tr>
</table>

  <p>*Please provide your previous address(es) if you have moved in the last three years:</p>

<table width="100%">
  <tr bgcolor="#f9f9f9">
            <td width="20%">Address 1</td>
            <td width="30%"><strong><?php echo $directDetail["paddress11"]; ?></strong></td>
            <td width="20%">Address 1</td>
            <td width="30%"><strong><?php echo $directDetail["jpaddress11"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["paddress12"]; ?></strong></td>
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["jpaddress12"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["paddress13"]; ?></strong></td>
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["jpaddress13"]; ?></strong></td>
  </tr>
  <tr>
            <td>City</td>
            <td><strong><?php echo $directDetail["pcity1"]; ?></strong></td>
            <td>City</td>
            <td><strong><?php echo $directDetail["jpcity1"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Country</td>
            <td><strong><?php echo $directDetail["pcountry1"]; ?></strong></td>
            <td>Country</td>
            <td><strong><?php echo $directDetail["jpcountry1"]; ?></strong></td>
  </tr>
  <tr>
            <td>Postcode 1</td>
            <td><strong><?php echo $directDetail["ppostcode1"]; ?></strong></td>
            <td>Postcode 1</td>
            <td><strong><?php echo $directDetail["jppostcode1"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Date From</td>
            <td><strong><?php echo $directDetail["pdatefrom1"]; ?></strong></td>
            <td>Date From</td>
            <td><strong><?php echo $directDetail["jpdatefrom1"]; ?></strong></td>
  </tr>
  <tr>
            <td>Date To</td>
            <td><strong><?php echo $directDetail["pdateto1"]; ?></strong></td>
            <td>Date To</td>
            <td><strong><?php echo $directDetail["jpdateto1"]; ?></strong></td>
  </tr>
</table>

<table width="100%">
  <tr bgcolor="#f9f9f9">
            <td width="20%">Address 2</td>
            <td width="30%"><strong><?php echo $directDetail["paddress21"]; ?></strong></td>
            <td width="20%">Address 2</td>
            <td width="30%"><strong><?php echo $directDetail["jpaddress21"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["paddress22"]; ?></strong></td>
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["jpaddress22"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["paddress23"]; ?></strong></td>
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["jpaddress23"]; ?></strong></td>
  </tr>
  <tr>
            <td>City</td>
            <td><strong><?php echo $directDetail["pcity2"]; ?></strong></td>
            <td>City</td>
            <td><strong><?php echo $directDetail["jpcity2"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Country</td>
            <td><strong><?php echo $directDetail["pcountry2"]; ?></strong></td>
            <td>Country</td>
            <td><strong><?php echo $directDetail["jpcountry2"]; ?></strong></td>
  </tr>
  <tr>
            <td>Postcode 2 </td>
            <td><strong><?php echo $directDetail["ppostcode2"]; ?></strong></td>
            <td>Postcode 2 </td>
            <td><strong><?php echo $directDetail["jppostcode2"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Date From</td>
            <td><strong><?php echo $directDetail["pdatefrom2"]; ?></strong></td>
            <td>Date From</td>
            <td><strong><?php echo $directDetail["jpdatefrom2"]; ?></strong></td>
  </tr>
  <tr>
            <td>Date To</td>
            <td><strong><?php echo $directDetail["pdateto2"]; ?></strong></td>
            <td>Date To</td>
            <td><strong><?php echo $directDetail["jpdateto2"]; ?></strong></td>
  </tr>
</table>

<table width="100%">
  <tr bgcolor="#f9f9f9">
            <td width="20%">Address 3 </td>
            <td width="30%"><strong><?php echo $directDetail["paddress31"]; ?></strong></td>
            <td width="20%">Address 3 </td>
            <td width="30%"><strong><?php echo $directDetail["jpaddress31"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["paddress32"]; ?></strong></td>
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["jpaddress32"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["paddress33"]; ?></strong></td>
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["jpaddress33"]; ?></strong></td>
  </tr>
  <tr>
            <td>City</td>
            <td><strong><?php echo $directDetail["pcity3"]; ?></strong></td>
            <td>City</td>
            <td><strong><?php echo $directDetail["jpcity3"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Country</td>
            <td><strong><?php echo $directDetail["pcountry3"]; ?></strong></td>
            <td>Country</td>
            <td><strong><?php echo $directDetail["jpcountry3"]; ?></strong></td>
  </tr>
  <tr>
            <td>Postcode 3 </td>
            <td><strong><?php echo $directDetail["ppostcode3"]; ?></strong></td>
            <td>Postcode 3 </td>
            <td><strong><?php echo $directDetail["jppostcode3"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Date From</td>
            <td><strong><?php echo $directDetail["pdatefrom3"]; ?></strong></td>
            <td>Date From</td>
            <td><strong><?php echo $directDetail["jpdatefrom3"]; ?></strong></td>
  </tr>
  <tr>
            <td>Date To</td>
            <td><strong><?php echo $directDetail["pdateto3"]; ?></strong></td>
            <td>Date To</td>
            <td><strong><?php echo $directDetail["jpdateto3"]; ?></strong></td>
  </tr>
</table>

</div>
<div class="pdf-page">
  <table width="100%">
  <tr>
      <td width="50%" colspan="2"><h4>Confirmation</h4></td>
      <td width="50%" colspan="2"><h4>Confirmation</h4></td>
    </tr>
    </table>

    <table width="100%">
    <tr>
      <td width="40%">I/we confirm that the information for the Sole or first named account holder was obtained by me/us in relation to the customer</td>
      <td width="10%"><?php if(@$directDetail["confirmfirstacc"] == "Yes") echo "Yes"; else echo "No"; ?>
        &nbsp;</td>
      <td width="40%">I/we confirm that the information for the Joint account holder was obtained by me/us in relation to the customer</td>
      <td width="10%"><?php if(@$directDetail["jconfirmsecondacc"] == "Yes") echo "Yes"; else echo "No"; ?>
        &nbsp;</td>
    </tr>
    <tr>
      <td width="50%" colspan="2"><h4>I/we confirm that the evidence I/we have obtained to verify the identity of the customer:</h4></td>
      <td width="50%" colspan="2"><h4>I/we confirm that the evidence I/we have obtained to verify the identity of the customer:</h4></td>
    </tr>
    <tr>
      <td>Meets the guidance for standard evidence set out within the guidance for the UK Financial Sector issued by JMLSG</td>
      <td><?php if(@$directDetail["customeridentity"] == "Meets") echo "Yes"; else echo "No"; ?></td>
      <td>Meets the guidance for standard evidence set out within the guidance for the UK Financial Sector issued by JMLSG</td>
      <td><?php if(@$directDetail["jcustomeridentity"] == "Meets") echo "Yes"; else echo "No"; ?></td>
    </tr>
    <tr>
      <td>Exceeds the standard evidence (written details of the further verification evidence taken are attached to this confirmation).</td>
      <td><?php if(@$directDetail["customeridentity"] == "Exceeds") echo "Yes"; else echo "No"; ?> </td>
      <td>Exceeds the standard evidence (written details of the further verification evidence taken are attached to this confirmation).</td>
      <td><?php if(@$directDetail["jcustomeridentity"] == "Exceeds") echo "Yes"; else echo "No"; ?></td>
    </tr>
</table>

</div>
<div class="pdf-page">

  <h2>Correspondence Section</h2>
  <h4>Correspondence to be sent to:</h4>

<table width="100%">
  <tr>
    <td width="40%">Same as Current Permanent Address</td>
    <td width="60%"><?php
				if($directDetail["correspondence"] == "Yes")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
             ?></td>
  </tr>
  <tr bgcolor="#f9f9f9">
    <td>Different Address</td>
    <td><?php
				if($directDetail["correspondence"] == "No")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
             ?></td>
  </tr>
  <tr>
            <td>Name</td>
            <td><strong><?php echo $directDetail["corname"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td> Address</td>
            <td><strong><?php echo $directDetail["coraddress1"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["coraddress2"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>&nbsp;</td>
            <td><strong><?php echo $directDetail["coraddress3"]; ?></strong></td>
  </tr>
  <tr>
            <td>City</td>
            <td><strong><?php echo $directDetail["corcity"]; ?></strong></td>
  </tr>
  <tr bgcolor="#f9f9f9">
            <td>Country</td>
            <td><strong><?php echo $directDetail["corcountry"]; ?></strong></td>
  </tr>
  <tr>
            <td>Post Code</td>
            <td><strong><?php echo $directDetail["corpostcode"]; ?></strong></td>
  </tr>
</table>

</div>

  <?php } ?>

  <?php if($directInvestExists == "Yes" || $this->session->userdata("newaccount") == ""){ ?>
<div class="front-page">
<script type="text/php">
$frontpage = $pdf->open_object();
$pdf->image("img/inter-4.png", "png", 0, 0, 615, 800);
$pdf->close_object();
$pdf->add_object($frontpage,"add");
</script>
</div>

<div class="pdf-page">

  <h1>Direct Investment Account</h1>
<table width="100%">
  <tr>
    <td width="50%">Bank/Building Society Name</td>
    <td width="50%"><?php if($this->session->userdata("newaccount") == "" && $directInvestExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directInvest["bankname"]."</strong>"; ?></td>
  </tr>
  <tr bgcolor="#f9f9f9">
  	 <td>Sort Code</td>
    <td><?php if($this->session->userdata("newaccount") == "" && $directInvestExists == "No")
					echo "<strong>NA</strong>";
				else { echo "<strong>".$directInvest["bsortcode1"]."</strong>"; ?>-<?php echo "<strong>".$directInvest["bsortcode2"]."</strong>"; ?>-<?php echo "<strong>".$directInvest["bsortcode3"]."</strong>"; } ?></td>
  </tr>
    <tr>
  	 <td>Branch</td>
    <td><?php if($this->session->userdata("newaccount") == "" && $directInvestExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directInvest["bbranch"]."</strong>"; ?></td>
  </tr>
    <tr bgcolor="#f9f9f9">
  	 <td>Account Name</td>
    <td><?php if($this->session->userdata("newaccount") == "" && $directInvestExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directInvest["baccountname"]."</strong>"; ?></td>
  </tr>
    <tr>
  	 <td>Account Number</td>
    <td><?php if($this->session->userdata("newaccount") == "" && $directInvestExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directInvest["baccountno"]."</strong>"; ?></td>
  </tr>
    <tr bgcolor="#f9f9f9">
  	 <td>Building Society Roll No(only for Building Society Accounts):</td>
    <td><?php if($this->session->userdata("newaccount") == "" && $directInvestExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directInvest["brollno"]."</strong>"; ?></td>
  </tr>
</table>

</div>
  <?php } ?>

  <?php if($directWHSippExists == "Yes" || $this->session->userdata("newaccount") == ""){ ?>
<div class="front-page">
<script type="text/php">
$frontpage = $pdf->open_object();
$pdf->image("img/inter-5.png", "png", 0, 0, 615, 800);
$pdf->close_object();
$pdf->add_object($frontpage,"add");
</script>
</div>

<div class="pdf-page">

  <h1>WH Ireland SIPP Investment Wrapper</h1>
  <h2>Pension Beneficiary Details Section</h2>

<table width="100%">
    <tr>
  	 <td width="50%">Pension Beneficiary</td>
    <td width="50%"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["beneficiary"]."</strong>"; ?></td>
  </tr>
    <tr bgcolor="#f9f9f9">
  	 <td>Nominated Retirement Age (From 6 April 2010 the minimum pension age at which you may start to draw benefits from your SIPP is 55. (50 until 5 April 2010).)</td>
    <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["retirementage"]."</strong>"; ?></td>
  </tr>
    <tr>
  	 <td>Tax Office Dealing with your Self-Assessment Returns</td>
    <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["returns"]."</strong>"; ?></td>
  </tr>
    <tr bgcolor="#f9f9f9">
  	 <td>Unique Tax Reference (UTR)</td>
    <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["utr"]."</strong>"; ?></td>
  </tr>
    <tr>
  	 <td colspan="2"><h4>Status:</h4></td>
  </tr>
    <tr>
  	 <td colspan="2"><h4>Employed:</h4></td>
  </tr>
    <tr>
  	 <td>chargeable to tax under Schedule E for the income tax year of assessment concerned with office or employment held</td>
    <td><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["status"] == "chargeable to tax under Schedule E for the income tax year of assessment concerned with office or employment held")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
			?></td>
  </tr>
    <tr>
  	 <td>chargeable to tax under Schedule E for the income tax year of assessment concerned in respect of pension</td>
    <td><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["status"] == "chargeable to tax under Schedule E for the income tax year of assessment concerned in respect of pension")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
			?></td>
  </tr>
  <tr>
  	 <td colspan="2"><h4>Self Employed:</h4></td>
</tr>
<tr><td>&nbsp;</td>
    <td><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["status"] == "Self Employed")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
			?></td>
	</tr>
	<tr>
  	 <td colspan="2"><h4>Other (Please indicate which is most applicable):</h4></td>
  </tr>
</table>

<table width="100%">
    <tr bgcolor="#f9f9f9">
  	 <td width="50%">caring for one or more children</td>
    <td width="50%"><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["status"] == "caring for one or more children")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
			?></td>
  </tr>
    <tr>
  	 <td>caring for a person aged 16 or over</td>
    <td><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["status"] == "caring for a person aged 16 or over")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
			?></td>
  </tr>
    <tr bgcolor="#f9f9f9">
  	 <td>in full-time education</td>
    <td><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["status"] == "in full-time education")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
			?></td>
  </tr>
    <tr>
  	 <td>unemployed</td>
    <td><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["status"] == "unemployed")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
			?></td>
  </tr>
    <tr bgcolor="#f9f9f9">
  	 <td>applying for a SIPP on behalf of a child aged under 16</td>
    <td><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["status"] == "applying for a SIPP on behalf of a child aged under 16")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
			?></td>
  </tr>
    <tr>
  	 <td>Other</td>
    <td><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["status"] == "Other"){
					echo "<strong>Yes</strong>";
					echo "<br><strong>".$directWHSipp["statusother"]."</strong>";
				}
				else
					echo "<strong>No</strong>";
			?></td>
  </tr>
  </table>

  </div>
<div class="pdf-page">

    <h4>If Employed state your employer's name and address</h4>

 <table width="100%">
    <tr>
      <td width="40%">Employer Name</td>
      <td width="60%"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["employer"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Address</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["empaddress1"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>&nbsp;</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["empaddress2"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>&nbsp;</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["empaddress3"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>City</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["empcity"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Country</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["empcountry"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Postcode</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["emppostcode"]."</strong>"; ?></td>
    </tr>
</table>

      <h4>Spouse/Civil Partner's</h4>

<table width="100%">
    <tr>
      <td width="40%">Title</td>
      <td width="60%"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["stitle"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Forename(s)</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["sforename"]."</strong>"; ?></td>
    </tr>
    <tr>
  	 <td>Surname</td>
    <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["ssurname"]."</strong>"; ?></td>
  </tr>
    <tr bgcolor="#f9f9f9">
  	 <td>Date of Birth</td>
    <td><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["sdob"]."</strong>"; ?></td>
  </tr>
</table>

</div>
<div class="pdf-page">

    <h2>Your SIPP Details Section</h2>

    <h4>Non-Protected Rights Funds</h4>

<p>On your death, your remaining Individual Funds ("your funds") will be applied in accordance with the rules of the Scheme to provide lump sum and/or pension death benefits. Within the overall limits of the tax legislation, the rules give the Scheme Trustee (EBS Managment Plc) wide discretion over the exact form of benefits, and the recipients.</p>
<p>If you want the Scheme Trustee to consider paying benefits to one or more persons in particular, please give details of the persons in the table below and (where you specify more than one person) indicate what percentage of your funds you want to benefit them.</p>

      <br/>
      <br/>
<table width="100%">
    <tr>
      <td width="40%">Number of people you would like to pay benefits to</td>
      <td width="60%"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["npnumber"]."</strong>"; ?></td>
    </tr>
	<?php
		if(isset($directWHSippNPExists) && $directWHSippNPExists == "Yes") {
			foreach($directWHSippNP as $nprow){
	?>
    <tr bgcolor="#f9f9f9">
      <td>Title</td>
      <td><?php echo "<strong>".$nprow["btitle"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Forename(s)</td>
      <td><?php echo "<strong>".$nprow["bforename"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Surname</td>
      <td><?php echo "<strong>".$nprow["bsurname"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Current Permanent Address</td>
      <td><?php echo "<strong>".$nprow["baddress1"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>&nbsp;</td>
      <td><?php echo "<strong>".$nprow["baddress2"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo "<strong>".$nprow["baddress3"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>City</td>
      <td><?php echo "<strong>".$nprow["bcity"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Country</td>
      <td><?php echo "<strong>".$nprow["bcountry"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Post Code</td>
      <td><?php echo "<strong>".$nprow["bpostcode"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Any Relationship to you</td>
      <td><?php echo "<strong>".$nprow["brelationship"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>% of Fund</td>
      <td><?php echo "<strong>".$nprow["bfundperc"]."</strong>"; ?></td>
    </tr>
	<?php }} ?>
	</table>

    </div>
    <div class="pdf-page">

    <h4>Protected Rights Funds</h4>
    <p>If any part of your funds represents &quot;protected rights&quot;, please give details of the persons in the table below and (where you specify more than one person) indicate what percentage of your funds you want to benefit them.</p>

<table width="100%">
    <tr bgcolor="#f9f9f9">
      <td width="50%">Number of people you would like to pay benefits to</td>
      <td width="50%"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["pnumber"]."</strong>"; ?></td>
    </tr>
	<?php
		if(isset($directWHSippPExists) && $directWHSippPExists == "Yes") {
			foreach($directWHSippP as $prow){
	?>
    <tr>
      <td>Title</td>
      <td><?php echo "<strong>".$prow["btitle"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Forename(s)</td>
      <td><?php echo "<strong>".$prow["bforename"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Surname</td>
      <td><?php echo "<strong>".$prow["bsurname"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Current Permanent Address</td>
      <td><?php echo "<strong>".$prow["baddress1"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo "<strong>".$prow["baddress2"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>&nbsp;</td>
      <td><?php echo "<strong>".$prow["baddress3"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>City</td>
      <td><?php echo "<strong>".$prow["bcity"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Country</td>
      <td><?php echo "<strong>".$prow["bcountry"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Post Code</td>
      <td><?php echo "<strong>".$prow["bpostcode"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Any Relationship to you</td>
      <td><?php echo "<strong>".$prow["brelationship"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>% of Fund</td>
      <td><?php echo "<strong>".$prow["bfundperc"]."</strong>"; ?></td>
    </tr>
	<?php }} ?>
    </table>

	<!--
    <tr>
      <td colspan="4"><strong>Eligibility and Contributions Section</strong></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Eligibility</strong></td>
    </tr>
    <tr>
      <td colspan="2">Are you a relevant UK individual? (See Explanatory Note D,E,F)</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["eukindividual"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">With regard to any benefits you may have accrued in registered pension schemes before 6 April 2006, have you registered for enhanced protection of such benefits? (See Explanatory Note G)</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["eregpension"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2"><strong>Personal Contributions (See Explanatory Note H)</strong></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">If you are enclosing a cheque for an initial single contribution (state amount)</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>&pound; ".$directWHSipp["pcsamt"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="4"><em>If you wish to pay by cheque, these should be made payable to: APHA SIPP - &quot;Your Name&quot;.<br>
  The amount you should pay is the gross amount less basic rate tax. For example, if you wished to contribute &pound;10,000, you would actually pay &pound;8,000<br>
You must advise us in writing if you contribute in aggregate in any tax year more than 100% of your relevant UK earnings for that tax year (see Explanatory Note C)</em></td>
    </tr>
    <tr>
      <td colspan="2">Do you wish to pay regular contributions</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["pcwishrc"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2"><strong>Personal Contribution Standing Order Details</strong></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Bank Name</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["pcbankname"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Sort Code</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else { echo "<strong>".$directWHSipp["pcsortcode1"]."</strong>"; ?>-<?php echo "<strong>".$directWHSipp["pcsortcode2"]."</strong>"; ?>-<?php echo "<strong>".$directWHSipp["pcsortcode3"]."</strong>"; } ?></td>
    </tr>
    <tr>
      <td colspan="2">Address</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["pcaddress1"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["pcaddress2"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["pcaddress3"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Post Code</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["pcpostcode"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Name of Account</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["pcaccount"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Account Number</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["pcaccountno"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Amount to be debited from Account (GROSS)</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>&pound; ".$directWHSipp["pcgrossamt"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Commencing date</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["pccommdate"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Monthly</td>
      <td colspan="2"><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["pcpaid"] == "Monthly")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
				?></td>
    </tr>
    <tr>
      <td colspan="2">Yearly</td>
      <td colspan="2"><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["pcpaid"] == "Yearly")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
				?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Employer contributions (See Explanatory Note H)</strong></td>
    </tr>
    <tr>
      <td colspan="2">Will your employer be contribution to your SIPP?</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["ecsipp"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">If yes, please confirm amount</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["ecsippamt"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Employer Contribution Standing Order Details</strong></td>
    </tr>
    <tr>
      <td colspan="2">Bank Name</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["ecbankname"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Sort Code</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else { echo "<strong>".$directWHSipp["ecsortcode1"]."</strong>"; ?>-<?php echo "<strong>".$directWHSipp["ecsortcode2"]."</strong>"; ?>-<?php echo "<strong>".$directWHSipp["ecsortcode3"]."</strong>"; } ?></td>
    </tr>
    <tr>
      <td colspan="2">Address</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["ecaddress1"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["ecaddress2"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["ecaddress3"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Post Code</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["ecpostcode"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Name of Account</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["ecaccount"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Account Number</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["ecaccountno"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Amount to be debited from Account (GROSS)</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>&pound; ".$directWHSipp["ecgrossamt"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Commencing date</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["eccommdate"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Monthly</td>
      <td colspan="2"><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["ecpaid"] == "Monthly")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
				?></td>
    </tr>
    <tr>
      <td colspan="2">Yearly</td>
      <td colspan="2"><?php
				if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else if($directWHSipp["ecpaid"] == "Yearly")
					echo "<strong>Yes</strong>";
				else
					echo "<strong>No</strong>";
				?></td>
    </tr>
    <tr>
      <td colspan="4"><strong>NOTES</strong></td>
    </tr>
    <tr>
      <td colspan="4">Employer contributions are paid gross</td>
    </tr>
    <tr>
      <td colspan="4"><em>To satisfy the requirements of The Pensions Regulator, the employer must complete and return to EBS a &lsquo;record of payments due&rsquo;.<br>
      EBS is obliged to report any missed or late payments to The Pensions Regulator.</em></td>
    </tr>
    <tr>
      <td colspan="4"><strong>Third Party Advice Section</strong></td>
    </tr>
    <tr>
      <td colspan="2">I have received Pension Advice from a Third Party</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["receivedpension"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2"><strong>Financial Adviser Details</strong></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Company Name</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["facompany"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Title</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["fatitle"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Forename(s)</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["faforename"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Surname</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["fasurname"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Address</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["faaddress1"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["faaddress2"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["faaddress3"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">City</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["facity"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Country</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["facountry"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Post Code</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["fapostcode"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Telephone Home </td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["fatelehome"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Telephone Business </td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["fatelebusiness"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Facsimile</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["fafacsimile"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Mobile</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["famobile"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">Email</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["faemail"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td colspan="2">I agree for an initial commission of</td>
      <td colspan="2"><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["facommperc"]."</strong>"; ?>% to be paid to the above party from the Funds being transferred in/invested.</td>
    </tr>
    <tr>
      <td colspan="2">I agree for SPGO Limited to pay an Annual Commission of</td>
      <td colspan="2"><label><?php if($this->session->userdata("newaccount") == "" && $directWHSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directWHSipp["faannualcommperc"]."</strong>"; ?>% of funds under management to be paid to the above Third Party half yearly in arrears which will be deducted from my fund.</label></td>
    </tr>
    <tr>
      <td colspan="4"><em>Fees for pension advice received may be settled from your SIPP upon presentation of an invoice from your Third Party and your signed consent to do so.</em></td>
    </tr>-->

    </div>
<div class="pdf-page">

      <h2>Transfer Payments and Investments Section</h2>

      <h4>Transfer Payments</h4>

      <p>If you wish to transfer in benefits from other registered pension schemes to your SIPP you should complete and return the Transfer Payments form in relation to each transfer.<br>
  You should consult your professional pension adviser, we can recommend one to you if you don&rsquo;t have one, on the suitability and execution of any such pension transfers.</p>

      <p>NB: Both EBS and the transferring scheme will have their own requirements relating to such transfers, which will be largely dependent on what type of scheme it is, whether you are in receipt of benefits under the transferring scheme and whether it is a cash transfer or a transfer of assets in specie.</p>

      <h4>Investments</h4>

      <p>Cash contributions and cash transfer payments will immediately be invested in an interest bearing account with the Bank of Scotland.</p>

      <h2>Cancellation Rights Section</h2>

      <h4>Set Up</h4>

      <p>When you set up your SIPP, EBS will send you a cancellation notice. You will have 30 days from the date you receive the notice to cancel your SIPP if you change your mind. Within this period EBS will retain any sums received in the SIPP bank account until the cancellation period has expired before proceeding with your benefit and investment instructions.<br>
      If you wish to waive your right to the 30 day cancellation period in relation to setting up the SIPP or in relation to contributions paid and<br>
      proceed with benefits/ investments immediately, you can complete the Waiver provided in this section the hard copy of the application form avaialble upon completion of this application process.</em>
      </p>

      <h4>Transfers In</h4>

      <p>If money resulting from a pension transfer is paid to your SIPP at any time, EBS will also issue a cancellation notice and you will have 30 days to cancel the pension transfer. It is not possible to waive cancellation rights in relation to any transfer. Therefore, if EBS receive the transfer payment during the cancellation period it will be held on cash deposit in your SIPP bank account until the cancellation period has expired, unless you confirm that you want the monies to be invested, on receipt, by completing the Investment Instruction below.</p>

</div>
<div class="pdf-page">
<h2>Investment Instruction Section</h2>
    <table width="100%"><tr><td width="80%">
        I hereby instruct you to pass the transfer payment on receipt, whenever that may be, to my SIPP investment manager, WH Ireland Ltd for immediate investment.<br>
        I understand that if I subsequently cancel the transfer during the cancellation period, you will attempt to repay the transferring scheme.<br>
        I accept that:<br>
        (a) the transferring scheme may refuse to accept the repayment, or only accept it on different terms to those applying prior to the transfer, in which case I will give you my instructions on whether to pay the amount to another registered pension scheme; and<br/>
        (b) transfer monies invested will be subject to investment fluctuations if assets have been purchased during the cancellation period.<br>
        As a result, the value of the repayment may be higher or lower than the amount originally invested.<br>
      This investment instruction should apply to all transfers in to my SIPP unless I otherwise inform you.
	 </td>
	 <td width="20%"><strong><?php if(@$directWHSipp["invinstruction"] == "Yes") echo "Yes"; else echo "No"; ?></strong></td>
	 </tr></table>
 </div>
 <?php } ?>

 <?php if($directExtSippExists == "Yes" || $this->session->userdata("newaccount") == ""){ ?>




<div class="front-page">
<script type="text/php">
$frontpage = $pdf->open_object();
$pdf->image("img/inter-6.png", "png", 0, 0, 615, 800);
$pdf->close_object();
$pdf->add_object($frontpage,"add");
</script>
</div>

<div class="pdf-page">

    <h1>External SIPP Investment Wrapper</h1>
    <h2>External SIPP Provider Selection</h2>

<table width="100%">
    <tr>
      <td width="50%">SIPP Provider</td>
      <td width="50%"><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directExtSipp["sippprovider"]."</strong>"; ?></td>
    </tr>
</table>

      <h2>Pension Beneficiary Selection</h2>

<table width="100%">
    <tr>
      <td width="50%">Pension Beneficiary</td>
      <td width="50%"><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directExtSipp["beneficiary"]."</strong>"; ?></td>
    </tr>
</table>

      <h2>External SIPP Investment Wrapper Details</h2>

<table width="100%">
    <tr>
      <td width="50%">Full name of Trustee/Scheme Administrator</td>
      <td width="50%"><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
					echo "<strong>NA</strong>";
				else echo "<strong>".$directExtSipp["trusteefullname"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>SIPP Number</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else echo "<strong>".$directExtSipp["sippno"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Address</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else echo "<strong>".$directExtSipp["taddress1"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>&nbsp;</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["taddress2"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>&nbsp;</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["taddress3"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>City</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["tcity"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Country</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["tcountry"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Post Code</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["tpostcode"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Contact Telephone Number</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["tcontacttelephone"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Fax Number</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["tfax"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Email Address</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["temail"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>HMRC SF Reference Number (please complete if you require a Bank Of Scotland Deposit Account)</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["tsfnumber"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Date of Establishment of the SIPP (please complete if you require a Bank Of Scotland Deposit Account)</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["establishdate"]."</strong>"; ?></td>
    </tr>
</table>
<h2>External SIPP Bank Account Details</h2>
<table width="100%">
    <tr bgcolor="#f9f9f9">
      <td width="50%">Bank Name</td>
      <td width="50%"><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["bankname"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Sort Code</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["bsortcode1"]."-".$directExtSipp["bsortcode2"]."-".$directExtSipp["bsortcode3"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Branch</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["bbranch"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Account Name</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["baccount"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Account Number</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directExtSippExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directExtSipp["baccountno"]."</strong>"; ?></td>
    </tr>
</table>
</div>
<div class="pdf-page">
<h2>Trustee or Authority Signatures</h2>
<p>The exercise of any options under the Terms and Conditions of the Plan must be authorised by the requisite number of
authorised signatories set out in the Scheme’s governing document or, where a number is not stipulated, by at least one
authorised signature. Please provide the names and sample signatures of all those who will be Authorised Signatories. If you
require more than four, please continue on a separate sheet of paper. Where there is any change to the Authorised Signatories,
please notify SPGO in writing giving the date of change to SPGO Structured Product Team, WH Ireland Limited, 11 St James,
Square, Manchester, M2 6WH. WH Ireland Limited will be entitled to rely on the previous list until they are informed to the
contrary.</p>
<table width="100%">

  <tr height="35">
    <td width="20%"> Signed</td>
    <td width="30%" bgcolor="#f9f9f9"></td>
    <td width="20%">Signed</td>
    <td width="30%" bgcolor="#f9f9f9"></td>
  </tr>
  <tr height="35">
    <td> Full Name</td>
    <td bgcolor="#f9f9f9"></td>
    <td >Full Name </td>
    <td bgcolor="#f9f9f9"></td>
  </tr>
  <tr height="35">
    <td>Capacity</td>
    <td bgcolor="#f9f9f9"></td>
    <td>Capacity</td>
    <td bgcolor="#f9f9f9"></td>
  </tr>
  <tr height="35">
    <td> Date</td>
    <td bgcolor="#f9f9f9"></td>
    <td>Date</td>
    <td bgcolor="#f9f9f9"></td>
  </tr>
</table>
<table width="100%">

  <tr height="35">
    <td width="20%"> Signed</td>
    <td width="30%" bgcolor="#f9f9f9"></td>
    <td width="20%">Signed</td>
    <td width="30%" bgcolor="#f9f9f9"></td>
  </tr>
  <tr height="35">
    <td> Full Name</td>
    <td bgcolor="#f9f9f9"></td>
    <td >Full Name </td>
    <td bgcolor="#f9f9f9"></td>
  </tr>
  <tr height="35">
    <td>Capacity</td>
    <td bgcolor="#f9f9f9"></td>
    <td>Capacity</td>
    <td bgcolor="#f9f9f9"></td>
  </tr>
  <tr height="35">
    <td> Date</td>
    <td bgcolor="#f9f9f9"></td>
    <td>Date</td>
    <td bgcolor="#f9f9f9"></td>
  </tr>
</table>
</div>

 <?php } ?>

  <?php if($directISAInvExists == "Yes" || $this->session->userdata("newaccount") == ""){ ?>



<div class="front-page">
<script type="text/php">
$frontpage = $pdf->open_object();
$pdf->image("img/inter-7.png", "png", 0, 0, 615, 800);
$pdf->close_object();
$pdf->add_object($frontpage,"add");
</script>
</div>

<div class="pdf-page">


<h1>ISA Investment Wrapper</h1>

    <h2>ISA Investment Wrapper Holder Selection</h2>

<table width="100%">
    <tr>
      <td width="50%">ISA Investment Wrapper Holder</td>
      <td width="50%"><?php if($this->session->userdata("newaccount") == "" && $directISAInvExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directISAInv["isaaccholder"]."</strong>"; ?></td>
    </tr>
</table>

      <h2>Client Bank or Building Society Details</h2>
 <table width="100%">
    <tr>
      <td width="50%">Bank/Building Society Name</td>
      <td width="50%"><?php if($this->session->userdata("newaccount") == "" && $directISAInvExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directISAInv["bankname"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Sort Code</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directISAInvExists == "No")
								echo "<strong>NA</strong>";
							else{
								echo "<strong>".$directISAInv["bsortcode1"]."</strong>"; ?>-<?php echo "<strong>".$directISAInv["bsortcode2"]."</strong>"; ?>-<?php echo "<strong>".$directISAInv["bsortcode3"]."</strong>"; } ?></td>
    </tr>
    <tr>
      <td>Branch</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directISAInvExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directISAInv["bbranch"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Account Name</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directISAInvExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directISAInv["baccount"]."</strong>"; ?></td>
    </tr>
    <tr>
      <td>Account Number</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directISAInvExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directISAInv["baccountno"]."</strong>"; ?></td>
    </tr>
    <tr bgcolor="#f9f9f9">
      <td>Building Society Roll No(only for Building Society Accounts):</td>
      <td><?php if($this->session->userdata("newaccount") == "" && $directISAInvExists == "No")
								echo "<strong>NA</strong>";
							else
								echo "<strong>".$directISAInv["bsocietyrollno"]."</strong>"; ?></td>
    </tr>
    </table>


</div>
	<?php } ?>
	    <?php if($intermedAdvFeeCommSetupExists == "Yes"){ ?>




<div class="front-page">
<script type="text/php">
$frontpage = $pdf->open_object();
$pdf->image("img/inter-8.png", "png", 0, 0, 615, 800);
$pdf->close_object();
$pdf->add_object($frontpage,"add");
</script>
</div>

<div class="pdf-page">

            <h1>Fee Requirements</h1>

            <h4>Select Fee To Assign To Client</h4>

<table width="100%">
            <tr>
              <td width="50%">Assign the Business Level Account fee to all of this client's Investment Wrappers</td>
              <td width="50%"><?php
                    if(@$advFee["feegroup"] == "Account Level Fee")
                        echo "Yes";
					else
						echo "No";
                ?></td>
            </tr>
            <tr bgcolor="#f9f9f9">
              <td>Assign Adviser/Thirdparty Level Account fee to all of this client's Investment Wrappers</td>
              <td><?php
                    if(@$advFee["feegroup"] == "Adviser Level Fee")
                        echo "Yes";
					else
						echo "No";
                ?></td>
            </tr>
            <tr>
              <td>Assign a fee specifically for this client to be applicable for all this clients Investment Wrappers</td>
              <td><?php
                    if(@$advFee["feegroup"] == "Client Fee")
                        echo "Yes";
					else
						echo "No";
                ?></td>
            </tr>
            <tr bgcolor="#f9f9f9">
              <td>Assign a specific fee for each of this clients Investment Wrappers separately</td>
              <td><?php
                    if(@$advFee["feegroup"] == "Portfolio Fee")
                        echo "Yes";
					else
						echo "No";
                ?></td>
            </tr>
            <tr>
              <td>Commission defined on a trade by trade basis (no fee required)</td>
              <td><?php
                    if(@$advFee["feegroup"] == "No Fee")
                        echo "Yes";
					else
						echo "No";
                ?></td>
            </tr>
            </table>
            <?php if(@$advFee["feegroup"] == "Client Fee"){ ?>

                      <h4>Client Fee</h4>

            <table width="100%">
                    <tr>
                      <td width="50%">Fee rate to apply</td>
                      <td width="50%"><?php echo @$clientAdvFee["feerate"]; ?>%</td>
                    </tr>
             </table>

                      <h4>Charge Frequency: </h4>
             <table width="100%">
                    <tr>
                      <td width="50%">Half Yearly</td>
                      <td width="50%"><?php
                            if(@$clientAdvFee["chargefreq"] == "Half Yearly")
                                echo "Yes";
							else
								echo "No";
                        ?>
                      </td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                      <td width="50%">Quarterly</td>
                      <td width="50%"><?php
                            if(@$clientAdvFee["chargefreq"] == "Quarterly")
                                echo "Yes";
							else
								echo "No";
                        ?>
                      </td>
                    </tr>
                    </table>
            <?php } ?>
			<!-- Client Ends -- >
			<!-- Portfolio Starts-->
			<?php if(@$advFee["feegroup"] == "Portfolio Fee"){ ?>
				<h2>Investment Wrapper Fee</h2>

				<!-- Portfolio Investment Starts-->
				<?php if($directInvSingleExists == "Yes" || $directInvJointExists == "Yes"){ ?>
						<h4>Direct Investment Account</h4>

                        <table width="100%">
						<tr>
						  <td width="50%">Fee rate to apply</td>
						  <td width="50%"><?php echo @$investAdvFee["feerate"]; ?>%</td>
						</tr>
						<tr bgcolor="#f9f9f9">
						  <td>Half Yearly</td>
						  <td><?php
											if(@$investAdvFee["chargefreq"] == "Half Yearly")
												echo "Yes";
											else
												echo "No";
										  ?>
							</td>
						</tr>
						<tr>
						  <td>Quarterly</td>
						  <td><?php
											if(@$investAdvFee["chargefreq"] == "Quarterly")
												echo "Yes";
											else
												echo "No";
										  ?>
						  </td>
						</tr>
                        </table>
				<?php } ?>
				<!-- Portfolio Investment Ends-->

				<!-- Portfolio WHSIPP Starts-->
				<?php if($directWHSippExists == "Yes"){ ?>
						<h2>WH Ireland SIPP Investment Wrapper</h2>

                        <table width="100%">
						<tr>
						  <td width="50%">Fee rate to apply</td>
						  <td width="50%"><?php echo @$whsippAdvFee["feerate"]; ?>%</td>
						</tr>
						<tr bgcolor="#f9f9f9">
						  <td>Half Yearly</td>
						  <td><?php
											if(@$whsippAdvFee["chargefreq"] == "Half Yearly")
												echo "Yes";
										  ?>
							</td>
						</tr>
						<tr>
						  <td>Quarterly</td>
						  <td><?php
											if(@$whsippAdvFee["chargefreq"] == "Quarterly")
												echo "Yes";
										  ?>
						  </td>
						</tr>
                        </table>
				<?php } ?>
				<!-- Portfolio WHSIPP Ends-->

				<!-- Portfolio EXTSIPP Starts-->
				<?php if($directExtSippExists == "Yes"){ ?>

                        <h2>External SIPP Investment Wrapper</h2>

                        <table width="100%">
						<tr>
						  <td width="50%">Fee rate to apply</td>
						  <td width="50%"><?php echo @$extsippAdvFee["feerate"]; ?>%</td>
						</tr>
						<tr bgcolor="#f9f9f9">
						  <td>Half Yearly</td>
						  <td><?php
											if(@$extsippAdvFee["chargefreq"] == "Half Yearly")
												echo "Yes";
											else
												echo "No";
										  ?>
							</td>
						</tr>
						<tr>
						  <td>Quarterly</td>
						  <td><?php
											if(@$extsippAdvFee["chargefreq"] == "Quarterly")
												echo "Yes";
											else
												echo "No";
										  ?>
						  </td>
						</tr>
                        </table>
				<?php } ?>
				<!-- Portfolio EXTSIPP Ends-->

				<!-- Portfolio ISAINV Starts-->
				<?php if($directISAInvExists == "Yes"){ ?>
						<h2>ISA Investment Wrapper</h2>
						<table width="100%">
						<tr>
						  <td width="50%">Fee rate to apply</td>
						  <td width="50%"><?php echo @$isainvAdvFee["feerate"]; ?>%</td>
						</tr>
						<tr bgcolor="#f9f9f9">
						  <td>Half Yearly</td>
						  <td><?php
											if(@$isainvAdvFee["chargefreq"] == "Half Yearly")
												echo "Yes"; else echo "No";
										  ?>
							</td>
						</tr>
						<tr>
						  <td>Quarterly</td>
						  <td><?php
											if(@$isainvAdvFee["chargefreq"] == "Quarterly")
												echo "Yes"; else echo "No";
										  ?>
						  </td>
						</tr>
                        </table>

				<?php } ?>
				<!-- Portfolio ISAINV Ends-->
			<?php } ?>
			<!-- Portfolio Ends-->
			</div>
     <?php } ?>
               <div class="front-page">
<script type="text/php">
$frontpage = $pdf->open_object();
$pdf->image("img/inter-9.png", "png", 0, 0, 615, 800);
$pdf->close_object();
$pdf->add_object($frontpage,"add");
</script>
</div>
<div class="pdf-page">
	<h1>Adviser Declaration</h1>
<p>
To: SPGO
<br/>
I hereby acknowledge and agree that the Retail Intermediary Terms of Business and this agreement form part of the agreement between us.</p>
<br/>
<p>By signing this declaration you confirm your acceptance and agreement to these terms and to the terms of the Retail
Intermediary Terms of Business.
</p>
<br/>
<p>I have read and understood the risks and Terms and Conditions of the Investment as detailed on the front page of this form.</p>

<table width="100%">
<tr bgcolor="#e5edf0" height="30">
<td width="30%">
<b>Adviser</b>
</td>
<td width="20%">
</td>
</tr>

<tr height="35">
<td>
Signed
</td>
<td bgcolor="#f9f9f9">
</td>

</tr>

<tr height="35">
<td>
Full Name
</td>
<td bgcolor="#f9f9f9">
</td>
</tr>

<tr height="35">
<td>
Date
</td>
<td bgcolor="#f9f9f9">
</td>

</tr>
</table>
</div>
<div class="pdf-page">
    <h1>Client Declaration</h1>

<p>
To: SPGO
<br/>
<p>
<font color="#c40f30"><b>If you have selected to open a Direct Investment Account or Joint Investment Account in this form</b></font>
<br/>
I confirm that I have read the Direct Investment Account Key Features Document and the Retail Client Direct Investment Account Terms and Conditions.
</p>
<br/>
<p>
<font color="#c40f30"><b>If you have selected to open an ISA Investment Wrapper</b></font>
<br/>
I confirm I agree that I have read the WH Ireland ISA Key Features Document and agree to the terms of the ISA Terms and Conditions.
<br/><br/>
I/we are 18 years of age or over. All subscriptions made, and to be made, belong to me/us.
<br/><br/>
I/we are resident and ordinarily resident in the United Kingdom for tax purposes or, if not so resident, either perform duties which, by virtue of section 28 of The Income Tax (Earnings &amp; Pensions) Act of 2003 (Crown Employees serving overseas), are treated as being performed in the United Kingdom, or I/we are married to, or in a civil partnership with, a person who performs such duties.
<br/><br/>
I/we are not a resident, nor am I/we acting on behalf of a resident of the United States, and that I/we will not assist any person who is so resident to invest in this Plan. Further, I/we agree to inform you immediately should I/ we become a resident of the United States.
<br/><br/>
I/we will inform SPGO if I/we cease to be so resident and ordinarily reside or to perform such duties or to be married to, or in a civil partnership with, a person who performs such duties.
<br/><br/>
I hereby authorise SPGO as ISA Manager, to hold my cash subscription, ISA Investments, interest, dividends and any other rights or proceeds in respect of these investments and any other cash. The information above is true and correct to the best of my/our knowledge and belief, and I/we agree to advise SPGO without delay of any change in my/our circumstances affecting any of the information on this declaration and authority.
</p>
<br/>
<p>
<font color="#c40f30"><b>If you have selected to open a WH Ireland Sipp Investment Wrapper</b></font>
<br/>
I confirm that:
<br/>
The WH Ireland SIPP is known as the Alpha SIPP ("the Scheme") which is a registered pension scheme as defined in Part 4 of the Finance Act 2004. The Establisher is Bank of Scotland and EBS Management Plc is the Trustee and Administrator.
<br/><br/>
I wish to apply for membership of the Alpha SIPP and I declare that:
<br/><br/>
1. I have been provided with a WH Ireland SIPP Key Features Document and Terms of Business. A copy of the Establishing Deed and Rules governing the Scheme can be provided on request.
<br/><br/>
2. Total contributions to my SIPP and any other registered pensions schemes in respect of which I am entitled to tax relief will not exceed the higher of the basic amount (currently &pound;3,600) or my relevant UK earnings for that tax year.
<br/><br/><br/><br/><br/><br/><br/>
3. I agree to inform EBS Management Plc within thirty days should any of the following occur:
<br/>
&nbsp;&nbsp;&nbsp; - My permanent residential address changes
<br/>
&nbsp;&nbsp;&nbsp; - I cease to be UK resident
<br/>
&nbsp;&nbsp;&nbsp; - I cease to have relevant UK earnings
<br/>
&nbsp;&nbsp;&nbsp; - I start to have relevant UK earnings again
<br/>
&nbsp;&nbsp;&nbsp; - My employment status changes
<br/>
&nbsp;&nbsp;&nbsp; - I contribute in total in any tax year more than 100% of my earnings to my SIPP and any other registered pension schemes
<br/>
&nbsp;&nbsp;&nbsp; - I register for an enhanced lifetime allowance in respect of a pension credit or a transfer from an overseas pension scheme
<br/>
&nbsp;&nbsp;&nbsp; - Any enhanced protection I have is invalidated
<br/><br/>
4. I consent to the Administrator obtaining details of any other registered pension schemes of which I am a member from the relevant trustees, insurance company(ies) and/or other providers concerned.
<br/><br/>
5. I hereby agree that in consideration of my rights under the Rules, to appoint SPGO as my Custodian/Dealer. I shall be solely responsible to myself and my dependants for the results of my investment decisions and choice of investment managers and that I shall hold the Establisher, Administrator and the Trustee fully indemnified against any claims in respect of such decisions and/or investment management appointments.
<br/><br/>
6. Every statement made in this application is to the best of my knowledge and belief true and complete. I understand that the making of false claims connected with an application for or in connection with my continued membership of the Scheme may constitute an offence rendering me liable for prosecution.
<br/><br/>
7. I authorise that cash deposited with Bank of Scotland for my SIPP Account, once cleared, should be passed to SPGO for investing. This will leave a zero balance at Bank of Scotland at all times, apart from when funds are needed to pay benefits.
</p>
<br/>
<p>
<font color="#c40f30"><b>General Declaration</b></font>
<br/>
If this form has been completed on your behalf, please take time to read it and ensure its accuracy before signing below.
<br/>
All subscriptions made, and to be made, belong to me.
<br/><br/>
You authorise us to hold and process the information supplied on the application form as a data controller for the purposes of the Data Protection Act 1998. We may hold and process information for the administration of the service for which you are currently applying or may apply for in the future, for the operation of your investment and for marketing goods and services from any member of WH Ireland Limited.
<br/><br/>
You authorise the disclosure of your information concerning your investment to an Independent Financial Adviser acting on your behalf.
<br/><br/>
You are entitled to request details of the information we hold upon payment of a fee and require us to correct any inaccuracies in that personal data.
<br/><br/>
To hold my cash subscription, ISA investments, interest, dividends and any other rights or proceeds in respect of those investments and any other cash;
<br/><br/>
To make on my behalf any claims to relief from tax in respect of ISA investments.
<br/><br/>
Important: If there is anything which you do not understand in any of the documents we have sent to you please contact us before you sign and return this form.
<br/><br/>
I hereby acknowledge and agree that the Retail Client Terms and Conditions of the SPGO Platform and the SPGO Service Retail Client Key Features Document and this agreement form part of the agreement between us.
<br/><br/>
By signing this declaration you confirm your acceptance and agreement to these terms and to the terms of the Retail Client Terms and Conditions of the SPGO Platform.
<br/><br/>
I/we have read and understood the risks and Terms and Conditions of the Investment as detailed on the front page of this form and I understand that:</p>
<table width="100%">
<tr height="35">
<td width="70%">I may get back less than my original invested should I need to withdraw from the product early</td>
<td width="30%" bgcolor="#f9f9f9">
 Yes / No</td>
</tr>
<tr height="35">
  <td>I am prepared to accept some risk to my capital in return for potential higher returns</td>
  <td bgcolor="#f9f9f9">Yes / No</td>
</tr>
<tr height="35">
  <td>I may lose some or all of my money by investing in this product</td>
  <td bgcolor="#f9f9f9">Yes / No</td>
</tr>
</table>
<br/><br/>
<table width="100%">
<tr bgcolor="#e5edf0" height="30">
<td colspan="2">
<b>Client Applicant</b></td>
<td colspan="2">Joint Applicant</td>
</tr>

<tr height="35">
<td width="20%">
Signed</td>
<td width="30%" bgcolor="#f9f9f9"></td>
<td width="20%">Signed</td>
<td width="30%" bgcolor="#f9f9f9"></td>
</tr>

<tr height="35">
<td>
Full Name</td>
<td bgcolor="#f9f9f9"></td>
<td >Full Name </td>
<td bgcolor="#f9f9f9"></td>
</tr>

<tr height="35">
<td>
Date</td>
<td bgcolor="#f9f9f9"></td>
<td>Date</td>
<td bgcolor="#f9f9f9"></td>
</tr>
</table>
<?php if($directExtSippExists != "Yes" && $this->session->userdata("newaccount") != ""){ ?>
<br/><br/>
<table width="100%">
<tr height="35">
<td width="70%" bgcolor="#e5edf0">
<b>Would you like a copy of these forms?</b>
</td>
<td width="30%" bgcolor="#f9f9f9">
 Yes / No
</td>
</tr>
</table>
<?php } ?>
</div>
<?php if($directExtSippExists == "Yes" || $this->session->userdata("newaccount") == ""){ ?>
<div class="pdf-page">
    <h1>External SIPP Declaration</h1>
<p>
To: SPGO
<br/>
</p>
<p>
We, the Trustees/Authorised Parties of this Trust/Scheme, request SPGO to arrange for the purchase of the Investment(s) on<br>
our behalf, in accordance with the Terms of the Investment.</p>
<p>We declare that:</p>
<p>We have read the Terms and Conditions and any other relevent documentation of the Investment and accept the Terms and Conditions under which our investment will be managed.</p>
<p>We have full power to invest in the Investment and have taken all necessary action to authorise the making of this application.  The person(s) signing this application has full power and authority to do so on our behalf.</p>
<p>The investing Trust/Scheme is a registered pension scheme under Part IV of the Finance Act 2004 (or an application for its registration has been made) and we undertake to advise SPGO immediately if it ceases to be a registered pension scheme or its application for registration is withdrawn or refused:</p>
<p>We authorise the Board of the Inland Revenue to inform SPGO if the Scheme is not granted exempt approval or if that approval is withdrawn at any time.</p>
<p>We are not prohibited under legal regulatory provisions or the terms of a Trust/ Scheme from investing in this Plan.</p>
<p>The application form and this declaration have been completed to the best of our knowledge and belief and the information provided is true and complete.</p>
<p>We authorise SPGO:</p>
<p>To purchase the Investment in accordance with this application and understand and agree that any investment in the Investment will be allocated in accordance with our instructions.</p>
<p>By signing, we confirm that we have read, understood and agreed to be bound by this declaration, the information supporting this application form, the documentation relating to the Investment and the Terms and Conditions used and disclosed.</p>
<p>If we make this application as Trustees of a pension scheme to which Part IV of the Finance Act 2004 applies, then:</p>
<p>We appoint SPGO to manage the cash and investments referred to above on our behalf from the date of this application.</p>
</div>
<div class="pdf-page">
<p>All communications to us from SPGO should be addressed to the contact name detailed in the External SIPP Section of this Application From. SPGO will only accept instructions from those persons approved as authorised signatories in relation to all matters concerning our investment in the Company. SPGO is authorised to pay or transfer to those persons on our behalf any amounts or assets due to us in connection with our investment in the Company and those persons will give a receipt on our behalf if requested to do so. We will notify SPGO in writing in advance of any changes to the persons authorised to give instructions and receive communications and payments on our behalf.</p>
<p>We will inform SPGO immediately if our scheme ceases to be duly registered as a tax exempt pension scheme under Chapter 2 of Part IV of the Finance Act 2004 or if circumstances arise which will or may result in our scheme ceasing to be so registered.</p>
<p>SPGO is requested to respond to us acknowledging its appointment and undertaking to notify us of any conflict of interest that<br>
may arise.</p>
<p>Under the regulations, there is a legal requirement to prove the identity of investors. Please submit a certified copy of the Trust Deed or evidence of HMRC’s approval of the Scheme, a list of authorised signatories and an identity verification certificate for the scheme member.</p>
<p>You authorise us to hold and process the information supplied on the application form as a data controller for the purposes of the Data Protection Act 1998. We may hold and process information for the administration of the service for which you are currently applying or may apply for in the future, for the operation of your investment and for marketing goods and services from any member of SPGO. You authorise the transfer of your information to any member of the group for these purposes.</p>
</p>You authorise the disclosure of your information concerning your investment to an Independent Financial Adviser acting on your behalf.</p>
<p>You are entitled to request details of the information we hold upon payment of a fee and require us to correct any inaccuracies in that personal data.</p>
<br/><br/>
<table width="100%">


<tr height="35">
<td width="20%">
Signed</td>
<td width="30%" bgcolor="#f9f9f9"></td>
<td width="20%">Signed</td>
<td width="30%" bgcolor="#f9f9f9"></td>
</tr>

<tr height="35">
<td>
Full Name</td>
<td bgcolor="#f9f9f9"></td>
<td >Full Name </td>
<td bgcolor="#f9f9f9"></td>
</tr>

<tr height="35">
  <td>Capacity</td>
  <td bgcolor="#f9f9f9"></td>
  <td>Capacity</td>
  <td bgcolor="#f9f9f9"></td>
</tr>
<tr height="35">
<td>
Date</td>
<td bgcolor="#f9f9f9"></td>
<td>Date</td>
<td bgcolor="#f9f9f9"></td>
</tr>
</table>
<br/><br/>
<table width="100%">
<tr height="35">
<td width="70%" bgcolor="#e5edf0">
<b>Would you like a copy of these forms?</b>
</td>
<td width="30%" bgcolor="#f9f9f9">
 Yes / No
</td>
</tr>
</table>
</div>
<?php } ?>
</body>
</html>
