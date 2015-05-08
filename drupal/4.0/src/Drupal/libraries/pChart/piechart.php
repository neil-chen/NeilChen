<?php
 /*
     Example10 : A 3D exploded pie graph
*/
if($_GET["pass"]>0)
$pass=$_GET["pass"];

if($_GET["fail"]>0)
$fail=$_GET["fail"];

 // Standard inclusions   
 include("pChart/pData.class");
 include("pChart/pChart.class");

 // Dataset definition 
 $DataSet = new pData;
 $point1 = array();
 $point2 = array();
 if($pass){
	$point2[] = "Pass";
	$point1[] = $pass;
 }
 if($fail){
	$point2[] = "Fail";
	$point1[] = $fail;
 }
 
 $DataSet->AddPoint($point1,"Serie1");
 $DataSet->AddPoint($point2,"Serie2");
 $DataSet->AddAllSeries();
 $DataSet->SetAbsciseLabelSerie("Serie2");

 // Initialise the graph
 $Test = new pChart(345,200);
 $Test->drawFilledRoundedRectangle(7,7,413,243,5,240,240,240);
 $Test->drawRoundedRectangle(5,5,415,245,5,230,230,230);
 $Test->createColorGradientPalette(1,6);

 // Draw the pie chart
 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 if($pass==0 && $fail>0){
 $Test->setColorPalette(0,243,134,48);
 }
 $Test->AntialiasQuality = 0;
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
 $Test->drawPieLegend(280,5,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

 // Write the title
 $Test->setFontProperties("Fonts/MankSans.ttf",10);
 //$Test->drawTitle(10,20,"Covidien",100,100,100);

 //$Test->Render("example10.png");
 $Test->stroke();
 /*   header('Content-type: image/png');
    imagepng($Test);
    imagedestroy($Test);*/
	//<img src="Example10.png">
?>
