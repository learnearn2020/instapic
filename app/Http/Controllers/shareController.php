<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Comment;
use App\Like;
use Illuminate\Support\Facades\Auth;

class shareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        return view('share.create');
    }
    public function save(Request $request)
    {
        $id = Auth::user()->id;
        $image = new Image;
        $validate = $this->validate($request, [
            'image' => ['required', 'image'],
            'description' => ['string']
        ]);

        $image_path = $request->file('image');
        if ($image_path) {
            $image_name = time().$image_path->getClientOriginalName();
            Storage::disk('shared')->put($image_name, File::get($image_path));
            $image->image_path = $image_name;
        }
        $image->user_id = $id;
        $description = $request->input('description');

        $image->description = $description;
        $image->save();
        return redirect()->route('home')->with(['message' => 'Your picture has been published with exited ! ']);
    }
    public function getImage($image_path)
    {
        $file = Storage::disk('shared')->get($image_path);
        return new Response($file, 200);
    }
    public function detail($id)
    {
        $image = Image::find($id);
        return view('share.detail', ['image' => $image]);
    }
    public function delete($id)
    {
        $user = Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();
        if ($user && $image && ($user->id == $image->user->id)) {
            // delete comments
            if ($comments && count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }
            // delete likes
            if ($likes && count($likes) >= 1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }
            // delete images
            Storage::disk('shared')->delete($image->image_path);
            // delete image
            $image->delete();
            return redirect()->route('home')->with('message', 'The photo was deleted correctly!');
        } else {
            return redirect()->route('home')->with('message', 'Oups!!! the photo did not  deleted , try again!');
        }
    }
    public function edit($id)
    {
        $user = Auth::user();
        $image = Image::find($id);
        if ($user && $image && ($user->id == $image->user->id)) {
            return view('share.edit', [
                'image' => $image
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Make sure you are login and this image is yours!');
        }
    }
    public function update(Request $request)
    {
        $validate = $this->validate($request, [
            'image' => ['image'],
            'description' => ['string']
        ]);

        $description = $request->input('description');
        $image_id=$request->input('image_id');
            $image=Image::find($image_id);
        $image_path = $request->file('image');
        if ($image_path) {
            $image_name = time() . $image_path->getClientOriginalName();
            Storage::disk('shared')->put($image_name, File::get($image_path));
            $image->image_path = $image_name;
        }
        $image->description=$description;
        $image->update();
        return redirect()->route('share.detail',['id'=>$image_id])->with('message', 'Your pub has been updated correctly !');


    }
}
