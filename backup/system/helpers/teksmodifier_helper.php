<?php
	function filtertext($string,$delim)
	{
		//$arr=array('~','!','@','#','$','%','^','&','*','(',')','_','+','|','}','{','"',':','?','>','<','`','-','=','\\',']','[','\'',';','/','.',',');
		$arr=array('?','\\','/','"','\'','%','\'','’','"',':',';','~','`','.',',','(',')','{','}','_','-','=','@','#','$','|','!',' ','*','&');
		$text=str_replace($arr, $delim, $string);
		$text=str_replace(array('---','--','-'), '-', $text);
		return strtolower($text);

	}
	function filterisi($string,$x=NULL)
	{
		$string=strip_tags($string,'<i><a>');
	    $kata = explode(' ', $string);

	    $jmlspasi = count($kata) - 1;
	    $tampilkan = '';
	    if($x==null || $x==0)
	    {
			if($jmlspasi<40)
				$n=$jmlspasi;
			else
				$n=40;
		}
	    else
	    {
			if($jmlspasi<40)
				$n=$jmlspasi;
			else
				$n=$x;
	    }
	    for($a = 0;$a <=$n; $a++)
	    {
	        $tampilkan = $tampilkan. ' ' .$kata[$a];
	    }

	    return strip_tags($tampilkan,'<i><b><br><a>');
	}
?>
