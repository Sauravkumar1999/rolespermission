$(() => {
    const socket = io(getNodeServerURL());
    const authUserId = getAuthId();
    const recipientUserId = getSelectedRecipientId();
    const recipientUserInfo = getRecipientInfo();

    socket.on('connect', () => {
        socket.emit('userConnected', { authUserId: authUserId, authToken: getAuthToken() });

        if (recipientUserId != undefined) {
            notifyMessage("You are connected with ", recipientUserInfo.name, 'success')
            fetchMessages();
        } else {
            notifyMessage("You are connected to the chat server")
        }
    });

    socket.on('updateConnectedUsers', (connectedUsers) => {
        updateUserStatus($('#chat-list li[data-user-id]'), connectedUsers);
        updateUserStatus($('#contact-list li[data-user-id]'), connectedUsers);
    });

    socket.on('typing', ({ from, isTyping }) => {
        if (from == recipientUserId) {
            showTypingStatus(isTyping);
        }
    });

    socket.on('broadcastChat', ({ from, message, messageId }) => {
        if (from == recipientUserId) {
            addToView(message, false, 'delivered');
            markMessageRevived(socket, messageId, recipientUserId);
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

    socket.on('messageSeenStatus', ({ messageId, status }) => {
        updateMessageStatus(messageId, status)
    });

    $('#chatinput-form').submit(e => {
        e.preventDefault();
        const inputField = $('#chat-input');
        const messageText = inputField.val();
        const recipientId = getSelectedRecipientId();

        if (messageText && recipientId) {
            const messageId = generateUniqueId();
            sendMessage(socket, messageText, recipientId, messageId);
            addToView(messageText, true, 'sent', messageId);
            inputField.val('');
        }
    });

    $('#chatinput-form #chat-input').on('input', () => {
        if (recipientUserId) socket.emit('typing', { to: recipientUserId, isTyping: true });
        debounceStopTyping(socket, recipientUserId);
    });
});

let typingTimeout;

function sendMessage(socket, messageText, recipientId, messageId) {
    socket.emit('sendChat', { message: messageText, recipientId, messageId, directMessageId: getdmId() });
}

function addToView(messageText, isSentByCurrentUser = false, status = 'sent', messageId = generateUniqueId()) {
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

    $('#users-conversation').append(messageHtml) && scrollToBottom();
    return messageId;
}

function markMessageRevived(socket, messageId, to, status = 'seen') {
    socket.emit('messageSeen', { messageId, to, status });
}

function updateMessageStatus(messageId, status) {
    const icon = document.querySelector(`#users-conversation #message-${messageId} .conversation-name span i`);
    if (icon) icon.className = `${getIconClass(status)} ${getIconColor(status)}`;
}

function updateUserStatus(elements, connectedUsers) {
    let isConnected = getSelectedRecipientId() ? connectedUsers.includes(getSelectedRecipientId().toString()) : false;
    let inboxHeaderImg = $('.user-chat-topbar .chat-user-img').next().find('p')

    if (inboxHeaderImg) {
        toggleClass($('.user-chat-topbar .chat-user-img span'), 'user-status', isConnected);
        isConnected ? inboxHeaderImg.html('<span>Online</span>') : inboxHeaderImg.html('<span>Offline</span>');
    }

    elements.each(function () {
        const userId = $(this).data('user-id');
        const statusSpan = $(this).find('.chat-user-img span');
        const inboxHeaderImg = $(this).find('.chat-user-text small');
        isConnected = connectedUsers.includes(userId.toString());

        isConnected ? inboxHeaderImg.html('<span>Online</span>') : inboxHeaderImg.html('<span>Offline</span>');

        toggleClass(statusSpan, 'user-status', isConnected);
    });
}

function debounceStopTyping(socket, recipientId) {
    clearTimeout(typingTimeout);
    typingTimeout = setTimeout(() => socket.emit('typing', { to: recipientId, isTyping: false }), 1000);
}
function toggleClass(element, className, condition) {
    condition ? element.addClass(className) : element.removeClass(className);
}

function scrollToBottom() {
    new SimpleBar(document.getElementById('chat-conversation')).getScrollElement().scrollTop =
        document.getElementById("users-conversation").scrollHeight;
}

function getRecipientInfo() {
    let info = $('input[name="user_info"]').val();
    return JSON.parse(info);
}

function getSelectedRecipientId() {
    return getRecipientInfo()?.id;
}

function getdmId() {
    return $('.chat-leftsidebar #chat-list li.bg-success-subtle').data('dm-id');
}

function getdmId() {
    return $('.chat-leftsidebar #chat-list li.bg-success-subtle').data('dm-id');
}

function getAuthId() {
    return $('input[name="auth_user_id"]').val();
}
function getAuthToken() {
    return $('input[name="auth_token"]').val();
}
function getNodeServerURL() {
    return location.protocol + "//" + location.hostname + ":3000";
}
function getLaravelAppURL() {
    return location.origin;
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

async function fetchMessages() {
    try {
        const dmId = getdmId();
        const authId = getAuthId();
        fetch(`${getLaravelAppURL()}/api/chat/get/${dmId}/${authId}`)
            .then(data => data.json())
            .then(response => {
                let messages = response.data.data
                if (response.success) {
                    messages.forEach(msg => {
                        let isSendedByMe = msg.sender_id == authId;
                        addToView(msg.message, isSendedByMe, msg.status, msg.message_id);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                swal("Error", "There was an issue processing the request.", "error");
            });
        // scrollToBottom();
    } catch (error) {
        console.error("Failed to fetch messages", error);
        swal("Error", "There was an issue Getting messages", "error");
    }
}

function notifyMessage(message, from, bg = "info") {
    Toastify({
        text: `${message} ${from ? 'from ' + from : ''}`,
        gravity: "top",
        position: "right",
        duration: 3000,
        close: true,
        className: "bg-" + bg
    }).showToast();
}
