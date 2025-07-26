<div class="p-2">
    @forelse ($messages as $msg)
        <div class="direct-chat-msg {{ $msg['sender_id'] == Auth::id() ? 'right' : '' }}">
            <div class="clearfix direct-chat-infos">
                <span class="{{ $msg['sender_id'] == Auth::id() ? 'float-left' : 'float-right' }} direct-chat-name">
                    {{ $msg['sender_id'] == Auth::id() ? Auth::user()->username : $selectedUser->username }}</span>
                <span
                    class="{{ $msg['sender_id'] == Auth::id() ? 'float-right' : 'float-left' }}    direct-chat-timestamp">
                    {{ \Carbon\Carbon::parse($msg['created_at'])->format('d/m/Y h:i A') }}</span>
            </div>
            <!-- /.direct-chat-infos -->
            <!-- /.direct-chat-img -->
            <div style="text-transform: uppercase;"
                class="direct-chat-img   align-content-center {{ $msg['sender_id'] == Auth::id() ? 'bg-primary' : 'bg-secondary' }} text-center">
                {{ substr($msg['sender_id'] == Auth::id() ? Auth::user()->username : $selectedUser->username, 0, 1) }}

            </div>

            <div class="direct-chat-text ">
                {{ $msg['message'] }}
            </div>
            <!-- /.direct-chat-text -->
        </div>
    @empty
        <p class="text-center text-muted">لا توجد رسائل بعد</p>
    @endforelse

    {{-- <div class="card">
        <div class="card-body" style="height: 400px; overflow-y: auto;">
            @forelse ($messages as $msg)
                <div
                    class="d-flex mb-2 {{ $msg['sender_id'] == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="bg-{{ $msg['sender_id'] == Auth::id() ? 'primary text-white' : 'light' }} p-2 rounded">
                        <div class="small">{{ $msg['message'] }}</div>
                        <div class="text-right text-muted small">{{ $msg['created_at'] }}</div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">لا توجد رسائل بعد</p>
            @endforelse
        </div> --}}

    <div class="card-footer">
        <form wire:submit.prevent="sendMessage">
            <div class="input-group">
                <input type="text" wire:model="messageText" class="form-control" placeholder="اكتب رسالتك..." />
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">إرسال</button>
                </div>
            </div>
            @error('messageText')
                <span class="mt-1 text-danger small d-block">{{ $message }}</span>
            @enderror
        </form>
    </div>
</div>
