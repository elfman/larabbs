@include('common.error')
<div class="reply-box">
    <form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
        {{ csrf_field() }}
        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
        <div class="form-group">
            <div id="editor" class="reply-box-editor"></div>
            <textarea class="form-control" name="body" id="textarea" rows="3" style="display: none"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-share"></i> 回复</button>
    </form>
</div>
<hr>