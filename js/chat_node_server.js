
var io = require('socket.io').listen(8010);

io.sockets.on('connection', function(socket) {
	socket.emit('start', {message: "connected to server"});
	
	socket.on('message', function(data) {
		socket.emit(data['wid'], { message : data });
		socket.broadcast.emit(data['wid'], { message : data });
	});
});
