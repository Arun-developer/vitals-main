<?php echo "<h2>" . @$cpagetitle . "</h2>";
?>
<p>Please fill in the following required information (required fields denoted by <font color="#ff0000"><strong>*</strong></font>)</p>
<div id="cssform">
<?php
if (isset($action)) {
    if (isset($errormsg)) {
        echo ("<div class=\"errorMsg\">" . $errormsg . "</div>");
    }
}
foreach ($templateDetails as $row) {
    echo form_open("master/mailtemplate/view_mailtemplate/edit/" . $row['id']);
    echo form_hidden('id', $row['id']);
    echo form_label('Message Type');
    $messagetype = isset($_REQUEST["messagetype"]) ? $_REQUEST["messagetype"] : $row['messagetype'];
    ?>
    <input type="text" readonly value="<?=$messagetype?>" style="width:500px"  />

    <?php
	echo "<font color=\"#ff0000\"><strong>*</strong></font>" . form_error('messagetype', '<div class="errorMsg">', '</div>');
    echo "<div id='spacer'></div>";

    echo form_label('Message Subject');
    $messagesubject = isset($_REQUEST["messagesubject"]) ? $_REQUEST["messagesubject"] : $row['messagesubject'];
    echo form_input("messagesubject", $messagesubject, 'style="width:500px"');
    echo "<font color=\"#ff0000\"><strong>*</strong></font>" . form_error('messagesubject', '<div class="errorMsg">', '</div>');
    echo "<div id='spacer'></div>";

    echo form_label('Message Body');
    $messagebody = isset($_REQUEST["messagebody"]) ? $_REQUEST["messagebody"] : $row['messagebody'];
    $data = array(
        'name' => 'messagebody',
        'id' => 'editor',
        'class' => 'input-text',
        'value' => $messagebody,
        'rows' => '33',
        'cols' => '160',
        'type' => 'textarea',
    );
    echo form_textarea($data);
    echo "<font color=\"#ff0000\"><strong>*</strong></font>" . form_error('messagebody', '<div class="errorMsg">', '</div>');
    echo "<div id='spacer'></div>";

    echo form_label('');
    $data = array('name' => 'txtsubmit', 'id' => 'txtsubmit', 'value' => 'Update Template', 'class' => 'button');
    echo "" . form_submit($data);
    echo "&nbsp;&nbsp;" . anchor('master/mailtemplate', 'Back', 'class="link_button"');

    echo form_close();
}
?>
</div>