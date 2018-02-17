<?php

require_once 'lib/PHPExcel/IOFactory.php';

$excelFile = "samopoznanie_trainers.xlsx";

$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load($excelFile);

//Itrating through all the sheets in the excel workbook and storing the array data
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $arrayData[$worksheet->getTitle()] = $worksheet->toArray();
}

$mask = " ";
$arr = $arrayData["Worksheet"];
if (is_array($arr) || is_object($arr))
{
foreach($arr as $key => $row){
	$phone = iconv("UTF-8", "windows-1251",$row[3]);
	if(isset($phone)){
		$phone2 = iconv("UTF-8", "windows-1251",$row[4]);
		if(isset($phone2)){
			$phone3 = iconv("UTF-8", "windows-1251",$row[5]);
			if(isset($phone3)){
				$phone4 = iconv("UTF-8", "windows-1251",$row[6]);

			}else{$phone4 = " ";}
		}else{$phone3 = " ";}
	}else{$phone2 = " ";}
	if(!isset($phone)){
		$phone = " ";
		$phone2 = " ";
		$phone3 = " ";
		$phone4 = " ";
	}

		$name = iconv("UTF-8", "windows-1251",$row[0]);


		$city = iconv("UTF-8", "windows-1251",trim($row[1]));

		$skype = iconv("UTF-8", "windows-1251",$row[2]);
		$mask .= "BEGIN:VCARD
VERSION:3.0
REV:05.02.2018
N:;$name;
FN:$name  
TEL;TYPE=WORK;VOICE:$phone3
TEL;TYPE=WORK;FAX:$phone4
ADR;TYPE=WORK:;;$skype;$city;;;
LABEL;TYPE=WORK:$skype
$city,
TEL;TYPE=HOME;VOICE:$phone
TEL;TYPE=CELL;VOICE:$phone2
TEL;TYPE=HOME;FAX:
ADR;TYPE=HOME:;;;;;;
LABEL;TYPE=HOME:
END:VCARD
";

}
	file_put_contents('vcf/samopoznanie_trainers.vcf', $mask);
}
/*
*/

/**/