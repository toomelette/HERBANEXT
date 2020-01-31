<?php


namespace App\Core\Helpers;


class __sanitize {


	static $haveUnicode = false;


	public static function html_encode($str, $default = ''){

		if(empty($str)){
			$str = $default;
		}
		
	 	settype($str, 'string');
		
		$out = '';
		$len = mb_strlen($str);
		
		for($cnt = 0; $cnt < $len; $cnt++){
			$c = __sanitize::uniord(__sanitize::unicharat($str, $cnt));
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) ||
				$c == 32 || $c == 44 || $c == 46 )
			{
				$out .= __sanitize::unicharat($str, $cnt);
			}
			else{
				$out .= "&#$c;";
			}
		}
		
		return $out;

	}





	public static function html_attribute_encode($str, $default = ''){

		if(empty($str)){
			$str = $default;
		}
		
	 	settype($str, 'string');
		
		$out = '';
		$len = mb_strlen($str);
		
		for($cnt = 0; $cnt < $len; $cnt++){
			$c = __sanitize::uniord(__sanitize::unicharat($str, $cnt));
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) )
			{
				$out .= __sanitize::unicharat($str, $cnt);
			}
			else{
				$out .= "&#$c;";
			}
		}
		
		return $out;

	}





	public static function xml_encode($str, $default = ''){

		if(empty($str)){
			$str = $default;
		}
		
	 	settype($str, 'string');
		
		$out = '';
		$len = mb_strlen($str);
		
		for($cnt = 0; $cnt < $len; $cnt++){
			$c = __sanitize::uniord(__sanitize::unicharat($str, $cnt));
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) ||
				$c == 32 || $c == 44 || $c == 46 )
			{
				$out .= __sanitize::unicharat($str, $cnt);
			}
			else{
				$out .= "&#$c;";
			}
		}
		
		return $out;

	}





	public static function xml_attribute_encode($str, $default = ''){

		if(empty($str)){
			$str = $default;
		}
		
	 	settype($str, 'string');
		
		$out = '';
		$len = mb_strlen($str);

		
		for($cnt = 0; $cnt < $len; $cnt++){
			$c = __sanitize::uniord(__sanitize::unicharat($str, $cnt));
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) )
			{
				$out .= __sanitize::unicharat($str, $cnt);
			}
			else{
				$out .= "&#$c;";
			}
		}
		
		return $out;

	}
	




	public static function js_string($str, $default = ''){

		if(empty($str)){

			$str = $default;
			
			if(empty($str)){
				return "''";
			}

		}
		
	 	settype($str, 'string');
		
		$out = "'";
		$len = mb_strlen($str);

		
		for($cnt = 0; $cnt < $len; $cnt++){

			$c = __sanitize::uniord(__sanitize::unicharat($str, $cnt));
			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) ||
				$c == 32 || $c == 44 || $c == 46 )
			{
				$out .= __sanitize::unicharat($str, $cnt);
			}
			elseif( $c <= 127 ){
				$out .= sprintf('\x%02X', $c);
			}
			else{
				$out .= sprintf('\u%04X', $c);
			}
		}
		
		return $out . "'";

	}
	




	public static function vbs_string($str, $default = ''){

		if(empty($str)){

			$str = $default;
			
			if(empty($str)){
				return '""';
			}

		}
		
	 	settype($str, 'string');
		
		$out = '';
		$inStr = false;
		$len = mb_strlen($str);

		
		for($cnt = 0; $cnt < $len; $cnt++){

			$c = __sanitize::uniord(__sanitize::unicharat($str, $cnt));

			if( ($c >= 97 && $c <= 122) ||
				($c >= 65 && $c <= 90 ) ||
				($c >= 48 && $c <= 57 ) ||
				$c == 32 || $c == 44 || $c == 46 )
			{
				if(! $inStr)
				{
					$inStr = true;
					$out .= '&"';
				}
				
				$out .= __sanitize::unicharat($str, $cnt);
			}
			else{

				if(! $inStr){
					$out .= sprintf('&chrw(%d)', $c);
				}

				else{
					$out .= sprintf('"&chrw(%d)', $c);
					$inStr = false;
				}

			}
		}
		
		return ltrim($out, '&') . ($inStr ? '"' : '');

	}

    


	/** Utility Methods **/

	public static function unichr($u){

		if(__sanitize::$haveUnicode == true){
			return mb_convert_encoding(pack("N",$u), 'UTF-8', 'UCS-4BE');
		}
		
		return chr($u);
	}
	



	public static function uniord($u){

		if(__sanitize::$haveUnicode == true){
			$c = unpack("N", mb_convert_encoding($u, 'UCS-4BE', 'UTF-8'));
			return $c[1];
		}
		
		return ord($u);
		
	}
	



	public static function unicharat($str, $cnt){

		if(__sanitize::$haveUnicode == true){
			return mb_substr($str, $cnt, 1);
		}
		
		return substr($str, $cnt, 1);

	}




}