<?php



$mask = "";
$arr = file("output.csv");
//echo "<pre>";
//var_dump($arr);
//echo "</pre>";

if (is_array($arr) || is_object($arr))
{
foreach($arr as $r){
	//$phone_position = 100;
	$row = explode(";",$r);
	for ($i=0; $i < count($row); $i++) { 
		preg_match('/\+[0-9]+/uis', $row[$i]);
		//var_dump($check_for);
		//exit();
		if(preg_match('/\+[0-9]+/uis', $row[$i])){
			$phone = iconv("windows-1251","UTF-8",$row[$i]);
			$phone_position = $i;
			break 1;
			echo $phone;

		}
	}

	//$phone = iconv("windows-1251","UTF-8",$row[4]);
	if(preg_match('/\+[0-9]+/uis', $row[$phone_position+1])){

		$phone2 = iconv("windows-1251","UTF-8",$row[$phone_position+1]);
		if(preg_match('/\+[0-9]+/uis', $row[$phone_position+2])){
			$phone3 = iconv("windows-1251","UTF-8",$row[$phone_position+2]);
			if(preg_match('/\+[0-9]+/uis', $row[$phone_position+3])){
				$phone4 = iconv("windows-1251","UTF-8",$row[$phone_position+3]);
			}else{$phone4 = " ";}
		}else{$phone3 = " ";}
	
	}else{$phone2 = " ";}
	if(isset($phone)){
		$name = iconv("windows-1251","UTF-8",$row[0]);
		$mask .= "BEGIN:VCARD
VERSION:3.0
REV:05.02.2018
N:;$name;
FN:$name  
TEL;TYPE=WORK;VOICE:$phone3
TEL;TYPE=WORK;FAX:$phone4
TEL;TYPE=HOME;VOICE:$phone
TEL;TYPE=CELL;VOICE:$phone2
TEL;TYPE=HOME;FAX:
ADR;TYPE=HOME:;;;;;;
LABEL;TYPE=HOME:
END:VCARD
";
	}



}
	file_put_contents('output.vcf', $mask);
}
/*
*/

/**/