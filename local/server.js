var fs = require('fs');
var options = {
    key: fs.readFileSync("ctogo.key"),
    cert: fs.readFileSync("ctogo.crt")
};

var app   = require('express')();
var http  = require('https').Server(options,app);

var io    = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

redis.psubscribe('*', function(err, count) {});

redis.on('pmessage', function(subscribed, channel, message) {
    console.log(channel);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

http.listen(3000, function () {
    console.log('Listening on Port 3000');
});

redis.on("error", function (err) {
    console.log(err);
});