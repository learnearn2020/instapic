@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6 mb-2">
            <h1>Favorites Pictures</h1>
            <hr>
            @foreach($likes as $like)
            <div class="card mb-3">
                <div class="card-header">
                    <a data-toggle="tooltip" data-placement="top" title="Visit Perfil" href="{{route('user.perfil',['user'=>$like->image->user->name,'id'=>$like->image->user->id])}}">


                        <div class="avatar-share">
                            @if($like->image->user->image)
                            <img src="{{route('user.avatar',['like_path'=>$like->image->user->image])}}" width="40" style="margin: 5px 0px;" alt="">

                            @endif
                        </div>
                        <div class="user_nick">

                            {{'@ '.$like->image->user->nick}}
                        </div>
                    </a>
                </div>

                <div class="card-body">
                    <div class="image-shared">
                        <img src="{{route('share.avatar',['like_path'=>$like->image->image_path])}}" alt="">

                    </div>
                    <?php $isset_like = false; ?>

                    @foreach($like->image->likes as $like)
                    @if($like->user->id==Auth::user()->id)
                    <?php $isset_like = true; ?>
                    @endif
                    @endforeach

                    <div class="icones p-2">
                        <i class="mr-2 mb-1">
                            @if($isset_like)
                            <img data-toggle="tooltip" data-placement="top" title="Dislike" src="{{asset('img/heart-blue.png')}}" class="like" data-id="{{$like->image->id}}" width="30px" alt="">
                            @else
                            <img data-toggle="tooltip" data-placement="top" title="Like" src="{{asset('img/heart-white.png')}}" class="dislike" data-id="{{$like->image->id}}" width="30px" alt="">
                            @endif
                        </i>
                        <i class="mr-2">
                            <a data-toggle="tooltip" data-placement="top" title="See all the comments" href="{{route('share.detail',['id'=>$like->image->id])}}"> <img src="{{asset('img/comments.png')}}" width="40px" alt=""></a>
                        </i>

                    </div>
                    <div class="likes p-2">
                        {{count($like->image->likes) .  ' likes'}}
                    </div>
                    <div class="description p-2">
                        <span>
                            <span style="font-weight: bold;font-size:17px;">
                                {{ $like->image->user->nick}}
                            </span>
                            {{ $like->image->description}}
                        </span>
                    </div>
                    <div class="date p-2">
                        <!-- {{$like->created_at}} -->
                        <i> {{ \FormatTime::LongTimeFilter($like->created_at) }}</i>

                    </div>

                    <div class="comments m-2">
                        <a class="btn btn-warning" href="">Comments({{count($like->image->comments)}})</a>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="pagination  text-center" style="margin-left: 30%;margin-top:10px;">

                {{$likes->links()}}
            </div>



        </div>

    </div>
</div>
@endsection