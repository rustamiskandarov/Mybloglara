@extends('admin.layout')
<!-- Site wrapper -->
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Список всех постов
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        {{Form::open([
            'route' => 'post.store',
            'files' => true
        ])}}
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Список всех статей</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{route('post.create')}}" class="btn btn-success">Добавить</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Заголовок</th>
                            <th>Описание</th>
                            <th>Категория</th>
                            <th>Теги</th>
                            <th>Картинка</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td>{{$post->title}}</td>
                            <td>{!! $post->description !!}</td>
                            <td>{{$post->getCategoryTitle()}}</td>
                            <td>{{$post->getTagsTitles()}}</td>
                            <td>
                                <img src="{{$post->getImage()}}" alt="" class="img-responsive" width="100">
                            </td>
                            <td>
                                <a href="{{route('post.edit', $post->id)}}" class="fa fa-pencil"></a>

                                {{Form::open(['route'=>['post.destroy', $post->id], 'method'=>'delete'])}}
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
        {{Form::close()}}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection('content')