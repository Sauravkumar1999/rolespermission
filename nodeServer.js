import express from 'express';
import http from 'http';
import { Server } from 'socket.io';
import dotenv from 'dotenv';

dotenv.config();
const app = express();
const server = http.createServer(app);

const PORT = process.env.NODE_SERVER_PORT || 3000;
const HOST = process.env.NODE_SERVER_HOST || 'localhost';
const LARAVEL_URL = process.env.APP_URL || 'http://localhost:8000';


const io = new Server(server, {
    cors: {
        origin: LARAVEL_URL,
        methods: ["GET", "POST"],
        allowedHeaders: ["Content-Type"],
        credentials: true
    }
});

const users = {};

io.on('connection', (socket) => {
    socket.on('userConnected', (auth_user) => {
        users[auth_user] = socket.id;
        io.emit('updateConnectedUsers', Object.keys(users));
    });

    socket.on('sendChat', ({ message, recipientId, messageId }) => {
        const recipientSocketId = users[recipientId];
        if (recipientSocketId) {
            io.to(recipientSocketId).emit('broadcastChat', {
                from: Object.keys(users).find(key => users[key] === socket.id),
                message, messageId
            });
        }
    });

    socket.on('messageSeen', ({ messageId, from }) => {
        const senderSocketId = users[from];
        if (senderSocketId) {
            io.to(senderSocketId).emit('messageSeenStatus', { messageId });
        }
    });

    socket.on('typing', ({ to, isTyping }) => {
        const recipientSocketId = users[to];
        if (recipientSocketId) {
            io.to(recipientSocketId).emit('typing', {
                from: Object.keys(users).find(key => users[key] === socket.id),
                isTyping
            });
        }
    });

    socket.on('disconnect', () => {
        const disconnectedUser = Object.keys(users).find(userId => users[userId] === socket.id);
        if (disconnectedUser) {
            delete users[disconnectedUser];
            io.emit('updateConnectedUsers', Object.keys(users));
        }
    });
});

server.listen(PORT, HOST, () => console.log(`Server running on port => http://${HOST}:${PORT}`));
