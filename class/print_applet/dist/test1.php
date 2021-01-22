<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN" "http://www.w3.org/TR/REC-html40/strict.dtd">
<html>
<head>
    <title>CustomEvent() across Firefox add-on, sandbox -- demo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        body {
            line-height: 1.5;
            padding: 1em 2em;
        }
        #extensionStatus {
            background: red;
        }
        #extensionStatus.okay {
            background: lime;
        }
        button {
            margin: 0 2em;
            cursor: pointer;
            padding: 0.2ex 1ex;
            font-size: 1.1em;
            font-weight: bold;
        }
        a:hover, button:hover {
            color: red;
        }
    </style>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    
  
    <script type="text/javascript">
        $(document).ready(function(){
			 
			jQueryMain();
			
			 
			//$(document.elementFromPoint(2, 2)).trigger({type: 'mousedown', which: 3});
			 
		});
		
		
		 
	 
 
        function jQueryMain () {
			
            $("button").click ( function () {
				//alert("")
                var eventName, detailVal, normBtnPressed  = (this.id == "normalDataBtn");
                console.log (
                    '**The '
                    + (normBtnPressed ? "Normal" : "JSON")
                    + ' button was pressed.**'
                );

                if (normBtnPressed) {
                    eventName   = "EventWithArrayDataFromPage";
                    detailVal   = ["printer_config","Fax", 0, "1,1,1,1"];
                }
                else {
                    eventName   = "EventWithJSON_DataFromPage";
                    detailVal   = JSON.stringify ( ['horse', 'cat', 'dog', 'bison', 'bird'] );
                }

                var zEvent = new CustomEvent (eventName,
                    {"detail": detailVal }
                );
                window.dispatchEvent (zEvent)
            } );
        }

        window.addEventListener ("ImAlivefromExtension", function (zEvent) {
            var statDisplay = document.getElementById ("extensionStatus");
            statDisplay.textContent = "The test extension appears to be loaded!";
            statDisplay.className   = "okay";
        } );

        window.addEventListener ("EventWithArrayDataFromPage", function (zEvent) {
            console.log (
                "In web page (Normal) from page: ", zEvent.detail, Array.isArray (zEvent.detail)
            );
        } );

        window.addEventListener ("EventWithArrayDataToPage", function (zEvent) {
			//$.cookie("username_window", zEvent.detail[0]);
            console.log (
                "In web page (Normal) to page: ", zEvent.detail, Array.isArray (zEvent.detail)
            );
			//alert($.cookie("username_window"));
        } );
		 
		
		

        window.addEventListener ("EventWithJSON_DataToPage", function (zEvent) {
            var datArray    = JSON.parse (zEvent.detail);
            console.log (
                "In web page (JSON): ", datArray, Array.isArray (datArray)
            );
        } );
    </script>
</head>
<body>
<div id="chinh">aaa</div>
<h2>CustomEvent() across Firefox add-on, sandbox -- demo</h2>
<p> CustomEvent() currently does not serialize array data properly when sending event data
    across the XPCNativeWrapper to and from a web page and a Firefox extension.
</p>
<h3>Open the Firebug console and Firefox's error console (Control-Shift-J) to see the results.</h3>
<p> Reference <a href="http://stackoverflow.com/q/12727733/331508">
    Stack Overflow question, "Add-On is sending javascript Array as an Object"
    </a>.
</p>
<div id="extensionStatus">Test add-on not detected! <br>
    Go to <a href="https://builder.addons.mozilla.org/package/156591/latest/">https://builder.addons.mozilla.org/package/156591/latest/</a>
    and install or "Test run" it, then reload this page.
</div>
<p> Press a button to send a CustomEvent with the indicated data.
    In both cases the add-on will send back an event.  See the two consoles for results.
</p>
<p>
    <button id="normalDataBtn">Normal array data</button>
    <button id="JSON_DataBtn">JSON-encoded array data</button>
</p>
<p>WARNING:  The normal button works a little, the first time.
After that, both message-data styles get corrupted (detail is null, coming from the extension).</p>
</body>
</html>
