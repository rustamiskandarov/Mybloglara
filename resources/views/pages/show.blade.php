@extends('layout')
@section('content')
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                    <article class="post">
                        <div class="post-thumb">
                            <p><img src="{{$post->getImage()}}" alt=""></p>
                        </div>
                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">
                                @if($post->hasCategory())
                                    <a href="{{route('category.show', $post->category->slug)}}">
                                    <h6> {{$post->getCategoryTitle()}}</h6>
                                    </a>
                                @endif
                                <h1 class="entry-title">{{$post->title}}</h1>


                            </header>
                            <div class="entry-content">
                                <h4>
                                    {!! $post->description !!}
                                </h4>
                            </div>

                            <div class="entry-content">
                                <p>
                                    {!! $post->content !!}
                                </p>
                            </div>
                            <div class="decoration">
                                @if($post->hasTags())
                                    @foreach($post->tags as $tag)
                                        <a href="{{route('tag.show', $tag->slug)}}" class="btn btn-default">{{$tag->title}}</a>
                                    @endforeach
                                @endif
                            </div>

                            <div class="social-share">
							<span
                                    class="social-share-title pull-left text-capitalize">By {{$post->author->name}} On {{$post->geDate()}}</span>
                                <ul class="text-center pull-right">
                                    <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </article>
                <div class="top-comment"><!--top comment-->
                    <img src="assets/images/comment.jpg" class="pull-left img-circle" alt="">
                    <h4>Rubel Miah</h4>

                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy hello ro mod tempor
                        invidunt ut labore et dolore magna aliquyam erat.</p>
                </div><!--top comment end-->
                <div class="row"><!--blog next previous-->
                    <div class="col-md-6">
                        @if($post->hasPrevious())
                        <div class="single-blog-box">
                            <a href="{{route('post.show', $post->getPrevious()->slug)}}">
                                <img src="{{$post->getPrevious()->getImage()}}" alt="">
                                <div class="overlay">

                                    <div class="promo-text">
                                        <p><i class=" pull-left fa fa-angle-left"></i></p>
                                        <h5>{{$post->getPrevious()->title}}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($post->hasNext())
                            <div class="single-blog-box">
                                <a href="{{route('post.show', $post->getNext()->slug)}}">
                                    <img src="{{$post->getNext()->getImage()}}" alt="">
                                    <div class="overlay">

                                        <div class="promo-text">
                                            <p><i class=" pull-right fa fa-angle-right"></i></p>
                                            <h5>{{$post->getNext()->title}}</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div><!--blog next previous end-->
                <div class="related-post-carousel"><!--related post carousel-->
                    <div class="related-heading">
                        <h4>You might also like</h4>
                    </div>
                    <div class="items">
                        @foreach($post->realeted() as $item)
                        <div class="single-item">
                            <a href="{{route('post.show', $item->slug)}}">
                                <img src="{{$item->getImage()}}" alt="">

                                <p>{{$item->title}}</p>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div><!--related post carousel-->
                <h4>Коментарии</h4>
                @if(!$post->comments->isEmpty())
                    @foreach($post->getComments() as $comment)
                    <div class="bottom-comment"><!--bottom comment-->

                    <div class="comment-img">
                        <img class="img-circle" src="{{$comment->author->getAvatar()}}" alt="" style="width: 80px; height: 80px;">
                    </div>

                    <div class="comment-text">
                        <a href="#" class="replay btn pull-right"> Replay</a>
                        <h5>{{$comment->author->name}}</h5>

                        <p class="comment-date">
                            {{$comment->created_at->diffForHumans()}}
                        </p>


                        <p class="para">
                            {{$comment->text}}
                        </p>
                    </div>

                </div>
                @endforeach
                @endif
                <!-- end bottom comment-->

                @if(Auth::check())
                <div class="leave-comment"><!--leave comment-->
                    <h4>Добавить комментарий</h4>


                    <form class="form-horizontal contact-form" role="form" method="post" action="/comment">
                        {{csrf_field()}}
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <div class="form-group">
                            <div class="col-md-12">
										<textarea class="form-control" rows="6" name="text"
                                                  placeholder="Напишите свой комментарий"></textarea>
                            </div>
                        </div>
                        <button class="btn send-btn">Опубликовать комментарий</button>
                    </form>
                </div><!--end leave comment-->
                @else
                        <h4>Войдите чтобы добавить комментарий</h4>
                @endif
            </div>
            @include('sidebar')

        </div>
    </div>
</div>
@endsection('content')