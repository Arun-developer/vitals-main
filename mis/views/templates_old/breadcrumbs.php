<?php $current_page =  $this->uri->segment(2); ?> 
<?php $funder_id =  $this->uri->segment(3); ?> 
<div class="villgro-breadcrumb container-fluid">
	<div class="row">
		<div class="col-md-12 col-12">
			<ul>
				<li><a href="<?= base_url() . 'index.php/portfolio/dashboard'; ?>">Home</a></li> <i
					class="fa fa-angle-double-right"></i>
					<?php if($current_page == 'display_summary_list'){?>
						<li><a class="active none-pointer">Funder Summary</a></li>
					<?php }else if($current_page == 'add_funder_form'){?>
							<li><a class="active none-pointer">Funder Summary</a></li>
					<?php }else if($current_page == 'edit_funder_form'){?>
						<li><a href="<?= base_url() . 'index.php/funder/display_summary_list'; ?>" class="">Funder Summary</a></li><i class="fa fa-angle-double-right"></i>
						<li><a class="active none-pointer">Edit Funder</a></li>
					<?php }else if($current_page == 'edit_funder_documents'){?>
						<li><a href="<?= base_url() . 'index.php/funder/display_summary_list'; ?>" class="">Funder Summary</a></li><i class="fa fa-angle-double-right"></i>
						<li><a class="active none-pointer">Funder Documents</a></li>
					<?php }else if($current_page == 'display_grant_list'){?>
					<li><a href="<?= base_url() . 'index.php/funder/display_summary_list'; ?>" class="">Funder Summary</a></li><i class="fa fa-angle-double-right"></i>
						<li><a class="active none-pointer">Grant Summary</a></li>
					<?php }else if($current_page == 'add_grant_form'){?>
						<li><a  style="color:#2a7d47;" href="<?= base_url() . 'index.php/funder/display_grant_list/'.$funder_id; ?>" >Funder Summary</a></li><i class="fa fa-angle-double-right"></i>
						<li><a href="<?= base_url() . 'index.php/funder/display_grant_list/'.$funder_id ?>" style="color:#2a7d47;" class="active" >Grant Summary</a><i class="fa fa-angle-double-right"></i>
						<li><a class="active none-pointer">Add Grant</a>
					<?php }else if($current_page == 'edit_grant_form'){?>
						<?php $funder_id =  $this->uri->segment(3); ?> 
						<li><a  style="color:#2a7d47;" href="<?= base_url() . 'index.php/funder/display_summary_list'; ?>" >Funder Summary</a></li><i class="fa fa-angle-double-right"></i>
						<li><a id="edit_gs_link" href="<?= base_url() . 'index.php/funder/display_grant_list/'.$funder_id ?>" style="color:#2a7d47;" class="active" >Grant Summary</a><i class="fa fa-angle-double-right"></i>
						<li><a class="active none-pointer">Edit Grant</a></li>
					<?php } ?>
			</ul>
		</div>
	</div>
</div>