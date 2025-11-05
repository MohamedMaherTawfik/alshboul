@extends('layouts.admin')
@section('title', 'الرسائل ')
@section('main_title_content', ' قائمة الرسائل ')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('chat.with') }}"> الدردشة</a>
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <div class="row">
        @forelse ($notifications as $notification)
            <div class="col-12 mb-3">
                <div class="card shadow-sm border-0 {{ $notification->seen ? 'bg-secondary' : 'bg-dark' }} text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-envelope text-info fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">
                                    لديك رسالة جديدة
                                </h5>
                                <p class="card-text mb-0">
                                    من: <strong>{{ $notification->sender?->name }}</strong>
                                </p>
                                <small class="text-light">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>

                        <!-- زرار فتح المودال -->
                        @if ($notification->sender->role == 'admin' || $notification->sender->role == 'superadmin')
                            <a href="{{ route('chat.with', $notification->sender) }}" class="btn btn-info">عرض الرسالة</a>
                        @else
                            <a href="{{ route('chat.with1', $notification->sender) }}" class="btn btn-info">عرض الرسالة</a>
                        @endif

                        <form action="{{ route('show.notification.read', $notification) }}" method="POST"
                            class="inline mr-2">
                            @csrf
                            <button type="submit"
                                class="px-3 py-1 text-sm rounded bg-[#FFC107] hover:bg-yellow-500 text-black">
                                تعيين كمقروء
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <!-- مودال الرسالة -->
            <div class="modal fade" id="messageModal{{ $notification->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">الرسالة من {{ $notification->sender?->name }}</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ $notification->message }}
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    لا توجد إشعارات حالياً
                </div>
            </div>
        @endforelse
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".view-message-btn").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    let notificationId = this.getAttribute("data-id");

                    fetch(`/notifications/read/${notificationId}`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({})
                        }).then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                console.log("✅ تم تعليم الرسالة كمقروءة");
                            }
                        });
                });
            });
        });
    </script>
@endsection
