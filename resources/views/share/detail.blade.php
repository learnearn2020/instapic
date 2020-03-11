@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8">
            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif
            <div class="card mb-3">
                <div class="card-header">
                    <a href="{{route('user.perfil',['user'=>$image->user->name,'id'=>$image->user->id])}}">


                        <div class="avatar-share">
                            @if($image->user->image)
                            <img src="{{route('user.avatar',['image_path'=>$image->user->image])}}" width="40" style="margin: 5px 0px;" alt="">

                            @endif
                        </div>
                        <div class="user_nick">

                            {{'@ '.$image->user->nick}}
                        </div>
                    </a>
                    @if(Auth::user()->id==$image->user->id)
                    <div class="action float-right">

                        <botton data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-danger mb-1">delete</botton>
                        <a class="btn btn-sm btn-primary mb-1" href="{{route('image.edit',['id'=>$image->id])}}">edit</a>
                    </div>
                    @endif
                </div>
                <!-- Button trigger modal -->


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">¿ Are you sure to delete this pub ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                If you delete this image all the comments and likes will delete also and you will not be able to recuparete it after .
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                <a href="{{route('image.delete',['id'=>$image->id])}}" class="btn btn-danger">Delete Image</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="image-shared">
                        <img src="{{route('share.avatar',['image_path'=>$image->image_path])}}" alt="">

                    </div>

                    <?php $isset_like=false;?>

                   @foreach($image->likes as $like)
                        @if($like->user->id==Auth::user()->id)
                            <?php $isset_like=true;?>
                        @endif
                   @endforeach

                   <div class="icones p-2">
                       <i class="mr-2 mb-1"> 
                       @if($isset_like)
                       <img  data-toggle="tooltip" data-placement="top" title="Dislike"src="{{asset('img/heart-blue.png')}}" class="like" data-id="{{$image->id}}" width="30px" alt=""> 
                        @else
                       <img  data-toggle="tooltip" data-placement="top" title="Like"src="{{asset('img/heart-white.png')}}" class="dislike" data-id="{{$image->id}}" width="30px" alt=""> 
                       @endif
                       </i>
                        <i class="mr-2">
                            <a data-toggle="tooltip" data-placement="top" title="See all the comments" href="{{route('share.detail',['id'=>$image->id])}}"> <img src="{{asset('img/comments.png')}}" width="40px" alt=""></a>
                        </i>

                    </div>
                    <div class="likes p-2">
                        {{count($image->likes) .  ' likes'}}
                    </div>
                    <div class="description p-2">
                        <span>
                            <span style="font-weight: bold;font-size:17px;">
                                {{ $image->user->nick}}
                            </span>
                            {{ $image->description}}
                        </span>
                    </div>
                    <div class="date p-2">
                        <!-- {{$image->created_at}} -->
                        <i> {{ \FormatTime::LongTimeFilter($image->created_at) }}</i>

                    </div>
                    <div class="comments m-2">
                        <h2 class="btn btn-info">Comments({{count($image->comments)}})</h2>
                    </div>

                    <hr>
                    <form action="{{route('comment.save')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$image->id}}" name="image_id">
                        <div class="form-group row">
                            <!-- <label for="image" class="col-md-3 col-form-label text-md-right">Picture </label> -->

                            <div class="col-md-9 ml-2">
                                <textarea id="comment" type="text" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" placeholder="add a comment ..."> </textarea>

                                @if ($errors->has('comment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('comment') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- <div class="form-group mb-0"> -->
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary m-2">
                                    Publish
                                </button>
                            </div>
                            <!-- </div> -->
                        </div>
                    </form>
                    <div class="allcomment">
                        @foreach($image->comments as $comment)
                        <div class="avatar-share p-1">
                            @if($comment->user->image)
                            <img src="{{route('user.avatar',['image_path'=>$comment->user->image])}}" width="40" style="margin: 5px 0px;" alt="">

                            @endif
                        </div>
                        <div class="comments p-2">
                            <span>
                                <span style="font-weight: bold;font-size:17px;">
                                    {{' @'. $comment->user->nick}}
                                </span>
                                {{ $comment->content . ' | ' .  \FormatTime::LongTimeFilter($comment->created_at)}}
                            </span>
                            @if(Auth::check() && (Auth::user()->id == $comment->user_id || $comment->image->user_id==Auth::user()->id))

                            <div class="action p-2 mt-3">
                                <a class="btn btn-sm btn-danger" href="{{route('comment.delete',['id'=>$comment->id])}}">Delete</a>
                                <a class="btn btn-sm btn-info" href="">Edit</a>
                            </div>
                            @endif

                        </div>
                        <hr>
                        @endforeach
                    </div>

                </div>
            </div>


            <div class="pagination  text-center" style="margin-left: 30%;margin-top:10px;">


            </div>
        </div>
    </div>
</div>
@endsection