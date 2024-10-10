$(() => {
    const socket = io('http://localhost:3000');

    socket.on('connect', () => {
        const auth_user = getAuthId();
        socket.emit('userConnected', auth_user);
    });

    socket.on('updateConnectedUsers', (connectedUsers) => {
        console.log('Connected users:', connectedUsers);
        // updateConnectedUsersView(connectedUsers);
    });

    socket.on('broadcastChat', ({ from, message }) => {
        console.log('Message from', from, ':', message);
        if (from == getSelectedRecipientId()) {
            addToView(socket, from, message, false, 'seen');
        }
    });

    socket.on('messageStatus', ({ messageId, status }) => {
        updateMessageStatus(messageId, status); // Update message status in the view
    });

    $('#chatinput-form').submit(function (e) {
        e.preventDefault();
        let inputField = $('input[id="chat-input"]');
        const recipientId = getSelectedRecipientId();

        if (inputField.val() !== '' && recipientId) {
            const messageText = inputField.val();
            sendMessage(socket, messageText, recipientId);
            addToView(socket, getAuthId(), messageText, true, 'sent');
        }
        inputField.val('');
    });
});

function sendMessage(socket, messageText, recipientId) {
    socket.emit('sendChat', { message: messageText, recipientId });
}

function markMessageAsSeen(socket, messageId) {
    const senderId = getAuthId();
    socket.emit('messageSeen', { messageId, senderId });
}

function updateMessageStatus(messageId, status) {
    const messageElement = $(`#message-${messageId}`);
    if (messageElement.length > 0) {
        const iconClass = getIconClass(status);
        const iconColor = getIconColor(status);
        messageElement.find('.check-message-icon i').attr('class', iconClass+' '+iconColor).removeClass('ri-check-line').addClass(iconColor);
    }
}

const addToView = (socket, from, messageText, isSentByCurrentUser = false, status = 'sent') => {
    let list = $('#users-conversation');
    let timestamp = new Date().toLocaleTimeString();
    const messageId = generateUniqueId(); // Generate unique ID for the message
    const messageClass = isSentByCurrentUser ? 'right' : 'left';

    const iconClass = getIconClass(status);
    const iconColor = getIconColor(status);

    let messageHtml = `
        <li class="chat-list ${messageClass}" id="message-${messageId}">
            <div class="conversation-list">
                <div class="user-chat-content">
                    <div class="ctext-wrap">
                        <div class="ctext-wrap-content">
                            <p class="mb-0 ctext-content">${messageText}</p>
                        </div>
                    </div>
                    <div class="conversation-name">
                        <small class="text-muted time">${timestamp}</small>
                        <span class="${iconColor} check-message-icon">
                            <i class="${iconClass} ${iconColor}"></i>
                        </span>
                    </div>
                </div>
            </div>
        </li>`;

    list.append(messageHtml);

    let scrollEl = new SimpleBar(document.getElementById("chat-conversation"));
    scrollEl.getScrollElement().scrollTop = document.getElementById("users-conversation").scrollHeight;

    if (!isSentByCurrentUser) {
        markMessageAsSeen(socket, messageId);
    }
};

function getSelectedRecipientId() {
    return $('.chat-leftsidebar #chats .bg-success-subtle').data('user-id');
}

function getAuthId() {
    return $('input[name="auth_user_id"]').val();
}

function getIconClass(status) {
    return status === 'seen' ? 'ri-check-double-line' : 'ri-check-line';
}

function getIconColor(status) {
    return status === 'seen' ? 'text-primary' : 'text-secondary';
}

function generateUniqueId() {
    return 'msg-' + Math.random().toString(36).substr(2, 9);
}
