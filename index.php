<?php

//unlink('log.txt');
$go ="parser.php";
//echo $go;

$start_times = 20; // how much times to start


    // open ten processes
    for ($j=0; $j<$start_times; $j++) {
        $pipe[$j] = popen('php '.$go.' '.$j." 2>&1 &\n", 'w');
        sleep(1);
    }

    // wait for them to finish
    for ($j=0; $j<$start_times; ++$j) {
        pclose($pipe[$j]);
    }


