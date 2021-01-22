<?php
	function lang($code){

		//print_r(file_get_contents("language/a.txt"));
		$content=@file_get_contents("language/language.txt");
		if($content === FALSE) { 
			echo('');
		}else{
			$temp=explode("|||",$content);
		   foreach ($temp as &$value) {
				//$value = $value * 2;
				$array=explode("=",$value);
				if($array[0]==$code){
					$array1=explode("~",$array[1]);					
					echo($array1[$_SESSION["user"]["language"]-1]);
					break;
				}
				
				
		   }
		}
		//print_r($handle);
	}

	function get_text_lang($code){
		if(isset($_SESSION["user"]["language"])){	
			if($_SESSION["user"]["language"]==''){
				$lang=1;	
			}else{
				$lang=$_SESSION["user"]["language"];	
			}
		}else{
			$lang=1;
		}
		
		$split_text = array("\r", "\n");
		$handle = @fopen("language/lang.txt", "r");	
		
		if ($handle) {
			while (!feof($handle)) {
				$temp=explode("=",fgets($handle, filesize("language/lang.txt")));
				if($temp[0]==$code){
					$temp_lang=explode("~",str_replace($split_text,"",$temp[1]));
					$noidung[$temp[0]]=str_replace($split_text,"",$temp_lang[$lang-1]) ;
					
					fclose($handle);
					
					break;
				}
			}
				
		}
		echo ($noidung[$code]);	
	}
	
		function get_text($code){
			 
			if(isset($_GET["view"])){$view = $_GET["view"];}
			else{
				$view=NULL;
				};
				
			if(isset($_GET["module"])){$modules = $_GET["module"];};
		    $split_text = array("\r", "\n");
			$handle = @fopen("modules/".$modules."/".$view."/vi.txt", "r");		
			
			if ($handle) {
				while (!feof($handle)) {
					$temp=explode("=",fgets($handle, filesize("modules/".$modules."/".$view."/vi.txt")));
					
					if($temp[0]==$code){
						$noidung[$temp[0]]=str_replace($split_text,"",$temp[1]) ;	
						fclose($handle);
						break;
					}
								
				}	
				   
				//fclose($handle);
				//print_r($noidung);				 
			   // return $noidung[$code];
				
		}
		echo( $noidung[$code]);	
	}


	function get_text1($code){
			 
			if(isset($_GET["view"])){$view = $_GET["view"];};
			if(isset($_GET["module"])){$modules = $_GET["module"];};
		    $split_text = array("\r", "\n");
			$handle = @fopen("language/vi.txt", "r");		
			
			if ($handle) {
				while (!feof($handle)) {
					$temp=explode("=",fgets($handle, filesize("language/vi.txt")));
					
					if($temp[0]==$code){
						$noidung[$temp[0]]=str_replace($split_text,"",$temp[1]) ;	
						fclose($handle);
						break;
					}
								
				}	
				   
				//fclose($handle);
				//print_r($noidung);				 
			   // return $noidung[$code];
				
		}
		echo( $noidung[$code]);	
	}
?>