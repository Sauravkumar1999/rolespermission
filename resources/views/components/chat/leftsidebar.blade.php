<div class="chat-leftsidebar">
    <div class="px-4 pt-4 mb-3">
        <div class="d-flex align-items-start">
            <div class="flex-grow-1">
                <h5 class="mb-4">Chats</h5>
            </div>
            <div class="flex-shrink-0">
                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" aria-label="Hide chat List"
                    data-bs-original-title="Hide chat List">
                    <button type="button" class="btn btn-soft-success btn-sm material-shadow-none chat-humburger-button d-lg-none">
                        <i class="ri-arrow-left-fill"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="search-box">
            <input type="text" class="form-control bg-light border-light" placeholder="Search here...">
            <i class="ri-search-2-line search-icon"></i>
            <input type="hidden" name="auth_user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="node_server_url" value="{{ env('NODE_SERVER_URL') }}">
            <input type="hidden" name="auth_token" value="{{ session('_token') }}">
            <input type="hidden" name="user_info" value="{{ json_encode($user) }}">
        </div>
    </div>

    <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#chats" role="tab">Chats</a>
        </li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#contacts" role="tab">Contacts</a></li>
    </ul>

    <div class="tab-content text-muted">
        <div class="tab-pane active" id="chats" role="tabpanel">
            <div class="chat-room-list" data-simplebar>
                <ul class="list-group" id="chat-list">
                    @foreach ($chats as $li)
                        <li class="list-group-item list-group-item-action @if ($li->inbox_user) bg-success-subtle @endif"
                            data-user-id="{{ $li->id }}" data-dm-id="{{ $li->dm }}">
                            <a class="d-flex align-items-center" href="{{ route('chat.inbox', $li) }}">
                                <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center">
                                    <img src="{{ $li->profile }}" class="rounded-2 avatar-sm" alt=""
                                        onerror="this.onerror=null; this.src='{{ asset('assets/images/error400-cover.png') }}';">
                                    <span class=""></span>
                                </div>
                                <div class="flex-shrink-0 ms-3 chat-user-text">
                                    <h6 class="fs-14 mb-0">{{ $li->name }}</h6>
                                    <small class="text-muted">8 days Ago</small>
                                </div>
                                <div class="flex-shrink-0 ms-auto chat-user-msg">
                                    <span class="text-success"></span>
                                </div>
                            </a>
                        </li>
                    @endforeach
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
                                    <img src="{{ $user->profile }}" class="rounded-2 avatar-sm" alt=""
                                        onerror="this.onerror=null; this.src='{{ asset('assets/images/error400-cover.png') }}';">
                                    <span class=""></span>
                                </div>
                                <div class="flex-shrink-0 ms-3 chat-user-text">
                                    <h6 class="fs-14 mb-0">{{ $user->name }}</h6>
                                    <small class="text-muted">8 days Ago</small>
                                </div>
                                <div class="flex-shrink-0 ms-auto chat-user-msg">
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
