<?php	
       
	function getConfigQms()
	{
		$data= new SQLServer;
			$store_name1="{call XH_GetListTiepNhanId (?)}";
			$params1 = array(
								$_SERVER['REMOTE_ADDR']
							);
			$get1=$data->query( $store_name1, $params1);
			$excute1= new SQLServerResult($get1);
			$ds1= $excute1->get_as_array();
		echo "<script type='text/javascript'>\r	
		window.var1=100;\r
		window.var2=200;\r";
		echo "</script>\r";		
	}
?>