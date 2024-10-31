import express from 'express';
import http from 'http';
import { Server } from 'socket.io';
import dotenv from 'dotenv';
import axios from 'axios';

dotenv.config();
const app = express();
const server = http.createServer(app);

const PORT = process.env.NODE_SERVER_PORT || 3000;
const HOST = process.env.NODE_SERVER_HOST || 'localhost';
const LARAVEL_URL = process.env.APP_URL || 'http://localhost:8000';
const LARAVEL_API_URL = `${LARAVEL_URL}/api`;


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
    socket.on('userConnected', ({ authUserId, authToken }) => {
        users[authUserId] = { socketId: socket.id, authToken };
        io.emit('updateConnectedUsers', Object.keys(users));
    });

    socket.on('sendChat', async ({ message, recipientId, messageId }) => {
        const senderId = Object.keys(users).find(key => users[key].socketId === socket.id);
        const senderToken = users[senderId]?.authToken;
        io.to(recipientSocketId).emit('broadcastChat', {
            from: senderId,
            message,
            messageId
        });
        // if (senderToken) {
        //     try {
        //         await axios.post(`${LARAVEL_API_URL}/chat/store`, {
        //             sender_id: senderId,
        //             recipient_id: recipientId,
        //             message,
        //             message_id: messageId
        //         }, {
        //             headers: {
        //                 'Authorization': `Bearer ${senderToken}`
        //             }
        //         });
        //         const recipientSocketId = users[recipientId]?.socketId;
        //         if (recipientSocketId) {
        //             io.to(recipientSocketId).emit('broadcastChat', {
        //                 from: senderId,
        //                 message,
        //                 messageId
        //             });
        //         }
        //     } catch (error) {
        //         console.error('Failed to store message:', error);
        //     }
        // } else {
        //     console.error('Sender authentication token missing');
        // }
    });

    socket.on('messageSeen', ({ messageId, to, status }) => {
        const senderSocketId = users[to].socketId;
        if (senderSocketId) {
            io.to(senderSocketId).emit('messageSeenStatus', { messageId, status });
        }
    });

    socket.on('messageSeen', async ({ messageId, to, status }) => {
        const senderId = Object.keys(users).find(key => users[key].socketId === socket.id);
        const senderToken = users[senderId]?.authToken;
        io.to(senderSocketId).emit('messageSeenStatus', { messageId, status });

        // if (senderToken) {
        //     try {
        //         await axios.post(`${LARAVEL_API_URL}/chat/mark/${messageId}/seen`, {
        //             message_id: messageId,
        //             status: status
        //         }, {
        //             headers: { 'Authorization': `Bearer ${senderToken}` }
        //         });
        //         const senderSocketId = users[to]?.socketId;
        //         if (senderSocketId) {
        //             io.to(senderSocketId).emit('messageSeenStatus', { messageId, status });
        //         }
        //     } catch (error) {
        //         console.error('Failed to update message status:', error);
        //     }
        // } else {
        //     console.error('Sender authentication token missing');
        // }
    });

    socket.on('typing', ({ to, isTyping }) => {
        const recipientSocketId = users[to].socketId;
        if (recipientSocketId) {
            io.to(recipientSocketId).emit('typing', { from: Object.keys(users).find(key => users[key].socketId === socket.id), isTyping });
        }
    });

    socket.on('disconnect', () => {
        const disconnectedUser = Object.keys(users).find(userId => users[userId].socketId === socket.id);

        if (disconnectedUser) {
            delete users[disconnectedUser];
            io.emit('updateConnectedUsers', Object.keys(users));
        }
    });
});

server.listen(PORT, HOST, () => console.log(`Server running on port => http://${HOST}:${PORT}`));
