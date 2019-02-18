<?php
$data = file_get_contents('output.vcf');
preg_match_all('/BEGIN:VCARD(.*?)END:VCARD\\n/uis', $data, $one_vcf);

for ($k=0; $k <= 15; $k++) { 
	for ($i=$k*15; $i < count($one_vcf[0]); $i+=15) { 
		file_put_contents('vcf$k.php', $one_vcf[0][$i]);
	}
}