@extends('layout')
@section('content')
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="leave-comment mr0"><!--leave comment-->

                            <h3 class="text-uppercase">Войти</h3>
                            <br>
                            @if(session('status'))
                                <div class="alert alert-danger">
                                    {{session('status')}}
                                </div>
                            @endif
                            @include('admin.errors')
                            <form class="form-horizontal contact-form" role="form" method="post"  action="/login">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="email" name="email"
                                               placeholder="Email" value="{{old('email')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="password" name="password"
                                               placeholder="password">
                                    </div>
                                </div>
                                <button type="submit" class="btn send-btn">Войти</button>

                            </form>
                        </div><!--end leave comment-->
                    </div>
                </div>
                @include('sidebar')
            </div>
        </div>
    </div>
    <!-- end main content-->
@endsection('content')