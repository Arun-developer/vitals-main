<?php
if (isset($file) && $file == 1) {
    $doc = $incub_details[0]['file1'];
} else if (isset($file) && $file == 2) {
    $doc = $incub_details[0]['file2'];
} else if (isset($file) && $file == 3) {
    $doc = $incub_details[0]['file3'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VITALS - Download Document</title>

    <script type="text/javascript" src="<?= base_url(); ?>source/dialog/jquery.js"></script>
    <link type="text/css" href="<?= base_url(); ?>source/dialog/css/start/jquery-ui-1.8.7.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="<?= base_url(); ?>source/dialog/js/jquery-ui-1.8.7.custom.min.js"></script>
</head>
<body>
    <?php if ($this->session->userdata('emp_number') == '') { ?>
        <div id="details_auth" title="Login" class="confirm_box" style="display:none">
            <form id="login" method="post" autocomplete="off" action="<?php echo site_url('login'); ?>">
                <input type="hidden"name="exportPage" value="export_doc">
                <div class="form-group">
                    <input type="text" name="username" required="" class="form-control" placeholder="Username" value="" />
                </div>
                <br>
                <div class="form-group">
                    <input type="password" name="password" required="" class="form-control" placeholder="Password" value="" />
                </div>

                <input type="submit" name="txtSubmit" class="btn4" value="Login >>" id="isSubmitted" />
                <!--<button type="button" class="btn4" id="confirmPwd" onclick="checkUser();">Sign In</button>-->
            </form>
        </div>
    <?php } else { ?>
        <p id="docMsg"></p>
        <script>
            $(document).ready(function () {
                checkUser();
            });
        </script>
    <?php } ?>


    <?php 
    $folder = '';
    if($incub_details[0]['program'] == '9') { 
        $folder = 'swachhata_startupchallenge';
    } else if($incub_details[0]['program'] == '10') { 
        $folder = 'tanseed';
    }else {
        $folder = 'IncubationForm';
    }
    ?>
    <input type="hidden" id="folder_path" value="<?php echo $folder; ?>" />

    <script>

        $(function () {
            $('#details_auth').dialog();
            return false;
        });

        function closeDialogForm(Id) {
            $(function () {
                $('#details_auth').dialog("close");
                return false;
            });
        }

        function checkUser() {
            var folder_path = $('#folder_path').val();
            window.location.href = "<?php echo host_url() . '"+folder_path+"/mis_download.php?file_name=' . $doc; ?>";
        }

    </script>
    <style>

        .btn4 {
            margin: 15px 63px;
            background-color: #4CAF50;
            border: 3px solid #4CAF50;
            color: white;
            text-transform: uppercase;
            height: auto;
            width: inherit;
            cursor: pointer;
            transition: transform 0.4s, box-shadow 0.4s;
        }

        .form-control{
            padding: .375rem .75rem;
        }
    </style>
</body>
</html>