import express from 'express';
import http from 'http';
import { Server } from 'socket.io';
import cors from 'cors';

const app = express();

app.use(cors({
    origin: 'http://localhost:3000',
    methods: ['GET', 'POST'],
    allowedHeaders: ['Content-Type']
}));

const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: "http://127.0.0.1:8000",
        methods: ["GET", "POST"],
        allowedHeaders: ["Content-Type"],
        credentials: true // allow credentials such as cookies or authentication
    }
});

const users = {}; // Map userId -> socketId

io.on('connection', (socket) => {
    socket.on('userConnected', (auth_user) => {
        users[auth_user] = socket.id;
        io.emit('updateConnectedUsers', Object.keys(users));
    });

    socket.on('sendChat', ({ message, recipientId }) => {
        const recipientSocketId = users[recipientId];
        if (recipientSocketId) {
            io.to(recipientSocketId).emit('broadcastChat', {
                from: Object.keys(users).find(key => users[key] === socket.id),
                message
            });

            socket.emit('messageStatus', { messageId: message.id, status: 'delivered' });
        } else {
            console.log(`User ${recipientId} is not connected.`);
        }
    });

    socket.on('messageSeen', ({ messageId, senderId }) => {
        const senderSocketId = users[senderId];
        if (senderSocketId) {
            io.to(senderSocketId).emit('messageStatus', { messageId, status: 'seen' });
        }
    });

    socket.on('disconnect', () => {
        const disconnectedUser = Object.keys(users).find(userId => users[userId] === socket.id);
        if (disconnectedUser) {
            delete users[disconnectedUser];
            console.log(`User disconnected: ${disconnectedUser}`);
            io.emit('updateConnectedUsers', Object.keys(users));
        }
    });
});

const PORT = 3000;
server.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
