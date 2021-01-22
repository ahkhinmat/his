
var xhangDuoc = require('./xephangDuoc.js');

 	var io=require('socket.io').listen(4800);
	io.on('connection', function (socket) {	
	socket.on('dsxephangDuoc', function (data) {			
	socket.emit('dsxephangDuoc', xhangDuoc.loadDanhSach(data));		
	});


})




