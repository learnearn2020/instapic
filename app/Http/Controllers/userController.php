<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class userController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function config()
    {
        return view('user.config');
    }
    public function update(Request $request)
    {
       
        $user=Auth::user();
        $id=$user->id;
        $validate=$this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255','unique:users,nick,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'avatar' => ['image'],
            
        ]);

        $name=$request->input('name');
        $surname=$request->input('surname');
        $nick=$request->input('nick');
        $email=$request->input('email');
        
        // get the image
        $avatar=$request->file('avatar');
        if($avatar){
           $avatar_name=time() . $avatar->getClientOriginalName();
            Storage::disk('users')->put($avatar_name,File::get($avatar));
            $user->image=$avatar_name;
        }
        

       
        $user->name=$name;
        $user->surname=$surname;
        $user->nick=$nick;
        $user->email=$email;
        $user->update();
        return redirect()->route('config')->with(['message'=>'Your data has been updated with exited ! ']);

    }
    public function getImage($image_path)
    {
       $file= Storage::disk('users')->get($image_path);
        return new Response($file,200);
        
    }
    public function perfil($id)
    {
        // $user=Auth::user();
        $find=User::find($id);
        return view('user.perfil',[
            'user'=>$find
        ]);
    }
    public function index($search=null)
    {
        if(!empty($search)){


            $users=User::where('nick','LIKE','%'.$search.'%')
                                ->orwhere('surname','LIKE','%'.$search.'%')
                                ->orwhere('name','LIKE','%'.$search.'%')
                                ->orderBy('id','desc')->paginate(10);
        }else{
            
            $users=User::orderBy('id','desc')->paginate(10);
        }
        return view('user.index',[
            'users'=>$users
        ]);
    }
    public function news()
    {
        return view('user.news');
    }
}
