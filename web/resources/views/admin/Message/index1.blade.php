@extends('layouts.admin')
@section('title', 'الدردشة ')
@section('main_title_content', ' قائمة الدردشة ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('chat.with1') }}"> الدردشة</a>
@endsection
@section('css')
    @livewireStyles
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> الدردشة

                </h3>
            </div>
            <div class="container-fluid">
                <div class="row">


                    <!-- Sidebar: قائمة المستخدمين -->
                    <div class="col-md-3">
                        <div class="list-group">
                            @foreach ($users as $user)
                                <a href="{{ route('chat.with1', $user->id) }}"
                                    class="list-group-item list-group-item-action {{ request()->route('userId') == $user->id ? 'active' : '' }}">
                                    {{ $user->username }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Main Chat Area -->
                    <div class="col-md-9">
                        <div class="card card-prirary cardutline direct-chat direct-chat-primary">
                            <div class="card-header">
                                <h3 class="card-title">دردشة مع {{ $selectedUser->username ?? '...' }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                            class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($selectedUser)
                                    @livewire('chat-boxs', ['userId' => $selectedUser->id], key($selectedUser->id))
                                @else
                                    <p class="text-muted">اختر مستخدمًا لبدء المحادثة.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    @livewireScripts

    <script>
        $(document).ready(function() {
            $('.open-delete-modal').on('click', function() {
                let id = $(this).data('id');
                $('#delete_id').val(id);
            });
        });
    </script>
@endsection
