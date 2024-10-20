<div class="chat-leftsidebar">
    <div class="px-4 pt-4 mb-3">
        <div class="d-flex align-items-start">
            <div class="flex-grow-1">
                <h5 class="mb-4">Chats</h5>
            </div>
            <div class="flex-shrink-0">
                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" aria-label="Add Contact" data-bs-original-title="Add Contact">
                    <button type="button" class="btn btn-soft-success btn-sm material-shadow-none"><i class="ri-add-line align-bottom"></i></button>
                </div>
            </div>
        </div>
        <div class="search-box">
            <input type="text" class="form-control bg-light border-light" placeholder="Search here...">
            <i class="ri-search-2-line search-icon"></i>
            <input type="hidden" name="auth_user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="node_server_url" value="{{ env('NODE_SERVER_URL') }}">
        </div>
    </div>

    <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#chats" role="tab">Chats</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#contacts" role="tab">Contacts</a></li>
    </ul>

    <div class="tab-content text-muted">
        <div class="tab-pane active" id="chats" role="tabpanel">
            <div class="chat-room-list" data-simplebar>
                <ul class="list-group" id="chat-list">
                    @if ($user != null)
                        <li class="list-group-item list-group-item-action bg-success-subtle"
                            data-user-id="{{ $user->id }}">
                            <a class="d-flex align-items-center" href="{{ route('chat.inbox', $user) }}">
                                <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center">
                                    <img src="{{ $user->profile }}" class="rounded-2 avatar-sm" alt="" onerror="this.onerror=null; this.src='{{ asset('assets/images/error400-cover.png') }}';">
                                    <span class=""></span>
                                </div>
                                <div class="flex-shrink-0 ms-3">
                                    <h6 class="fs-14 mb-0">{{ $user->name }}</h6>
                                    <small class="text-muted">8 days Ago</small>
                                </div>
                                <div class="flex-shrink-0 ms-auto">
                                    <span class="text-success"></span>
                                </div>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="tab-pane" id="contacts" role="tabpanel">
            <div class="chat-room-list" data-simplebar>
                <ul class="list-group" id="contact-list">
                    @foreach ($users as $user)
                        <li class="list-group-item list-group-item-action" data-user-id="{{ $user->id }}">
                            <a class="d-flex align-items-center" href="{{ route('chat.inbox', $user) }}">
                                <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center">
                                    <img src="{{ $user->profile }}" class="rounded-2 avatar-sm" alt="" onerror="this.onerror=null; this.src='{{ asset('assets/images/error400-cover.png') }}';">
                                    <span class=""></span>
                                </div>
                                <div class="flex-shrink-0 ms-3">
                                    <h6 class="fs-14 mb-0">{{ $user->name }}</h6>
                                    <small class="text-muted">8 days Ago</small>
                                </div>
                                <div class="flex-shrink-0 ms-auto">
                                    <span class="text-success"></span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
