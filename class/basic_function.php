<?php 
/*function escapeSingleQuotes($string){ 
return str_ireplace("'",'"',$string); 
}*/
date_default_timezone_set("Asia/Ho_Chi_Minh"); 
function createmenu($a,$menu,$b){
      $d=0;
      foreach($menu as $key=>$row){
        if($row['idParent']==$a){
            if($row['idParent']==''){

                echo '<li class="has-sub"><a class="'.$row['TenControl'].'" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.$row['TieuDeControl'].'</a><ul>'; 
                unset($menu[$key]);
                createmenu($row['idControl'],$menu,$row['TenControl']); 
                echo '</ul></li>'; 
            }else{

              if($a>0){
                  if($row['idParent']==$a){
					 // if($row['PageOpen']==true){
						$class='tab_form';  
					 // }else{
					//	$class='modal_form';   
					 // }
                    echo ' <li id="resource.php?module='.$b.'&view='. $row['TenControl'].'&id_form='.$row['idControl'].'&id_loai=0" class="'.$row['TenControl'].' '.$class.'" lang="0" role="100:100" >'.$row['TieuDeControl'].'</li>';
                    unset($menu[$key]);
                  }
              }else{
                //  echo ' <li><a class="'.$row['pageopen'].'" href="#" onClick="menu_openform('.$row['PageOpen'].',1)">'.$row['Caption'].'</a></li>';
                  unset($menu[$key]);
              }
            }
        }
		
      }//end for
   }//end func

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
function custom_images_pttt(){	 
	$chuoi="";
	list(,$idkham,)= explode('_', $_POST["default_name"]);
	//for($i=0;$i<count($_POST["image_data"]);$i++){
		//list($type, $data) = explode(';', $_POST["imaedit_pdf_ecgge_data"][$i]);
		list($type, $data) = explode(';', $_POST["image"]);
		//echo $type;
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);	 
		list(,$type)= explode('/', $type);
		$name=$_POST["default_name"].".$type";
		$chuoi.=$name.";";	 
		file_put_contents('tmp_images/'.$name, $data);
		$_FILES["upload"]["name"][0]=$name;
		$_FILES["upload"]["type"][0]="image\/$type";
		//$_FILES["upload"]["tmp_name"][$i]="D:\\xampp\\htdocs\\giaidoan2\\file_manager\\php\\tmp_images\\$name"; //119677_319762_63_559_2
		$_FILES["upload"]["tmp_name"][0]=STRING_PATH.$name;
		$_FILES["upload"]["error"][0]="0";
		$_FILES["upload"]["size"][0]=filesize('tmp_images/'.$name);
		//echo "$type";
		//$chuoi+=$name+";";
		//echo $chuoi;
	//}
	//print_r	($chuoi);	
	$nam_val=explode('_', $_POST["default_name"]);// 119677_119762_559
	
	$data= new SQLServer;
	$store_name="{call [GD2_KhamUpDuongDanHinh_PhauThuat] (?,?,?)}";
	$bien=  array($nam_val[1],$nam_val[2],$name);	
	print_r($params);
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
function load_ecg_pdf(){	 
	$URL =get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?profile=tcd&tenthumuc=".$_GET["tenthumuc"]."&answer=42&cmd=file&target=".$_GET["target"]; 
	$URL1 =get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?profile=tcd&tenthumuc=".$_GET["tenthumuc"]."&answer=42&cmd=file&target=".$_GET["target1"]; 	
	$content=CURL_load($URL);
	$content1=CURL_load($URL1);	 
	file_put_contents('tmp_images/'.$_GET["default_name"], $content);
	file_put_contents('tmp_images/'."raw".$_GET["default_name"], $content1);
	if(($content=="File not found")||($content=='{"error":["errConf","errNoVolumes"],"debug":["Driver \"elFinderVolumeFTP\" : Root folder does not exists."]}')){
		 echo "File not found";
	}		 
	
}
function CURL_load($link){
	$ch = curl_init(); 
	//Create a variable with the URL you want to "get".
	$URL =$link;	
	echo $URL; //Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	//Set the URL
	curl_setopt($ch, CURLOPT_URL, $URL); 
	//Execute the fetch
	$content = curl_exec($ch); 
	//Close the connection
	curl_close($ch); 	 
	//$content = file_get_contents('http://www.nchmf.gov.vn/web/vi-VN/43/Default.aspx');
	//echo $content;	
	return $content;	 	 
	
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
	//print_r($Wrd->ActiveDocument->Content);
	//echo "=============";
	//print_r($Wrd->ActiveDocument->Content);
	//echo "=============";
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
	$store_name="{call HIS_TableWithPage_GetBy(?,?,?,?,?,?,?,?)}";//tao bien khai bao store
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
function save_ecg_pdf(){
	//print_r($_FILES);
	$DocName =$_REQUEST["default_name"];
	move_uploaded_file($_FILES["valueimage"]["tmp_name"][0], 'tmp_images/'.$DocName);
	//move_uploaded_file($_FILES["valueimage"]["tmp_name"][0], 'tmp_images/'."raw".$DocName);		
	$_FILES["upload"]["name"][1]=$DocName;
	$_FILES["upload"]["type"][1]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][1]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][1]="0";	
	$_FILES["upload"]["size"][1]=filesize('tmp_images/'.$DocName);	
	
	$_FILES["upload"]["name"][2]="raw".$DocName;
	$_FILES["upload"]["type"][2]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][2]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][2]="0";
	$_FILES["upload"]["size"][2]=filesize('tmp_images/'.$DocName);	
}
function save_holter_pdf(){
	//print_r($_FILES);
	$DocName =$_REQUEST["default_name"];
	move_uploaded_file($_FILES["valueimage"]["tmp_name"][0], 'tmp_images/'.$DocName);
	//move_uploaded_file($_FILES["valueimage"]["tmp_name"][0], 'tmp_images/'."raw".$DocName);		
	$_FILES["upload"]["name"][1]=$DocName;
	$_FILES["upload"]["type"][1]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][1]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][1]="0";	
	$_FILES["upload"]["size"][1]=filesize('tmp_images/'.$DocName);	
	
	$_FILES["upload"]["name"][2]="raw".$DocName;
	$_FILES["upload"]["type"][2]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][2]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][2]="0";
	$_FILES["upload"]["size"][2]=filesize('tmp_images/'.$DocName);	
}
function edit_pdf_ecg(){
	//print_r($_POST);
	 
	$default_url=get_system_one_config("GD2_Default_Url");
	$sign_path=get_system_one_config("GD2_PathToStaffSignImages");
	
	
	$DocName =$_REQUEST["default_name"];
	$id_kham=explode("_",$DocName);
	$data= new SQLServer;//tao lop ket noi SQL
	$params1 = array($id_kham[1]);//tao param cho store 
	$store_name1="{call GD2_GetKhamById_Kham(?)}";//tao bien khai bao store
	$get_thongtinluotkham=$data->query( $store_name1,$params1);//Goi store
	$excute1= new SQLServerResult($get_thongtinluotkham);//Ket noi lop xu ly SQL và truyen gia tri tra ve tu lop ket noi SQL
	$thongtinluotkham= $excute1->get_as_array();//Tra ve mang toan bo data lay duoc
	
	
	//move_uploaded_file($_FILES["valueimage"]["tmp_name"][0], 'tmp_images/'.$DocName);	
	require_once('mpdf/mpdf.php');
	if(($_POST["loai_ecg"]==2)||($_POST["loai_ecg"]==3)||($_POST["loai_ecg"]==4)){
		$mpdf=new mPDF('','A4-L','','',0,0,0,0,0,0); 
	}elseif(($_POST["loai_ecg"]==6) || ($_POST["loai_ecg"]==7)){
		$mpdf=new mPDF('','A4','','',0,0,0,0,0,0); // nam edit tam 
	}
	$mpdf->SetImportUse();	
	$mpdf->SetDisplayMode('fullpage');	
	$mpdf->SetCompression(false);
	$pagecount=$mpdf->SetSourceFile(STRING_PATH."raw".$DocName);
	//echo $pagecount;	
	/*if(count($mpdf->pages)>1){ 
		$tplIdx = $mpdf->importPage(2);
	}else if(count($mpdf->pages)==1){
		$tplIdx = $mpdf->importPage(1);
	}*/
	
	if(($_POST["loai_ecg"]==2)||($_POST["loai_ecg"]==3)||($_POST["loai_ecg"]==4)||($_POST["loai_ecg"]==6)){			
		dientimdidong($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path,$pagecount);	 
	}
	$_FILES["upload"]["name"][1]=$DocName;
	$_FILES["upload"]["type"][1]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][1]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][1]="0";
	$_FILES["upload"]["size"][1]=filesize('tmp_images/'.$DocName);
}

function dientimdidong($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path,$tongsotrang){	
	//print_r($thongtinluotkham);
	if(($_POST["loai_ecg"]==2)||($_POST["loai_ecg"]==4)){	
		$tplIdx = $mpdf->importPage(2);	
		$mpdf->useTemplate($tplIdx, 5, -5, 290);
		//if($_POST["mabn"]=='89045'){
			$html = '
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:11px;	position: fixed; left: 0mm; rotate: -90; font-size:10px;margin-left:17px; top:60px;	">
				 	style="letter-spacing: 0.5px;text-transform:uppercase">'.$_POST["tenbv"].'</span> - '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'
				</div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:20px;
						width:100%;
						text-align:center;
						margin-top:-37px;				 
						height:50px;">
						<div style="margin-top:25px;"><b>'.$thongtinluotkham[0]["ReportName"].'</b></div><div style="margin-top:5px;font-size:13px;font-family:Arial, Geneva, sans-serif;"><b>Họ tên: </b>'.$_POST["tenbn"].'   <b> - Mã BN: </b>'.$_POST["mabn"].'</div></div>';
						
				if($thongtinluotkham[0]["chuky_bacsy_daidien"]==''){// Neu khong phai BS doi
					$html.='
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;				 
						top: 80px;
						left:730px;
						position:absolute;
						height:70px; 					
						width:220px;
						z-index:1000px;"><div style="width:220px; padding-left:5px;"><b>Chẩn đoán: </b><br>'.$_POST["ketluan1"].'</div></div>
					<div style="top: 100px;
							right:10px;
							position:absolute;
							height:89px; 	
							width:200px;
							z-index:1000px;
							background:#fff;"></div>				

					<div style="top: 100px;
							right:50px;
							position:absolute;
							height:50px;
							z-index:1001px;
							text-align:center;">'.'<img style="height:50px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0]["chuky_bacsy"]).'">'.'<br><div style="font-family:Arial, Geneva, sans-serif;
							font-size:11px;
							font-weight:bold;">'.$thongtinluotkham[0]["BsChanDoan"].'</div></div>';
				}else{
					$html.='
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;				 
						top: 80px;
						left:730px;
						position:absolute;
						height:70px;
						width:110px;
						z-index:1000px;"><div style="width:110px; padding-left:5px;"><b>Chẩn đoán: </b><br>'.$_POST["ketluan1"].'</div></div>
					<div style="top: 100px;
							right:10px;
							position:absolute;
							height:89px; 	
							width:200px;
							z-index:1000px;
							background:#fff;"></div>	
					<div style="top: 100px;
							right:60px;
							position:absolute;
							height:50px; 						 
							z-index:1001px;
							font-size:11px;
							text-align:center;">
							BS tham vấn<br>
							<img style="height:50px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0]["chuky_bacsy"]).'">'.'<br><div style="font-family:Arial, Geneva, sans-serif;
							font-size:11px;	
							font-weight:bold;">'.$thongtinluotkham[0]["BsChanDoan"].'</div></div>				
					</div>
					<div style="top: 100px;
							right:210px;
							position:absolute;
							height:50px; 						 
							z-index:1001px;
							font-size:11px;
							text-align:center;">
							BS Chính<br>
							<img style="height:50px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0]["chuky_bacsy_daidien"]).'">'.'<br><div style="font-family:Arial, Geneva, sans-serif;
							font-size:11px;	
							font-weight:bold;">'.$thongtinluotkham[0]["BsDaiDien"].'</div></div>				
					</div>
					';
				}
				
		/* }else{
		$html = '
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:11px;	position: fixed; left: 0mm; rotate: -90; font-size:10px;margin-left:17px; top:60px;	">
				 	 <span style="letter-spacing: 0.5px;text-transform:uppercase">'.$_POST["tenbv"].'</span> - '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'
				</div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:20px;
						width:100%;					 
						text-align:center;
						margin-top:-37px;					 
						height:45px;	">
						<div style="margin-top:20px;"><b>'.$thongtinluotkham[0]["ReportName"].'</b></div><div style="margin-top:5px;font-size:13px;font-family:Arial, Geneva, sans-serif;"><b>Họ tên: </b>'.$_POST["tenbn"].'   <b> - Mã BN: </b>'.$_POST["mabn"].'</div></div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;				 
						top: 80px;
						left:660px;
						position:absolute;
						height:70px; 					
						width:390px;
						z-index:1000px;"><div style="width:220px"><b>Chẩn đoán: </b>'.$_POST["ketluan1"].'</div></div>
				<div style="top: 80px;
						left:880px;
						position:absolute;
						height:50px; 						 
						z-index:1001px;">'.'<img style="margin-left:10px;width:80px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br><div style="font-family:Arial, Geneva, sans-serif;
						font-size:11px;	
						font-weight:bold;">'.$thongtinluotkham[0]["BsChanDoan"].'</div></div>				
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:9px;	
						position:absolute;
						top: 703px;
						left:730px;
						z-index:1002;">'."Ngày in ".date("d/m/Y").'</div>
				 '
				;	
		
		 }*/
				$mpdf->SetXY(30, 10);
				
				
				
			$mpdf->WriteHTML($html);
	}elseif($_POST["loai_ecg"]==3){	
		$tplIdx = $mpdf->importPage(1);	
		$mpdf->useTemplate($tplIdx, 5, -5, 290);
		$html = '
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:11px;	position: fixed; left: 0mm; rotate: -90; font-size:10px;margin-left:17px; top:60px;	">
				 	<span style="letter-spacing: 0.5px;text-transform:uppercase">'.$_POST["tenbv"].'</span> - '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'
				</div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:20px;
						width:100%;					 
						text-align:center;
						margin-top:-37px;					 
						height:45px;	">
						<div style="margin-top:20px;"><b>'.$thongtinluotkham[0]["ReportName"].'</b></div><div style="margin-top:5px;font-size:13px;font-family:Arial, Geneva, sans-serif;"><b>Họ tên: </b>'.$_POST["tenbn"].'   <b> - Mã BN: </b>'.$_POST["mabn"].'</div></div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;				 
						top: 80px;
						left:660px;
						position:absolute;
						height:70px; 					
						width:390px;
						z-index:1000px;"><div style="width:220px"><b>Chẩn đoán: </b>'.$_POST["ketluan1"].'</div></div>
				<div style="top: 80px;
						left:880px;
						position:absolute;
						height:50px; 						 
						z-index:1001px;">'.'<img style="margin-left:10px;width:80px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br><div style="font-family:Arial, Geneva, sans-serif;
						font-size:11px;	
						font-weight:bold;">'.$thongtinluotkham[0]["BsChanDoan"].'</div></div>				
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:9px;	
						position:absolute;
						top: 703px;
						left:730px;
						z-index:1002;">'."Ngày in ".date("d/m/Y").'</div>
				 '
				;	
				$mpdf->SetXY(30, 10);
			$mpdf->WriteHTML($html);
	}else if($_POST["loai_ecg"]==6){
		$tplIdx = $mpdf->importPage(1);
		$mpdf->useTemplate($tplIdx, 3, -7,220 );// 2,3: padding file pdf cuoi cung la width
		$mpdf->SetXY(30, 10);
		$html = '
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:11px;	position: fixed; left: 0mm; rotate: -90; font-size:10px;margin-left:10px; top:300px;	">
				 	<span style="letter-spacing: 0.5px;text-transform:uppercase">'.$_POST["tenbv"].'</span> - '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'
				</div>
				<div style="background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:22px;
						font-weight:bold;
						width:91%;					 
						text-align:center;
						margin-top:-25px;
						margin-left:51px;					 
						height:70px;">
						<div style="margin-top:10px;"><b>'.$thongtinluotkham[0]["ReportName"].'</b></div>
						</div>
				<div style="top:85px;
						left:215px;
						background:#fff;
						position:absolute;
						height:20px;				
						width:170px;
						font-size:16px;
						z-index:1001px;
						font-family:sans-serif;
						padding-left:2px;
						">'.$thongtinluotkham[0]["HoLotBenhNhan"].'
				</div>
				<div style="top:105px;
						left:215px;
						background:#fff;
						position:absolute;
						height:20px; 					
						width:170px;
						font-size:16px;
						z-index:1001px;
						font-family:sans-serif;
						padding-left:2px;
						">'.$thongtinluotkham[0]["TenBenhNhan"].'
				</div>
				<div style="top:141px;
						left:215px;
						background:#fff;
						position:absolute;
						height:20px; 					
						width:170px;
						font-size:16px;
						z-index:1001px;
						padding-left:2px;
						font-family:sans-serif;">'.$_POST["mabn"].'
				</div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:12px;				 
						bottom: 60px;
						left:468px;
						position:absolute;
						height:200px; 					
						width:270px;
						padding-left:6px;
						z-inde:1000px;">
					<div style="width:270px">
						<h2 style="padding-bottom:2px; margin-bttom:2px;">Chẩn đoán: </h2>'.$_POST["ketluan1"].'
					</div>
				</div>
				<div style="bottom: 95px;
						left:490px;
						position:absolute;
						height:50px; 						 
						z-index:1001px;">'.'<img style="margin-left:10px;width:90px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br>
						<div style="font-family:Arial, Geneva, sans-serif;
									font-size:11px;	
									font-weight:bold;">
									'.$thongtinluotkham[0]["BsChanDoan"].'
						</div>
				</div>				
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:9px;	
						position:absolute;
						top: 703px;
						left:730px;
						display:none;
						z-index:1002;">'."Ngày in ".date("d/m/Y").'
				</div>';
			
			$mpdf->WriteHTML($html);		 
	}else if($_POST["loai_ecg"]==7){
		for ($pageNo = 1; $pageNo <= 7; $pageNo++) {
			$tplIdx = $mpdf->importPage($pageNo);
		
			// add a page
			$mpdf->AddPage();
			//$mpdf->useTemplate($tplIdx, null, null, 0, 0, true);
			$mpdf->useTemplate($tplIdx, 5, -10,235 );
		
			// now write some text above the imported page
			$mpdf->SetXY(30, 10);
			
		//	$mpdf->Write(5, 'THIS IS JUST A TEST');
		
		
		//$mpdf->useTemplate($tplIdx, 5, -5,235 );
			$html = '<div style="font-family:Arial, Geneva, sans-serif;
							font-size:11px;	position: fixed; left: 0mm; rotate: -90; font-size:10px;margin-left:17px; top:60px;	">
						<span style="letter-spacing: 0.5px;text-transform:uppercase">'.$_POST["tenbv"].'</span> - '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'
					</div>
					<div style="background:#FFF;
							font-family:Arial, Geneva, sans-serif;
							font-size:22px;
							font-weight:bold;
							width:85%;					 
							text-align:center;
							margin-top:-25px;
							margin-left:60px;					 
							height:50px;">
							<div style="margin-top:5px;"><b>'.$thongtinluotkham[0]["ReportName"].'</b></div>
							</div>
					';
			$mpdf->WriteHTML($html);
		}
	}
	//$mpdf->Output($DocName, 'I');
	$mpdf->Output(STRING_PATH.$DocName, 'F');
	
}
function dientimdidongXXX($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path){	
	//print_r($thongtinluotkham);
	if(($_POST["loai_ecg"]==2)||($_POST["loai_ecg"]==4)||($_POST["loai_ecg"]==3)){			
		$tplIdx = $mpdf->importPage(2);	
		$mpdf->useTemplate($tplIdx, 5, -5, 290);
		$html = '
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:11px;	position: fixed; left: 0mm; rotate: -90; font-size:10px;margin-left:17px; top:60px;	">
				 	 <span style="letter-spacing: 0.5px;text-transform:uppercase">'.$_POST["tenbv"].'</span> - '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'
				</div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:20px;
						width:100%;					 
						text-align:center;
						margin-top:-37px;					 
						height:45px;	"><div style="margin-top:20px;"><b>'.$thongtinluotkham[0]["ReportName"].'</b></div><div style="margin-top:5px;font-size:13px;font-family:Arial, Geneva, sans-serif;"><b>Họ tên: </b>'.$_POST["tenbn"].'   <b> - Mã BN: </b>'.$_POST["mabn"].'</div></div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;				 
						top: 80px;
						left:680px;
						position:absolute;
						height:100px; 					
						width:390px;
						z-index:1000px;"><div style="width:250px"><b>Chẩn đoán: </b>'.$_POST["ketluan1"].'</div></div>
				<div style="top: 95px;
						left:920px;
						position:absolute;
						height:50px; 						 
						z-index:1001px;">'.'<img style="margin-left:10px;width:90px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br><div style="font-family:Arial, Geneva, sans-serif;
						font-size:11px;	
						font-weight:bold;">'.$thongtinluotkham[0]["BsChanDoan"].'</div></div>				
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:9px;	
						position:absolute;
						top: 703px;
						left:730px;
						z-index:1002;">'."Ngày in ".date("d/m/Y").'</div>
				 '
				;	
				$mpdf->SetXY(30, 10);
			$mpdf->WriteHTML($html);
	}else if($_POST["loai_ecg"]==6){
		$tplIdx = $mpdf->importPage(1);
		$mpdf->useTemplate($tplIdx, -10, -15,235 );
		$mpdf->SetXY(30, 10);
		$html = '
		<div style="font-family:Arial, Geneva, sans-serif;
				font-size:11px;	position: fixed; left: 0mm; rotate: -90; font-size:10px;margin-left:15px; top:55px;	">
			<span style="letter-spacing: 0.5px;text-transform:uppercase">'.$_POST["tenbv"].'</span> - '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'
		</div>
		<div style="background:#FFF;
				font-family:Arial, Geneva, sans-serif;
				font-size:22px;
				font-weight:bold;
				width:84%;					 
				text-align:center;
				margin-top:15px;
				margin-left:72px;					 
				height:70px;">
				<div style="margin-top:10px;"><b>'.$thongtinluotkham[0]["ReportName"].'</b></div>
				</div>
		<div style="top:120px;
				left:224px;
				background:#fff;
				position:absolute;
				height:20px;				
				width:170px;
				font-size:16px;
				z-index:1001px;
				font-family:sans-serif;
				">'.$thongtinluotkham[0]["HoLotBenhNhan"].'
		</div>
		<div style="top:137px;
				left:224px;
				background:#fff;
				position:absolute;
				height:20px; 					
				width:170px;
				font-size:16px;
				z-index:1001px;
				font-family:sans-serif;
				">'.$thongtinluotkham[0]["TenBenhNhan"].'
		</div>
		<div style="top:173px;
				left:224px;
				background:#fff;
				position:absolute;
				height:20px; 					
				width:170px;
				font-size:16px;
				z-index:1001px;
				font-family:sans-serif;">'.$_POST["mabn"].'
		</div>
		<div style="background:#FFF;
				font-family:Arial, Geneva, sans-serif;
				font-size:12px;				 
				bottom: 60px;
				left:455px;
				position:absolute;
				height:200px; 					
				width:270px;
				padding-left:6px;
				z-inde:1000px;">
			<div style="width:260px">
				<h2 style="padding-bottom:2px; margin-bttom:2px;">Chẩn đoán: </h2>'.$_POST["ketluan1"].'
			</div>
		</div>
		<div style="bottom: 95px;
				left:490px;
				position:absolute;
				height:50px; 						 
				z-index:1001px;">'.'<img style="margin-left:10px;width:90px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br>
				<div style="font-family:Arial, Geneva, sans-serif;
							font-size:11px;	
							font-weight:bold;">
							'.$thongtinluotkham[0]["BsChanDoan"].'
				</div>
		</div>				
		<div style="font-family:Arial, Geneva, sans-serif;
				font-size:9px;	
				position:absolute;
				top: 703px;
				left:730px;
				display:none;
				z-index:1002;">'."Ngày in ".date("d/m/Y").'
		</div>';
	
	$mpdf->WriteHTML($html);	
		/*$tplIdx = $mpdf->importPage(1);
		$mpdf->useTemplate($tplIdx, 5, -5,235 );
		$html = '
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:11px;	position: fixed; left: 0mm; rotate: -90; font-size:10px;margin-left:17px; top:60px;	">
				 	 <span style="letter-spacing: 0.5px;text-transform:uppercase">'.$_POST["tenbv"].'</span> - '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'
				</div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:22px;
						font-weight:bold;
						width:85%;					 
						text-align:center;
						margin-top:-15px;
						margin-left:60px;					 
						height:70px;">
						<div style="margin-top:10px;"><b>'.$thongtinluotkham[0]["ReportName"].'</b></div>
						</div>
				<div style="top:93px;
						left:220px;
						background:#fff;
						position:absolute;
						height:20px;				
						width:170px;
						font-size:16px;
						z-index:1001px;
						font-family:sans-serif;
						">'.$thongtinluotkham[0]["HoLotBenhNhan"].'
				</div>
				<div style="top:109px;
						left:220px;
						background:#fff;
						position:absolute;
						height:20px; 					
						width:170px;
						font-size:16px;
						z-index:1001px;
						font-family:sans-serif;
						">'.$thongtinluotkham[0]["TenBenhNhan"].'
				</div>
				<div style="top:146px;
						left:220px;
						background:#fff;
						position:absolute;
						height:20px; 					
						width:170px;
						font-size:16px;
						z-index:1001px;
						font-family:sans-serif;">'.$_POST["mabn"].'
				</div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:12px;				 
						bottom: 60px;
						left:470px;
						position:absolute;
						height:200px; 					
						width:270px;
						z-inde:1000px;"><div style="width:260px"><h2 style="padding-bottom:2px; margin-bttom:2px;">Chẩn đoán: </h2>'.$_POST["ketluan1"].'</div></div>
				<div style="bottom: 95px;
						left:520px;
						position:absolute;
						height:50px; 						 
						z-index:1001px;">'.'<img style="margin-left:10px;width:90px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br><div style="font-family:Arial, Geneva, sans-serif;
						font-size:11px;	
						font-weight:bold;">'.$thongtinluotkham[0]["BsChanDoan"].'</div></div>				
				<div style="font-family:Arial, Geneva, sans-serif;
						font-size:9px;	
						position:absolute;
						top: 703px;
						left:730px;
						display:none;
						z-index:1002;">'."Ngày in ".date("d/m/Y").'</div>
				 '
				;			 
	}
	// nam edit 18/5
	//$mpdf->useTemplate($tplIdx, 5, -5, 290);
	
//	$mpdf->SetFont('helvetica', '',6);		 
	//$mpdf->SetTextColor(0, 0, 0);
	$mpdf->SetXY(30, 10);	 
	
	$mpdf->WriteHTML($html);	*/
	//$mpdf->Output($DocName, 'I');
	$mpdf->Output(STRING_PATH.$DocName, 'F');
	}
}

function edit_pdf_holter(){
	//print_r($_POST);
	$default_url=get_system_one_config("GD2_Default_Url");
	$sign_path=get_system_one_config("GD2_PathToStaffSignImages");
	
	
	$DocName =$_REQUEST["default_name"];
	$id_kham=explode("_",$DocName);
	$data= new SQLServer;//tao lop ket noi SQL
	$params1 = array($id_kham[1]);//tao param cho store 
	$store_name1="{call GD2_GetKhamById_Kham(?)}";//tao bien khai bao store
	$get_thongtinluotkham=$data->query( $store_name1,$params1);//Goi store
	$excute1= new SQLServerResult($get_thongtinluotkham);//Ket noi lop xu ly SQL và truyen gia tri tra ve tu lop ket noi SQL
	$thongtinluotkham= $excute1->get_as_array();//Tra ve mang toan bo data lay duoc
	
	require_once('mpdf/mpdf.php');
	$mpdf=new mPDF('','A4','','',0,0,0,0,0,0); 

	$mpdf->SetImportUse();	
	$mpdf->SetDisplayMode('fullpage');	
	$mpdf->SetCompression(false);
	$pagecount=$mpdf->SetSourceFile(STRING_PATH."raw".$DocName);
		
	holter($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path);	 
	$_FILES["upload"]["name"][1]=$DocName;
	$_FILES["upload"]["type"][1]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][1]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][1]="0";
	$_FILES["upload"]["size"][1]=filesize('tmp_images/'.$DocName);
}
function holter($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path){	
	for ($pageNo = 1; $pageNo <= 7; $pageNo++) {
		$tplIdx = $mpdf->importPage($pageNo);
	
		// add a page
		$mpdf->AddPage();
		$mpdf->useTemplate($tplIdx, null, null, 0, 0, true);

	
		// now write some text above the imported page
		$mpdf->SetXY(20, 10);
		
	//	$mpdf->Write(5, 'THIS IS JUST A TEST');
	
	
	//$mpdf->useTemplate($tplIdx, 5, -5,235 );
		$html = '<div style="font-family:Arial, Geneva, sans-serif;
							font-size:11px;
							position: fixed;
							left: 0mm;
							rotate: -90;
							font-size:10px;
							margin-left:10px;
							top:60px;
							">
						<span style="letter-spacing: 0.5px;text-transform:uppercase">'.$_POST["tenbv"].'</span> - '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'
					</div>
					<div style="bottom: 55px;
						left:700px;
						position:absolute;
						text-align:right;
						background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;
						font-weight:bold;
						width:40px;					 				 
						height:15px;">
						<div style="margin-top:5px;">'.$pageNo.'</div>
					</div>
					<div style="bottom: 55px;
						left:200px;
						position:absolute;
						text-align:right;
						background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;
						font-weight:bold;
						width:500px;					 				 
						height:15px;">
						<div style="margin-top:5px;"></div>
					</div>
					';
		if($pageNo==1){
			$html.='<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						width:85%;					 
						text-align:center;
						margin-top:-65px;
						margin-left:60px;					 
						height:10px;">
						<h2 style="padding-top:2px;">'.$thongtinluotkham[0]["ReportName"].'</h2>
					</div>
					<div style="top:170px;
						left:140px;
						background:#fff;
						position:absolute;
						height:20px; 					
						width:100px;
						font-size:10px;
						z-index:1001px;
						font-family:sans-serif;">'.$_POST["mabn"].'
					</div>
					<div style="top:183px;
						left:140px;
						background:#fff;
						position:absolute;
						height:20px;				
						width:135px;
						font-size:10px;
						z-index:1001px;
						font-family:sans-serif;
						">'.$thongtinluotkham[0]["HoLotBenhNhan"].'
				</div>
				<div style="top:196px;
						left:140px;
						background:#fff;
						position:absolute;
						height:20px; 					
						width:135px;
						font-size:10px;
						z-index:1001px;
						font-family:sans-serif;
						">'.$thongtinluotkham[0]["TenBenhNhan"].'
				</div>
				';	
		}
		if($pageNo==7){
			$html.='<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:12px;				 
						bottom: 150px;
						left:470px;
						position:absolute;
						height:200px; 					
						width:270px;
						z-inde:1000px;">
					<div style="width:260px">
						<h2 style="padding-bottom:2px; margin-bttom:2px;">Chẩn đoán</h2>'.$_POST["ketluan1"].'
					</div>
				</div>
				<div style="bottom: 185px;
						left:470px;
						position:absolute;
						height:50px; 						 
						z-index:1001px;">'.'<img style="margin-left:10px;width:90px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br>
						<div style="font-family:Arial, Geneva, sans-serif;
									font-size:11px;	
									font-weight:bold;">
									'.$thongtinluotkham[0]["BsChanDoan"].'
						</div>
				</div>';	
		}
		$mpdf->WriteHTML($html);
	}
	$mpdf->Output(STRING_PATH.$DocName, 'F');
	
}


function edit_pdf_holter_new(){
	//print_r($_POST);
	$default_url=get_system_one_config("GD2_Default_Url");
	$sign_path=get_system_one_config("GD2_PathToStaffSignImages");
	
	
	$DocName =$_REQUEST["default_name"];
	$id_kham=explode("_",$DocName);
	$data= new SQLServer;//tao lop ket noi SQL
	$params1 = array($id_kham[1]);//tao param cho store 
	$store_name1="{call GD2_GetKhamById_Kham(?)}";//tao bien khai bao store
	$get_thongtinluotkham=$data->query( $store_name1,$params1);//Goi store
	$excute1= new SQLServerResult($get_thongtinluotkham);//Ket noi lop xu ly SQL và truyen gia tri tra ve tu lop ket noi SQL
	$thongtinluotkham= $excute1->get_as_array();//Tra ve mang toan bo data lay duoc
	
	require_once('mpdf/mpdf.php');
	$mpdf=new mPDF('','A4','','',0,0,0,0,0,0); 

	$mpdf->SetImportUse();	
	$mpdf->SetDisplayMode('fullpage');	
	$mpdf->SetCompression(false);
	$pagecount=$mpdf->SetSourceFile(STRING_PATH."raw".$DocName);
		
	holter_new($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path);	 
	$_FILES["upload"]["name"][1]=$DocName;
	$_FILES["upload"]["type"][1]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][1]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][1]="0";
	$_FILES["upload"]["size"][1]=filesize('tmp_images/'.$DocName);
}
function holter_new($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path){	
	for ($pageNo = 1; $pageNo <= 8; $pageNo++) {
		$tplIdx = $mpdf->importPage($pageNo);
	
		// add a page
		$mpdf->AddPage();
		$mpdf->useTemplate($tplIdx, null, null, 0, 0, true);

	
		// now write some text above the imported page
		$mpdf->SetXY(20, 10);
		
	//	$mpdf->Write(5, 'THIS IS JUST A TEST');
	
	
	//$mpdf->useTemplate($tplIdx, 5, -5,235 );
		$html = '<div style="font-family:Arial, Geneva, sans-serif;
							font-size:11px;
							position: fixed;
							left: 0mm;
							rotate: -90;
							font-size:10px;
							margin-left:0px;
							top:250px;
							">
						<span style="letter-spacing: 0.5px;text-transform:uppercase">'.$_POST["tenbv"].'</span> - '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'
					</div>
					<div style="bottom: 55px;
						left:700px;
						position:absolute;
						text-align:right;
						background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;
						font-weight:bold;
						width:40px;					 				 
						height:15px;">
						<div style="margin-top:5px;">'.$pageNo.'</div>
					</div>
					<div style="bottom: 55px;
						left:200px;
						position:absolute;
						text-align:right;
						background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;
						font-weight:bold;
						width:500px;					 				 
						height:15px;">
						<div style="margin-top:5px;"></div>
					</div>
					<div style="top:5px;
						left:5px;
						background:#fff;
						position:absolute;
						height:160px;				
						width:100%;
						font-size:10px;
						z-index:1001px;
						font-family:sans-serif;
						"></div>
					';
		if($pageNo==1){
			$html.='<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						width:85%;					 
						text-align:center;
						margin-top:20px;
						margin-left:60px;					 
						height:40px;z-index:2001px">
						<h2 style="padding-top:2px;">'.$thongtinluotkham[0]["ReportName"].'</h2>
					</div>
					<div style="top:203px;
						left:140px;
						background:#fff;
						position:absolute;
						height:20px; 					
						width:100px;
						font-size:13px;
						z-index:1001px;
						font-family:sans-serif;">'.$_POST["mabn"].'
					</div>
					<div style="top:219px;
						left:140px;
						background:#fff;
						position:absolute;
						height:20px;				
						width:135px;
						font-size:13px;
						z-index:1001px;
						font-family:sans-serif;
						">'.$thongtinluotkham[0]["HoLotBenhNhan"].'
				</div>
				<div style="top:235px;
						left:140px;
						background:#fff;
						position:absolute;
						height:20px; 					
						width:135px;
						font-size:13px;
						z-index:1001px;
						font-family:sans-serif;
						">'.$thongtinluotkham[0]["TenBenhNhan"].'
				</div>
				<div style="background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:12px;				 
						bottom: 260px;
						left:380px;
						position:absolute;
						height:200px; 					
						width:370px;
						z-inde:1000px;">
					<div style="width:370px">
						<div style="padding-bottom:2px; margin-bttom:2px;font-size:18px;
									font-weight:bold;">Chẩn đoán</div>'.$_POST["ketluan1"].'
					</div>
				</div>
				<div style="bottom: 300px;
						left:380px;
						position:absolute;
						height:50px; 						 
						z-index:1001px;">'.'<img style="margin-left:10px;width:90px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br>
						<div style="font-family:Arial, Geneva, sans-serif;
									font-size:11px;	
									font-weight:bold;">
									'.$thongtinluotkham[0]["BsChanDoan"].'
						</div>
				</div>';	
		}
		$mpdf->WriteHTML($html);
	}
	$mpdf->Output(STRING_PATH.$DocName, 'F');
	
}

// DO Luong Nhi
function save_pdf_do_luongnhi(){
	//print_r($_FILES);
	$DocName =$_REQUEST["default_name"];
	move_uploaded_file($_FILES["valueimage"]["tmp_name"][0], 'tmp_images/'.$DocName);
	//move_uploaded_file($_FILES["valueimage"]["tmp_name"][0], 'tmp_images/'."raw".$DocName);		
	$_FILES["upload"]["name"][1]=$DocName;
	$_FILES["upload"]["type"][1]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][1]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][1]="0";	
	$_FILES["upload"]["size"][1]=filesize('tmp_images/'.$DocName);	
	
	$_FILES["upload"]["name"][2]="raw".$DocName;
	$_FILES["upload"]["type"][2]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][2]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][2]="0";
	$_FILES["upload"]["size"][2]=filesize('tmp_images/'.$DocName);	
}

function edit_pdf_do_luongnhi(){
	//print_r($_POST);
	 $default_url=get_system_one_config("GD2_Default_Url");
	$sign_path=get_system_one_config("GD2_PathToStaffSignImages");
	
	
	$DocName =$_REQUEST["default_name"];
	$id_kham=explode("_",$DocName);
	$data= new SQLServer;//tao lop ket noi SQL
	$params1 = array($id_kham[1]);//tao param cho store 
	$store_name1="{call GD2_GetKhamById_Kham(?)}";//tao bien khai bao store
	$get_thongtinluotkham=$data->query( $store_name1,$params1);//Goi store
	$excute1= new SQLServerResult($get_thongtinluotkham);//Ket noi lop xu ly SQL và truyen gia tri tra ve tu lop ket noi SQL
	$thongtinluotkham= $excute1->get_as_array();//Tra ve mang toan bo data lay duoc
	
	require_once('mpdf/mpdf.php');
	$mpdf=new mPDF('','A4','','',0,0,0,0,0,0); 
	//$mpdf = new mPDF('utf-8', array(800,800));
	//$mpdf=new mPDF('utf-8', 'A4-L');
	$mpdf->SetImportUse();	
	$mpdf->SetDisplayMode('fullpage');	
	$mpdf->SetCompression(false);
	$pagecount=$mpdf->SetSourceFile(STRING_PATH."raw".$DocName);
		
	pdf_do_luongnhi($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path);	 
	$_FILES["upload"]["name"][1]=$DocName;
	$_FILES["upload"]["type"][1]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][1]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][1]="0";
	$_FILES["upload"]["size"][1]=filesize('tmp_images/'.$DocName); 
}

function pdf_do_luongnhi($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path){	
	//for ($pageNo = 1; $pageNo <= 1; $pageNo++) {
		$pageNo=1;
		$tplIdx = $mpdf->importPage($pageNo);
	
		// add a page
		$mpdf->AddPage();
		$mpdf->useTemplate($tplIdx, null, null, 0, 0, true);
		//$mpdf ->useTemplate($tplIdx, null, null, 215.6, 350.9,FALSE);
		//$mpdf->useTemplate($tplIdx, 0, -5,235 );
		$mpdf->SetXY(10, 0);
		
	//$mpdf->useTemplate($tplIdx, 5, -5,235 );
		$html = '<div style="font-family:Arial, Geneva, sans-serif;
							background:#fff;
							position: fixed;
							left: 0px;
							padding-top:10px;
							rotate: -90;
							font-size:14px;
							top:170px;
							">
						
						<span style="letter-spacing: 0.5px;text-transform:uppercase;font-size:14px;">'.$_POST["tenbv"].'</span>-<span style="font-family:Arial;font-size:14px; ">  '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'</span>
					</div>
					<div style="bottom: 55px;
						left:700px;
						position:absolute;
						text-align:right;
						background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:15px;
						font-weight:bold;
						width:40px;					 				 
						height:15px
						z-index:100;
						;">
						<div style="margin-top:5px;">'.$pageNo.'</div>
					</div>
					<div style="bottom: 55px;
						left:200px;
						position:absolute;
						text-align:right;
						background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;
						font-weight:bold;
						width:500px;					 				 
						height:15px;">
						<div style="margin-top:5px;"></div>
					</div>
					<div style="top: 95px;
						left:48px;
						position:absolute;
						text-align:right;
						background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;
						font-weight:bold;
						width:87%;					 				 
						height:35px;">
						<div style="margin-top:5px;"></div>
					</div>
					<div style="bottom: 15px;
						left:48px;
						position:absolute;
						text-align:right;
						background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:15x !important;
						font-weight:bold;
						width:698px;					 				 
						height:50px;">
						<div style="margin-top:5px;"></div>
					</div>
					';
		//if($pageNo==1){
			$html.='<div style="background:#fff;
						font-family: segoe ui,Tahoma,sans-serif !important;;
						width:85%;					 
						text-align:center;
						position:absolute;
						top:10px;
						left:60px;
						height:80px;z-index:2001px">
						<h1 style="background:#fff; ">'.$thongtinluotkham[0]["ReportName"].'</h1>
					</div>
					<div style="top:95px;
						left:60px;
						position:absolute;
						height:20px; 					
						width:85%;
						font-size:15px !important;
						z-index:1001px;
						font-family:sans-serif;">ID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$thongtinluotkham[0]["MaBenhNhan"].'
					</div>
					<div style="top:95px;
						left:500px;
						position:absolute;
						height:20px; 					
						width:85%;
						font-size:15px !important;
						z-index:1001px;
						font-family:sans-serif;">Tuổi:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$thongtinluotkham[0]["Tuoi"].'
					</div>
					<div style="top:113px;
						left:500px;
						position:absolute;
						height:20px; 					
						width:85%;
						font-size:15px !important;
						z-index:1001px;
						font-family:sans-serif;">Ngày khám: '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('d/m/Y').'
					</div>
					<div style="top:113px;
						left:60px;
						position:absolute;
						height:20px;				
						width:85%;
						font-size:15px !important;
						z-index:1001px;
						font-family:sans-serif;
						">Họ tên: '.$thongtinluotkham[0]["HoLotBenhNhan"].' '.$thongtinluotkham[0]["TenBenhNhan"].'
				</div>
				<div style="background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:15px !important;				 
						top: 500px;
						left:60px;
						position:absolute;
						min-height:100px; 					
						width:85%;
						z-inde:1000px;">
					<div style="width:370px">
						<div style="padding-bottom:2px; margin-bttom:2px;font-size:15px !important;
									font-weight:bold;">Chẩn đoán</div>'.'<div style="background:#fff;font-size:15px !important;">'.$_POST["ketluan1"].'</div>
					</div>
					<div style="width:100%;margin-top:50px;margin-left:250px; text-align:center;font-size:15px !important;">
					    In từ dữ liệu gốc, Ngày '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('d').' tháng '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('m').' năm '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('Y').' <br>
							<strong>BÁC SỸ</strong>
					</div>
					<div style="width:100%;margin-top:10px;margin-left:380px;">
					<img style="margin-left:40px;width:100px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br>
						<div style="font-family:Arial, Geneva, sans-serif;
									font-size:15px;	
									font-weight:bold;margin-top:10px;">
									'.$thongtinluotkham[0]["BsChanDoan"].'
						</div>
					</div>
				</div>
				';	
		//}
		$mpdf->WriteHTML($html);
	//}
	$mpdf->Output(STRING_PATH.$DocName, 'F');
	
}


function edit_pdf_do_thinhluc(){
	//print_r($_POST);
	 $default_url=get_system_one_config("GD2_Default_Url");
	$sign_path=get_system_one_config("GD2_PathToStaffSignImages");
	
	
	$DocName =$_REQUEST["default_name"];
	$id_kham=explode("_",$DocName);
	$data= new SQLServer;//tao lop ket noi SQL
	$params1 = array($id_kham[1]);//tao param cho store 
	$store_name1="{call GD2_GetKhamById_Kham(?)}";//tao bien khai bao store
	$get_thongtinluotkham=$data->query( $store_name1,$params1);//Goi store
	$excute1= new SQLServerResult($get_thongtinluotkham);//Ket noi lop xu ly SQL và truyen gia tri tra ve tu lop ket noi SQL
	$thongtinluotkham= $excute1->get_as_array();//Tra ve mang toan bo data lay duoc
	
	require_once('mpdf/mpdf.php');
	$mpdf=new mPDF('','A4','','',0,0,0,0,0,0); 
	//$mpdf = new mPDF('utf-8', array(800,800));
	//$mpdf=new mPDF('utf-8', 'A4-L');
	$mpdf->SetImportUse();	
	$mpdf->SetDisplayMode('fullpage');	
	$mpdf->SetCompression(false);
	$pagecount=$mpdf->SetSourceFile(STRING_PATH."raw".$DocName);
		
	pdf_do_thinhluc($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path);	 
	$_FILES["upload"]["name"][1]=$DocName;
	$_FILES["upload"]["type"][1]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][1]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][1]="0";
	$_FILES["upload"]["size"][1]=filesize('tmp_images/'.$DocName); 
}

function pdf_do_thinhluc($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path){	
	//for ($pageNo = 1; $pageNo <= 1; $pageNo++) {
		$pageNo=1;
		$tplIdx = $mpdf->importPage($pageNo);
	
		// add a page
		$mpdf->AddPage();
		$mpdf->useTemplate($tplIdx, null, null, 0, 0, true);
		//$mpdf ->useTemplate($tplIdx, null, null, 215.6, 350.9,FALSE);
		//$mpdf->useTemplate($tplIdx, 0, -5,235 );
		$mpdf->SetXY(10, 0);
		
	//$mpdf->useTemplate($tplIdx, 5, -5,235 );
		$html = '<div style="font-family:Arial, Geneva, sans-serif;
							background:#fff;
							position: fixed;
							left: 0px;
							padding-top:10px;
							rotate: -90;
							font-size:14px;
							top:170px;
							">
						
						<span style="letter-spacing: 0.5px;text-transform:uppercase;font-size:14px;">'.$_POST["tenbv"].'</span>-<span style="font-family:Arial;font-size:14px; ">  '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'</span>
					</div>
					<div style="bottom: 55px;
						left:700px;
						position:absolute;
						text-align:right;
						background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:15px;
						font-weight:bold;
						width:40px;					 				 
						height:15px
						z-index:100;
						;">
						<div style="margin-top:5px;">'.$pageNo.'</div>
					</div>
					<div style="bottom: 55px;
						left:200px;
						position:absolute;
						text-align:right;
						background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;
						font-weight:bold;
						width:500px;					 				 
						height:15px;">
						<div style="margin-top:5px;"></div>
					</div>
					<div style="top: 95px;
						left:48px;
						position:absolute;
						text-align:right;
						background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;
						font-weight:bold;
						width:87%;					 				 
						height:50px;">
						<div style="margin-top:5px;"></div>
					</div>
					<div style="bottom: 15px;
						left:48px;
						position:absolute;
						text-align:right;
						background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:15x !important;
						font-weight:bold;
						width:698px;					 				 
						height:50px;">
						<div style="margin-top:5px;"></div>
					</div>
					';
		//if($pageNo==1){
			$html.='<div style="background:#fff;
						font-family: segoe ui,Tahoma,sans-serif !important;;
						width:85%;					 
						text-align:center;
						position:absolute;
						top:10px;
						left:60px;
						height:80px;z-index:2001px">
						<h1 style="background:#fff; ">'.$thongtinluotkham[0]["ReportName"].'</h1>
					</div>
					<div style="top:95px;
						left:60px;
						position:absolute;
						height:20px; 					
						width:85%;
						font-size:15px !important;
						z-index:1001px;
						font-family:sans-serif;">ID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$thongtinluotkham[0]["MaBenhNhan"].'
					</div>
					<div style="top:95px;
						left:500px;
						position:absolute;
						height:20px; 					
						width:85%;
						font-size:15px !important;
						z-index:1001px;
						font-family:sans-serif;">Tuổi:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$thongtinluotkham[0]["Tuoi"].'
					</div>
					<div style="top:113px;
						left:500px;
						position:absolute;
						height:20px; 					
						width:85%;
						font-size:15px !important;
						z-index:1001px;
						font-family:sans-serif;">Ngày khám: '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('d/m/Y').'
					</div>
					<div style="top:113px;
						left:60px;
						position:absolute;
						height:20px;				
						width:85%;
						font-size:15px !important;
						z-index:1001px;
						font-family:sans-serif;
						">Họ tên: '.$thongtinluotkham[0]["HoLotBenhNhan"].' '.$thongtinluotkham[0]["TenBenhNhan"].'
				</div>
				<div style="background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:15px !important;				 
						top: 500px;
						left:60px;
						position:absolute;
						min-height:100px; 					
						width:85%;
						z-inde:1000px;">
					<div style="width:370px">
						<div style="padding-bottom:2px; margin-bttom:2px;font-size:15px !important;
									font-weight:bold;">Chẩn đoán</div>'.'<div style="background:#fff;font-size:15px !important;">'.$_POST["ketluan1"].'</div>
					</div>
					<div style="width:100%;margin-top:50px;margin-left:250px; text-align:center;font-size:15px !important;">
					    In từ dữ liệu gốc, Ngày '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('d').' tháng '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('m').' năm '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('Y').' <br>
							<strong>BÁC SỸ</strong>
					</div>
					<div style="width:100%;margin-top:10px;margin-left:380px;">
					<img style="margin-left:40px;width:100px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br>
						<div style="font-family:Arial, Geneva, sans-serif;
									font-size:15px;	
									font-weight:bold;margin-top:10px;">
									'.$thongtinluotkham[0]["BsChanDoan"].'
						</div>
					</div>
				</div>
				';	
		//}
		$mpdf->WriteHTML($html);
	//}
	$mpdf->Output(STRING_PATH.$DocName, 'F');
	
}



// AOE


function edit_pdf_do_aoe(){
	//print_r($_POST);
	 $default_url=get_system_one_config("GD2_Default_Url");
	$sign_path=get_system_one_config("GD2_PathToStaffSignImages");
	
	
	$DocName =$_REQUEST["default_name"];
	$id_kham=explode("_",$DocName);
	$data= new SQLServer;//tao lop ket noi SQL
	$params1 = array($id_kham[1]);//tao param cho store 
	$store_name1="{call GD2_GetKhamById_Kham(?)}";//tao bien khai bao store
	$get_thongtinluotkham=$data->query( $store_name1,$params1);//Goi store
	$excute1= new SQLServerResult($get_thongtinluotkham);//Ket noi lop xu ly SQL và truyen gia tri tra ve tu lop ket noi SQL
	$thongtinluotkham= $excute1->get_as_array();//Tra ve mang toan bo data lay duoc
	
	require_once('mpdf/mpdf.php');
	$mpdf=new mPDF('','A4','','',0,0,0,0,0,0); 
	//$mpdf = new mPDF('utf-8', array(800,800));
	//$mpdf=new mPDF('utf-8', 'A4-L');
	$mpdf->SetImportUse();	
	$mpdf->SetDisplayMode('fullpage');	
	$mpdf->SetCompression(false);
	$pagecount=$mpdf->SetSourceFile(STRING_PATH."raw".$DocName);
		
	pdf_do_aoe($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path);	 
	$_FILES["upload"]["name"][1]=$DocName;
	$_FILES["upload"]["type"][1]="application\/vnd.ms-word"; 
	$_FILES["upload"]["tmp_name"][1]=STRING_PATH.$DocName;
	$_FILES["upload"]["error"][1]="0";
	$_FILES["upload"]["size"][1]=filesize('tmp_images/'.$DocName); 
}

function pdf_do_aoe($mpdf,$DocName,$default_url,$thongtinluotkham,$sign_path){	
	//for ($pageNo = 1; $pageNo <= 1; $pageNo++) {
		$pageNo=1;
		$tplIdx = $mpdf->importPage($pageNo);
	
		// add a page
		$mpdf->AddPage();
		$mpdf->useTemplate($tplIdx, null, null, 0, 0, true);
		//$mpdf ->useTemplate($tplIdx, null, null, 215.6, 350.9,FALSE);
		//$mpdf->useTemplate($tplIdx, 0, 0,215 );
		$mpdf->SetXY(10, 0);
		
	//$mpdf->useTemplate($tplIdx, 5, -5,235 ); ảnh logo do
		$html = '<div style="font-family:Arial, Geneva, sans-serif;
							background:#fff;
							position: fixed;
							left: 7px;
							
							rotate: -90;
							font-size:14px;
							margin-top:3px;
							top:170px;
							">
						
						<span style="letter-spacing: 0.5px;text-transform:uppercase;font-size:14px;">'.$_POST["tenbv"].'</span>-<span style="font-family:Arial;font-size:14px; ">  '.$_POST["diachi"].' * T: '.$_POST["dienthoai"].'</span>
					</div>
					<div style="bottom: 55px;
						left:700px;
						position:absolute;
						text-align:right;
						background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;
						font-weight:bold;
						width:40px;					 				 
						height:15px
						z-index:100;
						;">
						<div style="margin-top:5px;">'.$pageNo.'</div>
					</div>
					<div style="bottom: 55px;
						left:200px;
						position:absolute;
						text-align:right;
						background:#FFF;
						font-family:Arial, Geneva, sans-serif;
						font-size:10px;
						font-weight:bold;
						width:500px;					 				 
						height:15px;">
						<div style="margin-top:5px;"></div>
					</div>
					<div style="top: 85px;
						left:56px;
						position:absolute;
						text-align:right;
						background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:15px;
						font-weight:bold;
						width:95%;					 				 
						height:100px;">
						<div style="margin-top:5px;"></div>
					</div>
					<div style="top: 87px;
						border-top:2px solid #808080;
						left:56px;
						position:absolute;
						text-align:right;
						background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:15px;
						font-weight:bold;
						width:88%;					 				 
						height:5px;">
						<div style="margin-top:5px;"></div>
					</div>
					
					<div style="top: 150px;
						border-top:2px solid #808080;
						left:56px;
						position:absolute;
						text-align:right;
						background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:15px;
						font-weight:bold;
						width:88%;					 				 
						height:5px;">
						<div style="margin-top:5px;"></div>
					</div>
					
					<div style="bottom: 55px;
						left:48px;
						position:absolute;
						text-align:right;
						background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:15px;
						font-weight:bold;
						width:95%;					 				 
						height:100px;">
						<div style="margin-top:5px;"></div>
					</div>
					<div style="bottom: 50px;
						border-top:2px solid #808080;
						left:56px;
						position:absolute;
						text-align:right;
						background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:15px;
						font-weight:bold;
						width:88%;					 				 
						height:5px;">
						<div style="margin-top:5px;"></div>
					</div>
					';
		//if($pageNo==1){
			$html.='<div style="background:#fff;
						font-family:Arial, Geneva, sans-serif;
						width:85%;					 
						text-align:center;
						position:absolute;
						top:10px;
						left:60px;
						height:70px;z-index:2001px">
						<h1 style="padding-top:0px; ">'.$thongtinluotkham[0]["ReportName"].'</h1>
					</div>
					<div style="top:105px;
						left:60px;
						position:absolute;
						height:20px; 					
						width:85%;
						z-index:1001px;
						font-size:15px !important;
						font-family:sans-serif;">ID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$thongtinluotkham[0]["MaBenhNhan"].'
					</div>
					<div style="top:105px;
						left:500px;
						position:absolute;
						height:20px; 					
						width:85%;
						font-size:15px !important;
						z-index:1001;
						font-family:sans-serif;">Tuổi:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$thongtinluotkham[0]["Tuoi"].'
					</div>
					<div style="top:123px;
						left:500px;
						position:absolute;
						height:20px; 					
						width:85%;
						font-size:15px;
						z-index:1001px;
						font-family:sans-serif;">Ngày khám: '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('d/m/Y').'
					</div>
					<div style="top:123px;
						left:60px;
						position:absolute;
						height:20px;				
						width:85%;
						font-size:15px !important;
						z-index:1001px;
						font-family:sans-serif;
						">Họ tên: '.$thongtinluotkham[0]["HoLotBenhNhan"].' '.$thongtinluotkham[0]["TenBenhNhan"].'
				</div>
				<div style="background:#fff;
						font-family:Arial, Geneva, sans-serif;
						font-size:15px !important;			 
						top: 870px;
						left:60px;
						position:absolute;
						min-height:70px; 					
						width:85%;
						z-inde:1000px;">
					<div style="width:370px">
						<div style="padding-bottom:2px; margin-bttom:2px;font-size:15px !important;
									font-weight:bold;">Chẩn đoán</div>'.$_POST["ketluan1"].'
					</div>
					<div style="width:100%;margin-top:30px;margin-left:250px; text-align:center;">
					    In từ dữ liệu gốc, Ngày '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('d').' tháng '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('m').' năm '.$thongtinluotkham[0]["NgayGioChanDoan"]->format('Y').' <br>
							<strong>BÁC SỸ</strong>
					</div>
					<div style="width:100%;margin-top:5px;margin-left:380px;">
					<img style="margin-left:30px;width:100px" src="'.$default_url."file_manager/php/connector.php?tenthumuc=".$sign_path."&answer=42&cmd=file&target="."f1_".base64_encode($thongtinluotkham[0][chuky_bacsy]).'">'.'<br>
						<div style="font-family:Arial, Geneva, sans-serif;
									font-size:15px;	
									font-weight:bold;margin-top:10px;">
									'.$thongtinluotkham[0]["BsChanDoan"].'
						</div>
					</div>
				</div>
				';	
		//}
		$mpdf->WriteHTML($html);
	//}
	$mpdf->Output(STRING_PATH.$DocName, 'F');
	
}


// END DO luong nhi






function edit_tcd($Wrd){	
	//print_r($_POST);	
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
	$Wrd->ActiveDocument->Paragraphs(2)->Range->Text="SIÊU ÂM DOPPLER XUYÊN SỌ".chr(13)."Tên: ".$_POST["tenbn"]." - Mã BN: ".$_POST["mabn"]." - Giới tính: ".$_POST["gioitinh"].chr(13);	
	$Wrd->ActiveDocument->Paragraphs(2)->SpaceAfter = 10;
	$Wrd->ActiveDocument->Paragraphs(2)->SpaceBefore = 0;
	$Wrd->ActiveDocument->Paragraphs(2)->Range->ParagraphFormat->Alignment = $wdAlignParagraphCenter;  
	$Wrd->ActiveDocument->Paragraphs(2)->Range->Font->Name = "Arial";  	 
	$Wrd->ActiveDocument->Paragraphs(2)->Range->Font->Size = "20";	 
	$Wrd->ActiveDocument->Paragraphs(2)->Range->Font->Color=$wdColorAqua;	
	$Wrd->ActiveDocument->Paragraphs(3)->SpaceAfter = 10;	 
	$Wrd->ActiveDocument->Paragraphs(3)->Range->ParagraphFormat->Alignment = $wdAlignParagraphCenter;  	 
	$Wrd->ActiveDocument->Paragraphs(3)->Range->Font->Size = "10";	
	$Wrd->ActiveDocument->Range($Wrd->ActiveDocument->Paragraphs(4)->Range->start, $Wrd->ActiveDocument->Paragraphs(4)->Range->end)->delete;	 
	//$Wrd->ActiveDocument->Range($Wrd->ActiveDocument->Paragraphs(5)->Range->start, $Wrd->ActiveDocument->Paragraphs(6)->Range->end)->delete;	
	$Wrd->ActiveDocument->Range($Wrd->ActiveDocument->Paragraphs(15)->Range->start, $Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->end)->delete;	
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
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text="                                                                                                                                         In từ dữ liệu gốc".chr(13);
	
	 
	 
	$xacdinhpara=$Wrd->ActiveDocument->Paragraphs->count;		 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text="                                                                                                                                "."Ngày ".  date("d")." tháng " . date("m")." năm " .  date("Y").chr(13);
	 //$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Delete;
	
	$xacdinhpara=$Wrd->ActiveDocument->Paragraphs->count;	 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceAfter = 0;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->SpaceBefore = 0;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Size = "10";	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Color=$wdColorBlack;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Bold = true; 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Italic = false;
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Font->Name = "Arial"; 
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text="                       BÁC SỸ                                                                          KỸ THUẬT VIÊN".chr(13);	
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
			$wrdPic->Left =330;
			$wrdPic->top =20;
			$wrdPic->Width  = 50;
			$wrdPic->Height = 50;
			//unlink('test.html');
		}	
	}	
	 
	if($_POST["chukybacsy"]!=""){		
		//$link=get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?tenthumuc=".get_system_one_config("GD2_PathToStaffSignImages")."&answer=42&cmd=file&target="."f1_".base64_encode($_POST["chukybacsy"]);
		//echo get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?tenthumuc=".get_system_one_config("GD2_PathToStaffSignImages")."&answer=42&cmd=file&target="."f1_".base64_encode(load_sign_by_id($_POST["chukybacsy"]));
		//file_put_contents('tmp_images/'.$_POST["chukybacsy"].".jpg", CURL($link)); 
		$chukybacsy=get_system_one_config("GD2_Default_Url")."file_manager/php/connector.php?tenthumuc=".get_system_one_config("GD2_PathToStaffSignImages")."&answer=42&cmd=file&target="."f1_".base64_encode(load_sign_by_id($_POST["chukybacsy"]));
		echo load_sign_by_id($_POST["chukybacsy"])."<br>";
		echo $chukybacsy;
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
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Text=$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count).chr(13)."             ".$_POST["chucdanhbacsy"]." ".$_POST["tenbacsy"]."                                                                ".$_POST["chucdanhktv"]." ".$_POST["tenktv"].chr(13);	
	$Wrd->ActiveDocument->Paragraphs($Wrd->ActiveDocument->Paragraphs->count)->Range->Delete;
	
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
	$store_name="{call HIS_TableWithPage_GetBy(?,?,?,?,?,?,?,?)}";//tao bien khai bao store
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
function kill_process($process){
	$WshShell = new COM("WScript.Shell"); 
	$oExec = $WshShell->Run("cmd /k D:/xampp/htdocs/giaidoan2/kill_anything.exe ".$process, 0, false); 
}
function layKieuDangNhap($ipfrom)
{
	$data= new SQLServer;//tao lop ket noi SQL
	$store_name1="{call XH_GetListTiepNhanId (?)}";
			$params1 = array($ipfrom);
			$get1=$data->query( $store_name1, $params1);
			$excute1= new SQLServerResult($get1);
			$tam= $excute1->get_as_array();
			if (empty($tam)) {
    		
    		$layKieuDangNhap=0;	
			}
			else{
				foreach ($tam as $row) {//duyet toan bo mang tra ve
				$layKieuDangNhap=$row["KieuDangNhap"];
			
				}  
			}
			
		$_SESSION["KieuDangNhap"]= $layKieuDangNhap;
		
}
function layTenTabMoMacDinh($ipfrom)
{
	$data= new SQLServer;//tao lop ket noi SQL
	$store_name1="{call XH_GetListTiepNhanId (?)}";
			$params1 = array($ipfrom);
			$get1=$data->query( $store_name1, $params1);
			$excute1= new SQLServerResult($get1);
			$tam= $excute1->get_as_array();
			if (empty($tam)) {
    		$TenTabMoMacDinh='monitorcenter';	
			}
			else{
				foreach ($tam as $row) {//duyet toan bo mang tra ve
			
				$TenTabMoMacDinh=$row["TenTabMoMacDinh"];	
				}  
			}
		
		$_SESSION["TenTabMoMacDinh"]= $TenTabMoMacDinh;
}
function layCongNodeJsDuLieu($ipfrom)
{
	$data= new SQLServer;//tao lop ket noi SQL
	$store_name1="{call XH_GetListTiepNhanId (?)}";
			$params1 = array($ipfrom);
			$get1=$data->query( $store_name1, $params1);
			$excute1= new SQLServerResult($get1);
			$tam= $excute1->get_as_array();
			foreach ($tam as $row) {//duyet toan bo mang tra ve
		
			$CongNodeJsDuLieu=$row["CongNodeJsDuLieu"];	
			}  
		
		$_SESSION["CongNodeJsDuLieu"]= $CongNodeJsDuLieu;
}
function layCongNodeJsCall($ipfrom)
{
	$data= new SQLServer;//tao lop ket noi SQL
	$store_name1="{call XH_GetListTiepNhanId (?)}";
			$params1 = array($ipfrom);
			$get1=$data->query( $store_name1, $params1);
			$excute1= new SQLServerResult($get1);
			$tam= $excute1->get_as_array();
			foreach ($tam as $row) {//duyet toan bo mang tra ve
		
			$CongNodeJsCall=$row["CongNodeJsCall"];	
			}  
		
		$_SESSION["CongNodeJsCall"]= $CongNodeJsCall;
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
		$_SESSION["config_system"]["nam"]="";
		$_SESSION["config_system"]["namUI"]="yy";
		$_SESSION["config_system"]["namEntry"]="y";
		$_SESSION["config_system"]["namDatejs"]="yyyy";
	}else{
		$_SESSION["config_system"]["nam"]="";
		$_SESSION["config_system"]["namUI"]="yy";
		$_SESSION["config_system"]["namEntry"]="y";
		$_SESSION["config_system"]["namDatejs"]="yyyy";				
	}		 
	$_SESSION["namhethong"]=2013;
    $_SESSION["GD2ChoPhepSuaKhiDaHoanTat"]=get_system_one_config("GD2ChoPhepSuaKhiDaHoanTat"); 
    $_SESSION["GD2PhanTramMucPhatDonChamCong"]=get_system_one_config("GD2PhanTramMucPhatDonChamCong"); 
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

function getOS() { 
    $user_agent=$_SERVER['HTTP_USER_AGENT'];;
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Linux',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }   
    return $os_platform;
}
function stringtochart($string) {
		$search = array (
			'#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
			'#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
			'#(ì|í|ị|ỉ|ĩ)#',
			'#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
			'#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
			'#(ỳ|ý|ỵ|ỷ|ỹ)#',
			'#(đ)#',
			'#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
			'#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
			'#(Ì|Í|Ị|Ỉ|Ĩ)#',
			'#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
			'#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
			'#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
			'#(Đ)#',
			"/[^a-zA-Z0-9\-\_]/",
			) ;
		$replace = array (
			'a',
			'e',
			'i',
			'o',
			'u',
			'y',
			'd',
			'A',
			'E',
			'I',
			'O',
			'U',
			'Y',
			'D',
			'-',
			) ;
		$string = preg_replace($search, $replace, $string);
		$string = preg_replace('/(-)+/', '-', $string);
		$string = strtolower($string);
		return $string;
	}

function anhoso($idluotkham,$iduser){
	$data= new SQLServer; 
	$store_name="{call GD2_CheckKhoaHoSoByID_LuotKhamAndID_NhanVien(?,?)}";
	//$params = array($_GET['idluotkham'],$_SESSION["user"]["id_user"]);
	$params = array($idluotkham,$iduser);
	$get_lich=$data->query( $store_name, $params);
	$excute= new SQLServerResult($get_lich);
	$tam= $excute->get_as_array();
	$emr_coquyen=$tam[0]['KetQua'];
	if($emr_coquyen==0){
		echo'
		<div id="dialog-anhoso" title="Thông báo" style="display:none;">
		  Hồ sơ bệnh án này đã khóa.<br>
		  Vui lòng liên hệ ban Giám đốc hoặc phòng KHTH để biết thêm chi tiết.
		</div>
		
		<script>
		  $(function() {
			$( "#dialog-anhoso" ).dialog({
			  resizable: false,
			  height:160,
			  modal: true,
			  buttons: {
				"OK": function() {
				  $( this ).dialog( "close" );
				}
			  }
			});
		  });
	  </script>';
	  exit();	
	}	
}



function custom_images_signs(){
	$chuoi="";
	$id_nhanvien='';
	if(isset($_POST["id_user_login"])){
		$id_login=$_POST["id_user_login"];
	}else{
		$id_login=0;
	}
	
	list($id_nhanvien,,)      = explode('_', $_POST["default_name"]);
	for($i=0;$i<count($_POST["image_data"]);$i++){
		list($type, $data) = explode(';', $_POST["image_data"][$i]);
		//echo $type;
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);	 
		list(,$type)= explode('/', $type);
		$name=$_POST["default_name"]."_1.$type";
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
		//echo $id_nhanvien."-".$id_login."-".$_SERVER['REMOTE_ADDR'];
	}
		
	$data= new SQLServer;

	$store_name="{call [GD2_DMNhanVienUpDuongDanHinhChuKy] (?,?,?,?)}";
	$params=  array($id_nhanvien,$name,$id_login,$_SERVER['REMOTE_ADDR'] );
	$update_duongdan=$data->query( $store_name, $params);
}


function Check_update($idluotkham,$iddonthuoc,$idkham,$idphy,$iddtph,$iduser,$idbennhan,$sid,$loaikiemtra) {
	$data= new SQLServer; 
	$store_name="{call GD2_Quanly_dieukienupdate(?,?,?,?,?,?,?,?,?)}";	
	$ma='';
	$Chuoi='';
	$Isupdate='';
	$params = array(
		 $idluotkham
		,$iddonthuoc
		,$idkham
		,$idphy
		,$iddtph
		,$iduser
		,$idbennhan
		,$sid
		,$loaikiemtra	
	);
	$get=$data->query( $store_name, $params);
	$excute= new SQLServerResult($get);
	$tam= $excute->get_as_array();   
    $out['Ma'] = $tam[0]['Ma'];
    $out['Chuoi'] =$tam[0]['Chuoi'];
    $out['Isupdate'] = $tam[0]['Isupdate'];
    return $out;
}


function Check_update_cls($idkham,$idphy,$iddtph,$iduser) {
	$out=Check_update(0,0,$idkham,$idphy,$iddtph,$iduser,0,0,5);   
    return $out;
}

// Kiem tra khoa BHYT và Thanh Toan
function CheckUpdate_BhytThanhtoan($idluotkham,$idkham,$idphy,$iddtph,$iduser) {
	$out=Check_update($idluotkham,0,$idkham,$idphy,$iddtph,$iduser,0,0,1);   
    return $out;
}
// Kiem tra khoa Thanh Toan,Xuat thuoc ngoai tru (Danh cho ngoai tru. Noi tru khong cho sua)
function CheckUpdate_BhytThanhtoanXuathuocNgoaitru($idluotkham,$iduser) {
	$out=Check_update($idluotkham,0,0,0,0,$iduser,0,0,3);   
    return $out;
}
// Kiem tra khoa Thanh Toan,Xuat thuoc ngoai tru (Noi tru sua duoc)
function CheckUpdate_BhytThanhtoanXuatThuoc($idluotkham,$iduser) {
	$out=Check_update($idluotkham,0,0,0,0,$iduser,0,0,6);   
    return $out;
}

//Mr Nam: Kiem tra khoa BHYT và Thanh Toan, BHCC, Noi tru
function CheckUpdate_BhytBhccThanhtoanNoitru($idluotkham,$idkham,$idphy,$iddtph,$iduser) {
	$out=Check_update($idluotkham,0,$idkham,$idphy,$iddtph,$iduser,0,0,7);   
    return $out;
}

//Mr Nam: Kiem tra khoa BHYT và Thanh Toan, BHCC
function CheckUpdate_BhytBhccThanhtoan($idluotkham,$idkham,$idphy,$iddtph,$iduser) {
	$out=Check_update($idluotkham,0,$idkham,$idphy,$iddtph,$iduser,0,0,8);   
    return $out;
}

//Mr Nam: Kiem tra khoa BHYT và Thanh Toan, BHCC Nhung cho phep doi voi KSK Cty
function CheckUpdate_BhytBhccThanhtoan_AllowKSKCTy($idluotkham,$idkham,$idphy,$iddtph,$iduser) {
	$out=Check_update($idluotkham,0,$idkham,$idphy,$iddtph,$iduser,0,0,9);   
    return $out;
}

//Mr Nam: Kiểm tra khóa theo tùy chọn. $loai là loại truyền vào store cần kiểm tra (Cân nhắc khi dùng hàm này).
function CheckUpdate_Custom($idluotkham,$idkham,$idphy,$iddtph,$iduser,$loai) {
	$out=Check_update($idluotkham,0,$idkham,$idphy,$iddtph,$iduser,0,0,$loai);   
    return $out;
}
//Mr Nam: Kiem tra khoa BHYT và Thanh Toan, BHCC By ID_DonThuoc
function CheckUpdate_BhytBhccThanhtoanByIDDonThuoc($iddonthuoc,$iduser) {
	$out=Check_update(NULL,$iddonthuoc,NULL,NULL,NULL,$iduser,0,0,8);
    return $out;
}
//Mr Van: Kiem tra khoa Ho So

function CheckUpdate_KhoaHoSo($idluotkham,$idbennhan,$iduser) {
	$out=Check_update($idluotkham,0,0,0,0,$iduser,$idbennhan,0,10);   
    return $out;
}



function HeaderReportA4($input="") {
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%;font-family:Arial, Helvetica, sans-serif;">
	<tr style="font-size:10px; padding-top:10px;">
		<td style=" width:6%; text-align:left">
			<img src="<?php echo $_SESSION["com"]["LogoBenhVien"]?>" style="<?php echo $_SESSION["com"]["LogoBenhVienCSS"]?>">
		</td>
		<td style=" width:92%; text-align:left; vertical-align: top; padding-top:10px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%;font-family:Arial, Helvetica, sans-serif;">
				 <tr style="font-size:10px;">
					 <td style=" width:100%; text-align:left">
						<span style="<?php echo $_SESSION["com"]["TenBenhVienCSS"]?>"><?php echo $_SESSION["com"]["TenBenhVien"]?></span><br />
						<span style="<?php echo $_SESSION["com"]["SoDTCSS"]?>"><?php echo $_SESSION["com"]["SoDT"]?><br /></span>
						<span style="<?php echo $_SESSION["com"]["DiaChiCSS"]?>"><?php echo $_SESSION["com"]["DiaChi"]?><br /></span>
						<span style="<?php echo $_SESSION["com"]["EmailCSS"]?>"><?php echo $_SESSION["com"]["Email"]?><br /></span>
					 </td>
				 </tr>
			</table> 

		</td>		
	</tr>
	</table>
	<br />
	<?php
}

function HeaderReportInNhiet($input="") {
	?>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%;font-family:Arial, Helvetica, sans-serif;">
         <tr style="font-size:10px;">
             <td style=" width:100%; text-align:left">
				<img src="<?php echo $_SESSION["com"]["LogoBenhVien"]?>" style="<?php echo $_SESSION["com"]["LogoBenhVienCSS"]?>"><br>
				<span style="<?php echo $_SESSION["com"]["TenBenhVienCSS"]?>"><?php echo $_SESSION["com"]["TenBenhVien"]?><br /></span>
				<span style="<?php echo $_SESSION["com"]["SoDTCSS"]?>"><?php echo $_SESSION["com"]["SoDT"]?><br /></span>
				<span style="<?php echo $_SESSION["com"]["DiaChiCSS"]?>"><?php echo $_SESSION["com"]["DiaChi"]?><br /></span>
				<span style="<?php echo $_SESSION["com"]["EmailCSS"]?>"><?php echo $_SESSION["com"]["Email"]?><br /></span>
             </td>
         </tr>
     </table> 
	<br />
	<?php
}

function HeaderReportInNhietReturn($input="") {
	$kq='
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%;font-family:Arial, Helvetica, sans-serif;">
         <tr style="font-size:10px;">
             <td style=" width:100%; text-align:left">
				<img src="'.$_SESSION["com"]["LogoBenhVien"].'" style="'.$_SESSION["com"]["LogoBenhVienCSS"].'"><br>
                <span style="'.$_SESSION["com"]["TenBenhVienCSS"].'">'.$_SESSION["com"]["TenBenhVien"].'<br /></span>
				 <span style="'.$_SESSION["com"]["SoDTCSS"].'">'.$_SESSION["com"]["SoDT"].'<br /></span>
				<span style="'.$_SESSION["com"]["DiaChiCSS"].'">'.$_SESSION["com"]["DiaChi"].'<br /></span>
				<span style="'.$_SESSION["com"]["EmailCSS"].'">'.$_SESSION["com"]["Email"].'<br /></span>
             </td>
         </tr>
     </table> 
	<br />';
	return $kq;
}
 function getClientQms()
 {
 	$data= new SQLServer;
			$store_name1="{call XH_GetListTiepNhanId (?)}";
			$params1 = array(
								$_SERVER['REMOTE_ADDR']
							);
			$get1=$data->query( $store_name1, $params1);
			$excute1= new SQLServerResult($get1);
			$ds1= $excute1->get_as_array();
			if( isset( $ds1[0])  )
			{
				echo "<script type='text/javascript'>\r	
				window.ListTiepNhanId=".$ds1[0]['PhongBan_Id'].";\r
				window.KhoangThoiGianGoi=".$ds1[0]['KhoangThoiGianGoi'].";\r
				window.KhoangThoiGianTuDongLayDuLieu=".$ds1[0]['KhoangThoiGianTuDongLayDuLieu'].";\r
				window.KhoangThoiGianTuDongThongBaoDesktop=".$ds1[0]['KhoangThoiGianTuDongThongBaoDesktop'].";\r
				window.DiemTiepNhan='".$ds1[0]['GhiChu']."';\r
				window.BatGhiChu=".$ds1[0]['BatGhiChu'].";\r
				window.BatKetQua=".$ds1[0]['BatKetQua'].";\r
				window.SoDongTruyVanTrangThaiKetQua=".$ds1[0]['SoDongTruyVanTrangThaiKetQua'].";\r
				window.KieuDangNhap=".$ds1[0]['KieuDangNhap'].";\r
				window.TenTabMoMacDinh='".$ds1[0]['TenTabMoMacDinh']."';\r
				window.TenQuay='".$ds1[0]['TenQuay']."';\r
				window.IsNoHasMissCall=".$ds1[0]['IsNoHasMissCall'].";\r
				window.NoSound=".$ds1[0]['NoSound'].";\r
				window.NoVoiceCall=".$ds1[0]['NoVoiceCall'].";\r
				window.KhoangThoiGianTuDongCanhBaoLuuY=".$ds1[0]['KhoangThoiGianTuDongCanhBaoLuuY'].";\r
				window.TanSuatLapLaiCanhBaoLuuY=".$ds1[0]['TanSuatLapLaiCanhBaoLuuY'].";\r
				window.ThoiLuongKhamBenh=".$ds1[0]['ThoiLuongKhamBenh'].";\r
				window.TenSocketNodeJS='".$ds1[0]['TenSocketNodeJS']."';\r
				window.CongNodeJsDuPhong=".$ds1[0]['CongNodeJsDuPhong'].";\r
				window.CongNodeJsDuLieu=".$ds1[0]['CongNodeJsDuLieu'].";\r
				window.CongNodeJsCall=".$ds1[0]['CongNodeJsCall'].";\r
				window.CongNodeJsReLoadClient=".$ds1[0]['CongNodeJsReLoadClient'].";\r
				window.PhanLoai=".$ds1[0]['PhanLoai'].";\r
				window.SoQuayMacDinh='".$ds1[0]['SoQuayMacDinh']."';\r
				window.NoVoiceCheckin=".$ds1[0]['NoVoiceCheckin'].";\r
				window.LoaiNghiepVu=".$ds1[0]['LoaiNghiepVu'].";\r
				window.PhongBan_ID_Str='".$ds1[0]['PhongBan_ID_Str']."';\r
				window.QuangCao=".$ds1[0]['QuangCao'].";\r
				window.SoDongBatDauTaoAutoScroll=".$ds1[0]['SoDongBatDauTaoAutoScroll'].";\r
				window.SoDongAutoScroll=".$ds1[0]['SoDongAutoScroll'].";\r
				window.IPView='".$ds1[0]['IPView']."';\r
				window.ButtonXem=".$ds1[0]['ButtonXem'].";\r
				window.Tang=".$ds1[0]['Tang'].";\r
				window.HienThiTenDichVu=".$ds1[0]['HienThiTenDichVu'].";\r
				window.HienThiTenDichVuTiviView=".$ds1[0]['HienThiTenDichVuTiviView'].";\r
				window.IsFirstCounter=".$ds1[0]['IsFirstCounter'].";\r
				window.DoPhanGiaiPixelTivi='".$ds1[0]['DoPhanGiaiPixelTivi']."';\r
				window.ImagePathDefault='".$ds1[0]['ImagePathDefault']."';\r
				window.InforLastCall='".$ds1[0]['InforLastCall']."';\r
				window.DungChungBarcode='".$ds1[0]['DungChungBarcode']."';\r
				window.NhanCounter='".$ds1[0]['NhanCounter']."';\r
				window.NhanCounter_EN='".$ds1[0]['NhanCounter_EN']."';\r
				window.NhanNghiepVuCounterA='".$ds1[0]['NhanNghiepVuCounterA']."';\r
				window.NhanNghiepVuCounterA_EN='".$ds1[0]['NhanNghiepVuCounterA_EN']."';\r
				window.NhanNghiepVuCounterB='".$ds1[0]['NhanNghiepVuCounterB']."';\r
				window.NhanNghiepVuCounterB_EN='".$ds1[0]['NhanNghiepVuCounterB_EN']."';\r
				window.var2=200;\r";
				echo "</script>\r";	

			}
			else {
					echo "<p style='color:red;font-size:50px'> Địa chỉ IP '".$_SERVER['REMOTE_ADDR']."' này chưa được cấu hình. Vui lòng báo địa chỉ IP này cho IT  </p>";
					return;
						
				 }		
 }
function ngayinreport($check,$ngay){
	if($check==1){
		echo 'Ngày '.$ngay->format("d")." tháng " . $ngay->format("m")." năm " .  $ngay->format("Y"); 
	}else{
		echo 'Ngày '.date('d')." tháng " .date('m')." năm " .  date('Y'); 
	}
}

function getInforQms()
{

}


function ThongTinHanhChinhReportA4($ReportName="",$HoTenBenhNhan="",$Gioi="",$Tuoi="",$MaBenhNhan="",$DiaChi="") {
	?>
	<table cellpadding="0" cellspacing="0" border="0" style=" width:100%;font-family:Tahoma, Geneva, sans-serif;">
     	<tr>
             <td style="text-align:center"><br /><br />
                <span style="letter-spacing: 0.5px;font-weight:bold;font-size:26px;"><?=$ReportName ?></span>
                <br />
                <span style="font-weight:bold;font-size:20px;">*****</span>
                <div style="height:10px;">
                </div>
             </td>
         
       </tr>    
     </table>
      <table cellpadding="0" cellspacing="0" border="0" style="color:#000;line-height:1.7;font-size:13px; width:100%;font-family:Tahoma, Geneva, sans-serif; border-top:1px solid #000; border-bottom:1px solid #000; padding:5px 0px">         
         <tr>
            <td style=" width:45%">Họ tên: <b><?=$HoTenBenhNhan;?></b></td> 
            <td align="right"style=" width:30%">Giới tính: <?=$Gioi;?>, <?=$Tuoi;?> tuổi</td>
			<td style=" width:15%" align="right">ID: <?=$MaBenhNhan?></td>
            <?php 
				if($_SESSION["com"]["HienThiBarcodeBenhNhan"]==1){
			?>
				<td rowspan="1" style=" width:10%" align="right" valign="middle"><img id="barcode" src = '<?=get_system_one_config("GD2_BarCode_PatientID_Src")?><?=$MaBenhNhan?>'></td>
			<?php
				}else{
			?>
				<td rowspan="1" style=" width:0%" align="right" valign="middle"></td>
			<?php
				}
			?>
         </tr>
         <tr>
            <td colspan="5" style="width:100%">Địa chỉ: <?=$DiaChi;?></td>           
         </tr>  
     </table>
	<?php
}
?>
