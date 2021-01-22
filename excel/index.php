<?php

/*function getIpRange(  $cidr) {

    list($ip, $mask) = explode('/', $cidr);

    $maskBinStr =str_repeat("1", $mask ) . str_repeat("0", 32-$mask );      //net mask binary string
    $inverseMaskBinStr = str_repeat("0", $mask ) . str_repeat("1",  32-$mask ); //inverse mask

    $ipLong = ip2long( $ip );
    $ipMaskLong = bindec( $maskBinStr );
    $inverseIpMaskLong = bindec( $inverseMaskBinStr );
    $netWork = $ipLong & $ipMaskLong; 

    $start = $netWork+1;//ignore network ID(eg: 192.168.1.0)

    $end = ($netWork | $inverseIpMaskLong) -1 ; //ignore brocast IP(eg: 192.168.1.255)
    return array('firstIP' => $start, 'lastIP' => $end );
}

function getEachIpInRange ( $cidr) {
    $ips = array();
    $range = getIpRange($cidr);
    for ($ip = $range['firstIP']; $ip <= $range['lastIP']; $ip++) {
        $ips[] = long2ip($ip);
    }
    return $ips;
}

$cidr = '10.22.10.22/his'; // max. 30 ips
print_r(getEachIpInRange ( $cidr));*/

/* output: 
Array                                                                 
(                                                                     
    [0] => 172.16.0.1                                                 
    [1] => 172.16.0.2
    [2] => 172.16.0.3
    ...
    [27] => 172.16.0.28                                               
    [28] => 172.16.0.29                                               
    [29] => 172.16.0.30
) 
*/
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<script defer src="./assets/js/fontawesome-free-5.0.13/svg-with-js/js/fontawesome-all.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<meta name="description" content="Dynamic tables and grids using jqGrid plugin" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<script src="nodejs/node_modules/socket.io-client/dist/socket.io.js"></script>
	<link rel="stylesheet" href="./assets/js/free-jqgrid/ui.jqgrid.css">
	<script src="./assets/js/free-jqgrid/jquery.jqgrid.src.js"></script>
	<link rel="stylesheet" href="./assets/css/bootstrap-3.3.4-dist/css/bootstrap.min.css"> 	 
	<script src="./assets/css/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="./assets/js/flipclock/compiled/flipclock.css">
	<script src="./assets/js/easytimer.js-master/dist/easytimer.min.js"></script>
	<script src="./assets/js/pusher/4.2/pusher.min.js"></script>

<style style="text/css">

@keyframes flickerAnimation {
  0%   { opacity:1; }
  50%  { opacity:0; }
  100% { opacity:1; }
}
@-o-keyframes flickerAnimation{
  0%   { opacity:1; }
  50%  { opacity:0; }
  100% { opacity:1; }
}
@-moz-keyframes flickerAnimation{
  0%   { opacity:1; }
  50%  { opacity:0; }
  100% { opacity:1; }
}
@-webkit-keyframes flickerAnimation{
  0%   { opacity:1; }
  50%  { opacity:0; }
  100% { opacity:1; }
}
.animate-flicker {
   -webkit-animation: flickerAnimation 3s infinite;
   -moz-animation: flickerAnimation 3s infinite;
   -o-animation: flickerAnimation 3s infinite;
    animation: flickerAnimation 3s infinite;
     background: orange;
}
			.ui-jqgrid tr.jqgrow td {
				font-size:1.5em !important;
				
				/*	quan trọng để chỉnh font lưới*/
			}
				.ui-jqgrid tr.ui-row-ltr td, .ui-jqgrid tr.ui-row-rtl td {
			border-bottom: 1px solid #E1E1E1;
			padding: 6px 4px;
			border-color: #E1E1E1 !important;
					white-space: normal !important;
					height:auto;
					vertical-align:text-top; 
					padding-top:2px;
		}
	
		
		
			.ui-jqgrid-sortable {
			padding-left: 4px;
			font-size: 14px;
			/* color: #777; */
			font-weight: 700;
			font-size: 25px;
			/*color: red;*/
			text-align: center!important;
		}
	


    </style>
		
		

				

</head>
<body>


	<div  id='container' >

  		<label for="from_day" style="width:17px"> Từ</label>
        <input type="text"  style="width:109px" name="from_day" id='from_day'>
        <label for="to_day" style="width:23px"> Đến </label>
        <input type="text"   style="width:109px" name="to_day" id='to_day'>
        <button id='xem' onclick="xem_click()">Xem</button>

  <button id="getDataExcel" >Xuất Data(nên lấy lúc 12h-13h)</button>
        <input type="radio" name="optionXem" value="1" checked="true" />Phòng khám
		<input type="radio" name="optionXem"  value="2" />Cận lâm sàng
		<div id="#grid1" class="col-md-6 none-pad-mar" style="margin-top: 10px;">
			<table id="grid-table" style="width:100%; padding:0px!important;"></table>
			<div id="grid-pager" ></div>

		</div>
			<div id="#grid2" class="col-md-6 none-pad-mar" style="margin-top: 10px;">
			<table id="grid-table2" style="width:100%; padding:0px!important;"></table>
			<div id="grid-pager2" ></div>
			
		</div>
		
    </div>


    
                       
<script type="text/javascript" >


	window.ipclient='<?=$_SERVER['REMOTE_ADDR']?>';
$( "radio" ).on( "click", function() {
	alert( $( "radio:checked" ).val());
 // $( "#log" ).html( $( "input:checked" ).val() + " is checked!" );
});



    Pusher.logToConsole = true;
    var pusher = new Pusher('a104cc00cc6742991536', {
      cluster: 'ap1',
      encrypted: true
    });

    var channel = pusher.subscribe('my-channel');

    channel.bind('my-event', function(data) {

    	if(window.ListTiepNhanId==data.ListTiepNhanId)
    	{
		responsiveVoice.speak("Bệnh nhân "+data.message+" vừa đến", "Vietnamese Female", {volume: 1,rate:0.9});
		tooltip_message("Bệnh nhân "+data.MayTe+" "+data.message+" ip "+data.IPView+" vừa đến");
		//alert("Bệnh nhân "+data.message+" vừa đến");
		}
		/*if(LoaiNghiepVu==1){

			$('#viewds2ck').hide();
		} */
    });






var id_row =0;

$( document ).ready(function() {


$("#getDataExcel").click(function(){
	if(id_row==0){
		alert('Hãy chọn 1 dòng để xuất');
	}
	else{
		   window.open("resource.php?module=report&view=hethong&action=excel_data_qms&type=excel&from_day="+$( '#from_day' ).val()+"&to_day="+$( '#to_day' ).val()+"&id_phongban="+id_row);	
	}

});


			$('input[type="radio"]').on('click', function(e) {
			 // alert($( "input:checked" ).val()) ;
			  $('#grid-table').jqGrid('setGridParam', {url:'resource.php?module=<?= $modules ?>&view=<?= $view ?>&action=data&opt='+$( "input:checked" ).val(), datatype: 'json'}).trigger("reloadGrid");

 			  $('#grid-table2').jqGrid('setGridParam', {url:'resource.php?module=<?= $modules ?>&view=<?= $view ?>&action=data&opt='+$( "input:checked" ).val(), datatype: 'json'}).trigger("reloadGrid");



			});

				$("#from_day, #to_day").datepicker({
				dateFormat:  $.cookie("ngayJqueryUi")
				});

			   $("#from_day, #to_day").val('<?php echo date($_SESSION["config_system"]["ngaythang"]) ?>');

		
		function resize_control(){

		    $("#grid-table").setGridWidth($(window).width()/2-20);//set mặc định độ rộng
			$("#grid-table").setGridHeight($(window).height()-105);
			 $("#grid-tabl2").setGridWidth($(window).width()/2-20);//set mặc định độ rộng
			$("#grid-table2").setGridHeight($(window).height()-105);
     	}

		  
		  $(window).resize(function() {
		   	resize_control();
		  });


	
		//1 Hàm Vẽ lưới
	   $(function($) {
		
			var grid_selector = "#grid-table";
			var pager_selector = "#grid-pager";    
			var grid_selector2 = "#grid-table2";
			var pager_selector2 = "#grid-pager2";  

			jQuery(grid_selector).jqGrid({
				url:'resource.php?module=<?= $modules ?>&view=<?= $view ?>&action=data&opt=1',
				datastr:{},
				datatype: 'json',
				height: 380,
				width:jQuery(".grid-left").width(),//880 //1300
				

				colNames:['id', 'Tại phòng','Nhóm','Checkin','Đang chờ','Mức CB1','Mức CB2','Cảnh báo 1','Cảnh báo 2'],
				colModel:[
				{name:'id',index:'id', width:0, hidden: true},
		
				{name:'TenPhongBan',index:'TenPhongBan', width:10,hidden: false},
				{name:'TenNhomDichVu', align: 'left',index:'TenNhomDichVu', width:10,hidden:true},
				{name:'SoLuongDaCheking',sorttype: 'number', align: 'center',index:'SoLuongDaCheking', width:10},
				{name:'SoLuongDangCho',sorttype: 'number', align: 'center',index:'SoLuongDangCho', width:10},
				{name:'SLCanhBaoC1', align: 'center',index:'SLCanhBaoC1', width:10,hidden: true},
				{name:'SLCanhBaoC2', align: 'center',index:'SLCanhBaoC2', width:10,hidden: true},
				{name:'IsOverC1', align: 'center',index:'IsOverC1', width:10,hidden: true},
				{name:'IsOverC2', align: 'center',index:'IsOverC2', width:10,hidden: true},
				
				],
				loadonce: true,
				rowNum:1000,
				rowList:[10,20,30],
				altRows: true,                                                 
				multiselect: false,
				multiboxonly: false,
				onSelectRow: function(ids) { 
			 
			  
			   	id_row=ids;
			   	 	//alert(id_row);
			   },

				loadComplete :  function() {	 				
								resize_control();				
				
											if ($("#grid-table").jqGrid("getGridParam", "datatype") !== "local") {
												setTimeout(function () {						
													
													$("#grid-table")[0].triggerToolbar();
												}, 50);
											}
		
									var     ids = $('#grid-table').jqGrid('getDataIDs');
									for (i = 0; i < ids.length; i++) {    
									var rowData = jQuery('#grid-table').getRowData(ids[i]);
									var IsOverC1=rowData["IsOverC1"];
										if ( rowData["IsOverC1"] ==1){
										$("#grid-table").setCell(ids[i], 'IsOverC1','', {background: 'yellow'});// tô màu xanh khi đã checking
										$("#grid-table").setCell(ids[i], 'TenPhongBan','', {background: 'yellow'});// tô màu xanh khi đã checking

										}


							

									}
									
								}
			});
			
			jQuery("#grid-table").jqGrid('filterToolbar', { stringResult: true, searchOnEnter: false, defaultSearch: "cn" });






jQuery(grid_selector2).jqGrid({
				url:'resource.php?module=<?= $modules ?>&view=<?= $view ?>&action=data&opt=1',
				datastr:{},
				datatype: 'json',
				height: 380,
				width:jQuery(".grid-left").width(),//880 //1300
				

				colNames:['id', 'Tại phòng','Nhóm','Checkin','Đang chờ','Mức CB1','Mức CB2','Cảnh báo 1','Cảnh báo 2'],
				colModel:[
				{name:'id',index:'id', width:0, hidden: true},
		
				{name:'TenPhongBan',index:'TenPhongBan', width:10,hidden: false},
				{name:'TenNhomDichVu', align: 'left',index:'TenNhomDichVu', width:10,hidden:true},
				{name:'SoLuongDaCheking',sorttype: 'number', align: 'center',index:'SoLuongDaCheking', width:10},
				{name:'SoLuongDangCho',sorttype: 'number', align: 'center',index:'SoLuongDangCho', width:10},
				{name:'SLCanhBaoC1', align: 'center',index:'SLCanhBaoC1', width:10,hidden: true},
				{name:'SLCanhBaoC2', align: 'center',index:'SLCanhBaoC2', width:10,hidden: true},
				{name:'IsOverC1', align: 'center',index:'IsOverC1', width:10,hidden: true},
				{name:'IsOverC2', align: 'center',index:'IsOverC2', width:10,hidden: true},
				
				],
				loadonce: true,
				rowNum:1000,
				rowList:[10,20,30],
				altRows: true,                                                 
				multiselect: false,
				multiboxonly: false,
				onSelectRow: function(ids) { 
			 
			   	alert(ids);
			   },

				loadComplete :  function() {	 				
								resize_control();				
				
										
								}
			});

		});


	   //2 Lấy dữ liệu cho lưới
	   
	    //3 resize khi cửa sổ thay đổi
	    function flagCss (cellValue, opts, rowObject) { 
	    		var grid = $(this);
			var rowData = rowObject;
			var id=rowData["id"];
			//alert(id)
	    	//return cellValue + \"Testing price formatter\";
	    	return  "<div  class='animate-flicker' >"+cellValue+ "</div>";  
	    	 }

	     
	});

	// $('#grid-table').jqGrid('setGridParam', {url:'resource.php?module=<?= $modules ?>&view=<?= $view ?>&action=data', datatype: 'json'}).trigger("reloadGrid");

	function xem_click()
		{
		 $('#grid-table').jqGrid('setGridParam', {url:'resource.php?module=<?= $modules ?>&view=<?= $view ?>&action=data&opt='+$( "input:checked" ).val(), datatype: 'json'}).trigger("reloadGrid");
		}	   



	


</script>

</body>  
</html>
