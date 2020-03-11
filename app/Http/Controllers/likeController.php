<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Like;

class likeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function like($image_id)
    {
        $user=Auth::user();
        $isset_like=Like::where('image_id',$image_id)->where('user_id',$user->id)->count();
        if($isset_like==0){
            
            $like=new like;
    
            $like->user_id=$user->id;
            $like->image_id=$image_id;
            $like->save();
            return response()->json([
               'like'=> $like ,
               'message'=> 'you liked this fotos '
            ]);
        }else{
            return response()->json([
                'message' => 'You have been liked yet this fotos'
            ]);
        }
    }
    public function dislike($image_id)
    {
        $user=Auth::user();
        $like=Like::where('image_id',$image_id)->where('user_id',$user->id)->first();
        if($like){
            
            
    
            $like->delete();
            return response()->json([
               'like'=> $like ,
               'message'=> 'you disliked this fotos '
            ]);
        }else{
            return response()->json([
                'message' => 'el like dont existe'
            ]);
        }
    }
    public function index()
    {
        $user=Auth::user();
        $likes=Like::where('user_id',$user->id)->orderBy('id','desc')->paginate(10);
        return view('like.index',[
            'likes'=>$likes
        ]);
    }
}
