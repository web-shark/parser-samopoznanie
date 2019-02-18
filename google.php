<?php
//iconv("windows-1251","UTF-8",$f);
file_put_contents("google.csv", str_replace(';', ",", iconv("windows-1251","UTF-8",file_get_contents("output.csv")) ), FILE_APPEND);