<script language="javascript"> 
 function setHomepage() 
 { 
 /* if (document.all) 
     { 
         document.body.style.behavior='url(#default#homepage)'; 
   document.body.setHomePage('http://sinhvienit.net'); 
   
     } 
     else if (window.sidebar) 
     { 
     if(window.netscape) 
     { 
          try 
          {   
             netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");   
          }   
          catch(e)   
          {   
 alert("this action was aviod by your browser, if you want to enable,please enter about:config in your address line,and change the value of signed.applets.codebase_principal_support to true"); 
          } 
     }  
     var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components. interfaces.nsIPrefBranch); 
     prefs.setCharPref('browser.startup.homepage','http://sinhvienit.net'); 
  } */
   
	 alert("") 
  
 } 
// signed.applets.codebase_principal_support
</script>



<?php
//echo phpinfo();
/*var_dump(printer_list(PRINTER_ENUM_LOCAL | PRINTER_ENUM_SHARED));
//$handle = printer_open("\\\\DELL-PC\\Canon LBP3000 chinh");
$handle = printer_open("Canon LBP3000");
 printer_set_option($handle, PRINTER_MODE, "TEXT"); 
   printer_write($handle, "Cộng hòa xã hội chủ nghĩa Việt Nam"); 
   printer_close($handle); */
?>

<?php
/*$p = printer_open("Canon LBP3000");
printer_set_option($p, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_A4);
printer_start_doc($p, "Testpage");
printer_start_page($p);
$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
$font = printer_create_font("Courier", 300, 150, PRINTER_FW_NORMAL, false, false, false, 0);

printer_select_pen($p, $pen);
printer_select_font($p, $font);

/*for ($i = 0; $i < 4600; $i+=100)
{
printer_draw_line($p, $i,0,$i,6700);
printer_draw_text($p,$i,$i,0);
}
for ($i = 0; $i < 6700; $i+=100)
{
printer_draw_line($p, 0,$i,4600,$i);
printer_draw_text($p,$i,0,$i);
}
printer_draw_text($p,"Cộng hòa xã hội chủ nghĩa Việt Nam",0,"Cộng hòa xã hội chủ nghĩa Việt Nam");
printer_delete_font($font);
printer_delete_pen($pen);
printer_end_page($p);
printer_end_doc($p);
printer_close($p);*/
?>
<html>
<head>
 <script type="text/javascript" src="js/jquery-1.7.1.js"></script>
   <script type="text/javascript" src="js/html2canvas.js"></script>
   <script type="text/javascript" src="js/jquery.plugin.html2canvas.js"></script>
     <script type="text/javascript">
	   $(document).ready(function() {
		   setHomepage() 
		   
	 	// callIframe("http://192.168.1.24:81/giaidoan2/resource.php?module=report&view=lich_lam_viec&action=in_lich_lam_viec&idphong=20&loailich=&from=2013-09-01&to=2013-09-30&mang_ngay=2013-09-01;2013-09-02;2013-09-03;2013-09-04;2013-09-05;2013-09-06;2013-09-07;2013-09-08;2013-09-09;2013-09-10;2013-09-11;2013-09-12;2013-09-13;2013-09-14;2013-09-15;2013-09-16;2013-09-17;2013-09-18;2013-09-19;2013-09-20;2013-09-21;2013-09-22;2013-09-23;2013-09-24;2013-09-25;2013-09-26;2013-09-27;2013-09-28;2013-09-29;2013-09-30;", loader,1000);
	    });
	// $("#print_iframe").contents().find("#someDiv").removeClass("hidden");
	 	 
	   function print(contents) {
		   var applet = document.jzebra; 
            applet.findPrinter("Canon LBP3000 chinh");  
			//applet.findPrinter("zebra"); 
			    
         	monitorFinding();
		 
		  // document.jzebra.findPrinter("Canon LBP3000");
		   //document.jzebra.getPrinterName("Canon LBP3000");
		   //  document.jzebra.appendHTMLFile("http://192.168.1.24:81/giaidoan2/resource.php?module=report&view=lich_lam_viec&action=in_lich_lam_viec&idphong=20&loailich=&from=2013-09-01&to=2013-09-30&mang_ngay=2013-09-01;2013-09-02;2013-09-03;2013-09-04;2013-09-05;2013-09-06;2013-09-07;2013-09-08;2013-09-09;2013-09-10;2013-09-11;2013-09-12;2013-09-13;2013-09-14;2013-09-15;2013-09-16;2013-09-17;2013-09-18;2013-09-19;2013-09-20;2013-09-21;2013-09-22;2013-09-23;2013-09-24;2013-09-25;2013-09-26;2013-09-27;2013-09-28;2013-09-29;2013-09-30;");
		// document.jzebra.appendHTML("<html>"+contents+"</html>");
      //	document.jzebra.printHTML(); 
	
	  //var encodedData = window.btoa(contents);
	   // alert(contents)
	/*   content="PGRpdiBzdHlsZT0id2lkdGg6IDQ4NXB4OyIgZGlyPSJsdHIiIGlkPSJnYm94X3Jvd2VkMyIgY2xhc3M9InVpLWpxZ3JpZCB1aS13aWRnZXQgdWktd2lkZ2V0LWNvbnRlbnQgdWktY29ybmVyLWFsbCI+PGRpdiBjbGFzcz0idWktd2lkZ2V0LW92ZXJsYXkganFncmlkLW92ZXJsYXkiIGlkPSJsdWlfcm93ZWQzIj48L2Rpdj48ZGl2IHN0eWxlPSJkaXNwbGF5OiBibG9jazsiIGNsYXNzPSJsb2FkaW5nIHVpLXN0YXRlLWRlZmF1bHQgdWktc3RhdGUtYWN0aXZlIiBpZD0ibG9hZF9yb3dlZDMiPsSQYW5nIG7huqFwIGThu68gbGnhu4d1Li4uPC9kaXY+PGRpdiBzdHlsZT0id2lkdGg6IDQ4NXB4OyIgaWQ9Imd2aWV3X3Jvd2VkMyIgY2xhc3M9InVpLWpxZ3JpZC12aWV3Ij48ZGl2IGNsYXNzPSJ1aS1qcWdyaWQtdGl0bGViYXIgdWktd2lkZ2V0LWhlYWRlciB1aS1jb3JuZXItdG9wIHVpLWhlbHBlci1jbGVhcmZpeCI+PGEgc3R5bGU9InJpZ2h0OiAwcHg7IiBjbGFzcz0idWktanFncmlkLXRpdGxlYmFyLWNsb3NlIEhlYWRlckJ1dHRvbiIgcm9sZT0ibGluayIgaHJlZj0iamF2YXNjcmlwdDp2b2lkKDApIj48c3BhbiBjbGFzcz0idWktaWNvbiB1aS1pY29uLWNpcmNsZS10cmlhbmdsZS1uIj48L3NwYW4+PC9hPjxzcGFuIGNsYXNzPSJ1aS1qcWdyaWQtdGl0bGUiPkzhu4tjaCBsw6BtIHZp4buHYyBj4bunYSB1bmRlZmluZWQ8L3NwYW4+PC9kaXY+PGRpdiBjbGFzcz0idWktc3RhdGUtZGVmYXVsdCB1aS1qcWdyaWQtaGRpdiIgc3R5bGU9IndpZHRoOiA0ODVweDsiPjxkaXYgY2xhc3M9InVpLWpxZ3JpZC1oYm94Ij48dGFibGUgY2xhc3M9InVpLWpxZ3JpZC1odGFibGUiIHN0eWxlPSJ3aWR0aDozODU1cHgiIHJvbGU9ImdyaWQiIGFyaWEtbGFiZWxsZWRieT0iZ2JveF9yb3dlZDMiIGJvcmRlcj0iMCIgY2VsbHBhZGRpbmc9IjAiIGNlbGxzcGFjaW5nPSIwIj48dGhlYWQ+PHRyIHN0eWxlPSJoZWlnaHQ6IGF1dG87IiBjbGFzcz0ianFnLWZpcnN0LXJvdy1oZWFkZXIiIGFyaWEtaGlkZGVuPSJ0cnVlIiByb2xlPSJyb3ciPjx0aCBjbGFzcz0idWktZmlyc3QtdGgtbHRyIiBzdHlsZT0iaGVpZ2h0OiAwcHg7IHdpZHRoOiAyNXB4OyIgcm9sZT0iZ3JpZGNlbGwiPjwvdGg+PHRoIGNsYXNzPSJ1aS1maXJzdC10aC1sdHIiIHN0eWxlPSJoZWlnaHQ6IDBweDsgd2lkdGg6IDcwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48dGggY2xhc3M9InVpLWZpcnN0LXRoLWx0ciIgc3R5bGU9ImhlaWdodDogMHB4OyB3aWR0aDogMTIwcHg7IiByb2xlPSJncmlkY2VsbCI+PC90aD48L3RyPjx0ciBjbGFzcz0idWktanFncmlkLWxhYmVscyBqcWctc2Vjb25kLXJvdy1oZWFkZXIiIHJvbGU9InJvd2hlYWRlciI+PHRoIHN0eWxlPSJib3JkZXItdG9wOiAwcHggbm9uZTsiIGNsYXNzPSJ1aS1zdGF0ZS1kZWZhdWx0IHVpLXRoLWNvbHVtbi1oZWFkZXIgdWktdGgtbHRyIiByb2xlPSJjb2x1bW5oZWFkZXIiPjwvdGg+PHRoIHN0eWxlPSJib3JkZXItdG9wOiAwcHggbm9uZTsiIGNsYXNzPSJ1aS1zdGF0ZS1kZWZhdWx0IHVpLXRoLWNvbHVtbi1oZWFkZXIgdWktdGgtbHRyIiByb2xlPSJjb2x1bW5oZWFkZXIiPjwvdGg+PHRoIGNvbHNwYW49IjEiIHN0eWxlPSJoZWlnaHQ6IDIycHg7IGJvcmRlci10b3A6IDBweCBub25lOyIgY2xhc3M9InVpLXN0YXRlLWRlZmF1bHQgdWktdGgtY29sdW1uLWhlYWRlciB1aS10aC1sdHIiIHJvbGU9ImNvbHVtbmhlYWRlciI+VHXhuqduIDM1PC90aD48dGggY29sc3Bhbj0iNyIgc3R5bGU9ImhlaWdodDogMjJweDsgYm9yZGVyLXRvcDogMHB4IG5vbmU7IiBjbGFzcz0idWktc3RhdGUtZGVmYXVsdCB1aS10aC1jb2x1bW4taGVhZGVyIHVpLXRoLWx0ciIgcm9sZT0iY29sdW1uaGVhZGVyIj5UdeG6p24gMzY8L3RoPjx0aCBjb2xzcGFuPSI3IiBzdHlsZT0iaGVpZ2h0OiAyMnB4OyBib3JkZXItdG9wOiAwcHggbm9uZTsiIGNsYXNzPSJ1aS1zdGF0ZS1kZWZhdWx0IHVpLXRoLWNvbHVtbi1oZWFkZXIgdWktdGgtbHRyIiByb2xlPSJjb2x1bW5oZWFkZXIiPlR14bqnbiAzNzwvdGg+PHRoIGNvbHNwYW49IjciIHN0eWxlPSJoZWlnaHQ6IDIycHg7IGJvcmRlci10b3A6IDBweCBub25lOyIgY2xhc3M9InVpLXN0YXRlLWRlZmF1bHQgdWktdGgtY29sdW1uLWhlYWRlciB1aS10aC1sdHIiIHJvbGU9ImNvbHVtbmhlYWRlciI+VHXhuqduIDM4PC90aD48dGggY29sc3Bhbj0iNyIgc3R5bGU9ImhlaWdodDogMjJweDsgYm9yZGVyLXRvcDogMHB4IG5vbmU7IiBjbGFzcz0idWktc3RhdGUtZGVmYXVsdCB1aS10aC1jb2x1bW4taGVhZGVyIHVpLXRoLWx0ciIgcm9sZT0iY29sdW1uaGVhZGVyIj5UdeG6p24gMzk8L3RoPjx0aCBzdHlsZT0iYm9yZGVyLXRvcDogMHB4IG5vbmU7IiBjbGFzcz0idWktc3RhdGUtZGVmYXVsdCB1aS10aC1jb2x1bW4taGVhZGVyIHVpLXRoLWx0ciIgcm9sZT0iY29sdW1uaGVhZGVyIj48L3RoPjwvdHI+PHRyIGNsYXNzPSJ1aS1qcWdyaWQtbGFiZWxzIGpxZy10aGlyZC1yb3ctaGVhZGVyIiByb2xlPSJyb3doZWFkZXIiPjx0aCBzdHlsZT0iIiBpZD0icm93ZWQzX3JuIiByb2xlPSJjb2x1bW5oZWFkZXIiIGNsYXNzPSJ1aS1zdGF0ZS1kZWZhdWx0IHVpLXRoLWNvbHVtbiB1aS10aC1sdHIiPjxkaXYgaWQ9ImpxZ2hfcm93ZWQzX3JuIj48c3BhbiBjbGFzcz0icy1pY28iIHN0eWxlPSJkaXNwbGF5Om5vbmUiPjxzcGFuIHNvcnQ9ImFzYyIgY2xhc3M9InVpLWdyaWQtaWNvLXNvcnQgdWktaWNvbi1hc2MgdWktc3RhdGUtZGlzYWJsZWQgdWktaWNvbiB1aS1pY29uLXRyaWFuZ2xlLTEtbiB1aS1zb3J0LWx0ciI+PC9zcGFuPjxzcGFuIHNvcnQ9ImRlc2MiIGNsYXNzPSJ1aS1ncmlkLWljby1zb3J0IHVpLWljb24tZGVzYyB1aS1zdGF0ZS1kaXNhYmxlZCB1aS1pY29uIHVpLWljb24tdHJpYW5nbGUtMS1zIHVpLXNvcnQtbHRyIj48L3NwYW4+PC9zcGFuPjwvZGl2PjwvdGg+PHRoIHN0eWxlPSIiIGlkPSJyb3dlZDNfbmFtZSIgcm9sZT0iY29sdW1uaGVhZGVyIiBjbGFzcz0idWktc3RhdGUtZGVmYXVsdCB1aS10aC1jb2x1bW4gdWktdGgtbHRyIj48c3BhbiBzdHlsZT0iY3Vyc29yOiBjb2wtcmVzaXplOyIgY2xhc3M9InVpLWpxZ3JpZC1yZXNpemUgdWktanFncmlkLXJlc2l6ZS1sdHIiPiZuYnNwOzwvc3Bhbj48ZGl2IGNsYXNzPSJ1aS1qcWdyaWQtc29ydGFibGUiIGlkPSJqcWdoX3Jvd2VkM19uYW1lIj5Uw6puPHNwYW4gY2xhc3M9InMtaWNvIiBzdHlsZT0iZGlzcGxheTpub25lIj48c3BhbiBzb3J0PSJhc2MiIGNsYXNzPSJ1aS1ncmlkLWljby1zb3J0IHVpLWljb24tYXNjIHVpLXN0YXRlLWRpc2FibGVkIHVpLWljb24gdWktaWNvbi10cmlhbmdsZS0xLW4gdWktc29ydC1sdHIiPjwvc3Bhbj48c3BhbiBzb3J0PSJkZXNjIiBjbGFzcz0idWktZ3JpZC1pY28tc29ydCB1aS1pY29uLWRlc2MgdWktc3RhdGUtZGlzYWJsZWQgdWktaWNvbiB1aS1pY29uLXRyaWFuZ2xlLTEtcyB1aS1zb3J0LWx0ciI+PC9zcGFuPjwvc3Bhbj48L2Rpdj48L3RoPjx0aCBzdHlsZT0iIiBpZD0icm93ZWQzXzIwMTMtMDktMDEiIHJvbGU9ImNvbHVtbmhlYWRlciIgY2xhc3M9InVpLXN0YXRlLWRlZmF1bHQgdWktdGgtY29sdW1uIHVpLXRoLWx0ciI+PHNwYW4gc3R5bGU9ImN1cnNvcjogY29sLXJlc2l6ZTsiIGNsYXNzPSJ1aS1qcWdyaWQtcmVzaXplIHVpLWpxZ3JpZC1yZXNpemUtbHRyIj4mbmJzcDs8L3NwYW4+PGRpdiBjbGFzcz0idWktanFncmlkLXNvcnRhYmxlIiBpZD0ianFnaF9yb3dlZDNfMjAxMy0wOS0wMSI+U3VuIDAxLTA5LTIwMTM8c3BhbiBjbGFzcz0icy1pY28iIHN0eWxlPSJkaXNwbGF5Om5vbmUiPjxzcGFuIHNvcnQ9ImFzYyIgY2xhc3M9InVpLWdyaWQtaWNvLXNvcnQgdWktaWNvbi1hc2MgdWktc3RhdGUtZGlzYWJsZWQgdWktaWNvbiB1aS1pY29uLXRyaWFuZ2xlLTEtbiB1aS1zb3J0LWx0ciI+PC9zcGFuPjxzcGFuIHNvcnQ9ImRlc2MiIGNsYXNzPSJ1aS1ncmlkLWljby1zb3J0IHVpLWljb24tZGVzYyB1aS1zdGF0ZS1kaXNhYmxlZCB1aS1pY29uIHVpLWljb24tdHJpYW5nbGUtMS1zIHVpLXNvcnQtbHRyIj48L3NwYW4+PC9zcGFuPjwvZGl2PjwvdGg+PHRoIHN0eWxlPSIiIGlkPSJyb3dlZDNfMjAxMy0wOS0wMiIgcm9sZT0iY29sdW1uaGVhZGVyIiBjbGFzcz0idWktc3RhdGUtZGVmYXVsdCB1aS10aC1jb2x1bW4gdWktdGgtbHRyIj48c3BhbiBzdHlsZT0iY3Vyc29yOiBjb2wtcmVzaXplOyIgY2xhc3M9InVpLWpxZ3JpZC1yZXNpemUgdWktanFncmlkLXJlc2l6ZS1sdHIiPiZuYnNwOzwvc3Bhbj48ZGl2IGNsYXNzPSJ1aS1qcWdyaWQtc29ydGFibGUiIGlkPSJqcWdoX3Jvd2VkM18yMDEzLTA5LTAyIj5Nb24gMDItMDktMjAxMzxzcGFuIGNsYXNzPSJzLWljbyIgc3R5bGU9ImRpc3BsYXk6bm9uZSI+PHNwYW4gc29ydD0iYXNjIiBjbGFzcz0idWktZ3JpZC1pY28tc29ydCB1aS1pY29uLWFzYyB1aS1zdGF0ZS1kaXNhYmxlZCB1aS1pY29uIHVpLWljb24tdHJpYW5nbGUtMS1uIHVpLXNvcnQtbHRyIj48L3NwYW4+PHNwYW4gc29ydD0iZGVzYyIgY2xhc3M9InVpLWdyaWQtaWNvLXNvcnQgdWktaWNvbi1kZXNjIHVpLXN0YXRlLWRpc2FibGVkIHVpLWljb24gdWktaWNvbi10cmlhbmdsZS0xLXMgdWktc29ydC1sdHIiPjwvc3Bhbj48L3NwYW4+PC9kaXY+PC90aD48dGggc3R5bGU9IiIgaWQ9InJvd2VkM18yMDEzLTA5LTAzIiByb2xlPSJjb2x1bW5oZWFkZXIiIGNsYXNzPSJ1aS1zdGF0ZS1kZWZhdWx0IHVpLXRoLWNvbHVtbiB1aS10aC1sdHIiPjxzcGFuIHN0eWxlPSJjdXJzb3I6IGNvbC1yZXNpemU7IiBjbGFzcz0idWktanFncmlkLXJlc2l6ZSB1aS1qcWdyaWQtcmVzaXplLWx0ciI+Jm5ic3A7PC9zcGFuPjxkaXYgY2xhc3M9InVpLWpxZ3JpZC1zb3J0YWJsZSIgaWQ9ImpxZ2hfcm93ZWQzXzIwMTMtMDktMDMiPlR1ZSAwMy0wOS0yMDEzPHNwYW4gY2xhc3M9InMtaWNvIiBzdHlsZT0iZGlzcGxheTpub25lIj48c3BhbiBzb3J0PSJhc2MiIGNsYXNzPSJ1aS1ncmlkLWljby1zb3J0IHVpLWljb24tYXNjIHVpLXN0YXRlLWRpc2FibGVkIHVpLWljb24gdWktaWNvbi10cmlhbmdsZS0xLW4gdWktc29ydC1sdHIiPjwvc3Bhbj48c3BhbiBzb3J0PSJkZXNjIiBjbGFzcz0idWktZ3JpZC1pY28tc29ydCB1aS1pY29uLWRlc2MgdWktc3RhdGUtZGlzYWJsZWQgdWktaWNvbiB1aS1pY29uLXRyaWFuZ2xlLTEtcyB1aS1zb3J0LWx0ciI+PC9zcGFuPjwvc3Bhbj48L2Rpdj48L3RoPjx0aCBzdHlsZT0iIiBpZD0icm93ZWQzXzIwMTMtMDktMDQiIHJvbGU9ImNvbHVtbmhlYWRlciIgY2xhc3M9InVpLXN0YXRlLWRlZmF1bHQgdWktdGgtY29sdW1uIHVpLXRoLWx0ciI+PHNwYW4gc3R5bGU9ImN1cnNvcjogY29sLXJlc2l6ZTsiIGNsYXNzPSJ1aS1qcWdyaWQtcmVzaXplIHVpLWpxZ3JpZC1yZXNpemUtbHRyIj4mbmJzcDs8L3NwYW4+PGRpdiBjbGFzcz0idWktanFncmlkLXNvcnRhYmxlIiBpZD0ianFnaF9yb3dlZDNfMjAxMy0wOS0wNCI+V2VkIDA0LTA5LTIwMTM8c3BhbiBjbGFzcz0icy1pY28iIHN0eWxlPSJkaXNwbGF5Om5vbmUiPjxzcGFuIHNvcnQ9ImFzYyIgY2xhc3M9InVpLWdyaWQtaWNvLXNvcnQgdWktaWNvbi1hc2MgdWktc3RhdGUtZGlzYWJsZWQgdWktaWNvbiB1aS1pY29uLXRyaWFuZ2xlLTEtbiB1aS1zb3J0LWx0ciI+PC9zcGFuPjxzcGFuIHNvcnQ9ImRlc2MiIGNsYXNzPSJ1aS1ncmlkLWljby1zb3J0IHVpLWljb24tZGVzYyB1aS1zdGF0ZS1kaXNhYmxlZCB1aS1pY29uIHVpLWljb24tdHJpYW5nbGUtMS1zIHVpLXNvcnQtbHRyIj48L3NwYW4+PC9zcGFuPjwvZGl2PjwvdGg+PHRoIHN0eWxlPSIiIGlkPSJyb3dlZDNfMjAxMy0wOS0wNSIgcm9sZT0iY29sdW1uaGVhZGVyIiBjbGFzcz0idWktc3RhdGUtZGVmYXVsdCB1aS10aC1jb2x1bW4gdWktdGgtbHRyIj48c3BhbiBzdHlsZT0iY3Vyc29yOiBjb2wtcmVzaXplOyIgY2xhc3M9InVpLWpxZ3JpZC1yZXNpemUgdWktanFncmlkLXJlc2l6ZS1sdHIiPiZuYnNwOzwvc3Bhbj48ZGl2IGNsYXNzPSJ1aS1qcWdyaWQtc29ydGFibGUiIGlkPSJqcWdoX3Jvd2VkM18yMDEzLTA5LTA1Ij5UaHUgMDUtMDktMjAxMzxzcGFuIGNsYXNzPSJzLWljbyIgc3R5bGU9ImRpc3BsYXk6bm9uZSI+PHNwYW4gc29ydD0iYXNjIiBjbGFzcz0idWktZ3JpZC1pY28tc29ydCB1aS1pY29uLWFzYyB1aS1zdGF0ZS1kaXNhYmxlZCB1aS1pY29uIHVpLWljb24tdHJpYW5nbGUtMS1uIHVpLXNvcnQtbHRyIj48L3NwYW4+PHNwYW4gc29ydD0iZGVzYyIgY2xhc3M9InVpLWdyaWQtaWNvLXNvcnQgdWktaWNvbi1kZXNjIHVpLXN0YXRlLWRpc2FibGVkIHVpLWljb24gdWktaWNvbi10cmlhbmdsZS0xLXMgdWktc29ydC1sdHIiPjwvc3Bhbj48L3NwYW4+PC9kaXY+PC90aD48dGggc3R5bGU9IiIgaWQ9InJvd2VkM18yMDEzLTA5LTA2IiByb2xlPSJjb2x1bW5oZWFkZXIiIGNsYXNzPSJ1aS1zdGF0ZS1kZWZhdWx0IHVpLXRoLWNvbHVtbiB1aS10aC1sdHIiPjxzcGFuIHN0eWxlPSJjdXJzb3I6IGNvbC1yZXNpemU7IiBjbGFzcz0idWktanFncmlkLXJlc2l6ZSB1aS1qcWdyaWQtcmVzaXplLWx0ciI+Jm5ic3A7PC9zcGFuPjxkaXYgY2xhc3M9InVpLWpxZ3JpZC1zb3J0YWJsZSIgaWQ9ImpxZ2hfcm93ZWQzXzIwMTMtMDktMDYiPkZyaSAwNi0wOS0yMDEzPHNwYW4gY2xhc3M9InMtaWNvIiBzdHlsZT0iZGlzcGxheTpub25lIj48c3BhbiBzb3J0PSJhc2MiIGNsYXNzPSJ1aS1ncmlkLWljby1zb3J0IHVpLWljb24tYXNjIHVpLXN0YXRlLWRpc2FibGVkIHVpLWljb24gdWktaWNvbi10cmlhbmdsZS0xLW4gdWktc29ydC1sdHIiPjwvc3Bhbj48c3BhbiBzb3J0PSJkZXNjIiBjbGFzcz0idWktZ3JpZC1pY28tc29ydCB1aS1pY29uLWRlc2MgdWktc3RhdGUtZGlzYWJsZWQgdWktaWNvbiB1aS1pY29uLXRyaWFuZ2xlLTEtcyB1aS1zb3J0LWx0ciI+PC9zcGFuPjwvc3Bhbj48L2Rpdj48L3RoPjx0aCBzdHlsZT0iIiBpZD0icm93ZWQzXzIwMTMtMDktMDciIHJvbGU9ImNvbHVtbmhlYWRlciIgY2xhc3M9InVpLXN0YXRlLWRlZmF1bHQgdWktdGgtY29sdW1uIHVpLXRoLWx0ciI+PHNwYW4gc3R5bGU9ImN1cnNvcjogY29sLXJlc2l6ZTsiIGNsYXNzPSJ1aS1qcWdyaWQtcmVzaXplIHVpLWpxZ3JpZC1yZXNpemUtbHRyIj4mbmJzcDs8L3NwYW4+PGRpdiBjbGFzcz0idWktanFncmlkLXNvcnRhYmxlIiBpZD0ianFnaF9yb3dlZDNfMjAxMy0wOS0wNyI+U2F0IDA3LTA5LTIwMTM8c3BhbiBjbGFzcz0icy1pY28iIHN0eWxlPSJkaXNwbGF5Om5vbmUiPjxzcGFuIHNvcnQ9ImFzYyIgY2xhc3M9InVpLWdyaWQtaWNvLXNvcnQgdWktaWNvbi1hc2MgdWktc3RhdGUtZGlzYWJsZWQgdWktaWNvbiB1aS1pY29uLXRyaWFuZ2xlLTEtbiB1aS1zb3J0LWx0ciI+PC9zcGFuPjxzcGFuIHNvcnQ9ImRlc2MiIGNsYXNzPSJ1aS1ncmlkLWljby1zb3J0IHVpLWljb24tZGVzYyB1aS1zdGF0ZS1kaXNhYmxlZCB1aS1pY29uIHVpLWljb24tdHJpYW5nbGUtMS1zIHVpLXNvcnQtbHRyIj48L3NwYW4+PC9zcGFuPjwvZGl2PjwvdGg+PHRoIHN0eWxlPSIiIGlkPSJyb3dlZDNfMjAxMy0wOS0wOCIgcm9sZT0iY29sdW1uaGVhZGVyIiBjbGFzcz0idWktc3RhdGUtZGVmYXVsdCB1aS10aC1jb2x1bW4gdWktdGgtbHRyIj4="*/
	 // var encodedData = window.btoa(contents);
	  // document.jzebra.append64(encodedData);
	      //alert(content)
          //$("#tam").val(encodedData);
		  
		  //applet.append64("QTU5MCwxNjAwLDIsMywxLDEsTiwialplYnJhIHNhbXBsZS5odG1sIgpBNTkwLDE1NzAsMiwzLDEsMSxOLCJUZXN0aW5nIHRoZSBwcmludDY0KCkgZnVuY3Rpb24iClAxCg==");
          applet.append("chinh")    
            // Send characters/raw commands to printer
            applet.print();
		//applet.append64(content);
		//applet.print();
         // Send characters/raw commands to printer
        // document.jzebra.print();
	  
		/* document.jzebra.appendHTML("<html><h1><font color=Red>Hello world!</font></h1>jZebra HTML Printing Demo</html>");
      	 document.jzebra.printHTML();*/
		 /* $("#content").html2canvas({ 
                canvas: hidden_screenshot,
                onrendered: function() {printBase64Image($("canvas")[0].toDataURL('image/png'));
				alert("a")
				// document.jzebra.printPS();
				}
				
           });*/
      }
	    function monitorFinding() {
			var applet = document.jzebra;
			if (applet != null) {
			   if (!applet.isDoneFinding()) {
				  window.setTimeout('monitorFinding()', 100);
			   } else {
				  var printer = applet.getPrinter();
					  alert(printer == null ? "Printer not found" : "Printer \"" + printer + "\" found");
			   }
			} else {
					alert("Applet not loaded!");
			}
      }
	  
	  
	  function callIframe(links, callback,elem) {
			window.elem=elem;			 
			$('.frame_'+elem).attr("src",links); 	
			$('.frame_'+elem).load(function() {
				callback(this);
			});
	}
	function loader(){
		/*
		  $(".frame_1000").contents().find("#grid_phong_ban").each(function() {
			 // var page_content = $(this).html().clone().find("script").remove().end().html(); 	
			$("#tam").val($(this).html());
		});*/
		temp='<div style="width: 485px;" dir="ltr" id="gbox_rowed3" class="ui-jqgrid ui-widget ui-widget-content ui-corner-all">';
		//$("#tam").val(temp+$(".frame_1000").contents().find("#gbox_rowed3").html()+'</div>');
		print(temp+$(".frame_1000").contents().find("#gbox_rowed3").html()+'</div>')
	}

	  
	</script>
   
   

</head>
<body  id="content" >
 <applet name="jzebra" code="jzebra.PrintApplet.class" archive="./jzebra.jar" width="50px" height="50px">
      <!-- Optional, searches for printer with "zebra" in the name on load -->
      <!-- Note:  It is recommended to use applet.findPrinter() instead for ajax heavy applications -->
      <param name="printer" value="Canon LBP3000 chinh">
      <!-- ALL OF THE CACHE OPTIONS HAVE BEEN REMOVED DUE TO A BUG WITH JAVA 7 UPDATE 25 -->
	  <!-- Optional, these "cache_" params enable faster loading "caching" of the applet -->
      <!-- <param name="cache_option" value="plugin"> -->
      <!-- Change "cache_archive" to point to relative URL of jzebra.jar -->
      <!-- <param name="cache_archive" value="./jzebra.jar"> -->
      <!-- Change "cache_version" to reflect current jZebra version -->
      <!-- <param name="cache_version" value="1.4.9.1"> -->
   </applet>
<iframe class="frame_1000" width="500" height="500"></iframe>
<textarea id="tam" cols="100" rows="100"></textarea>
      <a href="javascript:setHomepage()">Set homepage</a>
        <input type=button onClick="print()" value="Print"><br><br>
       </body><canvas id="hidden_screenshot" style="display:none;" />
       
       
</html>

    
  