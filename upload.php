<?php
//echo $_POST["dophangiai"]; 
$dophangiai="";
if(isset($_POST["dophangiai"])){
    $dophangiai=$_POST["dophangiai"];
}
else{
    $dophangiai='';
}
// echo "do phan giai: ".  $dophangiai; 

include("class/class.sqlserver.php");
include("class/basic_function.php");
include("class/cons_system.php");
// Check if image file is a actual image or fake image khakhak


$target_dir = "assets/images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$target_file_1902X1080 = $target_dir . basename($_FILES["fileToUpload1902X1080"]["name"]);
$uploadOk = 1;



$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<Br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<Br>";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Tên file đã dùng, chọn tên khác và nên đặt tên ngắn, không chứa ký tự lạ nhé <Br>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 1500000) {
    echo "Sorry, your file is too large >1500 KB. <Br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. <Br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<Br>";
        // kết nối csdl và lưu đương dẫn


            $data= new SQLServer;
            $store_name="{call XH_AddImagePrByIp (?,?,?)}";
            $params = array(    
            
              $_SERVER['REMOTE_ADDR'] , "./".$target_file,$dophangiai
             );
            $data->query( $store_name, $params);
            echo '$dophangiai ok '.$dophangiai;
            echo json_encode(array('status' => '<br><span style="color:blue"> OK success </span> <Br>'));
        //
    } else {
        echo "Sorry, there was an error uploading your file. <Br>";
    }
}
?>