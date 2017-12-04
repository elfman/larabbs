@extends('layouts.app')

@section('script')
    <script src="//unpkg.com/wangeditor/release/wangEditor.min.js"></script>

    <script type="text/javascript">
        var E = window.wangEditor;
        var editor = new E('#wang');
        var $textarea = $('#editor');
        editor.customConfig.onchange = function (html) {
            $textarea.val(html);
        };
        editor.create();
        $textarea.val(editor.txt.html());
    </script>
@endsection

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-body">
                <h2>
                    <i class="glyphicon glyphicon-edit"></i>
                    @if($topic->id)
                        编辑话题
                    @else
                        新建话题
                    @endif
                </h2>

                <hr>

                @include('common.error')

                @if($topic->id)
                    <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <div class="form-group">
                        <input class="form-control" type="text" name="title" placeholder="请填写标题" required value="{{ old('title', $topic->title ) }}" />
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="category_id" required>
                            <option value="" hidden disabled selected>请选择分类</option>
                            @foreach($categories as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div id="wang">{{ old('body', $topic->body ) }}</div>
                        <textarea name="body" id="editor" class="form-control" rows="3" placeholder="请至少填写3个字符" required style="display: none"></textarea>
                    </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok"></span> 保存
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection