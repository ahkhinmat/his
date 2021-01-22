<?php 
/*function escapeSingleQuotes($string){ 
return str_ireplace("'",'"',$string); 
}*/
function delete_image(){
	//print_r($_GET);
	$data= new SQLServer;
	$store_name="{call [GD2_KhamRemove_Hinh] (?,?)}";
        $bien=  array($_GET["idkham"],$_GET["tenanh"].";" );	
		//print_r($params);
		$params = $bien;
		//print_r ($bien);
		$update_duongdan=$data->query( $store_name, $params);
}
function upload_module(){
	/*echo count($_FILES['valueimage']["tmp_name"]);
	for($i=0;$i<count($_FILES['valueimage']["tmp_name"]);$i++){
		 echo $_FILES["valueimage"]["tmp_name"][$i];
	}	*/
	//print_r($_POST);
	/*foreach ($_FILES["valueimage"] as $key ) {
		print_r( $key);
		//echo $key["tmp_name"][0] ;
		
	}*/ 
	
	for($i=0;$i<count($_FILES['valueimage']["tmp_name"]);$i++){
		// echo $_FILES["valueimage"]["tmp_name"][$i];
		//list(,$type)= explode('/', $_FILES['valueimage']["type"][$i]);
		$type=explode('.', $_POST['filetype'][$i]);
		// echo $type[count($type)-1]."/n";
		if($_POST["multi"]=="true"){
			$_FILES["upload"]["name"][$i]=$_POST["default_name"]."_".($i+1+$_POST["total_images"]).".".strtolower($type[count($type)-1]) ;		
		}else{
			$_FILES["upload"]["name"][$i]=$_POST["default_name"].".".strtolower($type[count($type)-1]) ;		
		}
		 $_FILES["upload"]["type"][$i]=$_FILES['valueimage']["type"][$i];		 
		 $_FILES["upload"]["tmp_name"][$i]=$_FILES["valueimage"]["tmp_name"][$i];
		 $_FILES["upload"]["error"][$i]=$_FILES["valueimage"]["error"][$i];
		 $_FILES["upload"]["size"][$i]=$_FILES["valueimage"]["size"][$i]; 	 
	}
	//echo  $_FILES["upload"]["name"][0];
}

function custom_images(){	 
	$chuoi="";
	list(,$idkham,)      = explode('_', $_POST["default_name"]);
	for($i=0;$i<count($_POST["image_data"]);$i++){
		list($type, $data) = explode(';', $_POST["image_data"][$i]);
		//echo $type;
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);	 
		list(,$type)= explode('/', $type);
		$name=$_POST["default_name"]."_".($i+1+$_POST["total_images"]).".$type";
		$chuoi.=$name.";";	 
		file_put_contents('tmp_images/'.$name, $data);
		$_FILES["upload"]["name"][$i]=$name;
		$_FILES["upload"]["type"][$i]="image\/$type";
		//$_FILES["upload"]["tmp_name"][$i]="D:\\xampp\\htdocs\\giaidoan2\\file_manager\\php\\tmp_images\\$name";
		$_FILES["upload"]["tmp_name"][$i]=STRING_PATH.$name;
		$_FILES["upload"]["error"][$i]="0";
		$_FILES["upload"]["size"][$i]=filesize('tmp_images/'.$name);
		//echo "$type";
		//$chuoi+=$name+";";
		//echo $chuoi;
	}
	//print_r	($chuoi);	
	$data= new SQLServer;
	$store_name="{call [GD2_KhamUpDuongDanHinh] (?,?)}";
        $bien=  array($idkham,$chuoi );	
		//print_r($params);
		$params = $bien;
		//print_r ($bien);
		$update_duongdan=$data->query( $store_name, $params);
}
function single_image(){	
	//print_r($_POST);
	list($type, $data) = explode(';', $_POST["image_data"][0]);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);	
	list(,$type)= explode('/', $type);
	//echo $type;
	//$name=$_POST["default_name"].".$type";
	$name=$_POST["default_name"];
	file_put_contents('tmp_images/'.$name, $data);
	$_FILES["upload"]["name"][0]=$name;
	$_FILES["upload"]["type"][0]="image\/$type"; 
	$_FILES["upload"]["tmp_name"][0]=STRING_PATH.$name;
	$_FILES["upload"]["error"][0]="0";
	$_FILES["upload"]["size"][0]=filesize('tmp_images/'.$name); 
	//print_r($_FILES);	 
}
function load_mht($action){
	$ch = curl_init(); 
	//Create a variable with the URL you want to "get".
	$URL =get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?profile=tcd&tenthumuc=".$_GET["tenthumuc"]."&answer=42&cmd=file&target=".$_GET["target"]; 
	//Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	//Set the URL
	curl_setopt($ch, CURLOPT_URL, $URL); 
	//Execute the fetch
	$content = curl_exec($ch); 
	//Close the connection
	curl_close($ch); 	 
	//$content = file_get_contents('http://www.nchmf.gov.vn/web/vi-VN/43/Default.aspx');
	//echo $content;	
	if($action!="tcd_read"){
		file_put_contents('tmp_images/'.$_GET["user"].'.mht', $content);
		if(($content=="File not found")||($content=='{"error":["errConf","errNoVolumes"],"debug":["Driver \"elFinderVolumeFTP\" : Root folder does not exists."]}')){
			 echo "File not found";
		}	
	}else{
		file_put_contents('tmp_images/'.$_GET["user"].'.doc', $content);
		if($content!="File not found"){
			com_load_typelib('Word.Application');
			$Wrd = new COM("word.application", NULL, CP_UTF8); 
			sleep(1);
			tcd($Wrd,$action);	
		}		
	}	
}
function tcd($Wrd,$action){	
	/*//print_r($_POST);
	list($type, $data) = explode(';', $_POST["image_data"][0]);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);	
	list(,$type)= explode('/', $type);
	//$name=$_POST["default_name"]."_".($i+1+$_POST["total_images"]).".$type";
	
	file_put_contents('tmp_images/'.$name, $data);	 
	//get_tcd(STRING_PATH,$name);	 
	
	*/
	if($action!="tcd_read"){
		$name=$_POST["default_name"];
		move_uploaded_file($_FILES["valueimage"]["tmp_name"][0], 'tmp_images/'.$name);
	}else{
		$name=$_GET["user"].'.doc';
	}
	/*for($i=0;$i<count($_FILES['valueimage']["tmp_name"]);$i++){
		// echo $_FILES["valueimage"]["tmp_name"][$i];
		//list(,$type)= explode('/', $_FILES['valueimage']["type"][$i]);
		$type=explode('.', $_POST['filetype'][$i]);
		// echo $type[count($type)-1]."/n";
		if($_POST["multi"]=="true"){
			$_FILES["upload"]["name"][$i]=$_POST["default_name"]."_".($i+1+$_POST["total_images"]).".".strtolower($type[count($type)-1]) ;		
		}else{
			$_FILES["upload"]["name"][$i]=$_POST["default_name"].".".strtolower($type[count($type)-1]) ;		
		}
		 $_FILES["upload"]["type"][$i]=$_FILES['valueimage']["type"][$i];		 
		 $_FILES["upload"]["tmp_name"][$i]=$_FILES["valueimage"]["tmp_name"][$i];
		 $_FILES["upload"]["error"][$i]=$_FILES["valueimage"]["error"][$i];
		 $_FILES["upload"]["size"][$i]=$_FILES["valueimage"]["size"][$i]; 	 
	}
	*/
	
	$Wrd->Application->Visible = 0;
	$Wrd->Documents->Add();
	$wdColorAqua = "13421619"; 	 
	$Wrd->Documents->Open(realpath(STRING_PATH."\\".$name)); // file nguoon    
	$para6edit="";
	if($Wrd->ActiveDocument->Paragraphs->count>6){	 
		if(!preg_match("/Mean:/",$Wrd->ActiveDocument->Paragraphs(6))){
			echo "wrong format";
			$Wrd->ActiveDocument->Close(true);
			$Wrd->Application->Quit();
			$Wrd = null;	
			return;
		}			 
	}
  	$para6 = $Wrd->ActiveDocument->Paragraphs(6).$Wrd->ActiveDocument->Paragraphs(7);
	$para6 = explode("	",$para6); 
	for($i=0;$i<count($para6);$i++){
		 //Phan lay cac chi so Mean:               
			 if( preg_match("/Mean:/",$para6[$i]) || preg_match("/Peak:/",$para6[$i]) || preg_match("/Dias:/",$para6[$i])){
				 $para6edit .= $para6[$i].";";		   
			 }
	}
	
	$array_=array("Mean:","Peak:","Dias:");
	$para6edit=str_ireplace($array_,"",$para6edit);
	echo str_ireplace ("	","",$para6edit);
	
	
	$para12edit="";
  	$para12 = $Wrd->ActiveDocument->Paragraphs(12).$Wrd->ActiveDocument->Paragraphs(13);
	$para12 = explode("	",$para12); 
	for($i=0;$i<count($para12);$i++){
		 //Phan lay cac chi so Mean:               
			 if( preg_match("/Mean:/",$para12[$i]) || preg_match("/Peak:/",$para12[$i]) || preg_match("/Dias:/",$para12[$i])){
				 $para12edit .= $para12[$i].";";		   
			 }
	}
	
	 
	$para12edit=str_ireplace($array_,"",$para12edit);
	echo str_ireplace ("	","",$para12edit);	
	//$Wrd->ActiveDocument->SaveAs($strPath."/".$DocName,9);
	$Wrd->ActiveDocument->Close(true);
	$Wrd->Application->Quit();
	$Wrd = null;	
}
function load_sign_by_id($id){
	$data= new SQLServer;//tao lop ket noi SQL
	$store_name="{call GD2_TABLEWITHPAGE_GETBY(?,?,?,?,?,?,?,?)}";//tao bien khai bao store
	$params = array('ID_NhanVien','0','1000000','ID_NhanVien','ASC','DM_Nhanvien'," ID_NhanVien='$id'",'*');//tao param cho store
	//print_r($params);
	$get_data=$data->query( $store_name, $params);//Goi store
	$excute= new SQLServerResult($get_data);//Ket noi lop xu ly SQL và truyen gia tri tra ve tu lop ket noi SQL
	$tam= $excute->get_as_array();//Tra ve mang toan bo data lay duoc 	
	//print_r($tam);
		foreach ($tam as $row) {//duyet toan bo mang tra ve
			$system_config=$row["HinhChuKy"];
		}  
		return $system_config;	
}
function CURL($link){
	$ch = curl_init(); 
	//Create a variable with the URL you want to "get".
	$URL =$link; 
	//Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	//Set the URL
	curl_setopt($ch, CURLOPT_URL, $URL); 
	//Execute the fetch
	$content = curl_exec($ch); 
	//Close the connection
	curl_close($ch); 
	return 	$content; 
}
function edit_tcd($Wrd){	
	print_r($_POST);	
	$Wrd->Application->Visible = 0;
	$Wrd->Documents->Add();
	//$DocName = "chinh1.mht";// file dich
	//$DocName = "chinh1.doc";// file dich
	$DocName =$_REQUEST["default_name"];
	$wdColorAqua = "13421619";  
	$wdColorBlack = "&H0";
	$wdColorRed = "&HFF"; 
	$Wrd->Documents->Open(realpath(STRING_PATH.$_REQUEST["default_name"])); // file nguoon
    $kt1 = 0; $kt2 = 0;
	$strPath = realpath(str_ireplace("/","\\\\", $_SERVER['DOCUMENT_ROOT'])."\\giaidoan2\\file_manager\\php\\tmp_images\\"); // C:/AppServ/www/myphp
	$wdAlignParagraphCenter = "1"; 
	$Wrd->Selection->PageSetup->TopMargin = "0";  
	//$pathPicLogo=str_ireplace("/","\\\\", $_SERVER['DOCUMENT_ROOT'])."\\giaidoan2\\images\\header_tcd.jpg";	
	$pathPicLogo=get_system_one_config("GD2_Default_Url")."images/header_tcd.jpg";	
	//echo $pathPicLogo;
	//$Wrd->InlineShapes->AddPicture($pathPicLogo);	  	
	//$Wrd->ActiveDocument->Sections(1)->Headers->Item(1)->Shapes->AddPicture($pathPicLogo);
	//$Wrd->Selection->PageSetup->LeftMargin = "2.8";  
	//$Wrd->Selection->PageSetup->RightMargin = "1";  
	$logo=$Wrd->ActiveDocument->Paragraphs(1)->Range->InlineShapes->AddPicture($pathPicLogo)->ConvertToShape;	 
	$logo->Left =0;
	$logo->Top =0;
	$Wrd->ActiveDocument->Paragraphs->Add();	 
	$para2 = $Wrd->ActiveDocument->Paragraphs(2);
	$Wrd->ActiveDocument->Paragraphs(2)->Range->Text="SIÊU ÂM DOPPLER XUYÊN SỌ".chr(13).$para2;	
	$Wrd->ActiveDocument->Paragraphs(2)->SpaceAfter = 10;
	$Wrd->ActiveDocument->Paragraphs(2)->SpaceBefore = 0;
	$Wrd->ActiveDocument->Paragraphs(2)->Range->ParagraphFormat->Alignment = $wdAlignParagraphCenter;  
	$Wrd->ActiveDocument->Paragraphs(2)->Range->Font->Name = "Arial";  	 
	$Wrd->ActiveDocument->Paragraphs(2)->Range->Font->Size = "20";	 
	$Wrd->ActiveDocument->Paragraphs(2)->Range->Font->Color=$wdColorAqua;	
	$Wrd->ActiveDocument->Paragraphs(3)->SpaceAfter = 10;	 
	$Wrd->ActiveDocument->Paragraphs(3)->Range->ParagraphFormat->Alignment = $wdAlignParagraphCenter;  	 
	$Wrd->ActiveDocument->Paragraphs(3)->Range->Font->Size = "10";	
	//$Wrd->ActiveDocument->Range($Wrd->ActiveDocument->Paragraphs(5)->Range->start, $Wrd->ActiveDocument->Paragraphs(6)->Range->end)->delete;	
	$Wrd->ActiveDocument->Range($Wrd->ActiveDocument->Paragraphs(16)->Range->start, $Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->end)->delete;	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->InsertParagraphAfter;	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceBefore = 10;	 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Size = "12";	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Color=$wdColorAqua;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Bold = True; 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Italic = True;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Name = "Arial";  
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text="MÔ TẢ".chr(13);	
	//$Wrd->ActiveDocument->Range($Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->start, $Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->end)->delete;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceAfter = 0;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceBefore = 0;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Size = "9";	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Color=$wdColorBlack;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Bold = False; 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Italic = True;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Name = "Arial"; 
	$dem=substr_count($_POST["mota1"], "<br>");
	$_POST["mota1"]=str_ireplace("<br>",chr(13),$_POST["mota1"]) ;
	$xacdinhpara=$Wrd->ActiveDocument->Paragraphs->count;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text=$_POST["mota1"].chr(13);
	clear_character($xacdinhpara,$dem,$Wrd,1);	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceBefore = 10;	 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Size = "12";	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Color=$wdColorAqua;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Bold = True; 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Italic = True;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Name = "Arial";  
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text="KẾT LUẬN".chr(13);
		
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceAfter = 0;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceBefore = 0;
	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text="";	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Size = "9";	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Color=$wdColorBlack;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Bold = False; 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Italic = True;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Name = "Arial";
	$dem=substr_count($_POST["ketluan1"], "<br>");
	$_POST["ketluan1"]=str_ireplace("<br>",chr(13),$_POST["ketluan1"]) ;
	$xacdinhpara=$Wrd->ActiveDocument->Paragraphs->count;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text=$_POST["ketluan1"].chr(13);
	clear_character($xacdinhpara,$dem,$Wrd,1);
	$xacdinhpara=$Wrd->ActiveDocument->Paragraphs->count;	 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text="                                                                                                                                                   In từ dữ liệu gốc".chr(13);
	
	 
	 
	$xacdinhpara=$Wrd->ActiveDocument->Paragraphs->count;		 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text="                                                                                                                                          "."Ngày ".  date("d")." tháng " . date("m")." năm " .  date("Y").chr(13);
	 //$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Delete;
	
	$xacdinhpara=$Wrd->ActiveDocument->Paragraphs->count;	 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceAfter = 0;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceBefore = 0;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Size = "10";	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Color=$wdColorBlack;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Bold = true; 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Italic = false;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Name = "Arial"; 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text="                       BÁC SỸ                                                                                       KỸ THUẬT VIÊN".chr(13);	
	//$Wrd->ActiveDocument->Range($Wrd->ActiveDocument->Paragraphs($xacdinhpara)->Range->start,$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->end)->Delete;		 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Delete;
	 
	 
	
	
	/*$WTable = $Wrd->ActiveDocument->Tables->Add($Wrd->Selection->Range, 2, 1); // Colums, Rows 
	$WTable->Cell(2,1)->Range->Text = "In từ dữ liệu gốc";*/
	/*$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text="                                                                                                                                                                       ";
	$wrdPic=$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->InlineShapes->AddPicture($chukybacsy,false,true);
	$wrdPic->ScaleHeight = 50;
    $wrdPic->ScaleWidth = 50;*/
	
	if($_POST["chukyktv"]!=""){		
		//$link=get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?tenthumuc=".get_system_one_config("GD2_PathToStaffSignImages")."&answer=42&cmd=file&target="."f1_".base64_encode($_POST["chukybacsy"]);
		//echo get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?tenthumuc=".get_system_one_config("GD2_PathToStaffSignImages")."&answer=42&cmd=file&target="."f1_".base64_encode(load_sign_by_id($_POST["chukybacsy"]));
		//file_put_contents('tmp_images/'.$_POST["chukybacsy"].".jpg", CURL($link)); 
		$chukyktv=get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?tenthumuc=".get_system_one_config("GD2_PathToStaffSignImages")."&answer=42&cmd=file&target="."f1_".base64_encode(load_sign_by_id($_POST["chukyktv"]));
		$hinhanh= CURL($chukyktv);
		if($hinhanh!="File not found"){
			file_put_contents('tmp_images/'.$_POST["chukyktv"].'.jpg',$hinhanh);	 
			$wrdPic=$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->InlineShapes->AddPicture(realpath(STRING_PATH.$_POST["chukyktv"].'.jpg'),false,true)->ConvertToShape;	 
			$wrdPic->Left =360;
			$wrdPic->top =20;
			$wrdPic->Width  = 50;
			$wrdPic->Height = 50;
			unlink('test.html');
		}	
	}	
	 
	if($_POST["chukybacsy"]!=""){		
		//$link=get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?tenthumuc=".get_system_one_config("GD2_PathToStaffSignImages")."&answer=42&cmd=file&target="."f1_".base64_encode($_POST["chukybacsy"]);
		//echo get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?tenthumuc=".get_system_one_config("GD2_PathToStaffSignImages")."&answer=42&cmd=file&target="."f1_".base64_encode(load_sign_by_id($_POST["chukybacsy"]));
		//file_put_contents('tmp_images/'.$_POST["chukybacsy"].".jpg", CURL($link)); 
		$chukybacsy=get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?tenthumuc=".get_system_one_config("GD2_PathToStaffSignImages")."&answer=42&cmd=file&target="."f1_".base64_encode(load_sign_by_id($_POST["chukybacsy"]));
		$hinhanh= CURL($chukybacsy);
		if($hinhanh!="File not found"){
			file_put_contents('tmp_images/'.$_POST["chukybacsy"].'.jpg', CURL($chukybacsy));		 
			$wrdPic=$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->InlineShapes->AddPicture(realpath(STRING_PATH.$_POST["chukybacsy"].'.jpg'),false,true)->ConvertToShape;	 
			$wrdPic->Left =50;
			$wrdPic->top =20;
			$wrdPic->Width  = 50;
			$wrdPic->Height = 50;	 
		}
	}
	$Wrd->ActiveDocument->Paragraphs->Add();	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceAfter = 20;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceBefore = 0;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Size = "10";	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Color=$wdColorRed;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Bold = true; 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Italic = false;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Name = "Arial"; 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text=$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count).chr(13)."             ".$_POST["chucdanhbacsy"]." ".$_POST["tenbacsy"]."                                                                                ".$_POST["chucdanhktv"]." ".$_POST["tenktv"].chr(13);	
	//$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Delete;
	
	$Wrd->ActiveDocument->SaveAs($strPath."/".str_ireplace(".doc",".mht",$DocName),9);
	$Wrd->ActiveDocument->Close(true);
	$Wrd->Application->Quit();
	$Wrd = null;	 
	//print_r($_POST);
	//echo $_REQUEST["tenthumuc"]; 
	sleep(1);
	
	//echo 	$_FILES["upload"]["size"][1];
	$_FILES["upload"]["name"][0]=str_ireplace(".doc",".mht",$DocName);
	$_FILES["upload"]["type"][0]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][0]=STRING_PATH.str_ireplace(".doc",".mht",$DocName);
	$_FILES["upload"]["error"][0]="0";
	$_FILES["upload"]["size"][0]=filesize('tmp_images/'.str_ireplace(".doc",".mht",$DocName));
	
	$_FILES["upload"]["name"][1]=$DocName;
	$_FILES["upload"]["type"][1]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][1]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][1]="0";
	$_FILES["upload"]["size"][1]=filesize('tmp_images/'.$DocName);
	//print_r($_FILES);	
}
function clear_character($xacdinhpara,$dem,$Wrd,$line){
	if($Wrd->ActiveDocument->Paragraphs->count>($xacdinhpara+$dem+$line)){
		$start= $Wrd->ActiveDocument->Paragraphs($xacdinhpara+$dem+$line)->Range->start;
		$end=  $Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->end;
		$Wrd->ActiveDocument->Range($start,$end-1)->Delete;	
	}
}
function create_name($string){	
	$str= stringUnUtf8($string);
	$strArray= explode("-",$str); 
	//echo count($strArray);
	$tam="";
	for($i=0;$i<=count($strArray)-2;$i++){
		$tam.= strtoupper(substr($strArray[$i],0,1))." ";		
	}
	 $tam.= strtoupper($strArray[$i]);	
	 return $tam;
}
function create_username($string){	
	$str= stringUnUtf8($string);
	$strArray= explode("-",$str); 
	//echo count($strArray);
	$tam="";
	for($i=0;$i<=count($strArray)-2;$i++){
		$tam.= substr($strArray[$i],0,1);		
	}
	 $tam.= $strArray[$i];	
	 return $tam;
}

function stringUnUtf8($string)
	{
		$trans = array(
			"đ"=>"d","ă"=>"a","â"=>"a","á"=>"a","à"=>"a","ả"=>"a","ã"=>"a","ạ"=>"a",
			"ấ"=>"a","ầ"=>"a","ẩ"=>"a","ẫ"=>"a","ậ"=>"a",
			"ắ"=>"a","ằ"=>"a","ẳ"=>"a","ẵ"=>"a","ặ"=>"a",
			"é"=>"e","è"=>"e","ẻ"=>"e","ẽ"=>"e","ẹ"=>"e",
			"ế"=>"e","ề"=>"e","ể"=>"e","ễ"=>"e","ệ"=>"e",
			"í"=>"i","ì"=>"i","ỉ"=>"i","ĩ"=>"i","ị"=>"i",
			"ư"=>"u","ô"=>"o","ơ"=>"o","ê"=>"e",
			"Ư"=>"u","Ô"=>"o","Ơ"=>"o","Ê"=>"e",
			"ú"=>"u","ù"=>"u","ủ"=>"u","ũ"=>"u","ụ"=>"u",
			"ứ"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ự"=>"u",
			"ó"=>"o","ò"=>"o","ỏ"=>"o","õ"=>"o","ọ"=>"o",
			"ớ"=>"o","ờ"=>"o","ở"=>"o","ỡ"=>"o","ợ"=>"o",
			"ố"=>"o","ồ"=>"o","ổ"=>"o","ỗ"=>"o","ộ"=>"o",
			"ú"=>"u","ù"=>"u","ủ"=>"u","ũ"=>"u","ụ"=>"u",
			"ứ"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ự"=>"u",'ý'=>'y','ỳ'=>'y','ỷ'=>'y','ỹ'=>'y','ỵ'=>'y', 'Ý'=>'Y','Ỳ'=>'Y','Ỷ'=>'Y','Ỹ'=>'Y','Ỵ'=>'Y',
			"Đ"=>"D","Ă"=>"A","Â"=>"A","Á"=>"A","À"=>"A","Ả"=>"A","Ã"=>"A","Ạ"=>"A",
			"Ấ"=>"A","Ầ"=>"A","Ẩ"=>"A","Ẫ"=>"A","Ậ"=>"A",
			"Ắ"=>"A","Ằ"=>"A","Ẳ"=>"A","Ẵ"=>"A","Ặ"=>"A",
			"É"=>"E","È"=>"E","Ẻ"=>"E","Ẽ"=>"E","Ẹ"=>"E",
			"Ế"=>"E","Ề"=>"E","Ể"=>"E","Ễ"=>"E","Ệ"=>"E",
			"Í"=>"I","Ì"=>"I","Ỉ"=>"I","Ĩ"=>"I","Ị"=>"I",
			"Ư"=>"U","Ô"=>"O","Ơ"=>"O","Ê"=>"E",
			"Ư"=>"U","Ô"=>"O","Ơ"=>"O","Ê"=>"E",
			"Ú"=>"U","Ù"=>"U","Ủ"=>"U","Ũ"=>"U","Ụ"=>"U",
			"Ứ"=>"U","Ừ"=>"U","Ử"=>"U","Ữ"=>"U","Ự"=>"U",
			"Ó"=>"O","Ò"=>"O","Ỏ"=>"O","Õ"=>"O","Ọ"=>"O",
			"Ớ"=>"O","Ờ"=>"O","Ở"=>"O","Ỡ"=>"O","Ợ"=>"O",
			"Ố"=>"O","Ồ"=>"O","Ổ"=>"O","Ỗ"=>"O","Ộ"=>"O",
			"Ú"=>"U","Ù"=>"U","Ủ"=>"U","Ũ"=>"U","Ụ"=>"U",
			"Ứ"=>"U","Ừ"=>"U","Ử"=>"U","Ữ"=>"U","Ự"=>"U",'"'=>'');		 
			$str = str_replace('-', ' ', $string);
			$str = strtr($str, $trans);		 
			//$str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $str);			 
			//$str = trim(strtolower($str));
			return $str;
}
function substr_unicode($str, $s, $l = null) {
	return join("", array_slice(preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}
 
function get_system_one_config($value){
	$data= new SQLServer;//tao lop ket noi SQL
	$store_name="{call GD2_TABLEWITHPAGE_GETBY(?,?,?,?,?,?,?,?)}";//tao bien khai bao store
	$params = array('VarName','0','1000000','VarName','ASC','SysVars'," VarName='$value'",'*');//tao param cho store
	//print_r($params);
	$get_danh_muc_phong_ban=$data->query( $store_name, $params);//Goi store
	$excute= new SQLServerResult($get_danh_muc_phong_ban);//Ket noi lop xu ly SQL và truyen gia tri tra ve tu lop ket noi SQL
	$tam= $excute->get_as_array();//Tra ve mang toan bo data lay duoc 	
	//print_r($tam);
		foreach ($tam as $row) {//duyet toan bo mang tra ve
			$system_config=$row["DefaultValue"];
		}  
		return $system_config;
}
function convert_date($string){
	if($string==''){
		return $string;
	}
	if(preg_match("/\ /",$string)){
		$tam=explode(" ",$string);		 
		if(mb_strlen($tam[0])>mb_strlen($tam[1])){			 
			$tam1=explode($_SESSION["config_system"]["phancachngay"],$tam[0]); 
			return $_SESSION["config_system"]["nam"].$tam1[2]."-".$tam1[1]."-".$tam1[0]." ".$tam[1];			
		}else{		 
			$tam1=explode($_SESSION["config_system"]["phancachngay"],$tam[1]); 
			return $_SESSION["config_system"]["nam"].$tam1[2]."-".$tam1[1]."-".$tam1[0]." ".$tam[0];			
		}				 
	}else{
		$tam1=explode($_SESSION["config_system"]["phancachngay"],$string); 
		return $_SESSION["config_system"]["nam"].$tam1[2]."-".$tam1[1]."-".$tam1[0];
	}
}
function taoconfig(){
	
	
	$_SESSION["config_system"]["GD2_EXE_TCD"]=get_system_one_config("GD2_EXE_TCD"); 
	$_SESSION["config_system"]["GD2_TCD_DATA_ACCESS"]=get_system_one_config("GD2_TCD_DATA_ACCESS");
	
    $_SESSION["config_system"]["GD2_IP_FileZila"]=get_system_one_config("GD2_IP_FileZila"); 
    $_SESSION["config_system"]["GD2_UserName_FileZila"]=get_system_one_config("GD2_UserName_FileZila"); 
    $_SESSION["config_system"]["GD2_Pass_FileZila"]=get_system_one_config("GD2_Pass_FileZila"); 
    
	$_SESSION["config_system"]["Signs"]=get_system_one_config("GD2_PathToStaffSignImages");	
	$_SESSION["config_system"]["Staff"]=get_system_one_config("GD2_PathToStaffImages"); 
	$_SESSION["config_system"]["URL"]=get_system_one_config("GD2_Default_Url"); 
	$_SESSION["config_system"]["ngaythang"]=get_system_one_config("ShortFormaStringtNgayThangNamGD2"); 
	$_SESSION["config_system"]["dauthapphan"]=get_system_one_config("DinhdangDauThapPhan");	
	if($_SESSION["config_system"]["dauthapphan"]=='.'){
		$_SESSION["config_system"]["dauhangngan"]=',';
	}else if($_SESSION["config_system"]["dauthapphan"]==','){
		$_SESSION["config_system"]["dauhangngan"]='.';
	}
	if(preg_match("/\-/",$_SESSION["config_system"]["ngaythang"])){
		$_SESSION["config_system"]["phancachngay"]="-";
	}else{
		$_SESSION["config_system"]["phancachngay"]="/";				
	}			
	if(preg_match("/[y]/",$_SESSION["config_system"]["ngaythang"])){
		$_SESSION["config_system"]["nam"]="20";
		$_SESSION["config_system"]["namUI"]="y";
		$_SESSION["config_system"]["namEntry"]="Y";
		$_SESSION["config_system"]["namDatejs"]="yy";
	}else{
		$_SESSION["config_system"]["nam"]="";
		$_SESSION["config_system"]["namUI"]="yy";
		$_SESSION["config_system"]["namEntry"]="y";
		$_SESSION["config_system"]["namDatejs"]="yyyy";				
	}		 
	$_SESSION["namhethong"]=2013;
    $_SESSION["GD2ChoPhepSuaKhiDaHoanTat"]=get_system_one_config("GD2ChoPhepSuaKhiDaHoanTat"); 
	$ngayJqueryUi="dd".$_SESSION["config_system"]["phancachngay"]."mm".$_SESSION["config_system"]["phancachngay"].$_SESSION["config_system"]["namUI"];
	$ngayDateEntry="dm".$_SESSION["config_system"]["namEntry"].$_SESSION["config_system"]["phancachngay"];	
	$ngayDatejs="dd".$_SESSION["config_system"]["phancachngay"]."MM".$_SESSION["config_system"]["phancachngay"].$_SESSION["config_system"]["namDatejs"];
	$ngayJqgrid="d".$_SESSION["config_system"]["phancachngay"]."m".$_SESSION["config_system"]["phancachngay"].$_SESSION["config_system"]["namUI"];	 
	echo "<script type='text/javascript'>\r		 
		$.cookie('Windowpluginversion', '".get_system_one_config("Windowpluginversion")."');\r 
		$.cookie('phancachngay', '".$_SESSION["config_system"]["phancachngay"]."');\r 	
		$.cookie('ngayJqueryUi', '".$ngayJqueryUi."');\r 
	 	$.cookie('ngayDateEntry', '".$ngayDateEntry."');\r 
		$.cookie('ngayDatejs', '".$ngayDatejs."');\r
		$.cookie('ngayJqgrid', '".$ngayJqgrid."');\r
		$.cookie('namjs', '".$_SESSION["config_system"]["nam"]."');\r	
		$.cookie('remote_ip', '".$_SERVER['REMOTE_ADDR']."');\r	";
		if(preg_match("/Window/",$_SERVER['HTTP_USER_AGENT'])){
			echo "$.cookie('os', 'win');\r";
	  		$_SESSION["config_system"]["OS"]="win";
		}else {
			$_SESSION["config_system"]["OS"]="linux";			 
			$data= new SQLServer;//tao lop ket noi SQL
			$params = array('Id_auto',0,1000000,'Id_auto','ASC','GD2_PC_Printer_Linux',"IP  = '192.168.2.107'",'*');//tao param cho store 
			$store_name="{call GD2_TABLEWITHPAGE_GETBY (?,?,?,?,?,?,?,?)}";//tao bien khai bao store
			$get=$data->query($store_name, $params);//Goi store
			$excute= new SQLServerResult($get);//Ket noi lop xu ly SQL và truyen gia tri tra ve tu lop ket noi SQL
			$tam= $excute->get_as_array();
			$printers="";
			$i=0;			 
			foreach ($tam as $rows) {				
				$printers.=$rows['TenMayIn']."::";
				$i++;
			}			 
			echo "$.cookie('printers', '$printers');\r";	
		}		 	
		echo "$.cookie('Signs', '".$_SESSION['config_system']['Signs']."');\r";	
		echo "$.cookie('GD2_EXE_TCD', '".$_SESSION['config_system']['GD2_EXE_TCD']."');\r";	
		echo "$.cookie('GD2_TCD_DATA_ACCESS', '".$_SESSION['config_system']['GD2_TCD_DATA_ACCESS']."');\r";		
	echo "</script>\r";
}

function convert_comma_dot($inputA){	
//echo "chinh";
	if($_SESSION["config_system"]["dauthapphan"]=="."){
		return $inputA;
	};	
	$array=  array (".",",");
	$tam=str_ireplace($array,"",$inputA);
	
	if (!is_numeric($tam)) {
		return $inputA;
	}
	if(preg_match("/\./",$inputA)){
		return str_ireplace(".",",",$inputA);
	}else if(preg_match("/\,/",$inputA)){
		return str_ireplace(",",".",$inputA);					
	}else{	
		return $inputA;
	}	 
}


function convert_comma_dot_insert($inputA){	
	$inputA=str_ireplace(".","",$inputA);
	$inputA=str_ireplace(",",".",$inputA);
	

		return $inputA;
	 
}

function convert_comma_donthuoc($inputA){	
	
	$inputA=str_ireplace(",",".",$inputA);
	//$inputA=str_ireplace(".","",$inputA);

		return $inputA;
	 
}

   function SelectAllByGioiTinhLoaiChiSo($IsMale,$LoaiChiSo)
                {
    
                    $SQLServer= new SQLServer;
                    $storename='{call spFraminghamScores_SelectAllByGioiTinhLoaiChiSo (?,?)}';
                    $params =array($IsMale,$LoaiChiSo);    
                    $get_Framingham=$SQLServer->query($storename, $params);
                    $excute= new SQLServerResult($get_Framingham);
                    $array_return= $excute->get_as_array();
                    return $array_return ;
                }
                
                function  GetPointScore($GiaTriDeSoSanh,$IsMale,$LoaiChiSo)
                {
                    $point1=0;
                        $dmFraminghamScore= SelectAllByGioiTinhLoaiChiSo($IsMale,$LoaiChiSo);
                        foreach($dmFraminghamScore as $itemFraminghamScore )
                    {
                        if (($GiaTriDeSoSanh >=  $itemFraminghamScore['CanDuoi']) && ($GiaTriDeSoSanh <= $itemFraminghamScore['CanTren']))
                        {
                            $point1   =$itemFraminghamScore['Points'];
                            break;
                        }
                    }
                    return $point1;

                }
                
                function SelectAllByLoaiChiSoOptions($LoaiChiSo,$IsMale,$IsSmoker,$Isdiabetes,$IsTreated,$IsLVH,$IsCHD,$IsValve,$IsDiabetesValve,$IsSex,$IsCigs,$IsCVD,$IsAF,$IsMummer,$IsHF)
                {
                    $SQLServer= new SQLServer;
                    $storename='{call spFraminghamScores_SelectAllByLoaiChiSoOptions (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}';
                    $params =array($LoaiChiSo,$IsMale,$IsSmoker,$Isdiabetes,$IsTreated,$IsLVH,$IsCHD,$IsValve,$IsDiabetesValve,$IsSex,$IsCigs,$IsCVD,$IsAF,$IsMummer,$IsHF);    
                    $get_Framingham=$SQLServer->query($storename, $params);
                    $excute= new SQLServerResult($get_Framingham);
                    $array_return= $excute->get_as_array();
                    return $array_return ;
                }
                function GetPointScoreByOption($LoaiChiSo,$IsMale,$IsSmoker,$Isdiabetes,$IsTreated,$IsLVH,$IsCHD,$IsValve,$IsDiabetesValve,$IsSex,$IsCigs,$IsCVD,$IsAF,$IsMummer,$IsHF)
                {
                    $point=0;
                     $dmFraminghamScore= SelectAllByLoaiChiSoOptions($LoaiChiSo,$IsMale,$IsSmoker,$Isdiabetes,$IsTreated,$IsLVH,$IsCHD,$IsValve,$IsDiabetesValve,$IsSex,$IsCigs,$IsCVD,$IsAF,$IsMummer,$IsHF);
                    foreach($dmFraminghamScore as $itemFraminghamScore )
                    {
                        
                       if (($itemFraminghamScore != null) && (count($itemFraminghamScore) > 0))
                        {
                            $point   =$itemFraminghamScore['Points'];
                            break;
                        }
                    }
                    return $point;
                    
                }
                function GetPointScore2($GiaTriDeSoSanh,$LoaiChiSo,$IsMale,$IsSmoker,$Isdiabetes,$IsTreated,$IsLVH,$IsCHD,$IsValve,$IsDiabetesValve,$IsSex,$IsCigs,$IsCVD,$IsAF,$IsMummer,$IsHF)
                 {
                  $point=0;
                     
                       $dmFraminghamScore= SelectAllByLoaiChiSoOptions($LoaiChiSo,$IsMale,$IsSmoker,$Isdiabetes,$IsTreated,$IsLVH,$IsCHD,$IsValve,$IsDiabetesValve,$IsSex,$IsCigs,$IsCVD,$IsAF,$IsMummer,$IsHF);
                
                      
                        foreach($dmFraminghamScore as $itemFraminghamScore )
                    {
                        if (($GiaTriDeSoSanh >=  $itemFraminghamScore['CanDuoi']) && ($GiaTriDeSoSanh <= $itemFraminghamScore['CanTren']))
                        {
                            $point   =$itemFraminghamScore['Points'];
                            break;
                        }
                    }
                    return $point;
                          
                      
                    
                }
                function SelectPercentByPoints($LoaiChiSo,$IsMale,$TotalScore)
                {
                    $SQLServer= new SQLServer;
                    $storename='{call GD2_spFraminghamScoreTotal_SelectByPoints (?,?,?)}';
                    $params =array($LoaiChiSo,$IsMale,$TotalScore);  
                    $get_Framingham=$SQLServer->query($storename, $params);
                    $excute= new SQLServerResult($get_Framingham);
                    $array_return= $excute->get_as_array();
                    return $array_return[0]['PercentScore'] ;
                }
                function Framingham_Data_GetPaRaIn_PlusBMI($para_array_Framingham_Data)
{
    $cong=0;
   foreach($para_array_Framingham_Data as $values2)
    {
     $BMI=round($values2['Weight']*10000/( $values2['High']* $values2['High']),1);
     $para_array_Framingham_Data[$cong]['BMI']=$BMI;
     $para_array_Framingham_Data[$cong][]=$BMI;
    
     //HardCoronary10Year CHD10Y Lấy các chỉ số CHD10Y
     $TextAge_CVD=(GetPointScore($values2['Age'],$values2['Men'],'CVD'));
     $para_array_Framingham_Data[$cong]['TextAge_CVD']=$TextAge_CVD;
     $para_array_Framingham_Data[$cong][]=$TextAge_CVD;
     
     $TextSmoker_CVD = GetPointScoreByOption('CVDCommon',$values2['Men'],$values2['Smoker'], null, null, null, null, null, null, null, null, null, null, null, null);
     $para_array_Framingham_Data[$cong]['TextSmoker_CVD']=$TextSmoker_CVD;
     $para_array_Framingham_Data[$cong][]=$TextSmoker_CVD;
     
     $TextDiabet_CVD = GetPointScoreByOption('CVDCommonDiabet',$values2['Men'], null, $values2['DIABET'], null, null, null, null, null, null, null, null, null, null, null);
     $para_array_Framingham_Data[$cong]['TextDiabet_CVD']=$TextDiabet_CVD;
     $para_array_Framingham_Data[$cong][]=$TextDiabet_CVD;
     
     $TextCHO_CVD = GetPointScore($values2['CHOL_Total'],$values2['Men'],'CVDCHOL');
     $para_array_Framingham_Data[$cong]['TextCHO_CVD']=$TextCHO_CVD;
     $para_array_Framingham_Data[$cong][]=$TextCHO_CVD;
     
     $TextHDL_CVD = GetPointScore($values2['CHOL_HDL'],$values2['Men'],'CVDHDL');
     $para_array_Framingham_Data[$cong]['TextHDL_CVD']=$TextHDL_CVD;
     $para_array_Framingham_Data[$cong][]=$TextHDL_CVD;
     
     $TextSBP_CVD = GetPointScore2($values2['SBP'],'CVDSBP',$values2['Men'], null, null, $values2['Treated'],null, null, null, null, null, null, null, null, null, null);
     $para_array_Framingham_Data[$cong]['TextSBP_CVD']=$TextSBP_CVD;
     $para_array_Framingham_Data[$cong][]=$TextSBP_CVD;
     //Total và percent
     $TextTotal_CVD=assignIfNotEmpty($TextAge_CVD,0)+assignIfNotEmpty($TextSmoker_CVD,0)
             +assignIfNotEmpty($TextDiabet_CVD,0)+assignIfNotEmpty($TextCHO_CVD,0)
             +assignIfNotEmpty($TextHDL_CVD,0)+assignIfNotEmpty($TextSBP_CVD,0);
 
     
      $para_array_Framingham_Data[$cong]['TextTotal_CVD']=$TextTotal_CVD;
      $para_array_Framingham_Data[$cong][]=$TextTotal_CVD;
   
     IF($values2['Men']==1)//NAM 
            if($TextTotal_CVD>=18)
           {
                $TextPercent_CVD ='>30%';
           }
         elseif($TextTotal_CVD<=-3)
         {
              $TextPercent_CVD ='<1%';
         }    
         else
         {
             $TextPercent_CVD=SelectPercentByPoints('cvd',$values2['Men'],$TextTotal_CVD).'%';
         }
        ELSE//NỮ
        {
            if($TextTotal_CVD>=21)
           {
                $TextPercent_CVD ='>30%';
           }
         elseif($TextTotal_CVD<=-2)
         {
              $TextPercent_CVD ='<1%';
         }    
         else
         {
             $TextPercent_CVD=SelectPercentByPoints('cvd',$values2['Men'],$TextTotal_CVD).'%';
         }
        }
     $para_array_Framingham_Data[$cong]['TextPercent_CVD']=$TextPercent_CVD;
     $para_array_Framingham_Data[$cong][]=$TextPercent_CVD;
     
     //TÍNH CHO NGƯỜI BÌNH THƯỜNG KHÔNG BIẾT VÌ SAO ($TextAge_CVD,0) + 1 + (-1) + 1;
     
      $NTextTotal_CVD = assignIfNotEmpty($TextAge_CVD,0) + 1 + (-1) + 1;
      $para_array_Framingham_Data[$cong]['NTextTotal_CVD']=$NTextTotal_CVD;
      $para_array_Framingham_Data[$cong][]=$NTextTotal_CVD;
      
      $NTextPercent_CVD=SelectPercentByPoints('cvd',$values2['Men'],$NTextTotal_CVD).'%';
      $para_array_Framingham_Data[$cong]['NTextPercent_CVD']=$NTextPercent_CVD;
      $para_array_Framingham_Data[$cong][]=$NTextPercent_CVD;
      //TÍNH CHO NGƯỜI BÌNH THƯỜNG
     
      //***Over***Over***HardCoronary10Year CHD10Y ***Over***Over
      
      
      //Congestive Heart Failure(4Y)-CHF

       $TextAge_CHF=(GetPointScore($values2['Age'],$values2['Men'],'CHF'));
       $para_array_Framingham_Data[$cong]['TextAge_CHF']=$TextAge_CHF;
       $para_array_Framingham_Data[$cong][]=$TextAge_CHF;
      
       
        IF($values2['Men']!=1)//chỉ tính điểm này cho nữ
        {
               $TextBMI_CHF=(GetPointScore($BMI,$values2['Men'],'CHFBMI'));
               $para_array_Framingham_Data[$cong]['TextBMI_CHF']=$TextBMI_CHF;
               $para_array_Framingham_Data[$cong][]=$TextBMI_CHF;
        }
        
        $TextSBP_CHF=(GetPointScore($values2['SBP'],$values2['Men'],'CHFSBP'));
        $para_array_Framingham_Data[$cong]['TextSBP_CHF']=$TextSBP_CHF;
        $para_array_Framingham_Data[$cong][]=$TextSBP_CHF;
        
        $TextHrate_CHF=(GetPointScore($values2['HRate'],$values2['Men'],'CHFHR'));
        $para_array_Framingham_Data[$cong]['TextHrate_CHF']=$TextHrate_CHF;
        $para_array_Framingham_Data[$cong][]=$TextHrate_CHF;
        
         if($values2['CHD']==1)
         {           
         $TextCHD_CHF=(GetPointScoreByOption('CHFCommon',$values2['Men'],null, null, null, null, $values2['CHD'], null, null, null, null, null, null, null, null));
         }
        else { $TextCHD_CHF=0;
        }
         $para_array_Framingham_Data[$cong]['TextCHD_CHF']=$TextCHD_CHF;
         $para_array_Framingham_Data[$cong][]=$TextCHD_CHF;
         
         if($values2['LVH']==1)
         {           
         $TextLVH_CHF=(GetPointScoreByOption('CHFCommon',$values2['Men'],null, null, null, null, $values2['LVH'], null, null, null, null, null, null, null, null));
         }
        else { $TextLVH_CHF=0;
        }
         $para_array_Framingham_Data[$cong]['TextLVH_CHF']=$TextLVH_CHF;
         $para_array_Framingham_Data[$cong][]=$TextLVH_CHF;
         
         
         if($values2['Valve']==1)
         {           
         $TextValve_CHF=(GetPointScoreByOption('CHFCommon',$values2['Men'],null, null, null, null, $values2['Valve'], null, null, null, null, null, null, null, null));
         }
        else { $TextValve_CHF=0;
        }
         $para_array_Framingham_Data[$cong]['TextValve_CHF']=$TextValve_CHF;
         $para_array_Framingham_Data[$cong][]=$TextValve_CHF;
         
          if($values2['DIABET'] == 1)
         {           
         $TextDiabet_CHF=(GetPointScoreByOption('CHFCommon',$values2['Men'],null, true, null,null, null,null,null, null, null, null, null, null, null));
         
         }
        else { $TextDiabet_CHF=0;
        }
         $para_array_Framingham_Data[$cong]['TextDiabet_CHF']=$TextDiabet_CHF;
         $para_array_Framingham_Data[$cong][]=$TextDiabet_CHF;
       
        //Tông cổng và %
        //TextTotal_CHF = TextAge_CHF + TextSBP_CHF + TextSBP_AF + TextHrate_CHF + TextCHD_CHF 
        //+ TextLVH_CHF + TextValve_CHF + TextDiabet_CHF
       $TextTotal_CHF=assignIfNotEmpty($TextAge_CHF,0)+assignIfNotEmpty($TextSBP_CHF,0)
             +assignIfNotEmpty($TextHrate_CHF,0)+assignIfNotEmpty($TextCHD_CHF,0)
             +assignIfNotEmpty($TextLVH_CHF,0)+assignIfNotEmpty($TextValve_CHF,0)+assignIfNotEmpty($TextDiabet_CHF,0);
       $para_array_Framingham_Data[$cong]['TextTotal_CHF']=$TextTotal_CHF;
       $para_array_Framingham_Data[$cong][]=$TextTotal_CHF;
       
       
       IF($values2['Men']==1)
       {//NAM 
            if($TextTotal_CHF>=30)
           {
                $TextPercent_CHF ='>59%';
           }
           else
           {
                If ($TextTotal_CHF < 5) {
                 $TextPercent_CHF = "<1%";
                }
                else
                {
                          
                        $TextPercent_CHF = SelectPercentByPoints('CHF',$values2['Men'],$TextTotal_CHF).'%';
                     
                }
           }
        
         
         $NTextTotal_CHF = $TextAge_CHF + 1 + 3;
       }
        ELSE//NỮ
        {
       
          $NTextTotal_CHF = $TextAge_CHF + 1 + 1 + 1;
        }
        
        $para_array_Framingham_Data[$cong]['TextPercent_CHF']=$TextPercent_CHF;
         $para_array_Framingham_Data[$cong][]=$TextPercent_CHF;
        
         $para_array_Framingham_Data[$cong]['NTextTotal_CHF']=$NTextTotal_CHF;
         $para_array_Framingham_Data[$cong][]=$NTextTotal_CHF;
         
         
         $NTextPercent_CHF=  SelectPercentByPoints('CHF',$values2['Men'],$NTextTotal_CHF).'%';
         $para_array_Framingham_Data[$cong]['NTextPercent_CHF']=$NTextPercent_CHF;
         $para_array_Framingham_Data[$cong][]=$NTextPercent_CHF;
         
         
         
       
      //*********Over****************Congestive Heart Failure(4Y)*********************
      
      
      
   
     return $para_array_Framingham_Data;
    }
}
 function assignIfNotEmpty(&$item, $alternative)
{
    return (!empty($item)) ? $item : $alternative;
}
?>