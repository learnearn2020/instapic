<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
class commentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $request  )
    {
        $comment=new Comment();
        $user=Auth::user();
        $id_user=$user->id;
        $validate=$this->validate($request,[
            'image_id'=>['integer','required'],
            'comment'=>['required','string']
        ]);
        $comment_user=$request->input('comment');
        $image_id=$request->input('image_id');

        $comment->user_id=$id_user;
        $comment->image_id=$image_id;
        $comment->content=$comment_user;
        $comment->save();
        return redirect()->route('share.detail',['id'=>$image_id])->with('message','Your comment has been published successfully !');
    }
    public function delete($id)
    {
        $user=Auth::user();
        $comment=Comment::find($id);
        if($user && ($user->id == $comment->user_id || $comment->image->user_id==$user->id)){
            $comment->delete();
            return redirect()->route('share.detail',['id'=>$comment->image->id])->with('message','Your comment has been deleted successfully !');

            
        }else{
            return redirect()->route('share.detail',['id'=>$comment->image->id])->with('message','Ouupps!! Error by deleting your comment!');

        }
    }
}
// Auth::user()->id == $comment->user_id || $comment->image->user_id==Auth::user()->id
