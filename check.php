<?php
$filename = 'output.csv';
$array = file($filename);
$obj = array();
$i = 0;
unlink($filename);
foreach ($array as $string) {
	//array_unique($array,SORT_STRING) ;
	$small_arr = explode(';', trim($string));
	for ($f=0; $f < count($small_arr); $f++) { 
		if(mb_strpos($small_arr[$f], "num:")){
			$small_arr[$f] = trim(mb_substr(strstr( $small_arr[$f], ':'),1,-1));
			if(mb_strpos($small_arr[$f], ", ")){
				$num_arr = explode(', ', $small_arr[$f]);
			}else{
				$num_arr = [$small_arr[$f]];
			}

			//echo $small_arr[$f];
			//var_dump($num_arr);
			//var_dump($small_arr);
			array_pop($small_arr);
			$small_arr = array_merge($small_arr, $num_arr);

			
		}

		$small_arr[$f] = str_replace('"',"",$small_arr[$f]);
		//var_dump($small_arr);
	}
	//die();

	$obj[$i] = $small_arr;
	$i++;
}
//var_dump($obj);
//exit();
$obj_new = array();
for ($i=0; $i < count($obj); $i++) {
	$check = true; 

	for ($k=0; $k < count($obj); $k++) { 
		if($i!==$k&&$obj[$i][0]==$obj[$k][0]){
			$check = false;
		}
	}
	if($check){
		$df = fopen($filename, 'a');
		fputcsv($df, $obj[$i],";",'"');
		fclose($df);
	}

}
//
