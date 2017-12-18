<div class="reply-list">
    @foreach($replies as $index => $reply)
        <reply
                :reply-id="{{ $reply->id }}"
                user-url="{{ route('users.show', $reply->user_id) }}"
                :user-id="{{ $reply->user_id }}"
                username="{{ $reply->user->name }}"
                avatar="{{ $reply->user->avatar }}"
                created-at="{{ $reply->created_at->diffForHumans() }}"
                @can('destroy', $reply)
                    remove-url="{{ route('replies.destroy', $reply->id) }}"
                @endcan
        >
            {!! $reply->content !!}
        </reply>
    @endforeach
</div>

{!! $replies->render() !!}