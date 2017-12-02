@extends('layouts.app')

@section('title', 'LaraBBS')
    
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div class="center">
                            <img src="https://avatars2.githubusercontent.com/u/948001?s=460&v=4" alt="Harlan" class="thumbnail img-responsive" width="300px" height="300px">
                        </div>
                        <div class="media-body">
                            <hr>
                            <h4><strong>个人简介</strong></h4>
                            <p>This is a person</p>
                            <hr>
                            <h4><strong>注册于</strong></h4>
                            <p>2016.01.23</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span>
                        <h1 class="panel-title pull-left" style="font-size: 30px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
                    </span>
                </div>
            </div>
            <hr>

            <div class="panel panel-default">
                <div class="panel-body">
                    Empty
                </div>
            </div>
        </div>
    </div>
@endsection