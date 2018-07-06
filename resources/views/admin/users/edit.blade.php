@extends('admin.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Изменить пользователя
            <small> </small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Меняем данные пользователя {{$user->name}}</h3>
            </div>
            @include('admin.errors')
            {{Form::open(['route'=>['users.update', $user->id], 'method'=>'put', 'files'=>true])}}
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Имя</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="name" value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">E-mail</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="" name="email" value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Пароль</label>
                        <input type="password" class="form-control" id="exampleInputEmail1" placeholder="" name="password">
                    </div>
                    <img src="{{$user->getAvatar()}}" alt="" class="img-responsive" width="200">
                    <div class="form-group">
                        <label for="exampleInputFile">Аватар</label>
                        <input type="file" id="exampleInputFile" name="avatar">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button class="btn btn-default">Назад</button>
                <button class="btn btn-warning pull-right">Изменить</button>
            </div>
            {{Form::close()}}
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection('content')