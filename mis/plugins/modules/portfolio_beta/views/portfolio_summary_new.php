<?php $this->load->view('vitals_header.php', array('main_menu' => 'portfolio_new', 'page_title' => 'Portfolio Summary', 'portfolio_summary' => 'yes')); ?>

<!-- Inner Dashboard-->
<!--<div style="position:relative">-->
<div class="mar-tp75 pad-tp12">
    <div class="container-fluid">
        <iframe src="https://vitalsdash.villgroapps.org/Villgro/?emp_enc_user_key=<?php echo $enc_user_key; ?>" width="100%" height="750" style="border:none;"></iframe>
    </div>
</div>
<!--</div>-->

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'chart' => 'yes')); ?>
</body>
</html>
