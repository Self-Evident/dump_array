<?php
//******************************************************************************
function dump_array($var, $name="", $ECHO = 1, $PRE=1, $BRDR=1, $DSPLY=1, $VD=0, $LVL=0) { //**
	//If $VD == 1 (or true), use var_dump on each non-array value.
	$dump   = "";
	$pad    = '';
	$indent = '   ';

	if (($LVL == 0) && $PRE) { //used only on outer most level
		if     ($DSPLY == 1) {$DSPLY='display: inline-block; ';} //default
		elseif ($DSPLY == 2) {$DSPLY='float: left;'; }
		elseif ($DSPLY == 3) {$DSPLY='float: right;';}
		else   {$DSPLY='';}
		$dump .= '<pre style="'.$DSPLY.' font-family: courier; border: '.$BRDR.'px solid gray; margin:0;">';
	}

	if (!is_array($var)) {
		if ( $name != "" ) {$dump .= $name." = ";}
		if ($VD) {ob_start(); var_dump($var); $dump .= str_replace("\n",'',ob_get_clean());}
		else     {$dump .= $var;}
	}
	else {
		for ($x=0; $x < $LVL; $x++) {$pad .= $indent;}
		
		if ( $name != "" ) {
			if ($VD) {$desc=" => Array(".count($var).")";} else {$desc = '';}
			$dump .= $pad.$name.$desc."\n";
		}
		
		foreach ($var as $key => $value) {
			if (is_array($value)) {
				$dump .= dump_array($value,'['.$key.']',0,0,0,0,$VD,$LVL+1);
			}
			else if ($VD) {
				$dump .= $pad.$indent.'['.$key.'] => ';
				ob_start(); var_dump($value); $dump .= ob_get_clean();
			}
			else {$dump .= $pad.$indent.'['.$key.'] = '.$value."\n";}
		}
	}

	if (($LVL == 0) && $PRE ) {$dump .= "</pre>";}
	if ($ECHO) {echo $dump;} else {return $dump;}
}//dump_array() //**************************************************************

