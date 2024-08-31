$(() => {
    const socket = io('http://localhost:3000');

    $('#chatinput-form').submit(function (e) {
        e.preventDefault();
        let inputFiled = $('input[id="chat-input"]');
        if (inputFiled.val() != null && inputFiled.val() != '') {
            sendMessage(inputFiled.val());
        }
        inputFiled.val('');
    });
    socket.on('connect', () => {
        console.log('Connected to the server');
    });
    socket.on('broadcastChat', (message) => {
        addToView(message);
    });

    function sendMessage(message) {
        socket.emit('sendChat', message);
    }

    const addToView = (data) => {
        let list = $('#users-conversation');
        let dropdown = `<div class="dropdown align-self-start message-box-drop">
                            <a class="dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item delete-item" href="#">
                                    <i
                                        class="ri-delete-bin-5-line me-2 text-muted align-bottom"></i>Delete
                                </a>
                                <a class="dropdown-item delete-item" href="#">
                                    <i
                                        class="ri-delete-bin-5-line me-2 text-muted align-bottom"></i>Edit
                                </a>
                            </div>
                        </div>`;
        let meaasge = `<li class="chat-list right" id="chat-list-4">
                            <div class="conversation-list">
                                <div class="user-chat-content">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <p class="mb-0 ctext-content">${data} </p>
                                        </div>
                                    </div>
                                    <div class="conversation-name">
                                        <small class="text-muted time">12:06 pm</small>
                                        <span class="text-success check-message-icon"><i class="ri-check-double-line"></i></span>
                                    </div>
                                </div>
                            </div>
                        </li>`;
        list.append(meaasge);
        var scrollEl = new SimpleBar(document.getElementById("chat-conversation"));
        scrollEl.getScrollElement().scrollTop = document.getElementById("users-conversation").scrollHeight;
    }
})

