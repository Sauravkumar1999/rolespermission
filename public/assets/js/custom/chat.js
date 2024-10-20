$(() => {
    const socket = io(getNodeServerURL());
    const authUserId = getAuthId();

    socket.on('connect', () => {
        socket.emit('userConnected', authUserId)
        Toastify({
            text: "You are connected",
            gravity: "top",
            position: "right",
            duration: 3000,
            close: true,
            className: "bg-success"
        }).showToast();
    });

    socket.on('updateConnectedUsers', updateConnectedUsersView);

    socket.on('typing', ({ from, isTyping }) => {
        if (from == getSelectedRecipientId()) {
            showTypingStatus(isTyping);
        }
    });
    socket.on('broadcastChat', ({ from, message, messageId }) => {
        if (from == getSelectedRecipientId()) {
            addToView(socket, from, message, false, 'delivered');
            markMessageAsSeen(socket, messageId, from);
            return;
        }
        Toastify({
            text: message + "from" + from,
            gravity: "top",
            position: "right",
            duration: 3000,
            close: true,
            className: "bg-success"
        }).showToast();
    });

    socket.on('messageSeenStatus', ({ messageId }) => updateMessageStatus(messageId, 'seen'));

    $('#chatinput-form').submit(e => {
        e.preventDefault();
        const inputField = $('#chat-input');
        const messageText = inputField.val();
        const recipientId = getSelectedRecipientId();

        if (messageText && recipientId) {
            const messageId = generateUniqueId();
            sendMessage(socket, messageText, recipientId, messageId);
            addToView(socket, authUserId, messageText, true, 'sent', messageId);
            inputField.val('');
        }
    });

    $('#chatinput-form #chat-input').on('input', () => {
        const recipientId = getSelectedRecipientId();
        if (recipientId) socket.emit('typing', { to: recipientId, isTyping: true });
        debounceStopTyping(socket, recipientId);
    });
});

let typingTimeout;

function sendMessage(socket, messageText, recipientId, messageId) {
    socket.emit('sendChat', { message: messageText, recipientId, messageId });
}

function markMessageAsSeen(socket, messageId, from) {
    socket.emit('messageSeen', { messageId, from });
}

function updateConnectedUsersView(connectedUsers) {
    updateUserStatus($('#chat-list li[data-user-id]'), connectedUsers, true);
    updateUserStatus($('#contact-list li[data-user-id]'), connectedUsers, false);
}

function addToView(socket, from, messageText, isSentByCurrentUser = false, status = 'sent', messageId = generateUniqueId()) {
    const messageClass = isSentByCurrentUser ? 'right' : 'left';
    const timestamp = new Date().toLocaleTimeString();

    const messageHtml = `
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
                        <span class="${getIconColor(status)} check-message-icon">
                            <i class="${getIconClass(status)} ${getIconColor(status)}"></i>
                        </span>
                    </div>
                </div>
            </div>
        </li>`;

    $('#users-conversation').append(messageHtml) && scrollToBottom('chat-conversation');
    return messageId;
}

function updateMessageStatus(messageId, status) {
    const icon = $(`#message-${messageId} .check-message-icon i`);
    icon.attr('class', `${getIconClass(status)} ${getIconColor(status)}`);
}

function updateUserStatus(elements, connectedUsers, isChatList) {
    elements.each(function () {
        const userId = $(this).data('user-id');
        const statusSpan = $(this).find('.chat-user-img span');
        const isConnected = connectedUsers.includes(userId.toString());

        toggleClass(statusSpan, 'user-status', isConnected);

        if (isChatList && $(this).hasClass('bg-success-subtle')) {
            toggleClass($('.user-chat-topbar .chat-user-img span'), 'user-status', isConnected);
            toggleClass($('.user-chat-topbar .chat-user-img').next().find('span'), 'd-none', isConnected);
        }
    });
}

function debounceStopTyping(socket, recipientId) {
    clearTimeout(typingTimeout);
    typingTimeout = setTimeout(() => socket.emit('typing', { to: recipientId, isTyping: false }), 1000);
}
function toggleClass(element, className, condition) {
    condition ? element.addClass(className) : element.removeClass(className);
}

function scrollToBottom(elementId) {
    new SimpleBar(document.getElementById(elementId)).getScrollElement().scrollTop =
        document.getElementById("users-conversation").scrollHeight;
}

function getSelectedRecipientId() {
    return $('.chat-leftsidebar #chats .bg-success-subtle').data('user-id');
}

function getAuthId() {
    return $('input[name="auth_user_id"]').val();
}
function getNodeServerURL() {
    return $('input[name="node_server_url"]').val();
}

function showTypingStatus(isTyping) {
    let element = $('.user-chat-topbar .chat-user-img').next().find('.userStatus')
    if (element) {
        isTyping ? element.html('<small class="text-success">Typing...</small>') : element.html('<small>Online</small>');
    }
}

function getIconClass(status) {
    return status === 'seen' ? 'ri-check-double-line' : 'ri-check-line';
}

function getIconColor(status) {
    return status === 'seen' ? 'text-success' : 'text-secondary';
}

function generateUniqueId() {
    return 'msg-' + Math.random().toString(36).substr(2, 9);
}
