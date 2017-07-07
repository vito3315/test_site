<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

 $array = [
		"passenger_1" => "Подъемники легковые",
		"passenger_2" => "Подъемники грузовые",
		
		"stands_alignment" => "Стенды развал-схождение",
		"garage_1" => "Общегаражное оборудование для ла",
		"garage_2" => "Общегаражное оборудование га",
		"tire_repair_1" => "Все для шиномонтажа и шиноремонта ла",
		"tire_repair_2" => "Все для шиномонтажа и шиноремонта га",
		"tools" => "Инструменты",
		"car_washes" => "Оборудование для автомоек и клининга",
		"diagnostic_equipment" => "Диагностическое оборудование",
		"air_conditioning_service" => "Оборудование для обслуживания систем кондиционирования",
		"car_service" => "Оборудование для обслуживания систем автомобиля"
	];
	
	
 
 mysql_connect("localhost", "marusimg_marcet", "4815162342") or
        die("Could not connect: " . mysql_error());
    mysql_select_db("marusimg_marcet");

	//$data = array();
 
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
							 
	$t=0;	
	foreach ($array as $key => $value) {
		//echo "<b>$value $key</b><br>";
		$i=1;
		$result = mysql_query("SELECT * FROM allitems where typeTable='".$key."' ORDER BY name ASC");		
		
		while($row = mysql_fetch_assoc($result)){ 
			$objPHPExcel->setActiveSheetIndex($t++)
						->setCellValue('A'.$i, $row['fuckingCell'])
						->setCellValue('B'.$i, $row['name'])
						->setCellValue('C'.$i, $row['price']);
			$i++;			
		}
	}
				
	
	
	
	
	/*
	
	
		
	{name: "Маслоприемное и маслосменное обрудование", href: "#catalog/oil_tools"},
	{name: "Оборудование для проведения ТО, ЛИК", href: "#catalog/technical_inspection"},
	{name: "Сварочное, пусковое и зарядное оборудование", href: "#catalog/welding_equipment"},
	{name: "Компрессоры и воздухоподготовка", href: "#catalog/compressors"},	
	{name: "Окрасочное оборудование", href: "#catalog/painting"},	
	{name: "Оборудование для кузовных работ", href: "#catalog/body_repair"},		
	{name: "Производственная мебель для автосервисов", href: "#catalog/furniture"},			
	{name: "Системы отопления помещений на отработанном масле", href: "#catalog/systems_of_heating_on_waste_oil/systems_of_heating_on_waste_oil/page=1"},	
	*/
	
	
	
	
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFill()->getStartColor()->setRGB('333333');
$objPHPExcel->getActiveSheet()->getComment('D1')->getFillColor()->setRGB('333333');

/*$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK,
			'color' => array('argb' => 'FF000000'),
		),
	),
);

$objPHPExcel->getActiveSheet()->getStyle('A1:C10')->applyFromArray($styleThinBlackBorderOutline);*/

/*// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');*/

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
