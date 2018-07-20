@extends('admin.layout')
<!-- Site wrapper -->
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Список категорий
                <small></small>
            </h1>
            @component('admin.components.breadcrumb')
                @slot('title') Список категорий @endslot
                @slot('parent') Главная @endslot
                @slot('active') Категории @endslot
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
                    <div class="form-group">
                        <a href="{{route('categories.create')}}" class="btn btn-success">Добавить</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->title}}</td>
                            <td>
                                <a href="{{route('home.view', $category->id)}}" class="fa fa-pencil"></a>

                                {{Form::open(['route'=>['categories.destroy', $category->id], 'method'=>'delete'])}}
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