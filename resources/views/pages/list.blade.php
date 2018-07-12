@extends('layout')
@section('content')
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        @foreach($posts as $post)
                        <div class="col-md-6">
                            <article class="post post-grid">
                                <div class="post-thumb">
                                    <a href="{{route('post.show', $post->slug)}}"><img src="{{$post->getImage()}}" alt=""></a>

                                    <a href="{{route('post.show', $post->slug)}}" class="post-thumb-overlay text-center">
                                        <div class="text-uppercase text-center">Подробнее</div>
                                    </a>
                                </div>
                                <div class="post-content">
                                    <header class="entry-header text-center text-uppercase">
                                        @if($post->hasCategory())
                                            <h6> {{$post->getCategoryTitle()}}</h6>
                                        @endif
                                        <h1 class="entry-title"><a href="{{route('post.show', $post->slug)}}">{{$post->title}}</a></h1>


                                    </header>
                                    <div class="entry-content">
                                        <p>{!! $post->description !!}</p>

                                        <div class="social-share">
                                            <span class="social-share-title pull-left text-capitalize">{{$post->geDate()}}</span>
                                        </div>
                                    </div>
                                </div>

                            </article>
                        </div>
                        @endforeach
                    </div>
                    {{$posts->links()}}
                </div>
                @include('sidebar')
            </div>
        </div>
    </div>
    <!-- end main content-->
@endsection('content')