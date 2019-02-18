<?php
$data = file_get_contents('output.vcf');
preg_match_all('/BEGIN:VCARD(.*?)END:VCARD/uis', $data, $one_vcf);

for ($k=0; $k < 16; $k++) { 
	for ($i=$k*16; $i < count($one_vcf[0]); $i+=16) { 
		file_put_contents("vcf$k.vcf", $one_vcf[0][$i]."\n",FILE_APPEND);
	}
}