@extends('admin.layout')
<!-- Site wrapper -->
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Список подписчиков
                <small></small>
            </h1>
            @component('admin.components.breadcrumb')
                @slot('title') Список подписчиков @endslot
                @slot('parent') Главная @endslot
                @slot('active') Подписчики @endslot
            @endcomponent
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Подписчики</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{route('subscribers.create')}}" class="btn btn-success">Добавить</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>email</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subs as $subscriber)
                        <tr>
                            <td>{{$subscriber->id}}</td>
                            <td>{{$subscriber->email}}</td>
                            <td>{{$subscriber->getStatus()}}</td>

                            <td>
                                {{Form::open(['route'=>['post.destroy', $subscriber->id], 'method'=>'delete'])}}
                                    <button type="submit" class="delete-task" onclick="return confirm('Вы уверены?')">
                                        <i class="fa fa-remove"></i>
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