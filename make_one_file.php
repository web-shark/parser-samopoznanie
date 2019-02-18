<?php
for ($i=0; $i < 20; $i++) { 
	file_put_contents("output.csv", file_get_contents("output$i.csv"), FILE_APPEND);
}