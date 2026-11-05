<html lang="en">
<head>
<title><?php echo $cpagetitle;?></title>
<meta charset="utf-8">
<?php
$this->load->view('../includes');
?>
</head>
<body class="fluid">
<div class="headerLOGO">
<div class="headerLOGO_LFT"><img src="<?php echo base_url(); ?>source/template/images/logo.png" title="Villgro"></div>
<div class="headerLOGO_RHT">
<ul>
<li><a href="<?=site_url('login/logout');?>" ><strong>Logout</strong></a></li>
<li><span>Welcome : <?php
    if($this->session->userdata('user_type')=='admin' AND $this->session->userdata('user_type') !='mipuser') {
        echo "Administrator";
    } else if($this->session->userdata('user_type') !='admin' AND $this->session->userdata('user_type') !='mipuser' ){
                echo $this->session->userdata('emp_name');
    } else if(($this->session->userdata('user_type') !='admin')) {
            echo $this->session->userdata('name');
        }
    else
    {
        echo $innovation['name_of_enterprise'];
    }
    ?></span></li>

<li> <a href="<?php echo site_url('changepass');?>" style="background-image:none;"> Change Password</a> </li>
</ul>
</div>
</div>
<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<ul class="breadcrumb">
			<?php if($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'form' || $this->uri->segment('2') == 'agreement' || $this->uri->segment('2') == 'documents' || $this->uri->segment('2') == 'getCompanyDetails')
                            {?>
                                <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li><li><a href="<?=site_url('login/incubatee/company_info/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Company Info</b></font></a></li><li><a href="<?=site_url('screening/form/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Info</b></font></a></li><li> <a href="#"><font color="#000000"><b>Company Details</b></font></a></li>
                            <?php } ?>  
			
			</ul><br/><br/>
        	<article id="<?php echo $cpage;?>">
            <?php $this->load->view('../message');  ?>
           
			 <?php  $this->load->view($cpage); ?>
             
            </article>
		</section>
		<aside id="sidebar" class="grid_3 pull_9">
			<div class="boxed menu">
            
				<ul>
           
            <li><a href="<?=site_url('screening/nda_list/'.$this->uri->segment('3'));?>">NDA Documents</a></li>
            </ul>
            </section>
			</div>
           

		</aside>
	</section>
</section>
<?php $this->load->view('../footer'); ?>
</body>
</html>
