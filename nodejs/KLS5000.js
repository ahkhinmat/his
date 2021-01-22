

	var xhangDuoc = require('./xephangDuocFull.js');
	var xhangKhamBenh = require('./xhangKhamBenhFull.js');
 	var io=require('socket.io').listen(5000);
	io.on('connection', function (socket) {	

	socket.on('dsxephangKhamBenh', function (data) {			
	socket.emit('dsxephangKhamBenh', xhangKhamBenh.loadDanhSach(data));		
	});


	socket.on('dsxephangDuoc', function (data) {
	//ssconsole.log('DUOC 5000 '+' on '+new Date());			
	socket.emit('dsxephangDuoc', xhangDuoc.loadDanhSach(data));		
	});

	/*socket.on('reloadclient', function (data) {
		//sconsole.log('ReloadClient_4000: '+data.message+ ' ip_reload'+data.ip_reLoad +' on '+new Date());

        io.sockets.emit('reloadclient', {
        	ipMust_ReLoad:data.ip_reLoad        	

        });
    });*/



})




