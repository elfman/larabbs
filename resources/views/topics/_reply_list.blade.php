<div class="reply-list">
    <reply-list
            reply-data="{{ repliesToJson($replies) }}"
            @if (Auth::check())
                reply-url="{{ route('replies.store') }}"
            @endif
            :topic-id="{{ $topic->id }}"
    >
    </reply-list>
</div>

{!! $replies->render() !!}