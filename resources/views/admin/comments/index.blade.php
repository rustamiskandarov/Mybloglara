@extends('admin.layout')
<!-- Site wrapper -->
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Комментарии
                <small>it all starts here</small>
            </h1>
            @component('admin.components.breadcrumb')
                @slot('title') Список комментариев @endslot
                @slot('parent') Главная @endslot
                @slot('active') Комментарии @endslot
            @endcomponent
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Листинг сущности</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID Поста</th>
                            <th>Заголовок поста</th>
                            <th>Пользователь</th>
                            <th>Комментарий</th>
                            <th>Когда создан</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($comments as $comment)
                        <tr>
                            <td>{{$comment->post_id}}</td>
                            <td>{{$comment->post->title}}</td>
                            <td>{{$comment->author->name}}</td>
                            <td>{{$comment->text}}</td>
                            <td>{{$comment->created_at->diffForHumans()}}</td>
                            <td>
                                @if($comment->status == 0)
                                    <a href="/admin/comments/toggle/{{$comment->id}}" class="fa fa-thumbs-o-up"> разрешить</a>
                                @else
                                    <a href="/admin/comments/toggle/{{$comment->id}}" class="fa fa-lock"> запретить</a>
                                @endif

                                {{Form::open(['route'=>['comment.destroy', $comment->id], 'method'=>'delete'])}}
                                    <button type="submit" class="delete-task" onclick="return confirm('Вы уверены?')">
                                        <i href="#" class="fa fa-remove"></i>
                                    </button>
                                {{Form::close()}}

                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection('content')