@extends('layouts.dashboard')
@push('header')
    <title>Chat</title>
    <style>
        .list-group-item:first-child {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
        }

        .chat-conversation .right .conversation-list .ctext-wrap .ctext-wrap-content {
            background-color: rgb(30 131 25 / 15%);
            color: #474848;
        }

        .chat-conversation .conversation-list .ctext-wrap-content {
            padding: 4px 10px;
            background-color: var(--vz-light);
            position: relative;
            border-radius: 3px;
            -webkit-box-shadow: 0 5px 10px rgba(30, 32, 37, .12);
            box-shadow: 0 5px 10px rgba(30, 32, 37, .12);
        }

        .chat-conversation .conversation-list .ctext-wrap {
            margin-bottom: 0px;
        }

        small.time {
            font-size: 8px;
        }
    </style>
@endpush
@section('main-section')
    <div class="container-fluid">
        <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
            <x-chat.leftsidebar :user="$user ?? null" />
            <!-- end chat leftsidebar -->
            <!-- Start User chat -->
            @if (isset($user))
                <div class="user-chat w-100 overflow-hidden">
                    <div class="chat-content d-lg-flex">
                        <!-- start chat conversation section -->
                        <div class="w-100 overflow-hidden position-relative">
                            <!-- conversation user -->
                            <div class="position-relative">
                                <div class="position-relative" id="users-chat">
                                    <x-chat.user-chat-top-bar :user="$user" />
                                    <!-- end chat user head -->
                                    <div class="chat-conversation p-3 p-lg-4 " id="chat-conversation" data-simplebar>
                                        <div id="elmLoader">
                                        </div>
                                        <ul class="list-unstyled chat-conversation-list" id="users-conversation"></ul>
                                    </div>

                                    <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show"
                                        id="copyClipBoard" role="alert">
                                        Message copied
                                    </div>
                                </div>

                                <x-chat.chat-input-section/>

                                <div class="replyCard">
                                    <div class="card mb-0">
                                        <div class="card-body py-3">
                                            <div class="replymessage-block mb-0 d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <h5 class="conversation-name"></h5>
                                                    <p class="mb-0"></p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <button type="button" id="close_toggle"
                                                        class="btn btn-sm btn-link mt-n2 me-n3 fs-18">
                                                        <i class="bx bx-x align-middle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('footer')
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
    <script src="{{ asset('/assets/js/custom/chat.js') }}"></script>
@endpush
