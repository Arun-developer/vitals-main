
<link rel="shortcut icon" href="<?= base_url(); ?>myfavicon.ico" type="image/x-icon">

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>source/css/styles.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>source/template/css/style.css">

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>source/template/css/misstylesheet.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>source/template/css/breadcumbs_style.css">

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>source/template/css/skins/green.css" title="green">

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>source/template/css/mystyle.css" />

<link rel='stylesheet' type='text/css' href="<?= base_url(); ?>DataTables-1.9.4/media/css/jquery.dataTables.css" />


<script type="text/javascript" src="<?= base_url(); ?>source/template/js/jquery.js"></script>



<script type='text/javascript' src="<?= base_url(); ?>DataTables-1.9.4/media/js/jquery.dataTables.min.js"></script>

<script type='text/javascript' src="<?= base_url(); ?>DataTables-1.9.4/media/js/FixedColumns.js"></script>

<script type="text/javascript" charset="utf-8" src="<?= base_url(); ?>DataTables-1.9.4/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" charset="utf-8" src="<?= base_url(); ?>DataTables-1.9.4/media/js/TableTools.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>source/custom_js/table2CSV.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>source/custom_js/jquery.TableCSVExport.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>source/template/js/jquery.printElement.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>source/template/js/cufon-yui.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>source/template/js/Delicious_500.font.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>source/template/js/jquery.flot.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>source/template/js/jquery.cookie.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>source/template/js/switcher.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>source/template/js/custom.js"></script>

<script src="<?= base_url(); ?>source/validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>source/validate/jquery.metadata.js" type="text/javascript"></script>


<script type="text/javascript">

    var BASE_URL = '<?= base_url() ?>';

    var SITE_URL = BASE_URL + 'index.php/';

    function today_date()
    {

        var d = new Date();

        var curr_date = d.getDate();

        var curr_month = d.getMonth() + 1;

        var curr_year = d.getFullYear();

        var today = curr_date + '/' + curr_month + '/' + curr_year;

        return today;

    }

</script>





<!--CUSTOME JS FILES-->

<?php
if (isset($custom_js)) {

    if (php72_count($custom_js)) {

        foreach ($custom_js as $js_file):
            ?>

            <script type="text/javascript" src="<?= base_url(); ?>source/custom_js/<?= $js_file ?>.js"></script>

            <?php
        endforeach;
    }
}
?>

<!--END-->



<!--PLUGIN SCRIPTS-->

<?php
$this->load->library('jquery');

$this->jquery->superfish();

$this->jquery->uniform();

$this->jquery->jvalidate();

$this->jquery->fancybox();

$this->jquery->jalert();

$this->jquery->jqueryui();

$this->jquery->tinymce();
?>