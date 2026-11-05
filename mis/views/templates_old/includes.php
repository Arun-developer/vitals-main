<?php $current_module = $this->uri->segment(1);?>

<?php if(isset($current_module) && $current_module!=''){?>
	<?php if($current_module == 'master_pro'){?>
		<link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
		<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/jquery-bootstrap-scrolling-tabs.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/vital/css/all.css'; ?>">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/vital/css/dataTables.bootstrap.css'; ?>">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.4/css/dataTables.responsive.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/vital/css/toastr.css'; ?>">
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
        <script src="<?= base_url(); ?>source/validate/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() . 'source/vital/js/toastr.min.js'; ?>"></script>
    <?php }?>
<?php }else{?>

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

    if (count($custom_js)) {

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
<?php } ?>