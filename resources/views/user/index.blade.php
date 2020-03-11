@extends('layouts.app')

@section('content')

<div class="container">
    <div class="container">

        
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
        <form action="{{route('user.index')}}" method="get" class="" id="search-form">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" class="form-control" id="search" placeholder="search for someone...">
                </div>
                <div class="col-md-2">
                    <input type="submit" class="btn btn-primary" id="btn-search" value="Search">
                </div>
            </div>
        </form>
        </div>
        <br>
        <div class="clear"></div>

        @foreach($users as $user)
        <div class="clear-both"></div>
        <div class="col-md-7 bg-light rounded shadow-sm  perfil my-2">
            <div class="avatar-all-people">
                @if($user->image)
                <img class=" rounded-circle border mx-auto" src="{{route('user.avatar',['image_path'=>$user->image])}}" alt="">

                @endif
            </div>

            <div class="data-user rounded">
                <div class="name-complete ">
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
                <span class="edit-perfil">
                    <a class="btn btn-sm btn-success" href="{{route('user.perfil',['id'=>$user->id])}}">Visit Perfil</a>
                </span>
            </div>


        </div>
        @endforeach

    </div>
</div>


@endsection