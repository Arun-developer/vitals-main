<ul class="tabs" style="float:left">
                <?php
				$t = 1;
				foreach($masterType as $key => $value):
				if($t%7 == '0'){ 
				?>
                </ul><div style="clear:both; margin:1px; padding:1px;" ></div><ul class="tabs" style="float:left">
                <?php
				}
				?>
					<li class="<?=(@$currentTab == $key)?'selected':'';?>"><a href="<?=site_url('master/master_settings/view_list/'.$key);?>"><?=$value?></a></li>
					
                <?php 
				
				
				++$t;
				endforeach;
				if(php72_count($masterType)%7 != '0'){ 
				  echo '</ul>';
				}
				?>
                
<div style="clear:both"></div>