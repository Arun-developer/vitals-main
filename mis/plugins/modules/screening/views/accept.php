<br />
<h2 style="border:none"><?=$cpagetitle?></h2>
<?php


$this->jvalidate->validate('accept');

?>
<div class="clear"></div>
<form name="accept" action="<?=site_url('screening/accept/'.$this->uri->segment('3'));?>" enctype="multipart/form-data" method="post" id="accept">
<table class="nostyle" style="width:100%">
    
    <tr>
        <td  colspan="2"><h4>Passive Information Collection; Cookies</h4>
          <p>A cookie is a text-only piece of information that a website transfers   to your computer's hard disk so that the website can remember who you   are. A cookie will normally contain the name of the internet domain from   which the cookie has come, the &quot;lifetime&quot; of the cookie, and a value,   usually a randomly generated unique number. We use cookies to evaluate   the general use of the Site. We also use cookies to identify who you are   after you log in or register so that we can tailor your personal   preferences for a more personalized experience. Cookies also insure that   the appearance of our site conforms to your internet browser. You   usually can configure your Internet browser to reject cookies. However,   if you do so, you might not be able to access certain pages or use   important functions on the Site. We reserve the right to introduce new   passive tracking technologies and techniques related to the use of the   Site. In general, we do not link your identity with information that we   collect passively. However, in any situation where you log in with your   username and password, any or all of the information that is passively   collected about your activities on the Site may be linked with your   identity, and therefore may become Personal Information about you.</p>
          <p>To learn more about cookies and other passive tracking technologies   and how they may be used on your computer, please read the help   information supplied with your internet browser software.</p>
          <h4>Active Information Collection</h4>
          <p>In general, when you visit our Site you remain anonymous, but on some   pages, you need to provide Personal Information to register, make   donations, contact us and conduct other transactions via the Site. The   types of Personal Information collected at the Site may include any or   all of the following, depending on your activities on the Site: Name,   company, occupation, identification number, address, e-mail address,   phone number, username, password, personal financial details about   applicants and other Personal Information that you actively provide to   us via the Website.</p>
        <p>We also enable you to submit personally identifiable information   about other people. For example, we request that you provide us with   such information about friends who may be interested in hearing about   Wantrapreneur. The following types of personally identifiable   information may be collected about people at these pages include: name   and contact information (including email address).</p></td>
    </tr>

       <tr>
    <td>&nbsp;</td>
        <td><input type="submit" class="input-submit" name="txtSubmit" value="Accept Terms & Conditions" />&nbsp;&nbsp;
           </td>
    </tr>
</table>
   
</form>
