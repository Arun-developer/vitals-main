<?php
 /*
     Example8 : A radar graph
 */
 global $pchart_basepath;
 $pchart_basepath = APPPATH."third_party/pChart/";
 include $pchart_basepath.'pChart/pChart.php';
 include $pchart_basepath.'pChart/pData.php';

 class Chart {
	 function showChart($title = '', $label = array(), $serieList = array())
	 {
		$pchart_basepath = APPPATH."third_party/pChart/";
		$DataSet = new pData;
		 $DataSet->AddPoint($label,"Label");
		 $ii = 1;
		 foreach($serieList as $sl):
		 	$DataSet->AddPoint($sl['value'],"Serie".$ii);
			$DataSet->AddSerie("Serie".$ii);
			$DataSet->SetSerieName($sl['name'],"Serie".$ii);
			++$ii;
		 endforeach;
		 
		 $DataSet->SetAbsciseLabelSerie("Label");
		 // Initialise the graph
		 $Test = new pChart(500,500);
		 $Test->setFontProperties($pchart_basepath."Fonts/tahoma.ttf",8);
		 $Test->drawFilledRoundedRectangle(7,7,393,393,5,240,240,240);
		 $Test->drawRoundedRectangle(5,5,395,395,5,230,230,230);
		 $Test->setGraphArea(30,30,370,370);
		 $Test->drawFilledRoundedRectangle(30,30,370,370,5,255,255,255);
		 $Test->drawRoundedRectangle(30,30,370,370,5,220,220,220);
		 // Draw the radar graph
		 $Test->drawRadarAxis($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,20,120,120,120,230,230,230);
		 $Test->drawFilledRadar($DataSet->GetData(),$DataSet->GetDataDescription(),50,20);
		 // Finish the graph
		 $Test->drawLegend(15,15,$DataSet->GetDataDescription(),255,255,255);
		 $Test->setFontProperties($pchart_basepath."Fonts/tahoma.ttf",10);
		 $Test->drawTitle(0,22,$title,50,50,50,400);
		 $Test->Render('map.png');
	}
		 // Dataset definition 
 
 }
?>