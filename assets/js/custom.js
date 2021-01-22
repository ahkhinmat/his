//$.cookie("username_window", "hongocha");
//alert($.cookie("username_window"));
	String.prototype.replaceAll = function(search, replace) {
    if (replace === undefined) {
        return this.toString();
    }
    return this.split(search).join(replace);
	}
	function set_resolution(){
		if(screen.width<1336){
		   $("#tabs .ui-tabs-panel").css("overflow-x","scroll");
		   $("#tabs .ui-tabs-panel").css("overflow-y","hidden");
		   $("#tabs .ui-tabs-panel").css("height",$(window).height()-78+"px");
		   $("#tabs iframe").css("height",$(window).height()-105+"px");
		   window.resolution=true;
		}else{
		   window.resolution=false;
		}
	}
	function full_screen(){
		var docElement, request;
		docElement = document.documentElement;
		request = docElement.requestFullScreen || docElement.webkitRequestFullScreen || docElement.mozRequestFullScreen || docElement.msRequestFullScreen;

		if(typeof request!="undefined" && request){
			request.call(docElement);
		}
	}
	function check_file_type(type_array,type){
		window.file_type=true;
		//alert(type_array)
		types=type_array.split("|");
		//alert(types.length)
		for(i=0;i<types.length;i++){
			console.log(types[i]+"=="+type)
			if(types[i]==type){
				window.file_type=false;
				break;
			}
		}
		if (window.file_type==true){
			 parent.postMessage('post_message;' , '*');
			//tooltip_message("Chỉ chấp nhận file " + type_array);
		}
		//var _array=['image/png','image/jpg','image/jpeg'];

	}
	function print_preview(){
		var	 report_name_="";
		var	 default_url_="";
		
		//alert(report_name)
		if(typeof(report_name!="undefined")){
			report_name_=report_name
		}
		if(typeof(default_url!="undefined")){
			default_url_=default_url
		}
		var _dem=0
		goilenhin=setInterval(function(){
			send_message("print_preview",report_name_+"|"+default_url_);
			if (_dem==1){
				clearInterval(goilenhin);
			}
			_dem++;			
		},1000);
		/*$("body").mouseleave(function(e) {
			 //window.close();
		});*/
	}
	function print_direct(dongho1,dongho2){
		if(typeof(dongho1=="undefined")){
			dongho1=500
		}
		if(typeof(dongho2=="undefined")){
			dongho2=2000
		}
		
			t=setTimeout(function(){
				window.print();
				//alert("")
				d=setTimeout(function(){
					window.close();
			 	},dongho1);
			},dongho2);
	}
	function image_message(){
		var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
				var eventer = window[eventMethod];
				var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
				eventer(messageEvent,function(e) {
					_tam=e.data.split(";");
					if(_tam[0]=="edit_images"){
						edit_images(e.data);
					}else if(_tam[0]=="close_edit"){
						$( ".modal6754353898787675" ).dialog( "close" );
					}else if(_tam[0]=="fullview"){
						elem="6754353898787677";
						if(_tam[1]=="undefined"){
							 return tooltip_message("Không có ảnh để phóng to");
						}
							dialog_main("Xem ảnh (Ctrl+click để zoom out, click để zoom in) ", 95, 95, elem, "") ;
							$(".modal6754353898787677").append('<table id="fullview_container" style="height:100%;width:100%;" cellpadding="0" cellspacing="0" border="0"><tr><td valign="middle" align="center"><img tabindex="1" id="full_view" /></td></tr></table>');
							$(".modal6754353898787677 img").attr("src",_tam[1]);
							$("#full_view").css("cursor","-webkit-zoom-out");
							$("#full_view").css("cursor","-moz-zoom-out");
							$("#full_view").css("box-shadow","0 0 5px #383838");

							var _img_height,_img_width;
							var _step = 100;
							var _ctrlKey=true
							$('img#full_view').each(function() {
								_img_height=$(this).height();
								_img_width=$(this).width();
								//$(this).attr('height',$(this).height());
								$(this).attr('width',$(this).width());

							});
							$("img#full_view").click(function(e) {
								if (e.ctrlKey){
									if($(this).attr('width') - _step > 200){
										//$(this).fadeOut("fast").attr('width',parseFloat($(this).attr('width')) - _step).fadeIn(500);
										$(this).attr('width',parseFloat($(this).attr('width')) - _step);
										$("#full_view").css("cursor","-webkit-zoom-out");
										$("#full_view").css("cursor","-moz-zoom-out");
									}
								}else{
									$(this).attr('width',parseFloat($(this).attr('width')) + _step);
									$("#full_view").css("cursor","-webkit-zoom-in");
									$("#full_view").css("cursor","-moz-zoom-in");

								}
							});
							$('img#full_view').bind('keydown', function(e) {
								if (e.ctrlKey){
									$("#full_view").css("cursor","-webkit-zoom-out");
									$("#full_view").css("cursor","-moz-zoom-out");
								}
							});
							$('img#full_view').bind('keyup', function(e) {
								if (!e.ctrlKey){
									$("#full_view").css("cursor","-webkit-zoom-in");
									$("#full_view").css("cursor","-moz-zoom-in");
								}
							});

					}else if(_tam[0]=="loaddone"){
						//alert(_id_trangthai)
						var o = document.getElementsByTagName('iframe')[0];
						t=setTimeout(function(){
							if(($('#boqua').css("display")=="none")&&(_id_trangthai!="DangKham")){
									$("#images_viewer").contents().find(".delete_image").css("visibility","hidden");
									//$("#images_viewer")[0].contentWindow.set_status(false);
									o.contentWindow.postMessage(false, '*');

							} else{
								o.contentWindow.postMessage(true, '*');
							}
						},500);
					}

				},false);

	}
	function lock_viewer(_value,_css){
		$("#images_viewer").contents().find(".delete_image").css("visibility",_css);
		var o = document.getElementsByTagName('iframe')[0];
		o.contentWindow.postMessage(_value, '*');
	}
	function get_available(){
		 parseUri.options.strictMode = true
		 var uri = window.document.URL.toString();
	     var id_loai = parseUri(uri).queryKey["id_loai"];
	}
	function create_print_popup(data,width,height,left,top){
		 if((left==0)&&(top==0)){
		 	  popup_print=window.open('about:blank', 'newwin', 'width='+width+',height='+height+',location=0');
		 }else{
			  popup_print=window.open('about:blank', 'newwin', 'width='+width+',height='+height+',location=0,left='+left+',top='+top);
		 }
		 with(popup_print.document){
			  open();
			  write(data);
			  close();
		 };
		 popup_print.focus();
		// parent.focus();
	 }
	 function get_printer(elem,callback,IP,UserWindowName,TenReport){
		TenReport1=TenReport;
		var   TenMay = "'Khong xac dinh'";
      	var   TenReport = "'"+TenReport+"'";
	  	var   UserWindowName = "'"+UserWindowName+"'";
	  	var	  IPMay = "'"+IP+"'";
	  	var  search ={"search":'( TenMay ='+TenMay+' OR IPMay = ' +IPMay+ ' ) and ( TenReport = '+TenReport+') '};
		//var  search ={"search":'( TenMay ='+TenMay+' OR IPMay = ' +IPMay+ ' ) and ( TenReport = '+TenReport+' and  UserWindowName = '+UserWindowName+') '};
	  //	alertObject(search)
		$.post( "resource.php?module=web_services&function=get_print&action=index",search)
		.done(function( data ) {
			//alert(data)
			if(data==1){
				//alert( "Không load được cấu hình máy in cho report này!");
			}else{
				//alert(data);
				tam=data.split(";");
				printer_config=data;
				//alert(printer_config)				 
				elem1=elem;
				callback();
				// alert("chinh")
			}
		});

	 }
	 function set_printer () {
		 if(elem1=="none"){
			  var eventName, detailVal, normBtnPressed  = (this.id == "normalDataBtn");
                    eventName   = "EventWithArrayDataFromPage";

					_tam=printer_config.split(";");
					console.log(_tam)
					//alert(printer_config+": "+_tam[2])
                    detailVal   = ["printer_config",_tam[0], _tam[1], _tam[3]];
					var zEvent = new CustomEvent (eventName,
						{"detail": detailVal }
					);
                window.dispatchEvent (zEvent);
		 }else{
            $(elem1).click ( function () {
				//alert("")
                var eventName, detailVal, normBtnPressed  = (this.id == "normalDataBtn");
                    eventName   = "EventWithArrayDataFromPage";

					_tam=printer_config.split(";");
					console.log(_tam)
					//alert(printer_config+": "+_tam[2])
                    detailVal   = ["printer_config",_tam[0], _tam[1], _tam[3]];
					var zEvent = new CustomEvent (eventName,
						{"detail": detailVal }
					);
                window.dispatchEvent (zEvent);
            });
		 }
	}
	function set_print_select() {
		_tam=printer_config.split(";");
		$("#printer_list").val(_tam[0]);
		/*$("#printer_list").change( function () {
			var eventName, detailVal, normBtnPressed  = (this.id == "normalDataBtn");
				eventName   = "EventWithArrayDataFromPage";
				_tam=printer_config.split(";");
				//alert(printer_config+": "+_tam[2])
				detailVal   = ["printer_config",$("#printer_list :selected").val(), _tam[1], _tam[3]];
				var zEvent = new CustomEvent (eventName,
					{"detail": detailVal }
				);
			window.dispatchEvent (zEvent);
			update_print_ = $.ajax({url: 'resource.php?module=web_services&function=update_printer&action=index&id_form=111&printer='+$("#printer_list :selected").val()+'&report='+TenReport1, async: false, success: function(data, result) {
							 
			}}).responseText;
		})		*/ 
         $(elem1).click ( function () { 
		  
			 var eventName, detailVal, normBtnPressed  = (this.id == "normalDataBtn");
				eventName   = "EventWithArrayDataFromPage";//alert(printer_config)
				_tam=printer_config.split(";");
				//alert(printer_config+": "+_tam[2])
				detailVal   = ["printer_config",$("#printer_list :selected").val(), _tam[1], _tam[3]];
				var zEvent = new CustomEvent (eventName,
					{"detail": detailVal }
				);
			window.dispatchEvent (zEvent);
			update_print_ = $.ajax({url: 'resource.php?module=web_services&function=update_printer&action=index&id_form=111&printer='+$("#printer_list :selected").val()+'&report='+TenReport1, async: false, success: function(data, result) {
							 
			}}).responseText;           
			 t=setTimeout(function(){
				 if (window.frames['mht'] == null){
					alert('document not found');
				   } else {
					window.frames['mht'].focus();
					window.frames['mht'].print();
				  }
			 },200);			 
           }); 
	}
	function set_printer_iframe () {
            $(elem1).click ( function () {			 		 			 
                var eventName, detailVal, normBtnPressed  = (this.id == "normalDataBtn");
                    eventName   = "EventWithArrayDataFromPage";
					_tam=printer_config.split(";");
					//alert(printer_config+": "+_tam[2])
                    detailVal   = ["printer_config",_tam[0], _tam[1], _tam[3]];
					var zEvent = new CustomEvent (eventName,
						{"detail": detailVal }
					);
                window.dispatchEvent (zEvent);
				 t=setTimeout(function(){
					 if (window.frames['mht'] == null){
						alert('document not found');
					   } else {
						window.frames['mht'].focus();
						window.frames['mht'].print();
					  }
				 },200);
				
				 
            });
	}
	function send_message(command,_value){
		console.log(command+" "+_value)
	 var eventName, detailVal, normBtnPressed  = (this.id == "normalDataBtn");
		eventName   = "EventWithArrayDataFromPage";
		detailVal   = [command,_value];
		var zEvent = new CustomEvent (eventName,
			{"detail": detailVal }
		);
	window.dispatchEvent (zEvent);
	}
	function prin_preview (url) {
			var eventName, detailVal, normBtnPressed  = (this.id == "normalDataBtn");
				eventName   = "EventWithArrayDataFromPage";
				detailVal   = ["preview",url];
			var zEvent = new CustomEvent (eventName,
				{"detail": detailVal }
			);
			window.dispatchEvent (zEvent);
	}
function edit_images(tam){
 tam=tam.split(";");
 elem="6754353898787675";
 dialog_add_dm('Chỉnh sửa hình ảnh',95,95,elem,'resource.php?module=images_control&view=images_edit&id_form=49&search_string='+tam[1]+"&tenthumuc="+tam[2],refresh_images);
}
function refresh_images(){
  $("#images_viewer").attr("src",$("#images_viewer").attr("src"));
}

/*window.addEventListener ("ImAlivefromExtension", function (zEvent) { check plugin
	var statDisplay = document.getElementById ("extensionStatus");
	statDisplay.textContent = "The test extension appears to be loaded!";
	statDisplay.className   = "okay";
} );*/

window.addEventListener ("EventWithArrayDataFromPage", function (zEvent) {
	console.log (
		"In web page (Normal) from page: ", zEvent.detail, Array.isArray (zEvent.detail)
	);
});

window.addEventListener ("username", function (zEvent) {
	$.cookie("username_window", zEvent.detail);
	//alert(zEvent.detail[0])
	//alert(zEvent.detail);
            console.log (
                "username: ", zEvent.detail, Array.isArray (zEvent.detail)
            );
	//alert($.cookie("username_window"));
});

window.addEventListener ("maphongban", function (zEvent) {
	$.cookie("phongbanclient", zEvent.detail);
	//alert(zEvent.detail);
            console.log (
                "maphongban: ", zEvent.detail, Array.isArray (zEvent.detail)
            );
	//alert($.cookie("username_window"));
});
window.addEventListener ("printers", function (zEvent) {
	$.cookie("printers", zEvent.detail);
	//alert(zEvent.detail);
            console.log (
                "printers: ", zEvent.detail, Array.isArray (zEvent.detail)
            );
	//alert($.cookie("username_window"));
});
window.addEventListener ("dstang", function (zEvent) {
	$.cookie("dstang", zEvent.detail);
	//alert(zEvent.detail);
            console.log (
                "dstang: ", zEvent.detail, Array.isArray (zEvent.detail)
            );
	//alert($.cookie("username_window"));
});
/*	var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
			var eventer = window[eventMethod];
			var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
			eventer(messageEvent,function(e) {		
			 alert(e.data)
			})*/

window.addEventListener ("dskho", function (zEvent) {
	
	$.cookie("dskho", zEvent.detail);
            console.log (
                "dskho: ", zEvent.detail, Array.isArray (zEvent.detail)
            );

});
window.addEventListener ("getdomain", function (zEvent) {
	$.cookie("domain", zEvent.detail);
            console.log (
                "dskho: ", zEvent.detail, Array.isArray (zEvent.detail)
            );

});
window.addEventListener ("close_send_print", function (zEvent) {
	 //alert("close_send_print")
	 clearInterval(goilenhin);

});
window.addEventListener ("closetab", function (zEvent) {
	 alert("closetab");

});
window.addEventListener ("EventWithJSON_DataToPage", function (zEvent) {
	var datArray    = JSON.parse (zEvent.detail);
	console.log (
		"In web page (JSON): ", datArray, Array.isArray (datArray)
	);
});
function tooltip_message(message) {
	if($(".tooltips").length==1){
		return false;
	}
    $("body").append("<div class='tooltips'></div>");
    $('.tooltips span').remove();
    $('.tooltips').append($('<span></span>'));
    $('.tooltips span').html(message);
    width = $(".tooltips").width();
    $(".tooltips").css('top', ($(window).height() / 2) + 'px');
    $(".tooltips").css('left', ($(window).width() / 2) - width / 2 + 'px');
    $('.tooltips').fadeIn(1500, function() {
        /*	if(elem!="body"){
         $( ".tooltips").effect({effect:"explode",pieces:"50",duration:"slow",complete: function() {
         $('.tooltips').remove();
         }
         });
         }else{*/
        $(".tooltips").delay(1500).fadeOut(1000, function() {
            $('.tooltips').remove();
        })
        //}
    });


}
function xuongdong(formid) {
    $(".ui-widget-overlay").hide();
    /*$(".DataTD textarea,.DataTD select,.DataTD input,.DataTD a").focus(function() {
        $(this).css("box-shadow", "0 0 4px 2px #208AC8");
    });
    $(".DataTD textarea,.DataTD select,.DataTD input,.DataTD a").focusout(function() {
        $(this).css("box-shadow", "");
    });
    $("#sData,#cData").focus(function() {
        $(this).css("box-shadow", "0 0 4px 2px #208AC8");
    });
    $("#sData,#cData").focusout(function() {
        $(this).css("box-shadow", "");
    });*/
    var tam = [], i = 0;
    $('#' + formid[0].id).find('textarea,select,input,a').each(function() {
        if ($(this).css("display") != "none") {
            tam[i] = this.id;
            i++;
        }
    })
    //alert (i)
    //$("#" + tam[0]).css("box-shadow", "0 0 4px 2px #208AC8");
    $("#editmodrowed3").css("box-shadow", "0px 0px 5px #888888");
    jwerty.key('enter', false);
    $('.FormElement').bind('keydown', function(e) {
        if (jwerty.is('enter', e)) {
            //alert(e.target )
            var ii = 0;
            for (ii = 0; ii <= tam.length; ii++) {
                if (tam[ii] == $(this).attr("id")) {
                    break;
                }
            }
            $("#" + tam[ii + 1]).focus();
            if (ii == tam.length - 2) {
                $("#sData").focus();
            }
            // $(this).next('.FormElement').focus();
            // $( e.target ).closest("select.FormElement").focus();
        }
    });
}

function lendong(formid) {
    /* $(".DataTD textarea,.DataTD select,.DataTD input").focus(function(){
     $(this).css("box-shadow","0px 0px 6px #666");
     });
     $(".DataTD textarea,.DataTD select,.DataTD input").focusout(function(){
     $(this).css("box-shadow","");
     });	*/
    var tam = [], i = 0;
    $('#' + formid[0].id).find('textarea,input[type=text],select,input[type=checkbox],input[type=radio],input').each(function() {
        tam[i] = this.id;
        //console.log($(this).attr("name"))
        i++;
    })

    //jwerty.key('enter', false);
    $('.FormElement').bind('keydown', function(e) {
        if (jwerty.is('ctrl+enter', e)) {
            //alert(e.target )
            var ii = 0;
            for (ii = 0; ii <= tam.length; ii++) {
                if (tam[ii] == $(this).attr("id")) {
                    break;
                }
            }
            $("#" + tam[ii - 1]).focus();
            // $(this).next('.FormElement').focus();
            // $( e.target ).closest("select.FormElement").focus();
        }
    });
}
function split_string_grid_select(strings,remark){
	temp=strings.split(";");
	for (i=0;i<temp.length;i++){
		temp1=temp[i].split(":");
		if(remark==temp1[0]){
			return temp1[1];
		}
	}

}

function canhgiua(formid) {
    temp = (formid[0].id).split("_");
    var grid = $("#" + temp[1]);
    var dlgDiv = $("#editmod" + grid[0].id);
    var parentDiv = dlgDiv.parent();
    var dlgWidth = dlgDiv.width();
    var parentWidth = parentDiv.width();
    var dlgHeight = dlgDiv.height();
    var parentHeight = parentDiv.height();
    // TODO: change parentWidth and parentHeight in case of the grid
    //       is larger as the browser window

	 dlgDiv[0].style.top = Math.round(($(window).height() - dlgHeight) / 2) + "px";
     dlgDiv[0].style.left = Math.round(($(window).width()- dlgWidth) / 2) + "px";
   // dlgDiv[0].style.top = Math.round((parentHeight - dlgHeight) / 2) + "px";
   // dlgDiv[0].style.left = Math.round((parentWidth - dlgWidth) / 2) + "px";
}
function canhgiua_del(formid) {
    temp = (formid[0].id).split("_");
    var grid = $("#" + temp[1]);
    var dlgDiv = $("#delmod" + grid[0].id);
    var parentDiv = dlgDiv.parent();
    var dlgWidth = dlgDiv.width();
    var parentWidth = parentDiv.width();
    var dlgHeight = dlgDiv.height();
    var parentHeight = parentDiv.height();
    // TODO: change parentWidth and parentHeight in case of the grid
    //       is larger as the browser window

	 dlgDiv[0].style.top = Math.round(($(window).height() - dlgHeight) / 2) + "px";
     dlgDiv[0].style.left = Math.round(($(window).width()- dlgWidth) / 2) + "px";
   // dlgDiv[0].style.top = Math.round((parentHeight - dlgHeight) / 2) + "px";
   // dlgDiv[0].style.left = Math.round((parentWidth - dlgWidth) / 2) + "px";
}

var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
eventer(messageEvent, function(e) {
    if (e.data == 'traodoi') {
        $(".bongda").trigger("click");
    }
})


function getCellValue(rowId, cellId) {
    var cell = jQuery('#' + rowId + '_' + cellId);
    var val = cell.val();
    return val;
}

/*
 *
 * @param {type} title: Tên header của form
 * @param {type} width
 * @param {type} height
 * @param {type} row
 * @param {type} colName: tên cột
 * @returns {undefined}
 * author: khatm
 * date:13/9/2013
 *
 */


function dialog_form(title, width, height) {
    $("body").append('<div class="sub_grid"><table id="rowed6" style="width:100%" ><div class="form_row"><label>Loại Lịch</label><span><select name="loailichcopy" id="loailichcopy" ></select><input type="text" style="display:none" name="text_loailichcopy" id="text_loailiccopyh"></span></div><br><div class="form_row"><label>Phòng ban</label><span><select name="phongbancopy" id="phongbancopy" ></select><input type="text" style="display:none" name="text_phongbancopy" id="text_phongbancopy"></span></div><br><div class="form_row"><label>Tuần Copy</label><span><input type="text" name="week1" id="week1"><input type="hidden" name="week_mask1" id="week_mask1"><input type="hidden" name="week_maskfrom" id="week_maskfrom"></span></div><br><div class="form_row"><label>Tuần Paste</label><span><input type="text" name="week2" id="week2"><input type="hidden" name="week_mask2" id="week_mask2"><input type="hidden" name="week_maskto" id="week_maskto"></span></div><br> <br><a style="margin-left:0px;" class="fm-button ui-state-default ui-corner-all fm-button-icon-left" id="sCopylich" href="#">Copy Lịch<span class="ui-icon ui-icon-copy"></span></a></div><div id="dialog-confirm" ><p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Đã có lịch tuần Copy </p></div></table>');
    $("body").remove(".ui-jqdialog");
    $(this).remove();

    $("#week1").datepicker({
        showWeek: true,
        firstDay: 1,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 4,
        yearRange: year_range,
        onClose: function(selectedDate) {
            // $("#week2").datepicker("option", "minDate", $("#week_maskfrom").val());
            //$("#week1").val(fr);

        },
        onSelect: function(dat, inst) {
            var week1 = $.datepicker.iso8601Week(new Date(dat));

            $('#week1').val("tuần: " + (week1 < 10 ? '0' : '') + week1 + " của năm: " + $.datepicker.formatDate('yy', new Date(dat)));
            $("#week_maskfrom").val(dat);
            var date = new Date(dat);
            var date1 = new Date(dat)
            var day = date.getDay() || 7;
            var day1 = date1.getDay() || 7;
            date.setHours(-24 * (day - 1));
            firstDay2 = $.datepicker.formatDate("yy-mm-dd", date);
            date1.setHours(-24 * (day1 - 7));
            lastDay2 = $.datepicker.formatDate("yy-mm-dd", date1);
            lastDay3 = $.datepicker.formatDate("dd/mm/yy", date1);
            $('#week_mask1').val(firstDay2 + ";" + lastDay2);
            //alert($.datepicker.formatDate('',new Date(dat))+(week<10?'0':'')+week);week_mask

        }

    });
    $("#week2").datepicker({
        showWeek: true,
        firstDay: 1,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 4,
        yearRange: year_range,
        onClose: function(selectedDate) {
            //  $("#week1").datepicker("option", "maxDate", $("#week_maskto").val());
            //  $("#week2").val(to);
            //   $("#week1").val(fr);
        },
        onSelect: function(dat, inst) {
            var week2 = $.datepicker.iso8601Week(new Date(dat));

            $('#week2').val("tuần: " + (week2 < 10 ? '0' : '') + week2 + " của năm: " + $.datepicker.formatDate('yy', new Date(dat)));
            $("#week_maskto").val(dat);
            var date = new Date(dat);
            var date1 = new Date(dat)
            var day = date.getDay() || 7;
            var day1 = date1.getDay() || 7;
            date.setHours(-24 * (day - 1));
            firstDay2 = $.datepicker.formatDate("yy-mm-dd", date);
            date1.setHours(-24 * (day1 - 7));
            lastDay2 = $.datepicker.formatDate("yy-mm-dd", date1);
            $('#week_mask2').val(firstDay2 + ";" + lastDay2);
            //alert($.datepicker.formatDate('',new Date(dat))+(week<10?'0':'')+week);week_mask
        }
    });
    window.phongbancopy = $.ajax({url: 'resource.php?module=web_services&function=get_auto_edit_option_byid&action=index&term=IsPhongChuyenMon=0&status=2&tables=DM_PhongBan&id=ID_PhongBan&name=TenPhongBan', async: false, success: function(data, result) {
            if (!result)
                alert('Không load được danh mục phòng ban');
        }}).responseText;
    phongbancopy1 = phongbancopy.split(";");
    for (i = 0; i <= phongbancopy1.length - 1; i++) {
        temp = phongbancopy1[i].split(":");
        $('#phongbancopy').append($('<option>', {
            value: temp[0],
            text: temp[1]
        }));
    }
    window.loailichcopy = $.ajax({url: 'resource.php?module=web_services&function=get_auto_edit_option&action=index&term=&status=2&tables=DM_LoaiLich&id=ID_LoaiLich&name=TenLoaiLich', async: false, success: function(data, result) {
            if (!result)
                alert('Không load được danh mục phòng ban');
        }}).responseText;
    $('#loailichcopy').append($('<option>', {
        value: null,
        text: ''
    }));
    loailichcopy1 = loailichcopy.split(";");

    for (i = 0; i <= loailichcopy1.length - 1; i++) {
        temp = loailichcopy1[i].split(":");
        $('#loailichcopy').append($('<option>', {
            value: temp[0],
            text: temp[1]
        }));
    }


    $(".sub_grid").dialog({
        height: height,
        width: width,
        modal: false,
        title: title,
        stack: true,
        open: function(event, ui) {
            $("#dialog-confirm").dialog({
                autoOpen: false,
                height: 140,
                modal: false,
                zIndex: 2000,
                stack: true,
                buttons: {
                    "Delete all items": function() {
                        var kiemtra = 1;
                        aa(kiemtra);
                        $(this).dialog("close");
                    },
                    Cancel: function() {
                        $(this).dialog("close");
                    }
                }

            });

            autocompleted_combobox('#loailichcopy');
            autocompleted_combobox('#phongbancopy');
            $("#sCopylich").click(function()
            {
                var kiemtra = 0;
                aa(kiemtra);
            });
            $('.ui-draggable').css({"box-shadow": "0px 0px 10px rgb(136, 136, 136)"});
        },
        close: function(event, ui) {
            $("#dialog-confirm").dialog('destroy');
            $(this).dialog('destroy');
            $(this).remove();
            $("body").remove(".ui-jqdialog");
            $(this).remove();

        }

    });
}
function aa(kiemtra) {
    var elem1 = [];
    var elem2 = [];
    elem1 = ($('#week_mask1').val()).split(";");
    elem2 = ($('#week_mask2').val()).split(";");
    window.loailichcopy = $.ajax({url: 'resource.php?module=lich&view=lich_lam_viec&action=controller_Copy&loailich=' + $("#loailichcopy option:selected").val() + '&phongban=' + $("#phongbancopy option:selected").val() + '&fromcopy=' + elem1[0] + '&tocopy=' + elem1[1] + '&frompaste=' + elem2[0] + '&topaste=' + elem2[1] + '&kiemtra=' + kiemtra + '', async: false, success: function(data, textStatus, jqXHR) {
            if (jqXHR.responseText == 1) {
                $("#dialog-confirm").dialog("open");
            } else {
                tooltip_message("Copy Lịch thành công");
            }
        }}).responseText;


}

function callIframe(links, callback, elem) {
    window.elem = elem;
    $('.frame_' + elem).attr("src", links);
    $('.frame_' + elem).load(function() {
        callback(this);
    });
}
function hide_loader() {
    $(".loading").fadeOut(300, function() {
        $(".loading").remove();
    });
    $('.frame_' + window.elem).css({opacity: 0, visibility: "visible"}).animate({opacity: 1}, 300, function() {
        $('.frame_' + elem).focus();
    });
}

function dialog_main(title, width, height, elem, links) {
	if(links!=""){
		$("body").append("<div class='ui-jqdialog modal" + elem + "'><div class='loading'><div id='loading'></div></div><iframe id='frame1' class='frame_" + elem + "' src=''></iframe></div>");
	}else{
		$("body").append("<div class='ui-jqdialog modal" + elem + "'> </div>");
	}

	if (String(width).match(/px/g)==null){
		 width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
	}else{
		width=String(width).replace("px","")
	};
	if (String(height).match(/px/g)==null){
		 height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
	}else{
		 height=String(height).replace("px","")
	};

  //alert(links)
   // width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
    //height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
    $(".modal" + elem).dialog({
        height: height,
        width: width,
        modal: true,
        title: title,
		draggable: false,
		resizable: false,
        stack: true,
        close: function(event, ui) {
			$(".hidden_form").html(window.hidden_form);
            $("body").remove(".modal" + elem);
            $(this).remove();
        },
        hide: {
            effect: "fadeOut",
            duration: 1000,
        },
        open: function(event, ui) {
			callIframe(links, hide_loader, elem);
            $('.ui-draggable').css({"box-shadow": "0px 0px 30px #333"});
        },


    });
    $(".ui-dialog").css("box-shadow","0px 0px 10px #000");
}
var zindex_custom=1000;
function custom_dialog(title,width,height,elem,links){
		if (String(width).match(/px/g)==null){
			 width = ($(window).width() / 100 * parseFloat(width)).toFixed(0)+"px";
		}
		if (String(height).match(/px/g)==null){
			 height = ($(window).height() / 100 * parseFloat(height)).toFixed(0)+"px";
		}
	 var template='<div id="dialog_'+elem+'" class="ui-widget ui-widget-content ui-corner-all ui-front ui-draggable" style="position:absolute;height: '+height+'; width: '+width+'; top: 294.5px; left: 518px; display: block; box-shadow: 0px 0px 10px rgb(0, 0, 0);z-index:'+zindex_custom+'!important" tabindex="-1" role="dialog" ><div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" style="margin:2px 2px"><span style="margin-left:7px;display: inline-block;padding-top:1px; font-weight:normal" class="ui-dialog-title">'+title+'</span><div style="float:right; font-size:8px!important;margin-top:1px;margin-bottom:1px;"><button style="box-shadow:0px 0px 5px #383838;" id="close">Đóng</button></div></div>';
	 template+=' <div class="upload_frame ui-jqdialog modal476240749 ui-dialog-content ui-widget-content"  style="display: block; width: auto; min-height: 0px; max-height: none; height: 29px;"><iframe class="frame_"'+elem+' id="frame'+elem+'" style="opacity: 1; visibility: visible;"></iframe></div></div>';
	 $("body").append(template);
	  $("#dialog_"+elem+ " #close" ).button({
		  text: false,
		  icons: {
			primary: "ui-icon-close"
		  }
		}).click(function(e) {
			 $("#dialog_"+elem).fadeOut(200,function(e){
				 $("#dialog_"+elem + " #frame"+elem).remove();
				$("#dialog_"+elem).remove();
				console.log($("#dialog_"+elem + " #frame"+elem).length)
			 });
		});
	 t=setTimeout(function(){
			$("#frame"+elem).attr("src",links);
			$("#dialog_"+elem).draggable();
			$("#dialog_"+elem).mousedown(function(e) {
				$("body").append("<div class='ui-widget-overlay'></div>");
                zindex_custom++;
				$("#dialog_"+elem).css("z-index",zindex_custom);
				$(".ui-widget-overlay").click(function(e) {
					//alert("")
					$(".ui-widget-overlay").remove();
				});
				//alert($("#dialog_"+elem).zIndex())
				console.log($("#dialog_"+elem).zIndex())
            });
			$("#dialog_"+elem).mouseup(function(e) {
				$(".ui-widget-overlay").remove();

            });
			t=setTimeout(function(){
				$("#dialog_"+elem + " #frame"+elem)[0].contentWindow.postMessage(elem, '*');
			},3000);

	 },200);
}
function dialog_upload(title, width, height, elem, links) {
	if(links!=""){
		$("body").append("<div class='upload_frame ui-jqdialog modal" + elem + "'><div class='loading'><div id='loading'></div></div><iframe id='frame"+elem+"' class='frame_" + elem + "' src=''></iframe></div>");
	}else{
		$("body").append("<div class='ui-jqdialog modal" + elem + "'> </div>");
	}

	if (String(width).match(/px/g)==null){
		 width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
	}else{
		width=String(width).replace("px","")
	};
	if (String(height).match(/px/g)==null){
		 height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
	}else{
		 height=String(height).replace("px","")
	};

  //alert(links)
   // width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
    //height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
    $(".modal" + elem).dialog({
        height: height,
        width: width,
        modal: false,
        title: title,
		draggable: true,
		resizable: false,
        stack: false,
        close: function(event, ui) {
            $("body").remove(".modal" + elem);
            $(this).remove();
        },
        hide: {
            effect: "fadeOut",
            duration: 1000,
        },
        open: function(event, ui) {
		// $('.ui-widget-overlay').remove();

			callIframe(links, hide_loader, elem);
            $('.ui-draggable').css({"box-shadow": "0px 0px 30px #333"});
			  	t=setTimeout(function(){
				$("#frame"+elem)[0].contentWindow.postMessage(elem, '*');
			},3000);
        },


    });
    $(".ui-dialog").css("box-shadow","0px 0px 10px #000");
}
function dialog_report(title, width, height, elem, links,report_name,iframe_width) {
	if(links!=""){
		links+="&report_name="+report_name;
		$("body").append("<div class='ui-jqdialog modal" + elem + "'><div class='loading'><div id='loading'></div></div><div style='height:100%' align='center' ><iframe name='report_inan' id='frame1' class='frame_" + elem + "' src='' style='width:"+iframe_width+"px;opacity:1; visibility: visible;overflow-y:visible;box-shadow:0px 0px 2px #000'></iframe></div></div>");
	}else{
		$("body").append("<div class='ui-jqdialog modal" + elem + "'> </div>");
	}

	if (String(width).match(/px/g)==null){
		 width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
	}else{
		width=String(width).replace("px","")
	};
	if (String(height).match(/px/g)==null){
		 height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
	}else{
		 height=String(height).replace("px","")
	};

    //alert(links)
    //width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
    //height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
    $(".modal" + elem).dialog({
        height: height,
        width: width,
        modal: true,
        title: title,
		draggable: false,
		resizable: false,
        stack: false,
        close: function(event, ui) {
			$("body").remove(".modal" + elem);
            $(this).remove();
        },
        hide: {
            effect: "fadeOut",
            duration: 1000,
        },
        open: function(event, ui) {
				//dom.disable_window_flip;false
			 if($.cookie("in_status")=="print_preview"){				   
					popup_print=window.open(links);	
					callIframe(links, hide_loader, elem);
					$('.ui-draggable').css({"box-shadow": "0px 0px 30px #333"});
					$(".ui-dialog-title:contains('Xem trước khi in')").append('<input type="button" id="print_view" value="In" />');
					get_printer("#print_view",set_printer,$.cookie('remote_ip'),$.cookie('username_window'),report_name);
					t=setTimeout(function(){
						$("#print_view").click();
						$(".modal" + elem).dialog("close");
					},500);				
			 }else if($.cookie("in_status")=="print_direct"){
				    get_printer("none",set_printer,$.cookie('remote_ip'),$.cookie('username_window'),report_name);
					window.open(links, '_blank', 'width=10,height=10,location=0,left=0,top=0');;
					self.focus();
					window.focus();
					return false;
			 }
			/*popup_print=window.open(links, '_blank', 'width=10,height=10,location=0,left=0,top=0').focus();
			self.focus();
			window.focus(); */
			/*popup_print=window.open(links, '_blank', 'width=10,height=10,location=0,left=0,top=0').focus();
			self.focus();
			window.focus();*/
		
			/*get_printer("#print_report",set_printer,$.cookie('remote_ip'),$.cookie('username_window'),report_name);
				$("#print_report").click(function(){
					t=setTimeout(function(){
						window.frames["report_inan"].focus();
						window.frames["report_inan"].print();
						clearTimeout(t);
					},100);
				});	*/
        },
    });
   // $(".ui-dialog").css("box-shadow","0px 0px 10px #000");
}



function dialog_pic_select(title, width, height,elem,search_string,report_name,type,title_report,title_report1,doctor,panel,pic_number,report_template,module,iframe_width) {
	$("body").append("<div class='ui-jqdialog modal" + elem + "'><div id='images_thumnail'></div> </div>");
	if (String(width).match(/px/g)==null){
		 width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
	}else{
		width=String(width).replace("px","")
	};
	if (String(height).match(/px/g)==null){
		 height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
	}else{
		 height=String(height).replace("px","")
	};
   // width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
    //height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
    $(".modal" + elem).dialog({
        height: height,
        width: width,
        modal: false,
        title: title,
		draggable: false,
		resizable: false,
        stack: false,
        close: function(event, ui) {
            $("body").remove(".modal" + elem);
            $(this).remove();
        },
        hide: {
            effect: "fadeOut",
            duration: 1000,
        },
        open: function(event, ui) {
			get_printer("#print_view",set_printer,$.cookie('remote_ip'),$.cookie('username_window'),report_name);
			var _links="";
			$(".ui-dialog-title:contains('Chọn ảnh')").append('            <input type="button" id="print_view" value="Xem in" />');
			 //$('tr.rowed3ghead_0:has(td:contains("'+window.parent11+'"))').attr("id");
			$(".ui-dialog-title input#print_view").click(function(){


				$('#images_thumnail').find(':input[type=checkbox]').each(function(){
					if($("#"+this.id).is(":checked" )) {
						  _links+=encodeURIComponent($("#thumn_"+this.id.replace("c_","")).attr("src"))+":::";
					}
				});
				$(".modal" + elem).dialog("close");
				var _popup_link="resource.php?module=report&view="+module+"&action="+report_template+"&header="+panel+"&id_benhnhan="+id_benhnhan+"&id_kham="+id_kham+"&links="+_links+"&type=report&id_form=10&tieude="+title_report+"&chucnang="+title_report1+"&chucdanh="+doctor+"&report_name="+report_name;
				width=500;
				height=500;
				left=0;
				top=0;
				//window.open("http://www.w3schools.com");
				//popup_print=window.open(_popup_link, '_blank', 'width='+width+',height='+height+',location=0,left='+left+',top='+top).focus();
				window.open(_popup_link);
				//parent.postMessage("in_an;Xem trước khi in;95;95;u78787878975f;resource.php?module=report&view="+module+"&action="+report_template+"&header="+panel+"&id_benhnhan="+id_benhnhan+"&id_kham="+id_kham+"&links="+_links+"&type=report&id_form=10&tieude="+title_report+"&chucnang="+title_report1+"&chucdanh="+doctor+";"+report_name+";"+iframe_width, '*')
				//dialog_report("Xem trước khi in",90,90,"u78787878975f","resource.php?module=report&view=canlamsang&action="+report_name+"&header=left&id_benhnhan="+id_benhnhan+"&id_kham="+id_kham+"&links="+_links+"&type=report&id_form=10",report_name);
				_links="";


			});
            $('.ui-draggable').css({"box-shadow": "0px 0px 30px #333"});
			$.getJSON( 'file_manager/php/connector.php?answer=42&tenthumuc='+_folder_name+'&cmd=search&q='+search_string+'&_=1387364774212',
				function( data ) {
				/*for(i=0;i<data["files"].length;i++){
					if(String(data["files"][i]["mime"]).match('image')!=null){
						if(i<pic_number){
							_check='checked="checked"';
						}else{
							_check=' ';
						}
						$("#images_thumnail").append( '<div class="thum_container"><span class="check_image"><input class="check_mask" type="checkbox" '+_check+' id="c_'+i+'" /></span><img id="thumn_'+i+'" alt="'+data["files"][i]["hash"]+'" lang="'+data["files"][i]["name"]+'" style="width:90px; height:100px" src="file_manager/php/connector.php?tenthumuc='+_folder_name+'&answer=42&cmd=file&target='+data["files"][i]["hash"]+'" /></div>')
						 
					};
				};*/
				var image_arr=[];
				for(i=0;i<data["files"].length;i++){
					if(String(data["files"][i]["mime"]).match('image')!=null){
						 image_arr[i]=data["files"][i]["name"];
					}
				}
				image_arr.sort(natcmp);
				for(i=0;i<image_arr.length;i++){
					    if(i<pic_number){
							_check='checked="checked"';
						}else{
							_check=' ';
						}
					 $("#images_thumnail").append( '<div class="thum_container"><span class="check_image"><input class="check_mask" type="checkbox" '+_check+' id="c_'+i+'" /></span><img id="thumn_'+i+'" alt="'+"f1_"+encode64(image_arr[i])+'" lang="'+image_arr[i]+'" style="width:50px; height:60px" src="file_manager/php/connector.php?tenthumuc='+_folder_name+'&answer=42&cmd=file&target='+"f1_"+encode64(image_arr[i])+'" /></div>')				
					// $("#images_thumnail").append( '<div class="thum_container"><span class="check_image"><input class="check_mask" type="checkbox" '+_check+' id="c_'+i+'" /></span><img id="thumn_'+i+'" alt="'+data["files"][i]["hash"]+'" lang="'+data["files"][i]["name"]+'" style="width:90px; height:100px" src="file_manager/php/connector.php?tenthumuc='+_folder_name+'&answer=42&cmd=file&target='+data["files"][i]["hash"]+'" /></div>')
				}
				
				var dem_check=0;
				$(".check_mask").click(function(){

					$('#images_thumnail').find(':input[type=checkbox]').each(function(){
						if($("#"+this.id).is(":checked" )) {
							dem_check++;
						}
					});

					if(dem_check>pic_number){
						$("#"+this.id).prop( "checked", false );
						tooltip_message("Số lượng ảnh không được lớn hơn "+pic_number+".");
					}
					dem_check=0;
				});
				$("#images_thumnail img").click(function(){
				 	_img_no=$(this).attr("id").split("_");
					 $("#c_"+_img_no[1]).click();
				});
				if(type!="chonanh"){
					$("#print_view").click();
					$(".modal" + elem).dialog("close");
				};
			});

        },


    });
    $(".ui-dialog").css("box-shadow","0px 0px 10px #000");
}

function dialog_template_select(title, width, height,elem,search_string) {
	$("body").append("<div class='ui-jqdialog modal" + elem + "'><div id='template_container'></div></div>");
	if (String(width).match(/px/g)==null){
		 width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
	}else{
		width=String(width).replace("px","")
	};
	if (String(height).match(/px/g)==null){
		 height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
	}else{
		 height=String(height).replace("px","")
	};
   // width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
    //height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
    $(".modal" + elem).dialog({
        height: height,
        width: width,
        modal: false,
        title: title,
		draggable: false,
		resizable: false,
        stack: false,
        close: function(event, ui) {
            $("body").remove(".modal" + elem);
            $(this).remove();
        },
        hide: {
            effect: "fadeOut",
            duration: 1000,
        },
        open: function(event, ui) {


        },


    });
    $(".ui-dialog").css("box-shadow","0px 0px 10px #000");
}




function autocompleted(elem, links, minvalue) {
    $(elem).autocomplete({
        //source: "resource.php?module=web_services&function=get_auto_complete&action=index",
        source: links,
        minLength: minvalue,
        select: function(event, ui) {
            $('#combobox').empty();
            $('#combobox').append(new Option(ui.item.label, ui.item.id));
            //$(this).val(ui.item.label)
            /*log( ui.item ?
             "Selected: " + ui.item.value + " aka " + ui.item.label :
             "Nothing selected, input was " + this.value );*/
        },
        response: function(event, ui) {
            //alert("")
        }
    })/*.data("uiAutocomplete")._renderItem = function (ul, item) {
     var newText = String(item.value).replace(
     new RegExp(this.term, "gi"),
     "<span class='ui-state-highlight'>$&</span>");

     return $("<li></li>")
     .data("item.autocomplete", item)
     .append("<a>" + newText + "</a>")
     .appendTo(ul);
     };*/
    $.extend($.ui.autocomplete.prototype, {
        _renderItem: function(ul, item) {
            var term = this.element.val(),
                    html = item.label.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong style='color:#F60'>$1</strong>");
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append($("<a></a>").html(html))
                    .appendTo(ul);
        }
    });
}
function autocompleted_combobox(elem) {
    (function($) {
        $.widget("custom.combobox", {
            _create: function() {
                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);
                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },
            _createAutocomplete: function() {
                var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";
                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("type","text")
                        .attr("id", elem.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "") + "1")
                        .attr("name", elem.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "") + "1")
                        .attr("title", "")
                        .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                        .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: $.proxy(this, "_source")
                })
                        .tooltip({
                    tooltipClass: "ui-state-highlight"
                });
                this._on(this.input, {
                    autocompleteselect: function(event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },
                    autocompletechange: "_removeIfInvalid"
                });
            },
            _createShowAllButton: function() {
                var input = this.input;

                $("<a>")
                        .attr("tabIndex", -1)
                        .attr("title", "Show All Items")
                        .tooltip()
                        .appendTo(this.wrapper)
                        .button({
                    icons: {
                        primary: "ui-icon-triangle-1-s"
                    },
                    text: false
                })
                        .removeClass("ui-corner-all")
                        .addClass("custom-combobox-toggle ui-corner-right")
                        .mousedown(function() {
                    wasOpen = input.autocomplete("widget").is(":visible");
                })
                        .click(function() {
                    input.focus();
                    // Close if already visible
                    if (wasOpen) {
                        return;
                    }
                    // Pass empty string as value to search for, displaying all results
                    input.autocomplete("search", "");
                });
            },
            _source: function(request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function() {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },
            _removeIfInvalid: function(event, ui) {
                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }
                // Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function() {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });
                // Found a match, nothing to do
                if (valid) {
                    return;
                }
                // Remove invalid value
                this.input
                        .val("")
                        .attr("title", value + " didn't match any item")
                        .tooltip("open");
                this.element.val("");
                this._delay(function() {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.data("ui-autocomplete").term = "";
            },
            _destroy: function() {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);

    jQuery(elem).combobox();
    $.extend($.ui.autocomplete.prototype, {
        _renderItem: function(ul, item) {
            var term = this.element.val(),
                    html = item.label.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong style='color:#F60'>$1</strong>");
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append($("<a></a>").html(html))
                    .appendTo(ul);
        }
    });
}
function alertObject(obj) {
    for (var key in obj) {
        console.log('key: ' + key + '\n' + 'value: ' + obj[key]);
        if (typeof obj[key] === 'object') {
            console.log(obj[key]);
        }
    }
}

function shortcut_key() {
    jwerty.key('f3', false);
    jwerty.key('f4', false);
    jwerty.key('f8', false);
    jwerty.key('f7', false);
	jwerty.key('f10', false);
    jwerty.key('f11', false);
    $('body').bind('keydown', function(e) {
        if (jwerty.is('f3', e)) {
            $(".ui-icon-plus").trigger("click");
        }
    });
    $('body').bind('keydown', function(e) {
        if (jwerty.is('f4', e)) {
            $(".ui-icon-pencil").trigger("click");
        }
    });
    $('body').bind('keydown', function(e) {
        if (jwerty.is('f8', e)) {
            $(".ui-icon-trash").trigger("click");
        }
    });
    $('body').bind('keydown', function(e) {
        if (jwerty.is('f7', e)) {
            $(".ui-icon-search").trigger("click");
        }
    });
	 $('body').bind('keydown', function(e) {
        if (jwerty.is('f10', e)) {
            $(".ui-icon-disk").trigger("click");
        }
    });
    $('body').bind('keydown', function(e) {
        if (jwerty.is('f11', e)) {
            $(".ui-icon-refresh").trigger("click");
        }
    });
}
function gmmktime() {
    // Get UNIX timestamp for a GMT date
    //
    // version: 905.3122
    // discuss at: http://phpjs.org/functions/gmmktime
    // +   original by: Brett Zamir (http://brett-zamir.me)
    // +   derived from: mktime
    // *     example 1: gmmktime(14, 10, 2, 2, 1, 2008);
    // *     returns 1: 1201875002

    var no = 0, i = 0, ma = 0, mb = 0, d = new Date(), dn = new Date(), argv = arguments, argc = argv.length;

    var dateManip = {
        0: function(tt) {
            return d.setUTCHours(tt);
        },
        1: function(tt) {
            return d.setUTCMinutes(tt);
        },
        2: function(tt) {
            var set = d.setUTCSeconds(tt);
            mb = d.getUTCDate() - dn.getUTCDate();
            return set;
        },
        3: function(tt) {
            var set = d.setUTCMonth(parseInt(tt, 10) - 1);
            ma = d.getUTCFullYear() - dn.getUTCFullYear();
            return set;
        },
        4: function(tt) {
            return d.setUTCDate(tt + mb);
        },
        5: function(tt) {
            if (tt >= 0 && tt <= 69) {
                tt += 2000;
            }
            else if (tt >= 70 && tt <= 100) {
                tt += 1900;
            }
            return d.setUTCFullYear(tt + ma);
        }
        // 7th argument (for DST) is deprecated
    };

    for (i = 0; i < argc; i++) {
        no = parseInt(argv[i] * 1, 10);
        if (isNaN(no)) {
            return false;
        } else {
            // arg is number, let's manipulate date object
            if (!dateManip[i](no)) {
                // failed
                return false;
            }
        }
    }
    for (i = argc; i < 6; i++) {
        switch (i) {
            case 0:
                no = dn.getUTCHours();
                break;
            case 1:
                no = dn.getUTCMinutes();
                break;
            case 2:
                no = dn.getUTCSeconds();
                break;
            case 3:
                no = dn.getUTCMonth() + 1;
                break;
            case 4:
                no = dn.getUTCDate();
                break;
            case 5:
                no = dn.getUTCFullYear();
                break;
        }
        dateManip[i](no);
    }

    return Math.floor(d.getTime() / 1000);
}
function timeRange(input) {
    return {minTime: (input.id == 'week2' ?
                $('#week_maskfrom').timeEntry('getTime') : null),
        maxTime: (input.id == 'week1' ?
                $('#week_maskto').timeEntry('getTime') : null)};
}
Number.prototype.formatMoney = function(c, d, t){//kiểu protoype sử dụng giống method string.formatMoney(0, '.', ',')
			var n = this,
				c = isNaN(c = Math.abs(c)) ? 2 : c,
				d = d == undefined ? "." : d,
				t = t == undefined ? "," : t,
				s = n < 0 ? "-" : "",
				i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
				j = (j = i.length) > 3 ? j % 3 : 0;
			   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};


// parseUri 1.2.2
// (c) Steven Levithan <stevenlevithan.com>
// MIT License
function parseUri (str) {
	var	o   = parseUri.options,
		m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
		uri = {},
		i   = 14;

	while (i--) uri[o.key[i]] = m[i] || "";

	uri[o.q.name] = {};
	uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
		if ($1) uri[o.q.name][$1] = $2;
	});

	return uri;
};
function set_Timeout(callback,interval,view){
	window.check_Timeout=true;
	t=setTimeout(function(){
		if(window.check_Timeout==true){
			callback(view);
			window.check_Timeout=false;
			clearTimeout(t);
			//$('#rowed4').setGridParam({loadonce: false}).trigger("reloadGrid");
			//alert($('#rowed4').jqGrid('getGridParam', 'loadonce'))
		}
	},interval);
}
parseUri.options = {
	strictMode: false,
	key: ["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],
	q:   {
		name:   "queryKey",
		parser: /(?:^|&)([^&=]*)=?([^&]*)/g
	},
	parser: {
		strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
		loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
	}
};

function create_print_dialog(){
	message="Máy in đang khởi tạo, vui lòng chờ đợi.";
	popup="<div id='printMessageBox' style='\
          position:fixed;\
		  z-index:100000;\
          top:45%; left:50%;\
          text-align:center;\
          margin: -60px 0 0 -155px;\
          width:310px; height:120px; font-size:16px; padding:10px; color:#222; font-family:helvetica, arial;\
          display:none;\
          background:#fff 		  url(data:image/gif;base64,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) center 40px no-repeat;\
          border: 6px solid #555;\
          border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px;\
          box-shadow:0px 0px 10px #888; -webkit-box-shadow:0px 0px 10px #888; -moz-box-shadow:0px 0px 10px #888'>\
          "+message+"</div>";

		  $("body").append(popup);

   //  width = $("#printMessageBox").width();
	//  alert(($(window).width() / 2) - width / 2)
   // $("#printMessageBox").css('top', ($(window).height() / 2) + 'px');
  //  $("#printMessageBox").css('left', ($(window).width() / 2) - width / 2 + 'px');
    $('#printMessageBox').fadeIn(500, function() {
        $("#printMessageBox").delay(1000).fadeOut(500, function() {
            $('#printMessageBox').remove();
        })
        //}
    });

}

 function create_select(elem,value){
	 tam = value.split(";");
	 for (i = 0; i <= tam.length - 1; i++) {
            temp = tam[i].split(":");
			//alert( temp[0])
			//if(temp[0]!=0){
				$(elem).append($('<option>', {
					value: temp[0],
					text: temp[1]
				}));
			//}
     }
}

function dialog_add_dm(title, width, height, elem, links,callback) {
	if(links!=""){
		$("body").append("<div class='ui-jqdialog modal" + elem + "'><div class='loading'><div id='loading'></div></div><iframe webkitallowfullscreen mozallowfullscreen allowfullscreen id='frame1' class='frame_" + elem + "' src=''></iframe></div>");
	}else{
		$("body").append("<div class='ui-jqdialog modal" + elem + "'> </div>");
	}
	if (String(width).match(/px/g)==null){
		 width = ($(window).width() / 100 * parseFloat(width)).toFixed(0);
	}else{
		width=String(width).replace("px","")
	};
	if (String(height).match(/px/g)==null){
		 height = ($(window).height() / 100 * parseFloat(height)).toFixed(0);
	}else{
		 height=String(height).replace("px","")
	};
    $(".modal" + elem).dialog({
        height: height,
        width: width,
        modal: true,
        title: title,
		draggable: false,
		resizable: false,
        stack: false,
        close: function(event, ui) {
			callback();
			$(".hidden_form").html(window.hidden_form);
            $("body").remove(".modal" + elem);
            $(this).remove();
        },
        hide: {
            effect: "fadeOut",
            duration: 1000,
        },
        open: function(event, ui) {
			callIframe(links, hide_loader, elem);
            $('.ui-dialog').css({"box-shadow": "0px 0px 30px #333"});
        },
    });
}



$(function(){

    $.fn.hasScroll = function(axis){
        var overflow = this.css("overflow"),
            overflowAxis;

        if(typeof axis == "undefined" || axis == "y") overflowAxis = this.css("overflow-y");
        else overflowAxis = this.css("overflow-x");

        var bShouldScroll = this.get(0).scrollHeight > this.innerHeight();

        var bAllowedScroll = (overflow == "auto" || overflow == "visible") ||
                             (overflowAxis == "auto" || overflowAxis == "visible");

        var bOverrideScroll = overflow == "scroll" || overflowAxis == "scroll";

        return (bShouldScroll && bAllowedScroll) || bOverrideScroll;
    };

    $.fn.mousedown = function(data, fn) {
        if ( fn == null ) {
            fn = data;
            data = null;
        }
        var o = fn;
        fn = function(e){
            if(!inScrollRange(e)) {
                return o.apply(this, arguments);
            }
            return;
        };
        if ( arguments.length > 0 ) {
            return this.bind( "mousedown", data, fn );
        }
        return this.trigger( "mousedown" );
    };

    $.fn.mouseup = function(data, fn) {
        if ( fn == null ) {
            fn = data;
            data = null;
        }
        var o = fn;
        fn = function(e){
            if(!inScrollRange(e)) {
                return o.apply(this, arguments);
            }
            return;
        };
        if ( arguments.length > 0 ) {
            return this.bind( "mouseup", data, fn );
        }
        return this.trigger( "mouseup" );
    };

    $.fn.mousedownScroll = function(data, fn) {
        if ( fn == null ) {
            fn = data;
            data = null;
        }
        var o = fn;
        fn = function(e){
            if(inScrollRange(e)) {
                e.type = "mousedownscroll";
                return o.apply(this, arguments);
            }
            return;
        };
        if ( arguments.length > 0 ) {
            return this.bind( "mousedown", data, fn );
        }
        return this.trigger( "mousedown" );
    };

    $.fn.mouseupScroll = function(data, fn) {
        if ( fn == null ) {
            fn = data;
            data = null;
        }
        var o = fn;
        fn = function(e){
            if(inScrollRange(e)) {
                e.type = "mouseupscroll";
                return o.apply(this, arguments);
            }
            return;
        };
        if ( arguments.length > 0 ) {
            return this.bind( "mouseup", data, fn );
        }
        return this.trigger( "mouseup" );
    };

    var RECT = function(){
        this.top = 0;
        this.left = 0;
        this.bottom = 0;
        this.right = 0;
    }

    function inRect(rect, x, y){
        return (y >= rect.top && y <= rect.bottom) &&
               (x >= rect.left && x <= rect.right)
    }


    var scrollSize = measureScrollWidth();

    function inScrollRange(event){
        var x = event.pageX,
            y = event.pageY,
            e = $(event.target),
            hasY = e.hasScroll(),
            hasX = e.hasScroll("x"),
            rX = null,
            rY = null,
            bInX = false,
            bInY = false

        if(hasY){
            rY = new RECT();
            rY.top = e.offset().top;
            rY.right = e.offset().left + e.width();
            rY.bottom = rY.top +e.height();
            rY.left = rY.right - scrollSize;

            //if(hasX) rY.bottom -= scrollSize;
            bInY = inRect(rY, x, y);
        }

        if(hasX){
            rX = new RECT();
            rX.bottom = e.offset().top + e.height();
            rX.left = e.offset().left;
            rX.top = rX.bottom - scrollSize;
            rX.right = rX.left + e.width();

            //if(hasY) rX.right -= scrollSize;
            bInX = inRect(rX, x, y);
        }

        return bInX || bInY;
    }

    $(document).on("mousedown", function(e){
        //Determine if has scrollbar(s)
        if(inScrollRange(e)){
            $(e.target).trigger("mousedownScroll");
        }
    });

    $(document).on("mouseup", function(e){
        if(inScrollRange(e)){
            $(e.target).trigger("mouseupScroll");
        }
    });
});

function measureScrollWidth() {
    var scrollBarMeasure = $('<div />');
    $('body').append(scrollBarMeasure);
    scrollBarMeasure.width(50).height(50)
        .css({
            overflow: 'scroll',
            visibility: 'hidden',
            position: 'absolute'
        });

    var scrollBarMeasureContent = $('<div />').height(1);
    scrollBarMeasure.append(scrollBarMeasureContent);

    var insideWidth = scrollBarMeasureContent.width();
    var outsideWitdh = scrollBarMeasure.width();
    scrollBarMeasure.remove();

    return outsideWitdh - insideWidth;
};

function grid_filter_enter(grid) {
	grid1 = grid.substr(1);
	var  gr='#gbox_'+grid1 +' .ui-search-toolbar';
	//alert(gr);
 	$(gr).unbind('keydown');
  // var col_name = $(grid).jqGrid('getGridParam', 'colModel')
			$(gr).bind('keydown', function(e) {
       				 if (jwerty.is('enter', e)||jwerty.is("↓",e)) {
							e.preventDefault();
							$(grid+' #'+$(grid).getDataIDs()[0]).focus();
							$(grid).jqGrid("setSelection",$(grid).getDataIDs()[0], true);
        			}
   			});
};


function number_textbox_demical(elem){
	$(elem).bind("focus",function(e) {
		$(elem).select();
	});
	$(elem).keydown(function(e) {
		if ( $.inArray(e.keyCode,[46,8,9,27,13,190,188]) !== -1 ||
		   (e.keyCode == 65 && e.ctrlKey === true) ||
		   (e.keyCode >= 35 && e.keyCode <= 39)) {
			 return;
		  }
		  else {
		   if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105 )) {
			e.preventDefault();
		   }
		  }


			/* if (((e.keyCode >= 48)&&(e.keyCode <= 57))||(e.keyCode==8)||(e.keyCode==46)||((e.keyCode >= 96)&&(e.keyCode <= 105))) {	// chấp nhận từ 0-9, backspace 			alert("")
			 	//$(this).val(e.keyCode);

			 }else if((e.keyCode !=13)||(e.keyCode ==16) ||(e.keyCode ==17)){//Trừ enter và các key code điều kiện trên thì undo

			 	 e.preventDefault();
				 return;

			 }*/
	})
}
function number_textbox(elem){
	$(elem).bind("focus",function(e) {
		$(elem).select();
	});
	$(elem).keydown(function(e) {
		if ( $.inArray(e.keyCode,[46,8,9,27,13,190]) !== -1 ||
		   (e.keyCode == 65 && e.ctrlKey === true) ||
		   (e.keyCode >= 35 && e.keyCode <= 39)) {
			 return;
		  }
		  else {
		   if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105 )) {
			e.preventDefault();
		   }
		  }


			/* if (((e.keyCode >= 48)&&(e.keyCode <= 57))||(e.keyCode==8)||(e.keyCode==46)||((e.keyCode >= 96)&&(e.keyCode <= 105))) {	// chấp nhận từ 0-9, backspace 			alert("")
			 	//$(this).val(e.keyCode);

			 }else if((e.keyCode !=13)||(e.keyCode ==16) ||(e.keyCode ==17)){//Trừ enter và các key code điều kiện trên thì undo

			 	 e.preventDefault();
				 return;

			 }*/
	})
}


function init_combox(input,input1,dialog,grid,defaultvalue,seach){
jwerty.key('tab', false);
var truoc='';



if (typeof defaultvalue != 'undefined'){
	

	
	
	if(defaultvalue!=0){
		var idToDataIndex = $(grid).jqGrid('getGridParam','_index');		
		sodong = $(grid).jqGrid('getGridParam', 'rowNum');			
		trang=Math.ceil(idToDataIndex[defaultvalue]/parseFloat(sodong));	
						//	alert(trang);
		setTimeout(function(){
		$(grid).jqGrid('setGridParam', {page:trang}).trigger('reloadGrid');		
		$(grid).jqGrid("setSelection",defaultvalue, true);
		var idcur = $(grid).jqGrid('getGridParam', 'selrow');
		var columnNames = $(grid).jqGrid('getGridParam','colModel');
		ten = $(grid).jqGrid('getCell', idcur, columnNames[0].name);
		$(input).val(ten);
		$(input1).val(idcur)
		},1)
	}

}else{
		var ids = $(grid).getDataIDs();$(grid).jqGrid("setSelection",ids[0], true);
		var idcur = $(grid).jqGrid('getGridParam', 'selrow');
		var columnNames = $(grid).jqGrid('getGridParam','colModel');
		ten = $(grid).jqGrid('getCell', idcur, columnNames[0].name);
		$(input).val(ten);
		$(input1).val(idcur);
}




$(input).click(function(event){
	for(i=0;i<=id_combox_dialog.length;i++){
					if(id_combox_dialog[i]!=dialog){
						if($(id_combox_dialog[i]).is(":visible")===true){
							create_combobox_close(input,id_combox_dialog[i],input1,grid)
						}
					}
				}
	//alert(event.target.id);
    event.stopPropagation();
});
$(dialog).click(function(event){
});


$('html').click(function() {	
	if($(dialog).is(":visible")===true){
		create_combobox_close(input,dialog,input1,grid)
	}
});


$(dialog+' .ui-jqgrid-hbox').click(function(event) {
	for(i=0;i<=id_combox_dialog.length;i++){
					if(id_combox_dialog[i]!=dialog){
						if($(id_combox_dialog[i]).is(":visible")===true){
							create_combobox_close(input,id_combox_dialog[i],input1,grid)
						}
					}
				}
	event.stopPropagation();
});



$(input+','+dialog+' .ui-jqgrid-hbox').bind("keydown", function(e) {
	var key = e.which;
	
	if(jwerty.is("enter",e)||jwerty.is("tab",e)){
	
		if($(dialog).is(":visible")===true){
			$(grid).data('clicked', true);
			var idcur = $(grid).jqGrid('getGridParam', 'selrow');
			$(grid).jqGrid("setSelection",idcur, true);
			
			create_combobox_close(input,dialog,input1,grid);
		}
	}else if(jwerty.is("esc",e)){
			if($(dialog).is(":visible")===true){
			$(grid).data('clicked', true);
			create_combobox_close(input,dialog,input1,grid);
		}
	}else if(jwerty.is("↓",e)){
					$(grid).data('clicked', false);
					var idcur = $(grid).jqGrid('getGridParam', 'selrow');
					if($(dialog).is(":visible")===false){
					 create_combobox_open(input,dialog)
					}else{
						if(idcur==null){
						var ids = $(grid).getDataIDs();
						$(grid).jqGrid("setSelection",ids[0], true);
						}else{
					  var idcur = $(grid).jqGrid('getGridParam', 'selrow')
					  if (idcur == null) return;
					  var ids = $(grid).getDataIDs();
					  var index = $(grid).getInd(idcur);
					  if (ids.length < 2) return;
					 index++;
					  if (index > ids.length)
						index = 1;
					  $(grid).jqGrid("setSelection",ids[index - 1], true);
						}
					}

				}
	else if(jwerty.is("↑",e)){
					$(grid).data('clicked', false);
						var idcur = $(grid).jqGrid('getGridParam', 'selrow')
					if($(dialog).is(":visible")===false){
					 create_combobox_open(input,dialog)	}
					else{
						if(idcur==null){
						var ids = $(grid).getDataIDs();
						$(grid).jqGrid("setSelection",ids[0], true);
						}else{

					  var idcur = $(grid).jqGrid('getGridParam', 'selrow')
					  if (idcur == null) return;
					  var ids = $(grid).getDataIDs();
					  var index = $(grid).getInd(idcur);
					  if (ids.length < 2) return;
					 index--;
					  if (index == 0){
						index = ids.length;
					  }
					  $(grid).jqGrid("setSelection",ids[index - 1], true);
						}
					}
				}
				})
	$(input+','+dialog+' .ui-jqgrid-hbox').bind("keyup", function(e) {
		if(jwerty.is("enter",e)||jwerty.is("tab",e)){
		}else if(jwerty.is("esc",e)){
		}else if(jwerty.is("↓",e)){
		}else if(jwerty.is("↑",e)){
		}else{
					$(grid).data('clicked', false);
			//	if($.inArray(e.keyCode,[13,16,17,18,19,20,27,35,36,37,38,39,40,91,93,224,112,113,114,115,116,117,118,119,120,121,122,123])>-1) {return;}
				if($.inArray(seach,['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'])==-1)
				{
					seach='bw'
				}

				if(e.shiftKey && e.keyCode == 9){
				}else{
					 create_combobox_open(input,dialog);
					 grid = $(grid);
						var columnNames = $(grid).jqGrid('getGridParam','colModel');
						var searchFiler = $(input).val(), f;
						if (searchFiler.length === 0) {
							grid[0].p.search = false;
							$.extend(grid[0].p.postData,{filters:""});
						}
						f = {groupOp:"OR",rules:[]};
						f.rules.push({field:columnNames[0].name,op:seach,data:searchFiler});
						grid[0].p.search = true;
						$.extend(grid[0].p.postData,{filters:JSON.stringify(f)});
						grid.trigger("reloadGrid",[{page:1,current:true}])

						$(grid).jqGrid("setSelection",grid.getDataIDs()[0], true);
						//alert(searchFiler);
				}
				}
				
		});

}

function init_combox_namnew(input,input1,dialog,grid,defaultvalue,seach){
	jwerty.key('tab', false);
	var truoc='';
	if (typeof defaultvalue != 'undefined'){
	  if(defaultvalue!=0){
		var idToDataIndex = $(grid).jqGrid('getGridParam','_index');		
		sodong = $(grid).jqGrid('getGridParam', 'rowNum');			
		trang=Math.ceil(idToDataIndex[defaultvalue]/parseFloat(sodong));	
						//	alert(trang);
		setTimeout(function(){
		$(grid).jqGrid('setGridParam', {page:trang}).trigger('reloadGrid');		
		$(grid).jqGrid("setSelection",defaultvalue, true);
		var idcur = $(grid).jqGrid('getGridParam', 'selrow');
		var columnNames = $(grid).jqGrid('getGridParam','colModel');
		ten = $(grid).jqGrid('getCell', idcur, columnNames[0].name);
		$(input).val(ten);
		$(input1).val(idcur)
		},1)
	}

}else{
		var ids = $(grid).getDataIDs();$(grid).jqGrid("setSelection",ids[0], true);
		var idcur = $(grid).jqGrid('getGridParam', 'selrow');
		var columnNames = $(grid).jqGrid('getGridParam','colModel');
		ten = $(grid).jqGrid('getCell', idcur, columnNames[1].name);
		$(input).val(ten);
		$(input1).val(idcur);
}




$(input).click(function(event){
	for(i=0;i<=id_combox_dialog.length;i++){
					if(id_combox_dialog[i]!=dialog){
						if($(id_combox_dialog[i]).is(":visible")===true){
							create_combobox_close(input,id_combox_dialog[i],input1,grid)
						}
					}
				}
	//alert(event.target.id);
    event.stopPropagation();
});
$(dialog).click(function(event){
});


$('html').click(function() {	
	if($(dialog).is(":visible")===true){
		create_combobox_close(input,dialog,input1,grid)
	}
});


$(dialog+' .ui-jqgrid-hbox').click(function(event) {
	for(i=0;i<=id_combox_dialog.length;i++){
					if(id_combox_dialog[i]!=dialog){
						if($(id_combox_dialog[i]).is(":visible")===true){
							create_combobox_close(input,id_combox_dialog[i],input1,grid)
						}
					}
				}
	event.stopPropagation();
});



$(input+','+dialog+' .ui-jqgrid-hbox').bind("keydown", function(e) {
	var key = e.which;
	
	if(jwerty.is("enter",e)||jwerty.is("tab",e)){
	
		if($(dialog).is(":visible")===true){
			$(grid).data('clicked', true);
			var idcur = $(grid).jqGrid('getGridParam', 'selrow');
			$(grid).jqGrid("setSelection",idcur, true);
			
			create_combobox_close(input,dialog,input1,grid);
		}
	}else if(jwerty.is("esc",e)){
			if($(dialog).is(":visible")===true){
			$(grid).data('clicked', true);
			create_combobox_close(input,dialog,input1,grid);
		}
	}else if(jwerty.is("↓",e)){
					$(grid).data('clicked', false);
					var idcur = $(grid).jqGrid('getGridParam', 'selrow');
					if($(dialog).is(":visible")===false){
					 create_combobox_open(input,dialog)
					}else{
						if(idcur==null){
						var ids = $(grid).getDataIDs();
						$(grid).jqGrid("setSelection",ids[0], true);
						}else{
					  var idcur = $(grid).jqGrid('getGridParam', 'selrow')
					  if (idcur == null) return;
					  var ids = $(grid).getDataIDs();
					  var index = $(grid).getInd(idcur);
					  if (ids.length < 2) return;
					 index++;
					  if (index > ids.length)
						index = 1;
					  $(grid).jqGrid("setSelection",ids[index - 1], true);
						}
					}

				}
	else if(jwerty.is("↑",e)){
					$(grid).data('clicked', false);
						var idcur = $(grid).jqGrid('getGridParam', 'selrow')
					if($(dialog).is(":visible")===false){
					 create_combobox_open(input,dialog)	}
					else{
						if(idcur==null){
						var ids = $(grid).getDataIDs();
						$(grid).jqGrid("setSelection",ids[0], true);
						}else{

					  var idcur = $(grid).jqGrid('getGridParam', 'selrow')
					  if (idcur == null) return;
					  var ids = $(grid).getDataIDs();
					  var index = $(grid).getInd(idcur);
					  if (ids.length < 2) return;
					 index--;
					  if (index == 0){
						index = ids.length;
					  }
					  $(grid).jqGrid("setSelection",ids[index - 1], true);
						}
					}
				}
				})
	$(input+','+dialog+' .ui-jqgrid-hbox').bind("keyup", function(e) {
		if(jwerty.is("enter",e)||jwerty.is("tab",e)){
		}else if(jwerty.is("esc",e)){
		}else if(jwerty.is("↓",e)){
		}else if(jwerty.is("↑",e)){
		}else{
					$(grid).data('clicked', false);
			//	if($.inArray(e.keyCode,[13,16,17,18,19,20,27,35,36,37,38,39,40,91,93,224,112,113,114,115,116,117,118,119,120,121,122,123])>-1) {return;}
				if($.inArray(seach,['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'])==-1)
				{
					seach='bw'
				}

				if(e.shiftKey && e.keyCode == 9){
				}else{
					 create_combobox_open(input,dialog);
					 grid = $(grid);
						var columnNames = $(grid).jqGrid('getGridParam','colModel');
						var searchFiler = $(input).val(), f;
						if (searchFiler.length === 0) {
							grid[0].p.search = false;
							$.extend(grid[0].p.postData,{filters:""});
						}
						f = {groupOp:"OR",rules:[]};
						f.rules.push({field:columnNames[1].name,op:seach,data:searchFiler});
						grid[0].p.search = true;
						$.extend(grid[0].p.postData,{filters:JSON.stringify(f)});
						grid.trigger("reloadGrid",[{page:1,current:true}])

						$(grid).jqGrid("setSelection",grid.getDataIDs()[0], true);
						//alert(searchFiler);
				}
				}
				
		});

}
//end funtion init_combox_namnew

	function afterInit_combox(input,dialog,grid,input1) {

		 $(input).wrap( "<span class='custom-combobox' id='"+input.substr(1)+"_combobox'></span>" );
			var button = $("<a>").attr("tabIndex", -1).attr("title", "Show all items").tooltip().insertAfter($(input)).button({
			icons: {
				primary: "ui-icon-triangle-1-s"
			},
			text: false
		}).removeClass("ui-corner-all").addClass("custom-combobox-toggle  "+input.substr(1)+"_button").click(function(event) {
			$(input).focus();
			$(input).select();
			if($(dialog).is(":visible")===true){

				create_combobox_close(input,dialog,input1,grid)
				
			}else{
				for(i=0;i<=id_combox_dialog.length;i++){
					if(id_combox_dialog[i]!=dialog){
						if($(id_combox_dialog[i]).is(":visible")===true){
							create_combobox_close(input,id_combox_dialog[i],input1,grid)
						}
					}
				}
			    create_combobox_open(input,dialog);
				event.stopImmediatePropagation();
						
						var idToDataIndex = $(grid).jqGrid('getGridParam','_index');					
						var id = $(grid).jqGrid('getGridParam', 'selrow');
						trang=1
						if(id!=null){
							sodong = $(grid).jqGrid('getGridParam', 'rowNum');			
							trang=Math.ceil((idToDataIndex[id]+1)/parseFloat(sodong));		
													
						}else{
							trang=1;
						}
						//var columnNames = $(grid).jqGrid('getGridParam','colModel');
						grid = $(grid);	
						
						if(trang<=0){
							trang=1
						}
						grid[0].p.search = false;
						$.extend(grid[0].p.postData,{filters:""});	
						$(grid).data('clicked', false);		
						
					
						grid.jqGrid('setGridParam', {page:trang}).trigger('reloadGrid');		
						grid.jqGrid("setSelection",id, true);
						
					

			}


		});
	 }
	 function create_combobox_open(input,dialog){
				var top_combobox= $(input).offset().top+25+$(dialog).height();
				var left_combobox= $(input).offset().left+$(dialog).width();
				if(top_combobox>$(document).height()){
					 $(dialog).css('top', $(input).offset().top - $(dialog).height());
				}else{
					$(dialog).css("top",$(input).offset().top+25);
				}

				if(left_combobox>$(document).width()){
					 $(dialog).css('left', $(input).offset().left - (left_combobox-$(document).width()));
				}else{
					$(dialog).css("left",$(input).offset().left);
				}
				$(dialog).show();
		}
		function create_combobox_close(input,dialog,input1,grid){
				$(dialog).hide();
				count = jQuery(grid).jqGrid('getGridParam', 'records');
				if(count<=0){
					/*var data = $(grid).jqGrid('getGridParam', 'data');
									var idcur = $(grid).jqGrid('getGridParam', 'selrow');
									var columnNames = $(grid).jqGrid('getGridParam','colModel');
									ten = $(grid).jqGrid('getCell', data[0], columnNames[0].name);
								//alert(data[columnNames[0].name]);*/
									$(input).val("");
									$(input1).val("");

				}else if($.trim($(grid).jqGrid('getGridParam', 'selrow'))==''){
				}
				else{
									var ids = $(grid).getDataIDs();
									var idcur = $(grid).jqGrid('getGridParam', 'selrow')
									var columnNames = $(grid).jqGrid('getGridParam','colModel');
						 			ten = $(grid).jqGrid('getCell', idcur, columnNames[0].name);
									$(input1).val(idcur);
									$(input).val(ten);
								}
							
				$(input).focus();
				$(input).select();
		}
	function create_combobox_disable(input){
			$(input).prop('disabled', true);;
			$('.'+input.substr(1)+'_button').button('disable');;
	}
	function create_combobox_enable(input){
			$(input).prop('disabled', false);;
			$('.'+input.substr(1)+'_button').button('enable');;
	}
	function create_combobox_hide(input){
			$('#'+input.substr(1)+'_combobox').hide();
	}
	function create_combobox_hide(input){
			$('#'+input.substr(1)+'_combobox').show();
	}
	function create_combobox(input,input1,dialog,grid,fun,seach,height,title,data,defaultvalue){
		grid1 = grid.substr(1);
					dialog1 = dialog.substr(1);
					if(grid.charAt(0)=='.'){
						grid1="class='"+grid1+"'";
					}else{
						grid1="id='"+grid1+"'";
					}
					if(dialog.charAt(0)=='.'){
						dialog1="class='"+dialog1+"'";
					}else{
						dialog1="id='"+dialog1+"'";
					}
					if(typeof window.id_combox_dialog == 'undefined'){
						window.id_combox_dialog= new Array();
					}
		if($("."+input.substr(1)+"_button").length){
			var pathname = window.location.href;
			var module = getURLParameter('module',pathname);
			var view = getURLParameter('view',pathname);
			var pathname1='resource.php?module='+module+'&view='+view+'&action='+data;
				$.post(pathname1).done(function(datalocal) {


					$(grid).jqGrid('setGridParam', { datatype: 'jsonstring', datastr: datalocal }).trigger('reloadGrid', [{ page: 1}]);
				})



		}else{
			id_combox_dialog.push(dialog);
			$("body").append("<div  "+dialog1+"><table "+grid1+"></table></div>");
			 $( dialog ).css({
				"position":"absolute",
				"z-index":"1000000",
				"display":"none",
				"box-shadow":"0px 0px 6px #333"
			});

			$(grid).click(function(){
			  $(grid).data('clicked', true);
			});
			afterInit_combox(input,dialog,grid,input1);
			var pathname = window.location.href;
			var module = getURLParameter('module',pathname);
			var view = getURLParameter('view',pathname);
			
			var pathname1='resource.php?module='+module+'&view='+view+'&action='+data;
				if(data!=''){
				$.post(pathname1).done(function(datalocal) {
						fun(grid,datalocal);
						init_combox(input,input1,dialog,grid,defaultvalue,seach);
						//$( dialog+" .ui-jqgrid-hbox" ).append('<a class="ui-button ui-widget ui-state-default ui-corner-all"><span  class="ui-icon ui-icon-search"></span></a>').button() ;

				})
				}else{
					//alert();
					data='[]';
					fun(grid,data);
					init_combox(input,input1,dialog,grid,defaultvalue,seach);
				}
		}
	}
function put_Search_grid(grid,col,val,data,input,input1){
				 var data2 = new Object();
		data2= clone(data)
	 if(val!=0){
	  for (var i = 0; i < data2['rows'].length; i++) {
		if (data2['rows'][i]['cell'][col] != val) {
		  data2['rows'].splice(i, 1);
		  i--;
		}
	  }
	 }
	// alertObject(data2);
	$(grid).jqGrid('setGridParam', { datatype: "jsonstring" ,datastr:data2}).trigger("reloadGrid");
	setTimeout(function(){count = jQuery(grid).jqGrid('getGridParam', 'records');
	if(count<=0){
									$(input1).val("");
									$(input).val("");

								}else{
									var ids = $(grid).getDataIDs();
									//alert(ids[0]);
									$(grid).jqGrid("setSelection",ids[0], true);
									var idcur = $(grid).jqGrid('getGridParam', 'selrow')
									var columnNames = $(grid).jqGrid('getGridParam','colModel');
						 			ten = $(grid).jqGrid('getCell', idcur, columnNames[0].name);
									$(input1).val(idcur);
									$(input).val(ten);
								}});
}

function create_dialog_combox(dialog,input,input1,table,width,height,title){
	$(dialog).dialog({
				zIndex: 3000,
		autoOpen:false,
		height:height,
		width:width,
		modal:false,
		draggable:false,
		title:title,
		stack: false,
		position:[ $(input).offset().left , $(input).offset().top+25]	,
		open: function(event, ui){
			$(dialog).dialog({ position:[ $(input).offset().left , $(input).offset().top+25]	});
			$(input).focus();
		},
		close: function(event, ui) {
			//setval(input,input1,table);
		   $(".overlay_child").fadeOut(300);
		},
	});


}

 function setval(input,input1,grid,defaultvalue){
	 if($.trim(defaultvalue)==''){
		 $(grid).jqGrid('resetSelection');
		 $(input1).val('');
		 $(input).val('');
	 }else{
		var columnNames = $(grid).jqGrid('getGridParam','colModel');
		$(grid)[0].p.search = false;
		$.extend($(grid)[0].p.postData,{filters:""});
		$(grid).trigger("reloadGrid",[{page:1,current:true}]);
		$(grid).jqGrid("setSelection",defaultvalue, true);
		setTimeout(function(){var columnNames = $(grid).jqGrid('getGridParam','colModel');
		ten = $(grid).jqGrid('getCell', defaultvalue, columnNames[0].name);
		$(input1).val(defaultvalue);
		$(input).val(ten);
		},100);
	 }
}


 function setval_col(input,input1,grid,defaultvalue,col){

		var columnNames = $(grid).jqGrid('getGridParam','colModel');
		$(grid)[0].p.search = false;
		$.extend($(grid)[0].p.postData,{filters:""});
		$(grid).trigger("reloadGrid",[{page:1,current:true}]);
		//$(grid).jqGrid("setSelection",defaultvalue, true);
	var ids = $(grid).jqGrid('getDataIDs');

		for(i=0;i<=ids.length-1;i++){
		ten = $(grid).jqGrid('getCell', ids[i], columnNames[col].name);

			if(ten==defaultvalue){

				$(grid).jqGrid("setSelection",i, true);
				$(input1).val(i);
				$(input).val(ten);

			}

		}



}



function clone(obj) {
    // Handle the 3 simple types, and null or undefined
    if (null == obj || "object" != typeof obj) return obj;

    // Handle Date
    if (obj instanceof Date) {
        var copy = new Date();
        copy.setTime(obj.getTime());
        return copy;
    }

    // Handle Array
    if (obj instanceof Array) {
        var copy = [];
        for (var i = 0, len = obj.length; i < len; i++) {
            copy[i] = clone(obj[i]);
        }
        return copy;
    }

    // Handle Object
    if (obj instanceof Object) {
        var copy = {};
        for (var attr in obj) {
            if (obj.hasOwnProperty(attr)) copy[attr] = clone(obj[attr]);
        }
        return copy;
    }

    throw new Error("Unable to copy obj! Its type isn't supported.");
}

 function getURLParameter(name,myUrl) {
   			 return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(myUrl)||[,""])[1].replace(/\+/g, '%20'))||null;
	}

 function minmax(elem, min, max)
{
	var value = $(elem).val();
    if(parseInt(value) < min || isNaN(value))
        return min;
    else if(parseInt(value) > max)
        return max;
    else return value;
}

 function minmax_var(elem, min, max)
{

    if(parseInt(elem) < min || isNaN(elem))
        return min;
    else if(parseInt(elem) > max)
        return max;
    else return elem;
}
(function($) {
    $.fn.blink = function(options) {
        var defaults = {
            delay: 500,
			status: false,
        };
        var options = $.extend(defaults, options);
		var timer;
        return this.each(function() {
            var obj = $(this);
			if(options.status==false){
				timer=setInterval(function() {
					if ($(obj).css("visibility") == "visible") {
						$(obj).css('visibility', 'hidden');
					}
					else {
						$(obj).css('visibility', 'visible');
					}
				}, options.delay);
			}else{
				clearInterval(timer);
			}
        });
    }
}(jQuery))







function autocompleted_combobox_search(elem,grid) {
    (function($) {
        $.widget("custom.combobox", {
            _create: function() {
                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);
                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },
            _createAutocomplete: function() {
                var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";
                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("type","text")
                        .attr("id", elem.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "") + "1")
                        .attr("name", elem.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "") + "1")
                        .attr("title", "")
                        .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                        .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: $.proxy(this, "_source")
                })
                        .tooltip({
                    tooltipClass: "ui-state-highlight"
                });
                this._on(this.input, {
                    autocompleteselect: function(event, ui) {


                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
						$(grid)[0].triggerToolbar();
                    },
                    autocompletechange: "_removeIfInvalid"
                });
            },
            _createShowAllButton: function() {
                var input = this.input;

                $("<a>")
                        .attr("tabIndex", -1)
                        .attr("title", "Show All Items")
                        .tooltip()
                        .appendTo(this.wrapper)
                        .button({
                    icons: {
                        primary: "ui-icon-triangle-1-s"
                    },
                    text: false
                })
                        .removeClass("ui-corner-all")
                        .addClass("custom-combobox-toggle ui-corner-right")
                        .mousedown(function() {
                    wasOpen = input.autocomplete("widget").is(":visible");
                })
                        .click(function() {
                    input.focus();
                    // Close if already visible
                    if (wasOpen) {
                        return;
                    }
                    // Pass empty string as value to search for, displaying all results
                    input.autocomplete("search", "");
                });
            },
            _source: function(request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function() {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },
            _removeIfInvalid: function(event, ui) {
                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }
                // Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function() {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });
                // Found a match, nothing to do
                if (valid) {
                    return;
                }
                // Remove invalid value
                this.input
                        .val("")
                        .attr("title", value + " didn't match any item")
                        .tooltip("open");
                this.element.val("");
                this._delay(function() {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.data("ui-autocomplete").term = "";
            },
            _destroy: function() {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);

    jQuery(elem).combobox();
    $.extend($.ui.autocomplete.prototype, {
        _renderItem: function(ul, item) {
            var term = this.element.val(),
                    html = item.label.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong style='color:#F60'>$1</strong>");
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append($("<a></a>").html(html))
                    .appendTo(ul);
        }
    });
}
Array.prototype.min = function(comparer) {
    if (this.length === 0) return null;
    if (this.length === 1) return this[0];
    comparer = (comparer || Math.min);
    var v = this[0];
    for (var i = 1; i < this.length; i++) {
        v = comparer(this[i], v);
    }
    return v;
}

Array.prototype.max = function(comparer) {
    if (this.length === 0) return null;
    if (this.length === 1) return this[0];
    comparer = (comparer || Math.max);
    var v = this[0];
    for (var i = 1; i < this.length; i++) {
        v = comparer(this[i], v);
    }

    return v;
}
function convert_comma_dot(inputA){
	if($.cookie('dauthapphan')=="."){
		return inputA;
	}
	//alert($.cookie('dauthapphan'))
	if(typeof(inputA)!="undefined"){
		// '^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$'
		if(String(inputA).match('.')!=null){
			return String(inputA).replace(".",",");
		}else{
			return String(inputA).replace(",",".");
		}
	}else{
		return "";
	}
}

function convert_comma_dot_cacl(inputA){
	if($.cookie('dauthapphan')=="."){
		return inputA;
	}else{
			return String(inputA).replace(",",".");
	}
}

function debouncer( func , timeout ) {
   var timeoutID , timeout = timeout || 100;
   return function () {
      var scope = this , args = arguments;
      clearTimeout( timeoutID );
      timeoutID = setTimeout( function () {
          func.apply( scope , Array.prototype.slice.call( args ) );
      } , timeout );
   }
}
function convert_date(inputA){
	if(String(inputA).match(' ')!=null){
		var bientam=inputA.split(" ");
		if(bientam[0].length>bientam[1].length){
			var ngaytam=bientam[0].split($.cookie("phancachngay"));
			var giotam=bientam[1].split(":");
			return new Date($.cookie('namjs')+ngaytam[2],(parseInt(ngaytam[1])-1),ngaytam[0],giotam[0],giotam[1],0);
		}else if(bientam[1].length>bientam[0].length){
			var ngaytam=bientam[1].split($.cookie("phancachngay"));
			var giotam=bientam[0].split(":");
			//alert($.cookie('namjs')+""+ngaytam[2]+","+(parseInt(ngaytam[1])-1)+","+ngaytam[0]+","+giotam[0]+","+giotam[1]+","+0)
			return new Date($.cookie('namjs')+ngaytam[2],(parseInt(ngaytam[1])-1),ngaytam[0],giotam[0],giotam[1],0);
		}
	}else{
		var ngaytam=inputA.split($.cookie("phancachngay"));
		return new Date($.cookie('namjs')+ngaytam[2],parseInt(ngaytam[1])-1,ngaytam[0],0,0,0);
	}
}
function date_add_date(){

}
function convert_to_datejs(inputA){
	var d = new Date();
	var curr_hour = d.getHours();
	var curr_minute = (d.getMinutes()<10?'0':'') + d.getMinutes(); //phút trả về 1 chữ số nếu bé hơn mười nên phải ghép 0 vào
	var curr_time = curr_hour + ":" + curr_minute+ " ";
	var dd = d.getDate();
	var mm = d.getMonth()+1;//January is 0!`
	var yyyy = d.getFullYear();
	if(inputA!="current"){
		if(String(inputA).match(' ')!=null){
			var bientam=inputA.split(" ");
			if(bientam[0].length>bientam[1].length){
				var ngaytam=bientam[0].split($.cookie("phancachngay"));
				var giotam=bientam[1].split(":");
				ngaytam[2]=$.cookie('namjs')+ngaytam[2];
			}else if(bientam[1].length>bientam[0].length){
				var ngaytam=bientam[1].split($.cookie("phancachngay"));
				var giotam=bientam[0].split(":");
				ngaytam[2]=$.cookie('namjs')+ngaytam[2];
			}
		}else if(String(inputA).match(':')!=null){
				var ngaytam=[];
				ngaytam[0]=dd,ngaytam[1]=mm,ngaytam[2]=yyyy;
				var giotam=inputA.split(":");
		}else{
			var ngaytam=inputA.split($.cookie("phancachngay"));
			ngaytam[2]=$.cookie('namjs')+ngaytam[2];
			var giotam=[];
			giotam[0]=0;giotam[1]=0;
		}
		var thoigian=Date.today().set({
			millisecond: 0,
			second: 0,
			minute: parseInt(giotam[1]),
			hour: parseInt(giotam[0]),
			day: parseInt(ngaytam[0]),
			month: parseInt(ngaytam[1])-1,
			year: parseInt(ngaytam[2])
		});
	}else{
		var thoigian=Date.today().set({
			millisecond: 0,
			second: 0,
			minute: parseInt(curr_minute),
			hour: parseInt(curr_hour),
			day: parseInt(dd),
			month: parseInt(mm)-1,
			year: parseInt(yyyy)
		});
		//thoigian=thoigian.addHours(0).toString("MMMM dd, yyyy  H:mm:ss");
	}
	return thoigian;
}
function phanquyen(){
	var grid_button=[];
	/*grid_button[0]	="ui-icon ui-icon-trash";grid_button[1]	="ui-icon ui-icon-plus";
	grid_button[2]	="ui-icon ui-icon-trash";grid_button[3]	="ui-icon ui-icon-pencil";
	grid_button[4]	="ui-icon ui-icon-pencil";  */
	$('.ui-button,.fm-button,.ui-pager-control table.navtable td,.danhdauphanquyen').each(function(){
		//alert($(this).attr("id"))
		//console.log($(this).attr("id"))
		//if((permission[$(this).attr("id")]==1)||($(this).attr("id")=="rowed3_ilsave")||($(this).attr("id")=="rowed3_ilcancel")){
		if(permission[$(this).attr("id")]==1){
			//$(this).show(1);
			$(this).css("visibility","visible")
		}else if(typeof($(this).attr("id"))!="undefined"){
			$(this).remove();
		}
	});
	$('ul.menu li').each(function(){
		var ct_tam=	$(this).attr("class").split(" ");
		if(permission[ct_tam[0]]==1){
			$(this).show(1);
		}else{
			$(this).remove();
		}
	});
	//$("input").attr("autocomplete", "off");
	jwerty.key('ctrl+p', false);
	jwerty.key('ctrl+b', false);
	jwerty.key('ctrl+s', false);
	$("body").bind('keydown', function(e) {
		 if (jwerty.is("ctrl+p",e)) {
			e.preventDefault();
			create_print_dialog();
		 }
	 })
	/* $("body").bind('keydown', function(e) {
		 if (jwerty.is("ctrl+b",e)) {
			 var o = document.getElementsByTagName('iframe')[0];
			 o.contentWindow.postMessage(true, '*');
		 }
	 })*/
}
var report_code="";
function create_print_dialog(){
	elem="67543538987876753453";
		if (report_code==""){
			return tooltip_message("Không tìm thấy cấu hình máy in của form này");
		}
		//dialog_main("Cấu hình máy in", "600px", "200px", elem, "") ;
			$("body").append("<div class='ui-jqdialog modal" + elem + "'> </div>");
			$(".modal"+elem).dialog({
				height: 130,
				width: 600,
				modal: false,
				title: "Cấu hình máy in",
				stack: true,
				 buttons: {
					"Áp dụng": function() {
					 //resource.php?module=web_services&function=printer_check&action=index&id_form=111&public=1&printers=$OUTPUT&host=$HOST
					     var printer=$("#printer_list option:selected").val();
						 var report=$("#report_list option:selected").val();
						 update_print = $.ajax({url: 'resource.php?module=web_services&function=update_printer&action=index&id_form=111&printer='+printer+'&report='+report, async: false, success: function(data, result) {
							/*if (!result){

							}*/
						 }}).responseText;
							if (update_print=="0"){
								tooltip_message("Áp dụng thành công");
							}else{
								tooltip_message("Không thể áp dụng máy in này vì chưa tạo cấu hình gốc");
							}
					},
				 },
				open: function(event, ui) {
					$(".modal67543538987876753453").append('<select style="width:250px" id="report_list"></select><select style="width:250px" id="printer_list"></select>');
						for (i = 0; i <report_code.length; i++) {
							$("#report_list").append($('<option>', {
								value: report_code[i],
								text: report_name[i]
							}));
						 }
						 _prints=$.cookie("printers").split("::");
						 for (i = 0; i <_prints.length-1; i++) {
							$("#printer_list").append($('<option>', {
								value: _prints[i],
								text: _prints[i]
							}));
						 }

				},
				close: function(event, ui) {
					$(this).dialog('destroy');
					$(this).remove();
				}

			});

			//$(".modal6754353898787677 img").attr("src",_tam[1]);
			//$("#full_view").css("cursor","-webkit-zoom-out");
			//$("#full_view").css("cursor","-moz-zoom-out");
			//$("#full_view").css("box-shadow","0 0 5px #383838");
}

function autocompleted_combobox_callback(elem,callback) {
    (function($) {
        $.widget("custom.combobox", {
            _create: function() {
                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);
                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },
            _createAutocomplete: function() {
                var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";
                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("type","text")
                        .attr("id", elem.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "") + "1")
                        .attr("name", elem.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "") + "1")
                        .attr("title", "")
                        .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                        .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: $.proxy(this, "_source")
                })
                        .tooltip({
                    tooltipClass: "ui-state-highlight"
                });
                this._on(this.input, {
                    autocompleteselect: function(event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
						callback(elem);
                    },
                    autocompletechange: "_removeIfInvalid"
                });
            },
            _createShowAllButton: function() {
                var input = this.input;

                $("<a>")
                        .attr("tabIndex", -1)
                        .attr("title", "Show All Items")
                        .tooltip()
                        .appendTo(this.wrapper)
                        .button({
                    icons: {
                        primary: "ui-icon-triangle-1-s"
                    },
                    text: false
                })
                        .removeClass("ui-corner-all")
                        .addClass("custom-combobox-toggle ui-corner-right")
                        .mousedown(function() {
                    wasOpen = input.autocomplete("widget").is(":visible");
                })
                        .click(function() {
                    input.focus();
                    // Close if already visible
                    if (wasOpen) {
                        return;
                    }
                    // Pass empty string as value to search for, displaying all results
                    input.autocomplete("search", "");
                });
            },
            _source: function(request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function() {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },
            _removeIfInvalid: function(event, ui) {
                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }
                // Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function() {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });
                // Found a match, nothing to do
                if (valid) {
                    return;
                }
                // Remove invalid value
                this.input
                        .val("")
                        .attr("title", value + " didn't match any item")
                        .tooltip("open");
                this.element.val("");
                this._delay(function() {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.data("ui-autocomplete").term = "";
            },
            _destroy: function() {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);

    jQuery(elem).combobox();
    $.extend($.ui.autocomplete.prototype, {
        _renderItem: function(ul, item) {
            var term = this.element.val(),
                    html = item.label.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong style='color:#F60'>$1</strong>");
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append($("<a></a>").html(html))
                    .appendTo(ul);
        }
    });
}
function add_icon_button_dialog(_text,_icon){
	var btndialog = $('.ui-dialog-buttonpane').find('button:contains("'+_text+'")');
    btndialog.prepend('<span style="float:left; margin-top: 3px;" class="ui-icon ui-icon-'+_icon+'"></span>');
    btndialog.width(btndialog.width() + 25);
}
function grid_scroll(elem,id){
	var ids =$(elem).getDataIDs();
	var rowData = $(elem).getRowData(id);
	var chieudai_rowed=0;
	for(i=0;i<=ids.length;i++){
		if(ids[i]==id){
			break;
		}
		chieudai_rowed +=$(elem + " #" +  ids[i]).height();
	}
	$(elem).jqGrid("setSelection",id, true);
	$( "#gview_"+elem.replace("#","")+" .ui-jqgrid-bdiv" ).scrollTop( chieudai_rowed);
}
function string_parse_SQL(value){
	return !value ? value : String(value).replace(/&/g, "&amp;").replace(/\"/g, "&quot;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
}


function grid_filter(grid,col,val,data){
				 var data2 = new Object();
		data2= clone(data)
	 if(val!=0){
	  for (var i = 0; i < data2['rows'].length; i++) {
		if (data2['rows'][i]['cell'][col] != val) {
		  data2['rows'].splice(i, 1);
		  i--;
		}
	  }
	 }

	$(grid).jqGrid('setGridParam', { datatype: "jsonstring" ,datastr:data2}).trigger("reloadGrid");

}

function convert_date_to_string(inputA){

thoigian=$.datepicker.formatDate('dd'+$.cookie("phancachngay")+'mm'+$.cookie("phancachngay")+'y', inputA);
	return thoigian;
}


function grid_filter_array(grid,col,val,data){
	 var data2 = new Object();
		data2= clone(data);
	  for (var i = 0; i < data2['rows'].length; i++) {

		if ($.inArray(data2['rows'][i]['cell'][col],[val]) !==-1 ) {
		//alert([val]);
		  data2['rows'].splice(i, 1);
		  i--;
		}
	  }


	$(grid).jqGrid('setGridParam', { datatype: "jsonstring" ,datastr:data2}).trigger("reloadGrid");

}


function checkbox_search(input,grid){
	if(!$("#"+input).length){
	 setTimeout(function(){checkbox_search(input,grid)},10);
	  return;
	}
	$("td.ui-search-clear").hide();
	$('#'+input).hide();
				$('#'+input).before( '<span id="'+input+'1" style="cursor: default;"><input id="'+input+'1State" name="'+input+'1State" value="1" type="hidden">  </span>' );
				initTriStateCheckBox(input+'1', input+'1State', true);
				$('#'+input+'1').click(function(){
					if($('#'+input+'1State').val()==0){
						$('#'+input).val(0)

					}else if($('#'+input+'1State').val()==1){
						$('#'+input).val('')
					}else if($('#'+input+'1State').val()==2){
						$('#'+input).val(1)
					}
					$(grid)[0].triggerToolbar();

					})

}

function checkbox_grid(input,grid){
	if(!$("#"+input).length){
	 setTimeout(function(){checkbox_grid(input,grid)},10);
	  return;
	}
	$("td.ui-search-clear").hide();
	$('#'+input).hide();
	$('#'+input).before( '<input type="checkbox" onchange="checkbox(this)" > ' );
}



 function autocomplete_noselect(input,data) {
		$(input).autocomplete({
			source: data,
			minLength: 0,
			open: function(event, ui) {
			}  ,
			autoFocus: true,
			}).data("uiAutocomplete")._renderItem = function (ul, item) {
					var newid = String(item.label).replace(
					new RegExp(this.term, "gi"),
					"<strong style='color:#F60'>$&</strong>");}
					return $("<li ></li>")
					.data("item.autocomplete", item)
					.append("<a style='width:60px;display: inline-block!important'>" + newid + "</a>")
					.appendTo(ul);
};
function load_sign(id,elem){
	var _hash="f1_"+encode64(id);	 
	_chuky = $.ajax({url: 'file_manager/php/connector.php?tenthumuc='+$.cookie('Signs')+'&answer=42&cmd=file&target='+_hash, async: false, success: function(data, result) {if (!result) alert('Không load được danh mục tầng');}}).responseText;
	if(_chuky=="File not found"){
		$("#"+elem).append("<br><br><br><br><br>");
	}else{
		var _link= "file_manager/php/connector.php?tenthumuc="+$.cookie('Signs')+"&answer=42&cmd=file&target="+_hash;
		$("#"+elem).attr("src",_link);
	}

	//file_manager/php/connector.php?tenthumuc=USTQ//89045&answer=42&cmd=file&target=f1_ODkwNDVfMTA0Mjg4Ml80Mjk2XzEuanBlZw
	//list($width, $height, $type, $attr) = getimagesize($_SESSION["config_system"]["URL"]."file_manager/php/connector.php?tenthumuc=".$_GET["tenthumuc"]."&answer=42&cmd=file&target=".$hash_name);

}



function search_mutilgrid(rowed){
	$('body').append('<div id="search_mutilgrid" style="display:none"><div style="font-weight:bold">Thông tin bệnh nhân</div><br><table><tr><td><label for="input_mutilgrid" style="font-weight:bold">Mã hoặc Tên BN</label></td><td><input id="input_mutilgrid"></td></tr><br><tr><td><label for="input_bacsy" style="font-weight:bold">Tên bác sỹ</label></td><td><input id="input_bacsy"></td></table></div>');
	var tam = rowed.split(',');
	 var cell_search='';
	 var input_search='';
	 var kiemtra=0;
	 jwerty.key('ctrl+f', false);
	 jwerty.key('ctrl+z', false);
	 $("#input_mutilgrid").bind('keydown', function(e) {
		 if (jwerty.is("tab",e)) {
			 $("#input_bacsy").focus();
			 $("#input_bacsy").select();
		 }
	 })
	 $("#input_bacsy").bind('keydown', function(e) {
		 if (jwerty.is("tab",e)) {
			 $("#input_mutilgrid").focus();
			 $("#input_mutilgrid").select();
		 }
	 })
	 $('body').bind('keydown', function(e) {
		if (jwerty.is("ctrl+z",e)) {
			kiemtra=1;
			$("#search_mutilgrid").dialog('close');
			for(var i=0;i<=tam.length-1;i++){
				grid = $(tam[i]);
				grid[0].p.search = false;
				$.extend(grid[0].p.postData,{filters:""});
				grid.trigger("reloadGrid",[{page:1,current:true}]);
			}
		}

	});
	$('body').bind('keydown', function(e) {
		if (jwerty.is("ctrl+f",e)) {
			$('#search_mutilgrid').dialog('open');
		}
	});
	$("#input_mutilgrid").keydown(function(e){
		if (jwerty.is("enter",e)) {
			if(isNaN($("#input_mutilgrid").val())){
				cell_search='TenBenhNhan'
			}else{
				cell_search='MaBenhNhan'
			}
			input_search='#input_mutilgrid';
			$("#search_mutilgrid").dialog('close');
		}
	})
	$("#input_bacsy").keydown(function(e){
		if (jwerty.is("enter",e)) {
				cell_search='Bslamsang'
				input_search='#input_bacsy';
				$("#search_mutilgrid").dialog('close');
		}
	})
	 $("#search_mutilgrid").dialog({
        height: 'auto',
        width: 'auto',
        modal: true,
        autoOpen: false,
        stack: true,
		title:'Tìm kiếm bệnh nhân trong danh sách',
        buttons: {
			"Tìm kiếm": function() {
			if ($("#input_bacsy").is(":focus")) {
  				input_search='#input_bacsy';
			}else if($("#input_mutilgrid").is(":focus")){
				if(isNaN($("#input_mutilgrid").val())){
					cell_search='TenBenhNhan'
				}else{
					cell_search='MaBenhNhan'
				}
				input_search='#input_mutilgrid';
			}

			 $("#search_mutilgrid").dialog('close');
			},
     	 },
		 close: function( event, ui ) {
				timer_title_danhsach("start")
				for(var i=0;i<=tam.length-1;i++){
						grid = $(tam[i]);
						var searchFiler = $(input_search).val(), f;
						f = {groupOp:"OR",rules:[]};
						//alert(cell_search);
						f.rules.push({field:cell_search,op:"cn",data:searchFiler});

						if(kiemtra==1){
						    grid[0].p.search = false;
							$.extend(grid[0].p.postData,{filters:""});

						 }else{

							 grid[0].p.search = true;
							$.extend(grid[0].p.postData,{filters:JSON.stringify(f)});

						}
						grid.trigger("reloadGrid",[{page:1,current:true}]);
				}
				$('#input_mutilgrid').val('');
				$('#input_bacsy').val('');
				window.kiemtrasearch = true;
					//timer_title_danhsach("start");

		},
		open: function( event, ui ) {
			kiemtra=0;
		}


    });

}



function create_combobox_inline(input,rowId,grid_,dialog,grid,fun,data,defaultvalue,callback,idfocus){	
		$("#"+grid_).jqGrid('unbindKeys');			
		var input_tam='#'+rowId+'_'+input;	
		var input_tam1='#'+rowId+'_'+input+'_combobox';			
		var with_idthuoc=parseFloat($('#jqgh_'+grid_+'_'+input).width())-32;
//alert();
		$(input_tam).hide(); 
		$('#'+grid_+' #'+rowId+'_'+input).before( '<input id="'+rowId+'_'+input+'_combobox" class="editable" type="text" style="width:'+with_idthuoc+'px" role="textbox">' );   
		grid1 = grid.substr(1);
		dialog1 = dialog.substr(1);
					if(grid.charAt(0)=='.'){
						grid1="class='"+grid1+"'";
					}else{
						grid1="id='"+grid1+"'";
					}
					if(dialog.charAt(0)=='.'){
						dialog1="class='"+dialog1+"'";
					}else{
						dialog1="id='"+dialog1+"'";
					}
					if(typeof window.id_combox_dialog == 'undefined'){
						window.id_combox_dialog= new Array();
					}
					$('#'+rowId+'_'+input+'_combobox' ).bind('keyup',function(e){						
						callback(e);
					})
			id_combox_dialog.push(dialog);
			$("body").append("<div  "+dialog1+"><table "+grid1+"></table></div>");
			 $( dialog ).css({
				"position":"absolute",
				"z-index":"1000000",
				"display":"none",
				"box-shadow":"0px 0px 6px #333"
			});
			
			
			$(grid).click(function(){
			  $(grid).data('clicked', true);
			});
			$("#"+grid_).jqGrid('unbindKeys');
			fun(grid,data);
			
			init_combox(input_tam1,input_tam,dialog,grid,defaultvalue,'bw');
			afterInit_combox(input_tam1,dialog,grid,input_tam);		
			$('#'+rowId+'_'+idfocus).focus();
			$('#'+rowId+'_'+idfocus).select();
	}


function destroy_combobox_inline(input,rowId,grid_,dialog,grid){
	var input_tam='#'+rowId+'_'+input;	
	var input_tam1='#'+rowId+'_'+input+'_combobox';	
	$(grid).jqGrid('GridUnload');
	$(input_tam).remove();
	$(input_tam1).remove();
	$(dialog).remove();
	$("#"+grid_).jqGrid('bindKeys');						
	$('#'+grid_).focus();	
}
function destroy_combobox_inline_new(input,rowId,grid){		
	var grid1   = input+'_grid';
	var input1 = input+'_hidden';
	var dialog = input+'_dialog';	
	$('#'+grid1).unbind('click');
	$('#'+grid1).jqGrid('GridUnload');	
	$('#'+input1).remove();
	$('#'+dialog).remove();		
	$("#"+grid).jqGrid('bindKeys');						
	$('#'+grid).focus();	
}



	function create_combobox_new(input,fun,seach,data_local,data,defaultvalue){
		var grid   = input+'_grid';
		var input1 = input+'_hidden';
		var dialog = input+'_dialog';
		var dialog_tam    = dialog.substr(1);
		var input1_tam    = input1.substr(1);
		var grid_tam      =grid.substr(1);
		var grid1      ="id='"+grid_tam+"'";
		var dialog1    ="id='"+dialog_tam+"'";	
		var input11    ="id='"+input1_tam+"'";	
		var name1    ="name='"+input1_tam+"'";	
		if(typeof window.id_combox_dialog == 'undefined'){
				window.id_combox_dialog= new Array();
		}
		if($("."+input.substr(1)+"_button").length){
			if(data_local==''){
			var pathname = window.location.href;
			var module = getURLParameter('module',pathname);
			var view = getURLParameter('view',pathname);
			var pathname1='resource.php?module='+module+'&view='+view+'&action='+data;
				$.post(pathname1).done(function(datalocal) {
					$(grid).jqGrid('setGridParam', { datatype: 'jsonstring', datastr: datalocal }).trigger('reloadGrid', [{ page: 1}]);
				})
			}else{
				$(grid).jqGrid('setGridParam', { datatype: 'jsonstring', datastr: data_local }).trigger('reloadGrid', [{ page: 1}]);
			}
		}else{
			
			
			id_combox_dialog.push(dialog);
			$(input).before('<input '+input11+' '+name1+'  type="text" lang="luu" style="display:none">');  
			$("body").append("<div  "+dialog1+"><table "+grid1+"></table></div>");
			 $( dialog ).css({
				"position":"absolute",
				"z-index":"1000000",
				"display":"none",
				"box-shadow":"0px 0px 6px #333"
			});
			
			
			$(grid).click(function(){
			  $(grid).data('clicked', true);
			});
			afterInit_combox(input,dialog,grid,input1);
			if(data_local==''){
				
				var pathname = window.location.href;
				var module = getURLParameter('module',pathname);
				var view = getURLParameter('view',pathname);
				var pathname1='resource.php?module='+module+'&view='+view+'&action='+data;
					if(data!=''){
					$.post(pathname1).done(function(datalocal) {
							fun(grid,datalocal);
							init_combox(input,input1,dialog,grid,defaultvalue,seach);
							//$( dialog+" .ui-jqgrid-hbox" ).append('<a class="ui-button ui-widget ui-state-default ui-corner-all"><span  class="ui-icon ui-icon-search"></span></a>').button() ;
	
					})
					}else{
						//alert();
						data='[]';
						fun(grid,data);
						init_combox(input,input1,dialog,grid,defaultvalue,seach);
					}
			}else{				
				fun(grid,data_local);
				init_combox(input,input1,dialog,grid,defaultvalue,seach);				
			}
		}
	}
	
	
function create_combobox_namnew(input,fun,seach,data_local,data,defaultvalue){
		var grid   = input+'_grid';
		var input1 = input+'_hidden';
		var dialog = input+'_dialog';
		var dialog_tam    = dialog.substr(1);
		var input1_tam    = input1.substr(1);
		var grid_tam      =grid.substr(1);
		var grid1      ="id='"+grid_tam+"'";
		var dialog1    ="id='"+dialog_tam+"'";	
		var input11    ="id='"+input1_tam+"'";	
		if(typeof window.id_combox_dialog == 'undefined'){
				window.id_combox_dialog= new Array();
		}
		if($("."+input.substr(1)+"_button").length){
			if(data_local==''){
			var pathname = window.location.href;
			var module = getURLParameter('module',pathname);
			var view = getURLParameter('view',pathname);
			var pathname1='resource.php?module='+module+'&view='+view+'&action='+data;
				$.post(pathname1).done(function(datalocal) {
					$(grid).jqGrid('setGridParam', { datatype: 'jsonstring', datastr: datalocal }).trigger('reloadGrid', [{ page: 1}]);
				})
			}else{
				$(grid).jqGrid('setGridParam', { datatype: 'jsonstring', datastr: data_local }).trigger('reloadGrid', [{ page: 1}]);
			}
		}else{
			
			
			id_combox_dialog.push(dialog);
			$(input).before('<input '+input11+'  type="text" lang="luu" style="display:none">');  
			$("body").append("<div  "+dialog1+"><table "+grid1+"></table></div>");
			 $( dialog ).css({
				"position":"absolute",
				"z-index":"1000000",
				"display":"none",
				"box-shadow":"0px 0px 6px #333"
			});
			
			
			$(grid).click(function(){
			  $(grid).data('clicked', true);
			});
			afterInit_combox(input,dialog,grid,input1);
			if(data_local==''){
				
				var pathname = window.location.href;
				var module = getURLParameter('module',pathname);
				var view = getURLParameter('view',pathname);
				var pathname1='resource.php?module='+module+'&view='+view+'&action='+data;
					if(data!=''){
					$.post(pathname1).done(function(datalocal) {
							fun(grid,datalocal);
							init_combox_namnew(input,input1,dialog,grid,defaultvalue,seach);
							//$( dialog+" .ui-jqgrid-hbox" ).append('<a class="ui-button ui-widget ui-state-default ui-corner-all"><span  class="ui-icon ui-icon-search"></span></a>').button() ;
	
					})
					}else{
						//alert();
						data='[]';
						fun(grid,data);
						init_combox_namnew(input,input1,dialog,grid,defaultvalue,seach);
					}
			}else{				
				fun(grid,data_local);
				init_combox_namnew(input,input1,dialog,grid,defaultvalue,seach);				
			}
		}
	}		 
 //end function create_combobox_namnew
 
function setval_new(input,defaultvalue){
		var grid   = input+'_grid';
		var input1 = input+'_hidden';
		var dialog = input+'_dialog';
	
	 if($.trim(defaultvalue)==''){
		 $(grid).jqGrid('resetSelection');
		 $(input1).val('');
		 $(input).val('');
	 }else{
		var idToDataIndex = $(grid).jqGrid('getGridParam','_index');	
		//alert(idToDataIndex);	
		sodong = $(grid).jqGrid('getGridParam', 'rowNum');			
		trang=Math.ceil(idToDataIndex[defaultvalue]/parseFloat(sodong));
		$(grid).jqGrid('setGridParam', { loadComplete: function(data){ 				
			
			var columnNames = $(grid).jqGrid('getGridParam','colModel');
			ten = $(grid).jqGrid('getCell', defaultvalue, columnNames[0].name);
			$(input1).val(defaultvalue);
			$(input).val(ten);
			
			$(grid).jqGrid('setGridParam', { loadComplete: function(data){ } });	
			$(grid).jqGrid("setSelection",defaultvalue, true);
			 } }
		 );					
			$(grid)[0].p.search = false;
			$.extend($(grid)[0].p.postData,{filters:""});	
			$(grid).jqGrid('setGridParam', {page:trang}).trigger('reloadGrid');		
						
		
			
		
	 
	 }
}



function move_tabindex(tam,tabindex,e){				  
		  if($(e.target).attr('kiemtra')=='trong' && $('[tabindex=' +  tabindex + ']').val()=='' && !$('[tabindex=' +tabindex + ']').prop('disabled')){	  
			  $('[tabindex=' +  tabindex + ']').addClass('error_null');
		  }else{			 
			   $('[tabindex=' +  tabindex + ']').removeClass('error_null'); 
			     if(tam=='next'){
					tabindex++;
				  }else{
					tabindex--;
				  }	   
			  if($('[tabindex=' +tabindex + ']').prop('disabled')){				 	
			 	 move_tabindex(tam,tabindex,e);
			  }else{				
				 $('[tabindex=' +  tabindex + ']').focus();
				return false;
			  }
		  }
		  
  }
  
  
  function combobox_inline_new(input,rowId,grid_,fun,data,defaultvalue,isfocus,callback){
	  	var grid   = rowId+'_'+input+'_grid';
		var input1 = rowId+'_'+input+'_combobox';
		var dialog = rowId+'_'+input+'_dialog';		
		var grid1      ="id='"+grid+"'";
		var dialog1    ="id='"+dialog+"'";	
		var input_tam='#'+rowId+'_'+input;	
		var input_tam1='#'+rowId+'_'+input+'_combobox';	
		$("body").append("<div  "+dialog1+"><table "+grid1+"></table></div>");
		$( '#'+dialog ).css({
			"position":"absolute",
			"z-index":"1000000",
			"display":"none",
			"box-shadow":"0px 0px 6px #333"
		});	  
	  	$("#"+grid_).jqGrid('unbindKeys');		
		var with_idthuoc=parseFloat($('#jqgh_'+grid_+'_'+input).width())-32;
		$(input_tam).hide(); 		
		$('#'+grid_+' '+input_tam).before( '<input id="'+input1+'" class="editable" type="text" style="width:'+with_idthuoc+'px" role="textbox">' );   
		if(typeof window.id_combox_dialog == 'undefined'){
			window.id_combox_dialog= new Array();
		}	
		window.id_combox_dialog.push(dialog);
		$(grid).click(function(){
			  $(grid).data('clicked', true);
		});
		$("#"+grid_).jqGrid('unbindKeys');
		callback(input1);					
		fun('#'+grid,data);			
		init_combox(input_tam1,input_tam,'#'+dialog,'#'+grid,defaultvalue,'bw');
		afterInit_combox(input_tam1,'#'+dialog,'#'+grid,input_tam);	
		if(isfocus==1){	
			$('#'+rowId+'_'+input+'_combobox').focus();
			$('#'+rowId+'_'+input+'_combobox').select();	  
		}	  
  }
  
  
  
  
  function create_combobox_formedit(input,fun,seach,data_local,data,defaultvalue){
		var grid   = input+'_grid';
		var input1 = input;
		var input = input+'_hidden';
		var dialog = input+'_dialog';
		var dialog_tam    = dialog.substr(1);
		var input1_tam    = input.substr(1);
		var grid_tam      =grid.substr(1);
		var grid1      ="id='"+grid_tam+"'";
		var dialog1    ="id='"+dialog_tam+"'";	
		var input11    ="id='"+input1_tam+"'";	
		if(typeof window.id_combox_dialog == 'undefined'){
				window.id_combox_dialog= new Array();
		}
		if($(grid).length){
			
			if(data_local==''){
			$(input1).before('<input '+input11+'  type="text" lang="luu" >');
			$(input1).hide();
			$(grid).click(function(){
			  $(grid).data('clicked', true);
			});
			afterInit_combox(input,dialog,grid,input1);  
			var pathname = window.location.href;
			var module = getURLParameter('module',pathname);
			var view = getURLParameter('view',pathname);
			var pathname1='resource.php?module='+module+'&view='+view+'&action='+data;
				$.post(pathname1).done(function(datalocal) {
					$(grid).jqGrid('setGridParam', { loadComplete: function(data){ 	
						
						var columnNames = $(grid).jqGrid('getGridParam','colModel');
						ten = $(grid).jqGrid('getCell', defaultvalue, columnNames[0].name);
						$(input1).val(defaultvalue);
						$(input).val(ten);						
						$(grid).jqGrid('setGridParam', { loadComplete: function(data){ } });	
						$(grid).jqGrid("setSelection",defaultvalue, true);
					 	}}
					 );		
					$(grid).jqGrid('setGridParam', { datatype: 'jsonstring', datastr: datalocal }).trigger('reloadGrid', [{ page: 1}]);
					//setval_new(input1,defaultvalue)
								
						
					
				})
			}else{
				$(grid).jqGrid('setGridParam', { datatype: 'jsonstring', datastr: data_local }).trigger('reloadGrid', [{ page: 1}]);
				
			}
		}else{
			
			
			id_combox_dialog.push(dialog);
			
			$(input1).before('<input '+input11+'  type="text" lang="luu" >');  
			//
			
			
			$("body").append("<div  "+dialog1+"><table "+grid1+"></table></div>");
			 $( dialog ).css({
				"position":"absolute",
				"z-index":"1000000",
				"display":"none",
				"box-shadow":"0px 0px 6px #333"
			});
			
			$(input1).hide();
			$(grid).click(function(){
			  $(grid).data('clicked', true);
			});
			afterInit_combox(input,dialog,grid,input1);
			if(data_local==''){
				
				var pathname = window.location.href;
				var module = getURLParameter('module',pathname);
				var view = getURLParameter('view',pathname);
				var pathname1='resource.php?module='+module+'&view='+view+'&action='+data;
					if(data!=''){
					$.post(pathname1).done(function(datalocal) {
							fun(grid,datalocal);
							init_combox(input,input1,dialog,grid,defaultvalue,seach);							
					})
					}else{
						//alert();
						data='[]';
						fun(grid,data);
						init_combox(input,input1,dialog,grid,defaultvalue,seach);
					}
			}else{				
				fun(grid,data_local);
				init_combox(input,input1,dialog,grid,defaultvalue,seach);				
			}
		}
	}
	
	
	
	
	
	
	
	function search_thungan(rowed){
	$('body').append('<div id="search_mutilgrid" style="display:none"><div style="font-weight:bold">Thông tin bệnh nhân</div><br><table><tr><td><label for="input_mutilgrid" style="font-weight:bold">Mã hoặc Tên BN</label></td><td><input id="input_mutilgrid"></td></tr></table></div>');
	var tam = rowed.split(',');
	 var cell_search='';
	 var input_search='';
	 var kiemtra=0;
	 jwerty.key('ctrl+f', false);
	 jwerty.key('ctrl+z', false);
	 
	 $('body').bind('keydown', function(e) {
		if (jwerty.is("ctrl+z",e)) {
			kiemtra=1;
			$("#search_mutilgrid").dialog('close');
			for(var i=0;i<=tam.length-1;i++){
				grid = $(tam[i]);
				
				$('.ui-jqgrid-hdiv input').val('');
				grid[0].p.search = false;
				$.extend(grid[0].p.postData,{filters:""});
				grid.trigger("reloadGrid",[{page:1,current:true}]);
			}
		}

	});
	$('body').bind('keydown', function(e) {
		if (jwerty.is("ctrl+f",e)) {
			$('#search_mutilgrid').dialog('open');
		}
	});
	$("#input_mutilgrid").keydown(function(e){
		if (jwerty.is("enter",e)) {
			if(isNaN($("#input_mutilgrid").val())){
				cell_search='TenBenhNhan'
			}else{
				cell_search='MaBenhNhan'
			}
			input_search='#input_mutilgrid';
			$("#search_mutilgrid").dialog('close');
		}
	})
	
	 $("#search_mutilgrid").dialog({
        height: 'auto',
        width: 'auto',
        modal: true,
        autoOpen: false,
        stack: true,
		title:'Tìm kiếm bệnh nhân trong danh sách',
        buttons: {
			"Tìm kiếm": function() {
			if ($("#input_bacsy").is(":focus")) {
  				input_search='#input_bacsy';
			}else if($("#input_mutilgrid").is(":focus")){
				if(isNaN($("#input_mutilgrid").val())){
					cell_search='TenBenhNhan'
				}else{
					cell_search='MaBenhNhan'
				}
				input_search='#input_mutilgrid';
			}

			 $("#search_mutilgrid").dialog('close');
			},
     	 },
		 close: function( event, ui ) {				
				for(var i=0;i<=tam.length-1;i++){
						grid = $(tam[i]);
						var searchFiler = $(input_search).val(), f;
						f = {groupOp:"OR",rules:[]};						
						f.rules.push({field:cell_search,op:"cn",data:searchFiler});
						if(kiemtra==1){
						    grid[0].p.search = false;
							$.extend(grid[0].p.postData,{filters:""});
						 }else{
						    grid[0].p.search = true;
							$.extend(grid[0].p.postData,{filters:JSON.stringify(f)});
						}
						grid.trigger("reloadGrid",[{page:1,current:true}]);
				}
				$('#input_mutilgrid').val('');
				$('#input_bacsy').val('');
		},
		open: function( event, ui ) {
			kiemtra=0;
			window.search_dialog=1
		}


    });

}
function strcmp(a, b) {
    return a > b ? 1 : a < b ? -1 : 0;
}
function natcmp(a, b) {
    var x = [], y = [];

    a.replace(/(\d+)|(\D+)/g, function($0, $1, $2) { x.push([$1 || 0, $2]) })
    b.replace(/(\d+)|(\D+)/g, function($0, $1, $2) { y.push([$1 || 0, $2]) })

    while(x.length && y.length) {
        var xx = x.shift();
        var yy = y.shift();
        var nn = (xx[0] - yy[0]) || strcmp(xx[1], yy[1]);
        if(nn) return nn;
    }

    if(x.length) return -1;
    if(y.length) return +1;

    return 0;
}





 function combobox_inline_slick(input,rowId,grid_,fun,data,defaultvalue,isfocus,callback){
	  	var grid   = rowId+'_'+input+'_grid';
		var input1 = rowId+'_'+input+'_combobox';
		var dialog = rowId+'_'+input+'_dialog';		
		var grid1      ="id='"+grid+"'";
		var dialog1    ="id='"+dialog+"'";	
		var input_tam='#'+rowId+'_'+input;	
		var input_tam1='#'+rowId+'_'+input+'_combobox';	
		$("body").append("<div  "+dialog1+"><table "+grid1+"></table></div>");
		$( '#'+dialog ).css({
			"position":"absolute",
			"z-index":"1000000",
			"display":"none",
			"box-shadow":"0px 0px 6px #333"
		});	  
	  	$("#"+grid_).jqGrid('unbindKeys');		
		var with_idthuoc=parseFloat($('#jqgh_'+grid_+'_'+input).width())-32;
		$(input_tam).hide(); 		
		$('#'+grid_+' '+input_tam).before( '<input id="'+input1+'" class="editable" type="text" style="width:'+with_idthuoc+'px" role="textbox">' );   
		if(typeof window.id_combox_dialog == 'undefined'){
			window.id_combox_dialog= new Array();
		}	
		window.id_combox_dialog.push(dialog);
		$(grid).click(function(){
			  $(grid).data('clicked', true);
		});
		$("#"+grid_).jqGrid('unbindKeys');
		callback(input1);					
		fun('#'+grid,data);			
		init_combox(input_tam1,input_tam,'#'+dialog,'#'+grid,defaultvalue,'bw');
		afterInit_combox(input_tam1,'#'+dialog,'#'+grid,input_tam);	
		if(isfocus==1){	
			$('#'+rowId+'_'+input+'_combobox').focus();
			$('#'+rowId+'_'+input+'_combobox').select();	  
		}	  
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
	function create_combobox_tam(input,fun,seach,data_local,data,defaultvalue){
		var grid   = input+'_grid';
		var input1 = input+'_hidden';
		var dialog = input+'_dialog';
		var dialog_tam    = dialog.substr(1);
		var input1_tam    = input1.substr(1);
		var grid_tam      =grid.substr(1);
		var grid1      ="id='"+grid_tam+"'";
		var dialog1    ="id='"+dialog_tam+"'";	
		var input11    ="id='"+input1_tam+"'";	
		if(typeof window.id_combox_dialog == 'undefined'){
				window.id_combox_dialog= new Array();
		}
		if($("."+input.substr(1)+"_button").length){
			if(data_local==''){
			var pathname = window.location.href;
			var module = getURLParameter('module',pathname);
			var view = getURLParameter('view',pathname);
			var pathname1='resource.php?module='+module+'&view='+view+'&action='+data;
				$.post(pathname1).done(function(datalocal) {
					$(grid).jqGrid('setGridParam', { datatype: 'jsonstring', datastr: datalocal }).trigger('reloadGrid', [{ page: 1}]);
				})
			}else{
				$(grid).jqGrid('setGridParam', { datatype: 'jsonstring', datastr: data_local }).trigger('reloadGrid', [{ page: 1}]);
			}
		}else{
			
			
			id_combox_dialog.push(dialog);
			$(input).before('<input '+input11+'  type="text" lang="luu" style="display:none">');  
			$("body").append("<div  "+dialog1+"><table "+grid1+"></table></div>");
			 $( dialog ).css({
				"position":"absolute",
				"z-index":"1000000",
				"display":"none",
				"box-shadow":"0px 0px 6px #333"
			});
			
			
			$(grid).click(function(){
			  $(grid).data('clicked', true);
			});
			afterInit_combox_tam(input,dialog,grid,input1);
			if(data_local==''){
				
				var pathname = window.location.href;
				var module = getURLParameter('module',pathname);
				var view = getURLParameter('view',pathname);
				var pathname1='resource.php?module='+module+'&view='+view+'&action='+data;
					if(data!=''){
					$.post(pathname1).done(function(datalocal) {
							fun(grid,datalocal);
							init_combox_tam(input,input1,dialog,grid,defaultvalue,seach);	
					})
					}else{						
						data='[]';
						fun(grid,data);
						init_combox_tam(input,input1,dialog,grid,defaultvalue,seach);
					}
			}else{				
				fun(grid,data_local);
				init_combox_tam(input,input1,dialog,grid,defaultvalue,seach);				
			}
		}
	}		 



function init_combox_tam(input,input1,dialog,grid,defaultvalue,seach){
jwerty.key('tab', false);




if (typeof defaultvalue != 'undefined'){
		if(defaultvalue!=0){
		var idToDataIndex = $(grid).jqGrid('getGridParam','_index');		
		sodong = $(grid).jqGrid('getGridParam', 'rowNum');			
		trang=Math.ceil(idToDataIndex[defaultvalue]/parseFloat(sodong));				
		setTimeout(function(){
		$(grid).jqGrid('setGridParam', {page:trang}).trigger('reloadGrid');		
		$(grid).jqGrid("setSelection",defaultvalue, true);
		var idcur = $(grid).jqGrid('getGridParam', 'selrow');
		var columnNames = $(grid).jqGrid('getGridParam','colModel');
		ten = $(grid).jqGrid('getCell', idcur, columnNames[0].name);
		$(input).val(ten);
		$(input1).val(idcur)
		},1)
	}
}else{
		var ids = $(grid).getDataIDs();$(grid).jqGrid("setSelection",ids[0], true);
		var idcur = $(grid).jqGrid('getGridParam', 'selrow');
		var columnNames = $(grid).jqGrid('getGridParam','colModel');
		ten = $(grid).jqGrid('getCell', idcur, columnNames[0].name);
		$(input).val(ten);
		$(input1).val(idcur);
}
$(input).click(function(event){
	for(i=0;i<=id_combox_dialog.length;i++){
					if(id_combox_dialog[i]!=dialog){
						if($(id_combox_dialog[i]).is(":visible")===true){
							create_combobox_close(input,id_combox_dialog[i],input1,grid)
						}
					}
				}	
    event.stopPropagation();
});
$('html').click(function() {	
	if($(dialog).is(":visible")===true){
		create_combobox_close_tam(input,dialog,input1,grid)
	}
});
$(dialog+' .ui-jqgrid-hbox').click(function(event) {
	for(i=0;i<=id_combox_dialog.length;i++){
					if(id_combox_dialog[i]!=dialog){
						if($(id_combox_dialog[i]).is(":visible")===true){
							create_combobox_close_tam(input,id_combox_dialog[i],input1,grid)
						}
					}
				}
	event.stopPropagation();
});



$(input+','+dialog+' .ui-jqgrid-hbox').bind("keydown", function(e) {
	var key = e.which;
	
	if(jwerty.is("enter",e)||jwerty.is("tab",e)){
	
		if($(dialog).is(":visible")===true){
			$(grid).data('clicked', true);
			var idcur = $(grid).jqGrid('getGridParam', 'selrow');
			$(grid).jqGrid("setSelection",idcur, true);
			
			create_combobox_close_tam(input,dialog,input1,grid);
		}
	}else if(jwerty.is("esc",e)){
			if($(dialog).is(":visible")===true){
			$(grid).data('clicked', true);
			create_combobox_close_tam(input,dialog,input1,grid);
		}
	}else if(jwerty.is("↓",e)){
					$(grid).data('clicked', false);
					var idcur = $(grid).jqGrid('getGridParam', 'selrow');
					if($(dialog).is(":visible")===false){
					 create_combobox_open(input,dialog)
					}else{
						if(idcur==null){
						var ids = $(grid).getDataIDs();
						$(grid).jqGrid("setSelection",ids[0], true);
						}else{
					  var idcur = $(grid).jqGrid('getGridParam', 'selrow')
					  if (idcur == null) return;
					  var ids = $(grid).getDataIDs();
					  var index = $(grid).getInd(idcur);
					  if (ids.length < 2) return;
					 index++;
					  if (index > ids.length)
						index = 1;
					  $(grid).jqGrid("setSelection",ids[index - 1], true);
						}
					}

				}
	else if(jwerty.is("↑",e)){
					$(grid).data('clicked', false);
						var idcur = $(grid).jqGrid('getGridParam', 'selrow')
					if($(dialog).is(":visible")===false){
					 create_combobox_open(input,dialog)	}
					else{
						if(idcur==null){
						var ids = $(grid).getDataIDs();
						$(grid).jqGrid("setSelection",ids[0], true);
						}else{

					  var idcur = $(grid).jqGrid('getGridParam', 'selrow')
					  if (idcur == null) return;
					  var ids = $(grid).getDataIDs();
					  var index = $(grid).getInd(idcur);
					  if (ids.length < 2) return;
					 index--;
					  if (index == 0){
						index = ids.length;
					  }
					  $(grid).jqGrid("setSelection",ids[index - 1], true);
						}
					}
				}
				})
	$(input+','+dialog+' .ui-jqgrid-hbox').bind("keyup", function(e) {
		if(jwerty.is("enter",e)||jwerty.is("tab",e)){
		}else if(jwerty.is("esc",e)){
		}else if(jwerty.is("↓",e)){
		}else if(jwerty.is("↑",e)){
		}else{
					$(grid).data('clicked', false);		
				if($.inArray(seach,['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc'])==-1)
				{
					seach='bw'
				}
				if(e.shiftKey && e.keyCode == 9){
				}else{
					 create_combobox_open(input,dialog);
					 grid = $(grid);
						var columnNames = $(grid).jqGrid('getGridParam','colModel');
						var searchFiler = $(input).val(), f;
						if (searchFiler.length === 0) {
							grid[0].p.search = false;
							$.extend(grid[0].p.postData,{filters:""});
						}
						f = {groupOp:"OR",rules:[]};
						f.rules.push({field:columnNames[0].name,op:seach,data:searchFiler});
						grid[0].p.search = true;
						$.extend(grid[0].p.postData,{filters:JSON.stringify(f)});
						grid.trigger("reloadGrid",[{page:1,current:true}])
						$(grid).jqGrid("setSelection",grid.getDataIDs()[0], true);
				}
				}
		});

}
	function afterInit_combox_tam(input,dialog,grid,input1) {

		 $(input).wrap( "<span class='custom-combobox' id='"+input.substr(1)+"_combobox'></span>" );
			var button = $("<a>").attr("tabIndex", -1).attr("title", "Show all items").tooltip().insertAfter($(input)).button({
			icons: {
				primary: "ui-icon-triangle-1-s"
			},
			text: false
		}).removeClass("ui-corner-all").addClass("custom-combobox-toggle  "+input.substr(1)+"_button").click(function(event) {
			$(input).focus();
			$(input).select();
			if($(dialog).is(":visible")===true){

				create_combobox_close_tam(input,dialog,input1,grid)
				
			}else{
				for(i=0;i<=id_combox_dialog.length;i++){
					if(id_combox_dialog[i]!=dialog){
						if($(id_combox_dialog[i]).is(":visible")===true){
							create_combobox_close_tam(input,id_combox_dialog[i],input1,grid)
						}
					}
				}
			    create_combobox_open(input,dialog);
				event.stopImmediatePropagation();
						
						var idToDataIndex = $(grid).jqGrid('getGridParam','_index');					
						var id = $(grid).jqGrid('getGridParam', 'selrow');
						trang=1
						if(id!=null){
							sodong = $(grid).jqGrid('getGridParam', 'rowNum');			
							trang=Math.ceil((idToDataIndex[id]+1)/parseFloat(sodong));		
													
						}else{
							trang=1;
						}						
						grid = $(grid);							
						if(trang<=0){
							trang=1
						}
						grid[0].p.search = false;
						$.extend(grid[0].p.postData,{filters:""});	
						$(grid).data('clicked', false);		
						grid.jqGrid('setGridParam', {page:trang}).trigger('reloadGrid');		
						grid.jqGrid("setSelection",id, true);
			}


		});
	 }
	 
	 
	 function create_combobox_close_tam(input,dialog,input1,grid){
				$(dialog).hide();
				count = jQuery(grid).jqGrid('getGridParam', 'records');
				if(count<=0){
				}else if($.trim($(grid).jqGrid('getGridParam', 'selrow'))==''){
				}
				else{
									var ids = $(grid).getDataIDs();
									var idcur = $(grid).jqGrid('getGridParam', 'selrow')
									var columnNames = $(grid).jqGrid('getGridParam','colModel');
						 			ten = $(grid).jqGrid('getCell', idcur, columnNames[0].name);
									$(input1).val(idcur);
									$(input).val(ten);
				}
							
				$(input).focus();
				$(input).select();
		}
		
function load_sign_new(id,elem){
		if(id!=''){
			var _hash="f1_"+encode64(id);	 
			_chuky = $.ajax({url: 'file_manager/php/connector.php?tenthumuc='+$.cookie('Signs')+'&answer=42&cmd=file&target='+_hash, async: false, success: function(data, result) {if (!result) alert('Không load được danh mục');}}).responseText;
			if(_chuky=="File not found"){
				//	$("#"+elem).append("<br><br><br><br><br>");
			}else{
				var _link= "file_manager/php/connector.php?tenthumuc="+$.cookie('Signs')+"&answer=42&cmd=file&target="+_hash;
				$("#"+elem).attr("src",_link);
			}
		}
	}
	
	function resize_panel(height_panel,ID_Chinh,ID_PHU){		
	 if($(ID_Chinh).height()>height_panel){		 	
		 var size = $(ID_PHU).css('font-size');		
		 size=parseInt(size)-1;
		 $(ID_PHU).css("font-size",size+"px");	
		 resize_panel(height_panel,ID_Chinh,ID_PHU)
		}
	}
	
	function barcode(barcode){
		barcode=$.trim(barcode);
		$("#barcode_key").remove();
		if(isNaN(barcode)){
			barcode_callback(barcode);
		}else{
			
			$.ajax({url: 'resource.php?module=web_services&function=create_mabenhnhan&action=index&term='+barcode, async: false, success: function(data, result) {data=data.split('|');parent.postMessage("editbenhnhan;"+data[0]+";"+data[1]+";"+data[2], "*") ;}});
		}	
	};
	
	function barcode_callback(barcode){
			
	};
	
	function convertHexToString(input) {    
		var hex = input.match(/[\s\S]{2}/g) || [];
		var output = '';	   
		for (var i = 0, j = hex.length; i < j; i++) {
			output += '%' + ('0' + hex[i]).slice(-2);
		}
		output = decodeURIComponent(output);
		return output;
	}
	function checkbox_search_slickgrid(input,data){
	if(!$("#"+input).length){
	 setTimeout(function(){checkbox_search_slickgrid(input,grid)},10);
	  return;
	}
	//$("td.ui-search-clear").hide();
	$('#'+input).hide();
	$('#'+input).before( '<span id="'+input+'1" style="cursor: default;"><input id="'+input+'1State" name="'+input+'1State" value="1" type="hidden">  </span>' );
	initTriStateCheckBox(input+'1', input+'1State', true);
	$('#'+input+'1').click(function(){
					if($('#'+input+'1State').val()==0){
						$('#'+input).val(0);
					}else if($('#'+input+'1State').val()==1){
						$('#'+input).val('')
					}else if($('#'+input+'1State').val()==2){
						$('#'+input).val(1)
					}
					window.dataView.refresh();
	})
}


// dialog xep hang goiloa
function goiloa_dialog_main(tieude,rong,cao,url){
    $("#goiloa_dialog_main").remove();
    $("body").append("<div id='goiloa_dialog_main' style='display:none;'><iframe src="+url+" style='border: none;width:100%;height:100%;'></iframe><div>");
    $( function() {

        $( "#goiloa_dialog_main" ).dialog({
          resizable: false,
          title:tieude,
          height: cao,
          width: rong,
          modal: true,
        });

        var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
        var eventer = window[eventMethod];
        var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
        eventer(messageEvent,function(e) { 
            tam=e.data.split('|||');
            if(tam[0]=='tatformtuybienxephang'){
                $( "#goiloa_dialog_main" ).dialog('close');
            }
        })
    });

}

// Kiem tra khoa HSBA noi tru
function kiemtrakhoa_hsbanoi(loaikhoa,id_benhannoitru){
	// loaikhoa: 1 la khoa luu 3 buoc, 2 la khoa in 3 buoc, 3 la khoa giay ra vien
	window._chitietkhoa='';
	window._chitietkhoa_notes='';
	window._khoain_giayravien=0;
	window._khoahsba=0;
	
    $.ajax({
        type: 'POST',
        async : false,
        url: "resource.php?module=web_services&function=kiemtrakhoa_hsbanoi&action=khoa_hsba_noi",
        data: {
            idbenhan:id_benhannoitru
        },
        success: function(data, status, xhr) {
            data=$.parseJSON(data);
             window._khoahsba=parseInt(data.Khoa);
			if(parseInt(data.ID_XemHSBA)>0){
				$("#daxem_giayravien").button('disable');
				$("#daxem_giayravien").attr("title",data.ThongTinXemHSBA);
			}else{
				$("#daxem_giayravien").button('enable');
				$("#daxem_giayravien").attr("title",'');
			}
			 if(loaikhoa==1 || loaikhoa==2 || loaikhoa==0){
				if(loaikhoa==1 || loaikhoa==2){
					$(".btn-khoa-luu,.btn-khoa-in").button('enable');
					$("[id$='iladd'],[id$='iledit'],[id$='ilsave'],[id$='ilcancel'],[id$='refresh'],[id$='print']").removeClass('ui-state-disabled');
					$("#grid_thuphanungthuoc_doc_ket_qua,#grid_thuphanungthuoc_thuc_hien").removeClass('ui-state-disabled');
					//to dieu tri
					$("#themylenh,#todieutri_sua,#todieutri_xoa,#todieutri_hoantat,#todieutri_in,#todieutri_chidinh_cls,#todieutri_chidinh_dtph,#todieutri_intoathuoc,#in_cns").removeClass('ui-state-disabled');
					// Buong giuong
					//$("#del_rowed4,#refresh_rowed4,#rowed4_iledit,#chotngay_rowed4,#huybo_rowed4").removeClass('ui-state-disabled');
					// Phieu cham soc
					$("#add_rowed3,#edit_rowed3,#edit_rowed3,#del_rowed3,#inphieu_rowed3").removeClass('ui-state-disabled');
					// Phieu tam ung
					$("#Phieutamung,#dnthanhtoan").removeClass('ui-state-disabled');
				}
				if(parseInt(data.Khoa)==1){
					$('body').find(':input[type=text],input[type=radio],input[type=text_checkbox],select,a,textarea,input[type=hidden],input[type=checkbox],input[type=checkbox]:checked').each(function(e) {
						 if ($(this).is(':enabled')) {
							if($("#"+this.id).attr('type')=="text_checkbox"){
								create_combobox_disable("#"+this.id);
							}else{
								$(this).prop('disabled', true);
								$(this).attr('khoa3buoc',1);
							}
						 }
					});
					$(".btn-khoa-luu").button('disable');
					$("[id$='iladd'],[id$='iledit'],[id$='ilsave'],[id$='ilcancel'],[id$='refresh']").addClass('ui-state-disabled');
					//giay thu phan ung thuoc
					$("#grid_thuphanungthuoc_doc_ket_qua,#grid_thuphanungthuoc_thuc_hien").addClass('ui-state-disabled');
					//to dieu tri
					$("#themylenh,#todieutri_sua,#todieutri_xoa,#todieutri_hoantat").addClass('ui-state-disabled');
					// Buong giuong
					$("#del_rowed4,#refresh_rowed4,#rowed4_iledit,#chotngay_rowed4,#huybo_rowed4").addClass('ui-state-disabled');
					// Phieu cham soc
					$("#add_rowed3,#edit_rowed3,#edit_rowed3,#del_rowed3").addClass('ui-state-disabled');
					// Phieu tam ung
					//$("#Phieutamung,#dnthanhtoan").addClass('ui-state-disabled');
				 }else if(parseInt(data.Khoa)==2){
					$('body').find(':input[type=text],input[type=radio],input[type=text_checkbox],select,a,textarea,input[type=hidden],input[type=checkbox],input[type=checkbox]:checked').each(function(e) {
						 if ($(this).is(':enabled')) {
							if($("#"+this.id).attr('type')=="text_checkbox"){
								create_combobox_disable("#"+this.id);
							}else{
								$(this).prop('disabled', true);
								$(this).attr('khoa3buoc',1);
							}
						 }
					});
					$(".btn-khoa-luu").button('disable');
					$("[id$='iladd'],[id$='iledit'],[id$='ilsave'],[id$='ilcancel'],[id$='refresh']").addClass('ui-state-disabled');
					//giay thu phan ung thuoc
					$("#grid_thuphanungthuoc_doc_ket_qua,#grid_thuphanungthuoc_thuc_hien").addClass('ui-state-disabled');
					//to dieu tri
					$("#themylenh,#todieutri_sua,#todieutri_xoa,#todieutri_hoantat").addClass('ui-state-disabled');
					// Buong giuong
					$("#del_rowed4,#refresh_rowed4,#rowed4_iledit,#chotngay_rowed4,#huybo_rowed4").addClass('ui-state-disabled');
					// Phieu cham soc
					$("#add_rowed3,#edit_rowed3,#edit_rowed3,#del_rowed3").addClass('ui-state-disabled');
					// Phieu tam ung
					//$("#Phieutamung,#dnthanhtoan").addClass('ui-state-disabled');
				 }else if(parseInt(data.Khoa)==3){
					$('body').find(':input[type=text],input[type=radio],input[type=text_checkbox],select,a,textarea,input[type=hidden],input[type=checkbox],input[type=checkbox]:checked').each(function(e) {
						 if ($(this).is(':enabled')) {
							if($("#"+this.id).attr('type')=="text_checkbox"){
								create_combobox_disable("#"+this.id);
							}else{
								$(this).prop('disabled', true);
								$(this).attr('khoa3buoc',1);
							}
						 }
					});
					$(".btn-khoa-luu").button('disable');
					$(".btn-khoa-in").button('disable');
					$("[id$='iladd'],[id$='iledit'],[id$='ilsave'],[id$='ilcancel'],[id$='refresh'],[id$='print']").addClass('ui-state-disabled');
					//giay thu phan ung thuoc
					$("#grid_thuphanungthuoc_doc_ket_qua,#grid_thuphanungthuoc_thuc_hien").addClass('ui-state-disabled');
					//to dieu tri
					$("#themylenh,#todieutri_sua,#todieutri_xoa,#todieutri_hoantat,#todieutri_in,#todieutri_chidinh_cls,#todieutri_chidinh_dtph,#todieutri_intoathuoc,#in_cns").addClass('ui-state-disabled');
					// Buong giuong
					$("#del_rowed4,#refresh_rowed4,#rowed4_iledit,#chotngay_rowed4,#huybo_rowed4").addClass('ui-state-disabled');
					// Phieu cham soc
					$("#add_rowed3,#edit_rowed3,#edit_rowed3,#del_rowed3,#inphieu_rowed3").addClass('ui-state-disabled');
					// Phieu tam ung
					$("#Phieutamung,#dnthanhtoan").addClass('ui-state-disabled');
				}else{
					 $('body').find(':input[type=text],input[type=radio],input[type=text_checkbox],select,a,textarea,input[type=hidden],input[type=checkbox],input[type=checkbox]:checked').each(function(e) {
						 if ($(this).is(':disabled') && $(this).attr('khoa3buoc')=='1') {
							if($("#"+this.id).attr('type')=="text_checkbox"){
								create_combobox_enable("#"+this.id);
							}else{
								$(this).prop("disabled",false);
								$(this).attr('khoa3buoc',0);
							}
						 }
					});
				 }
				 
				$("#khoa_cap1,#mokhoa_cap1,#khoa_cap2,#mokhoa_cap2,#khoa_cap3,#mokhoa_cap3").button('enable');
				if(parseInt(data.ID_KhoaCap1)>0){
					$("#khoa_cap1").hide();
					$("#mokhoa_cap1").show();

					$("#mokhoa_cap1").attr('title','Khóa bởi: '+data.NguoiHoanTatCap1);
					window._chitietkhoa+='\n - Khóa cấp 1 bởi '+data.NguoiHoanTatCap1;
					window._chitietkhoa_notes+='<br> - Khóa cấp 1 bởi '+data.NguoiHoanTatCap1;
					
				}else{
					$("#mokhoa_cap1").hide();
					$("#khoa_cap1").show();
					//$("#khoa_cap3,#mokhoa_cap3,#khoa_cap2,#mokhoa_cap2").button('disable');
					$("#mokhoa_cap3,#khoa_cap2,#mokhoa_cap2").button('disable');
					$("#mokhoa_cap1").attr('title','');
					//$(".btn-khoa-luu").button('enable');
				}
				if(parseInt(data.ID_KhoaCap2)>0){
					$("#khoa_cap2").hide();
					$("#mokhoa_cap2").show();
					$("#khoa_cap1,#mokhoa_cap1").button('disable');
					$("#mokhoa_cap2").attr('title','Khóa bởi: '+data.NguoiHoanTatCap2);
					window._chitietkhoa+='\n - Khóa cấp 2 bởi '+data.NguoiHoanTatCap2;
					window._chitietkhoa_notes+='<br> - Khóa cấp 2 bởi '+data.NguoiHoanTatCap2;
					//$(".btn-khoa-luu").button('disable');
				}else{
					$("#mokhoa_cap2").hide();
					$("#khoa_cap2").show();
					//$("#khoa_cap3,#mokhoa_cap3").button('disable');
					$("#mokhoa_cap3").button('disable');
					$("#mokhoa_cap2").attr('title','');
					//$(".btn-khoa-luu").button('enable');
				}
				if(parseInt(data.ID_KhoaCap3)>0){
					$("#khoa_cap3").hide();
					$("#mokhoa_cap3").show();
					$("#khoa_cap1,#mokhoa_cap1,#khoa_cap2,#mokhoa_cap2").button('disable');
					$("#mokhoa_cap3").attr('title','Khóa bởi: '+data.NguoiHoanTatCap3);
					window._chitietkhoa+='\n - Khóa cấp 3 bởi '+data.NguoiHoanTatCap3;
					window._chitietkhoa_notes+='<br> - Khóa cấp 3 bởi '+data.NguoiHoanTatCap3;
					$("#mokhoa_cap3").button('enable');
				}else{
					$("#mokhoa_cap3").hide();
					$("#khoa_cap3").show();
					$("#khoa_cap3").attr('title','');
					//$(".btn-khoa-in").button('enable');
				}
			}
			if(loaikhoa==3 || loaikhoa==0){
				if(parseInt(data.ID_KhoaInGiayRaVien)>0){
					window._khoain_giayravien=1;
					$("#khoa_ingiayravien").hide();
					$("#mokhoa_ingiayravien").show();
					$("#mokhoa_ingiayravien").attr('title','Khóa bởi: '+data.NguoiKhoaInGiayRaVien);
					$("#xemingrv").attr('title','Khóa bởi: '+data.NguoiKhoaInGiayRaVien);
					
					window._chitietkhoa+='\n - Khóa in giấy ra viện bởi '+data.NguoiKhoaInGiayRaVien;
					window._chitietkhoa_notes+='<br> - Khóa in giấy ra viện bởi '+data.NguoiKhoaInGiayRaVien;
					$(".btn-khoa-in-ravien").button('disable');
				}else{
					window._khoain_giayravien=0;
					$("#mokhoa_ingiayravien").hide();
					$("#khoa_ingiayravien").show();
					$("#mokhoa_ingiayravien").attr('title','');
					$("#xemingrv").attr('title','');
					$(".btn-khoa-in-ravien").button('enable');
				}
			}
			
			//if(((parseInt(data.Khoa)==1 || parseInt(data.Khoa)==2) && (loaikhoa==1 || loaikhoa==0)) || ((parseInt(data.Khoa)==3) && (loaikhoa==1 || loaikhoa==2 || loaikhoa==0)) || (window._khoain_giayravien==1  && (loaikhoa==3 || loaikhoa==0))){
			if(((parseInt(data.Khoa)==1 || parseInt(data.Khoa)==2) && (loaikhoa==1 || loaikhoa==0)) || ((parseInt(data.Khoa)==3) && (loaikhoa==1 || loaikhoa==2 || loaikhoa==0))  || (window._khoain_giayravien==1  && loaikhoa==3)){
			$("#khoa_benhan_noi_dialog_main").remove();
				$("body").append("<div id='khoa_benhan_noi_dialog_main' style='display:none;'><b>Hồ sơ này đã khóa!</b>"+ window._chitietkhoa_notes+" <br><br><hr style='width: 100%; border-width: 0px 0px 1px; border-style: none none dashed; border-color: -moz-use-text-color; -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; border-image: none;'><i style='font-size:10px;'><strong>Lưu ý:</strong></i><br><i style='font-size:10px;'>- Khóa cấp 1, 2 sẽ khóa chức năng chỉnh sửa.</i><br><i style='font-size:10px;'>- Khóa cấp 3 sẽ khóa chức năng chỉnh sửa và in hồ sơ.</i><div>");
				$( function() {
					$( "#khoa_benhan_noi_dialog_main" ).dialog({
					  resizable: false,
					  title:"Thông báo",
					  height: "auto",
					  width: 350,
					  modal: true,
					  buttons: {
						"OK": function() {
						  $( this ).dialog( "close" );
						}
					}
					});
				});
				
			}
			
        }
    });
}
// End kiem tra khoa HSBA noi tru

// Show thông báo
function hienthongbao(text){
  if(text==''){
    $(".nam-bongmo").remove();
    $(".nam-dangtai").remove();
  }else{
     $("body").append('<div class="nam-bongmo"></div><div class="nam-dangtai">'+text+'<br>(Vui lòng chờ trong giây lát)</div>');
  }
}
// ENd show thông báo

// Show thông báo custom
function emrhienthongbao_custom(text,emrClass=""){
  if(text==''){
    $(".emr-bongmo").remove();
    $(".emr-dangtai").remove();
  }else{
     $("body").append('<div class="emr-bongmo '+emrClass+'"></div><div class="emr-dangtai '+emrClass+'" style="top: 30%;width:250px">'+text+'</div>');
  }
}
// ENd show thông báo

//Luu nguoi duyet ho so benh an
function emr_duyet_hsba_noi(a){
    var idba=$(a).attr('data-idba');
    if($("#KetQuaDieuTri").val()==''){
        alert("Bệnh nhân chưa ra viện!");
    }else{
        $.ajax({
            type: 'POST',
            async : false,
            url: 'resource.php?module=web_services&function=daxemhoso&action=khoa_hsba_noi',
            data: {
                idbenhan: idba
            },
            success: function(data, status, xhr) {
                tooltip_message("Lưu thành công");
				 kiemtrakhoa_hsbanoi(1,idba); 
            }
        });
    }
}
// END luu nguoi duyet ho so benh an

//Chuyen phong kham
function emr_thuchienxong(input1,input2,input3,input4,input5){
	//input1: ID_Kham
	//input2: sampleid
	
   /*  if((input1=='' || input1==0) && (input2=='' || input2==0)){
		alert("Không tìm thấy ID khám hoặc Sample ID, nên không thể chuyển phòng!");
    }else{
		$('#emr-dialog-xephang-confirm').remove();
		$('body').append('<div id="emr-dialog-xephang-confirm" title="Thông báo">Bạn có muốn chuyển bệnh nhân qua phòng kế tiếp không?<hr style="border: 1px dashed #ccc;" /><span style="font-size:10px; font-style: italic;">- Chọn <strong>có</strong> hệ thống sẽ chuyển qua cận lâm sàng tiếp theo nếu có<br>- Chọn <strong>Không</strong> hệ thống sẽ ngừng chuyển qua cận lâm sàng kế tphiếp</span></div>');

		$('#emr-dialog-xephang-confirm').dialog({
			autoOpen: true,
			width: 350,
			height:180,
			modal: true,
			resizable: false,
			closeOnEscape: true,
			focus: function() {
				$('#emr-dialog-xephang-confirm').parent().find('.ui-dialog-buttonpane button:eq(0)').focus();
			},
			buttons: {
				"Có": function() {
					$( this ).dialog( "close" );
					$.ajax({
						type: 'POST',
						async : false,
						url: 'resource.php?module=web_services&function=thuchienxong&action=xephang',
						data: {
							idkham: input1,
							sampleid: input2
						},
						success: function(data, status, xhr) {
							//tooltip_message("Lưu thành công");
							alert(data);
						}
					});
				},
				"Không": function() {
					$( this ).dialog( "close" );
				}
			}
		});
        
    } */
}
// END Chuyen phong kham


//Day vao phong khi kich hoat KSK, Tam ung, Lay DHST KSKCTY
function emr_xephangluotkham(idluotkham,hienthongbao,kiemtra,async=false){
   /*  if((idluotkham=='' || idluotkham==0)){
		if(hienthongbao==1){
			alert("Không tìm thấy lượt khám của bệnh nhân!");
		}else if(hienthongbao==2){
			tooltip_message("Không tìm thấy lượt khám của bệnh nhân!");
		}
    }else{
        $.ajax({
            type: 'POST',
            async : async,
            url: 'resource.php?module=web_services&function=xephangluotkham&action=xephang&hienmaloi=a',
            data: {
                idluotkham: idluotkham,
				kiemtra:kiemtra
            },
            success: function(data, status, xhr) {
				if(hienthongbao==1){
					alert(data);
				}else if(hienthongbao==2){
					tooltip_message(data);
				}
				
            }
        });
    } */
}
//Day vao phong khi kich hoat KSK, Tam ung, Lay DHST KSKCTY


//Check lock
function emr_checkLock(idluotkham,idkham,idphy,iddtph,iduser,loai,hienthongbao=1){
	window.emrIsLock=0;
	$.ajax({
		type: 'POST',
		async : false,
		url: 'resource.php?module=web_services&function=khoacustom&action=check_khoa',
		data: {
			idluotkham:idluotkham,
			idkham:idkham,
			idphy:idphy,
			iddtph:iddtph,
			iduser:iduser,
			loai:loai
		},
		success: function(data, status, xhr) {
			data=$.parseJSON(data);
			if(data.IsLock==1){
				window.emrIsLock=1;
				if(hienthongbao==1){
					alert(data.Notes);
				}else if(hienthongbao==2){
					tooltip_message(data.Notes);
				}
			}else{
				window.emrIsLock=0;
			}
		}
	});
}
// END Check lock

//Check bat dau benh an
function emr_checkBatDauBenhAnNoiTru(idluotkham,iduser,hienthongbao=1,chucnang=1){
	window.emrCheckBatDauBenhAnNoiTru=0;
	$.ajax({
		type: 'POST',
		async : false,
		url: 'resource.php?module=web_services&function=khoacustom&action=check_khoa',
		data: {
			idluotkham:idluotkham,
			idkham:null,
			idphy:null,
			iddtph:null,
			iduser:iduser,
			loai:11
		},
		success: function(data, status, xhr) {
			data=$.parseJSON(data);
			if(data.IsLock==1){
				setTimeout(function(){
					$('body').find(':input[type=text],input[type=text_checkbox],input[type=button],select,textarea,input[type=hidden],input[type=checkbox]:checked,button').each(function() {
						var n_newid=this.id+'_hidden';
						if($("#"+n_newid).length>0){
						   // console.log("#"+n_newid);
							create_combobox_disable("#"+this.id);
							//$(this).attr('test','phannam');
						}else if($("#"+this.id).hasClass( "ui-button" ) && this.id!='batdau'){
							$("#"+this.id).button('disable');
						}else if(this.id!='batdau'){
							$("#"+this.id).prop("disabled",true);
						}
					});
					if(chucnang==2){
						emrhienthongbao_custom("Vui lòng <span style='color:red;'>Bắt đầu</span> bệnh án trước khi thực hiện chức năng này!<br><span style='font-size: 11px; display: inline-block; margin-top: 5px; width: 100%; border-top: 1px dashed rgb(204, 204, 204); font-weight: normal; font-style: italic;'>(Nếu đã bắt đầu vui lòng click vào <a href='javascript:window.location.href=window.location.href'>ĐÂY</a> để tải lại)<span>");
					}
				},300);
				window.emrCheckBatDauBenhAnNoiTru=1;
				if(hienthongbao==1){
					alert(data.Notes);
				}else if(hienthongbao==2){
					tooltip_message(data.Notes);
				}
			}else{
				window.emrCheckBatDauBenhAnNoiTru=0;
			}
		}
	});
}
// END Check bat dau benh an









function IsJsonString(str) {
	try {
		JSON.parse(str);
	} catch (e) {
		return false;
	}
	return true;
}