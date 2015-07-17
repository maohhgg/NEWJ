<?php

	class error{

	    public static function log($err) {

	        $fh = fopen(ROOT. 'log/'.date('Y-m-d',time()).'.log','a');
	        $err = date('Y-m-d H:i:s',time()) . "\n" . $err."\n";
	        fwrite($fh,$err);
	        fclose($fh);

	    }

    }
