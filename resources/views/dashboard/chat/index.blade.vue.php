@extends('layouts.dashboard')
@push('header')
    <title>Chat</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
@endpush
@section('main-section')
    <div class="container-fluid">
        <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1" id="app">
            <!-- chat leftsidebar start -->
            <div class="chat-leftsidebar">
                <!-- chat leftsidebar header -->
                <div class="px-4 pt-4 mb-2">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="mb-4">Live Users : <span class="align-bottom" id="online-users-count"> 0</span></h5>
                        </div>
                    </div>
                </div>
                <!-- chat leftsidebar body -->
                <ul class="nav nav-tabs nav-tabs-custom nav-primary nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#chats" role="tab">
                            <i class="ri-message-2-line fs-20 align-middle me-1"></i>
                            <span class="fs-15">Chats</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#contacts" role="tab">
                            <i class="ri-contacts-book-line fs-20 align-middle me-1"></i>
                            <span class="fs-15">Contacts</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="chats" role="tabpanel">
                        <div class="chat-room-list">
                            <ul class="list-group" id="chat-list">
                                <li class="list-group-item list-group-item-action" data-user-id>
                                    <a class="d-flex align-items-center" href="#">
                                        <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center">
                                            <img src="/assets/images/users/avatar-2.jpg" class="rounded-2 avatar-xs"
                                                alt="">
                                            <span class="user-status d-none"></span>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <h6 class="fs-14 mb-0">Alisia parkor</h6>
                                            <small class="text-muted d-none">8 days Ago</small>
                                        </div>
                                        <div class="flex-shrink-0 ms-auto">
                                            <span class="text-success"></span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" id="contacts" role="tabpanel">
                        <div class="chat-room-list">
                            <div class="sort-contact" data-simplebar>
                                <div data-simplebar style="max-height: 445px;">
                                    <ul class="list-group" id="contact-list">
                                        <contact-li v-for="user in users" :key="user.id"
                                            :user="user"></contact-li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- chat leftsidebar end -->
            <!-- Start User chat -->
            <div class="user-chat w-100 overflow-hidden">
                <div class="chat-content d-lg-flex">
                    <div class="w-100 overflow-hidden position-relative">
                        <div class="position-relative">
                            <div class="position-relative" id="users-chat">
                                <!-- start chat user head -->
                                <div class="p-3 user-chat-topbar">
                                    <div class="row align-items-center">
                                        <div class="col-sm-4 col-8">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                            <img src="/assets/images/users/avatar-2.jpg"
                                                                class="rounded-circle avatar-xs" alt="">
                                                            <span class="user-status"></span>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate mb-0 fs-16"><a
                                                                    class="text-reset username" data-bs-toggle="offcanvas"
                                                                    href="#userProfileCanvasExample"
                                                                    aria-controls="userProfileCanvasExample">Lisa
                                                                    Parker</a>
                                                            </h5>
                                                            <p class="text-truncate text-muted fs-14 mb-0 userStatus">
                                                                <small>Online</small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8 col-4">
                                            <ul class="list-inline user-chat-nav text-end mb-0">
                                                <li class="list-inline-item m-0">
                                                    <div class="dropdown">
                                                        <button class="btn btn-ghost-secondary btn-icon" type="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i data-feather="search" class="icon-sm"></i>
                                                        </button>
                                                        <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                                                            <div class="p-2">
                                                                <div class="search-box">
                                                                    <input type="text"
                                                                        class="form-control bg-light border-light"
                                                                        placeholder="Search here..."
                                                                        onkeyup="searchMessages()" id="searchMessage">
                                                                    <i class="ri-search-2-line search-icon"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-inline-item d-none d-lg-inline-block m-0">
                                                    <button type="button" class="btn btn-ghost-secondary btn-icon"
                                                        data-bs-toggle="offcanvas"
                                                        data-bs-target="#userProfileCanvasExample"
                                                        aria-controls="userProfileCanvasExample">
                                                        <i data-feather="info" class="icon-sm"></i>
                                                    </button>
                                                </li>
                                                <li class="list-inline-item m-0">
                                                    <div class="dropdown">
                                                        <button class="btn btn-ghost-secondary btn-icon" type="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i data-feather="more-vertical" class="icon-sm"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item d-block d-lg-none user-profile-show"
                                                                href="#"><i
                                                                    class="ri-user-2-fill align-bottom text-muted me-2"></i>
                                                                View Profile</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-inbox-archive-line align-bottom text-muted me-2"></i>
                                                                Archive</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-mic-off-line align-bottom text-muted me-2"></i>
                                                                Muted</a>
                                                            <a class="dropdown-item" href="#"><i
                                                                    class="ri-delete-bin-5-line align-bottom text-muted me-2"></i>
                                                                Delete</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- end chat user head -->
                                <!-- start chat-conversation-list -->
                                <div class="chat-conversation p-3 p-lg-4" data-simplebar style="max-height: 445px;"
                                    id="chat-conversation">
                                    <ul class="list-unstyled chat-conversation-list" id="users-conversation">
                                        {{-- <li class="chat-list right">
                                            <div class="conversation-list">
                                                <div class="user-chat-content">
                                                    <div class="ctext-wrap">
                                                        <div class="ctext-wrap-content">
                                                            <span>ghfgh</span>
                                                        </div>
                                                        <div class="dropdown align-self-start message-box-drop">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <i class="ri-more-2-fill"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item copy-message" href="#">
                                                                    <i
                                                                        class="ri-file-copy-line me-2 text-muted align-bottom"></i>
                                                                    Copy
                                                                </a>
                                                                <a class="dropdown-item delete-item" href="#">
                                                                    <i
                                                                        class="ri-delete-bin-5-line me-2 text-muted align-bottom"></i>
                                                                    Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="conversation-name">
                                                        <small class="text-muted time">12:56 pm</small>
                                                        <span class="text-muted check-message-icon">
                                                            <i class="ri-user-follow-line"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li> --}}
                                    </ul>
                                </div>
                                <!-- end chat-conversation-list -->
                            </div>
                            <!-- end chat-conversation -->
                            <!-- start chat-conversation input-->
                            <div class="chat-input-section p-3 p-lg-4">
                                <form id="chat-form" action="{{ route('chat.message') }}" method="POST"
                                    class="row g-0 align-items-center" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-auto">
                                        <div class="chat-input-links me-2">
                                            <div class="links-list-item">
                                                <button type="button" class="btn btn-link text-decoration-none">
                                                    <i class="bx bx-smile align-middle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="chat-input-feedback">Please Enter a Message</div>
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}"
                                            id="user_id">
                                        <input type="text" name="message"
                                            class="form-control chat-input bg-light border-light" id="chat-input"
                                            placeholder="Type your message...">
                                    </div>
                                    <div class="col-auto">
                                        <div class="chat-input-links ms-2">
                                            <div class="links-list-item">
                                                <button type="submit"
                                                    class="btn btn-success chat-send waves-effect waves-light">
                                                    <i class="ri-send-plane-2-fill align-bottom"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- end chat-conversation input-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('footer')
    <script src="{{ asset('assets/libs/toastify/toastify-js.js') }}"></script>
    <script src="{{ asset('build/assets/app--9yKdif2.js') }}"></script>
    @verbatim
        <script>
            const {
                createApp,
                ref
            } = Vue;
            const ContactLi = {
                props: ['user'],
                template: `<li class="list-group-item list-group-item-action">
                            <a class="d-flex align-items-center" href="#">
                                <div
                                    class="flex-shrink-0 chat-user-img online user-own-img align-self-center">
                                    <img :src="user.profile" class="rounded-2 avatar-xs"
                                        alt="">
                                    <span class="user-status"></span>
                                </div>
                                <div class="flex-shrink-0 ms-3">
                                    <h6 class="fs-14 mb-0">{{ user . name }}</h6>
                                    <small class="text-muted">8 days Ago</small>
                                </div>
                                <div class="flex-shrink-0 ms-auto">
                                    <span class="text-success"></span>
                                </div>
                            </a>
                        </li>`,
                setup() {
                    const message = ref('Hello from My Component!');
                    return {
                        message
                    };
                }
            };
            const app = createApp({
                components: {
                    'contact-li': ContactLi
                },
                data() {
                    return {
                        users: [],
                        chatWith:{

                        }
                    };
                },
                methods: {
                    async fetchUsers() {
                        try {
                            const response = await fetch('http://127.0.0.1:9000/api/users');
                            this.users = await response.json();
                        } catch (error) {
                            console.error('Error fetching users:', error);
                        }
                    }
                },
                mounted() {
                    this.fetchUsers();
                }
            });
            app.mount('#app');
        </script>
    @endverbatim
    <script src="{{ asset('assets/js/custom/chat.js') }}"></script>
@endpush
