<?php 

	class Mexport extends CI_Model{

		function __construct()
		{
			parent::__construct();
			$this->load->helper('excel');
			$this->load->model('master/Mreports');
		}
		

		function export($rowExport,$custom_report,$print = NULL)
		{
			$getReportData = $this->Mreports->getReportsInfo($custom_report);
			$report_data = $getReportData['0']['report_data'];
			$reportFields = $this->Mreports->getReportFields($getReportData['0']['report_type']);
			$sum_rows = array();
			$headerArray = array('S.No');
			foreach($report_data as $key => $value){
				array_push($headerArray,$reportFields[$value]);
			}

			for($i=0;$i<php72_count($rowExport);$i++){
				$dataArray[$i] = array();
				array_push($dataArray[$i],($i+1));	
					foreach($report_data as $key => $value){
						$more_option = explode('#',$value);
						if(count($more_option)=='2')
						{
							if($more_option['1']=='date')
								$reportValue = mysql2date(@$rowExport[$i][$more_option['0']]);

							if($more_option['1']=='sum')
								$reportValue = $rowExport[$i][$more_option['0']];

						}
						else
						{
							$reportValue = @$rowExport[$i][$value];
						}
						array_push($dataArray[$i], $reportValue); 
					}
			}
			$sum_columns[] = '0';
			foreach($report_data as $row)
			{
				$pos = strrpos($row, "sum");
				if($pos)
					$sum_columns[] = '1';

				else
					$sum_columns[] = '0';

			}

			foreach($dataArray as $key1 => $value1):
				foreach($value1 as $key => $value):
					if($sum_columns[$key] == 0)
						$sum_value[$key] = '';

					else
						@$sum_value[$key] += $value;

				endforeach;
			endforeach;

			$sum_value['0'] = 'Total';
			$lent = php72_count($dataArray);
			$dataArray[$lent] = array();
			foreach($sum_value as $key => $value):
			   array_push($dataArray[$lent], $value);
			endforeach;

			if($print == NULL)
			{
				dataarray_to_excel($headerArray,$dataArray);
				exit;
			}
			else
			{
				$data['headerArray']=$headerArray;
				$data['dataArray']=$dataArray;
				return $data;
			}
		}
		

		function exportOption($type = '',$formname = '')
		{
			$reportsList = $this->Mreports->getReportsByType($type);
			?>
			<a href="javascript:void(0);" class="exportLink button">Export</a>
			<div class="exportOption" title="Export List">
            <h3>Export List

            <a href="javascript:void(0);" class="closeExport" style="float:right">

            <img src="<?=base_url()?>source/template/images/icons/cross.png" alt="Close" /></a></h3>
			<dl class="inline" style="padding:20px">
            <dt><label for="report_data">Reports</label></dt>
			<dd><select name="report_data" >
				<option value="">-Select-</option>
					<?php
					foreach($reportsList as $row):
						?>
						<option value="<?=$row['id']?>"><?=$row['report_name']?></option>
						<?php 
					endforeach;
					?>
				</select>
                </dd>
             </dl>
			</div>
			<?php
		}

		

	}

?>