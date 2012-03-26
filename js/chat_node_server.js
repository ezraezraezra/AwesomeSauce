
var io = require('socket.io').listen(8010);

io.sockets.on('connection', function(socket) {
	socket.emit('start', {message: "connected to server"});
	
	socket.on('message', function(data) {
		socket.emit('message_all', { message : data });
		socket.broadcast.emit('message_all', { message : data });
	});
});
