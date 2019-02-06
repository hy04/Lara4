<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;

class PhotosController extends Controller
{
    public function create($album_id){
      return view('photos.create')->with('album_id', $album_id);
    }

    public function store(Request $request){
      $this->validate($request, [
        'title' => 'required',
        'photo' => 'image|max:1999'
      ]);
      //GET file name with extension
      $filenameWithExt= $request->file('photo')->getClientOriginalName();
      //get file name
      $filename=pathinfo($filenameWithExt, PATHINFO_FILENAME);
      //get extension
      $extension=$request->file('photo')->getClientOriginalExtension();
      //create new filename with timestamp
      $filenameToStore = $filename.'_'.time().'.'.$extension;

      //upload image
      $path=$request->file('photo')->storeAs('public/photos/'.$request->input('album_id'), $filenameToStore);
      //create album
      $photo=new Photo;
      $photo->album_id=$request->input('album_id');
      $photo->title=$request->input('title');
      $photo->description=$request->input('description');
      $photo->size=$request->file('photo')->getClientSize();
      $photo->photo=$filenameToStore;
      $photo->save();
      return redirect('/albums/'.$request->input('album_id'))->with('success', 'Photo Uploaded');

    }
}
