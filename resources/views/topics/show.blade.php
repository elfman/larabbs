@extends('layouts.app')

@section('title', $topic->title)

@section('description', $topic->excerpt)

@section('script')
    <script src="//cdn.bootcss.com/wangEditor/10.0.13/wangEditor.min.js"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        作者：{{ $topic->user->name }}
                    </div>
                    <hr>
                    <div class="media">
                        <div align="center">
                            <a href="{{ route('users.show', $topic->user_id) }}">
                                <img src="{{ $topic->user->avatar }}" alt="{{ $topic->user->name }}" class="thumbnail img-responsive" width="300px" height="300px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1 class="text-center">
                        {{ $topic->title }}
                    </h1>

                    <div class="article-meta text-center">
                        {{ $topic->created_at->diffForHumans() }}
                        ⋅
                        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                        {{ $topic->reply_count }}
                    </div>

                    <div class="topic-body">
                        {!! $topic->body !!}
                    </div>

                        <div class="operate">
                            <hr>
                            @can('update', $topic)
                            <div class="pull-left">
                                <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-default btn-xs" role="button">
                                    <i class="glyphicon glyphicon-edit"></i> 编辑
                                </a>
                                <remove-topic url="{{ route('topics.destroy', $topic->id) }}" redirect-to="{{ route('topics.index') }}"></remove-topic>
                            </div>
                            @endcan
                            <div class="pull-right">
                                <i class="glyphicon glyphicon-eye-open"></i> {{ $topic->view_count }} &nbsp; &nbsp;
                                <topic-vote :voted={{ $topic->voted() ? 'true' : 'false'}} :vote-count="{{ $topic->upvote_count }}" url="{{ route('topics.vote', $topic->id) }}" {{ Auth::check() ? '' : ':disabled=true' }}></topic-vote>
                            </div>
                        </div>
                </div>
            </div>

            <div class="panel panel-default topic-reply">
                <div class="panel-body">
                    @include('topics._reply_list', ['replies' => $topic->replies()->recent()->with('user', 'topic')->paginate(10)])
                </div>
            </div>
        </div>
    </div>
@endsection
