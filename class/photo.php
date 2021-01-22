<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>


<?php
$root_path =getcwd()."/"  ;
include($root_path."include/sqlsrv.php");
$connect_db= new software_databse();
$tsql_callSP = "{call sotang(?)}";

$Ten_tang = $_POST['login'];

$params = array( 
                $Ten_tang
               );
			   
			   if (isset($_POST['Submit'])) {
	
  $stmt=$connect_db->select_store($tsql_callSP,$params);   
 
  while( $row = sqlsrv_fetch( $stmt[0]))
	 
     {
		 
		  $name = sqlsrv_get_field( $stmt[0], 0);
		echo "$name: ";
 		$TenBuong_Giuong = sqlsrv_get_field( $stmt[0], 1);
		echo "$TenBuong_Giuong: ";


		 echo "<br>";
     }
	$connect_db->close_conn($stmt[0]);
			   }
?>  
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<label for="login">Login:</label>
  <input type="text" name="login" size="20" value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : $Ten_tang; ?>"><br> <input type="submit" name="Submit" value="Login">
  </form>
 
</body>
</html>
