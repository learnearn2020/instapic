@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8 bg-primary perfil">
            <div class="avatar-all-people">
                @if($user->image)
                <img class=" rounded-circle border mx-auto" src="{{route('user.avatar',['image_path'=>$user->image])}}" alt="">

                @endif
            </div>
           
            <div class="data-user rounded">
                <div class="name-complete">
                    <span class=" ">{{$user->name .' '. $user->surname}}</span>
                </div>
                <div class="nick-perfil">
                    <span class="">{{ '@'.$user->nick}}</span>
                </div>
                <div class="email-perfil">
                    <span class=" ">{{ $user->email}}</span>
                 </div>
                 <div class="date">
                 {{'joined '.  \FormatTime::LongTimeFilter($user->created_at) }}

                 </div>
                 @if(Auth::user()->id==$user->id)
                 <span class="edit-perfil">
                <a class="btn btn-sm btn-danger" href="{{route('config')}}">Edit Perfil</a>
                </span>
                @endif
            </div>
          

        </div>
        
    </div>
</div>

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-4">

            <h1>Pictures Shared </h1>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8 bg-warning images-shared">
            @if(count($user->images)>=1)
            @foreach($user->images as $img)

                <div class="all-images">
                    
                    <img class="border" src="{{route('share.avatar',['image_path'=>$img->image_path])}}" alt="">
                </div>

            @endforeach
            @else
            <h1 class="text-center p-2">This user doesn't have picture for this moment</h1>
            @endif
        </div>
    </div>
</div>
@endsection


<!-- wgqu0ipfkn -->