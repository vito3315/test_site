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

/** Error reporting */
	header('Content-Type: text/html; charset= utf-8');
	
	mysql_connect("localhost", "marusimg_marcet", "4815162342") or
        die("Could not connect: " . mysql_error());
    mysql_select_db("marusimg_marcet");

	function get_query_list($query){
		$query = mysql_query($query);
		$result = array();
		while($row = mysql_fetch_assoc($query)){
			$result[] = $row;
		}
		return $result;
	}
	
	function get_pages_from_category($id=0){
		return get_query_list("SELECT p.*, c.sort, c.id cat_id FROM `category` c RIGHT JOIN `pages` p ON p.query=c.id AND c.parent_id='$id' WHERE p.is_show=1 AND c.is_show=1 ORDER BY c.sort ASC");
	}
	
	function get_items($id){
		$items = array();
		$result = mysql_query("SELECT name, art, price FROM items WHERE is_show=1 AND category_id=".$id."");
		while($row = mysql_fetch_assoc($result)){ 
			$items[] = $row; 
		}
		return $items;
	}
	
	
	$data['main_category'] = get_pages_from_category(0);
	
	foreach($data['main_category'] as &$main_cat){
		$main_cat['parent_cat'] = get_pages_from_category($main_cat['query']);
		
		if(empty($main_cat['parent_cat'])){// 1 уровень
			$main_cat['parent_cat'][0]['name'] = $main_cat['name'];
			$main_cat['parent_cat'][0]['query'] = $main_cat['query'];
		}
		
		foreach($main_cat['parent_cat'] as &$parent_cat){
			$parent_cat['items'] = get_items($parent_cat['query']);
		}
		
		
	}
	
	//var_dump($data['main_category']);
	//die();
	
	/*$category = array();
	$result = mysql_query("SELECT * FROM catalog_category WHERE is_show=1");
	while($row = mysql_fetch_assoc($result)){ 
		$category[] = $row; 
	}
	
	$data = array();
	
	foreach($category as &$cat){
		
		$abc = array(
		
			'cat' => $cat,
			'items' => get_items($cat['NewTypeTable'])
		
		);
		
		$data[] = $abc;
		
	}*/
		
		
	class excel{
		
		function start($data){
			global $objPHPExcel;
			
			$active_sheet = 0;
			
			foreach($data['main_category'] as $main_cat){
				//echo mb_substr($main_cat['name'], 0, 31, 'UTF-8')."<br />";
				if($active_sheet == 0){
					$objPHPExcel->getActiveSheet()->setTitle(mb_substr($main_cat['name'], 0, 31, 'UTF-8'));
				}else{
					$objPHPExcel->createSheet()->setTitle(mb_substr($main_cat['name'], 0, 31, 'UTF-8'));
				}
				
				$this->set_name($main_cat['name'], $active_sheet);
				$objPHPExcel->setActiveSheetIndex($active_sheet);
				
				//if(!empty($main_cat)){
					$this->set_content($main_cat, $active_sheet);
				//}
				
				
				//var_dump($main_cat);
				//echo "<br/><br/><br/><br/><br/><br/><br/>";
				$this->setSize();
				
				$active_sheet++;
			}
		}
		
		function cellColor($cells,$color){
			global $objPHPExcel;

			$objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					 'rgb' => $color
				)
			));
		}

		function setStyle1($i){
			global $objPHPExcel;

			$this->cellColor('A'.$i, '60b5ff');
			$this->cellColor('B'.$i, '60b5ff');
			$this->cellColor('C'.$i, '60b5ff');
			$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->getColor()->setARGB('ffffff');	
			$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray(array('font'  => array( 'size'  => 20 )));	
		}
		
		function set_name_price_art($ind){
			global $objPHPExcel;
			$objPHPExcel->setActiveSheetIndex($ind)
						->setCellValue('A2', "Артикул")
						->setCellValue('B2', "Название")
						->setCellValue('C2', "Цена");
		}
		
		function set_name($name, $active_sheet){
			global $objPHPExcel;
			
			$objPHPExcel->setActiveSheetIndex($active_sheet)
						->setCellValue('A1', "")
						->setCellValue('B1', $name)
						->setCellValue('C1', "");
						
			$this->setStyle1(1);
		}
		
		function set_content($data, $active_sheet){
			global $objPHPExcel;
			
			$i=3;
			
			foreach($data['parent_cat'] as $parent_cat){
				$objPHPExcel->setActiveSheetIndex($active_sheet)
							->setCellValue('A'.$i, "")
							->setCellValue('B'.$i, $parent_cat['name']?$parent_cat['name']:'')
							->setCellValue('C'.$i, "");
										
				$this->cellColor('A'.$i, 'a7d6ff');
				$this->cellColor('B'.$i, 'a7d6ff');
				$this->cellColor('C'.$i, 'a7d6ff');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->getColor()->setARGB('003e75');
				$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->getColor()->setARGB('003e75');
				$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->getColor()->setARGB('003e75');
				
				$this->set_name_price_art($active_sheet);
				
				$i++;
				
				foreach($parent_cat['items'] as $item){
					$objPHPExcel->setActiveSheetIndex($active_sheet)
								->setCellValue('A'.$i, $item['art'])
								->setCellValue('B'.$i, $item['name'])
								->setCellValue('C'.$i, $item['price']);
					$i++;	
				}
				
			}
		}
		
		function setSize(){
			global $objPHPExcel;
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("100");
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("10");
		}
		
	}	
		
	
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

	/*************************/						 
	
	$excel = new excel();
	$excel->start($data);
	

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Price_rossvik63_ru.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
