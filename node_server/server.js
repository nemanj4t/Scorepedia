var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);

// Kreira se redis klijent koji se subscribuje
// na dati kanal
var liveMatchesSub = redis.createClient();
liveMatchesSub.subscribe('liveMatches');
liveMatchesSub.on('message', (channel, message) => {
    console.log("Dodat podatak:" + message + " u kanal:" + channel);
    io.sockets.emit(channel, message);
});

io.on('connection', function(socket) {
    console.log("Vreme:" + new Date().toLocaleTimeString() + 
    ".Korisnik:" + socket.id + " je konektovan.");

    // Kada se diskonektuje
    socket.on('disconnect', () => {
        console.log("Vreme:" + new Date().toLocaleTimeString() + 
        ".Korisnik:" + socket.id + " je diskonektovan.");
    });
});
