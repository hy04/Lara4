<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    public function index(){
      return view('albums.index');
    }
    public function create(){
      return view('albums.create');
    }
    public function store(Request $request){
      $this->validate($request, [
        'name' => 'required',
        'cover_image' => 'image|max:1999'
      ]);
      //GET file name with extension
      $filenameWithExt= $request->file('cover_image')->getClientOriginalName();
      //get file name
      $filename=pathinfo($filenameWithExt, PATHINFO_FILENAME);
      //get extension
      $extension=$request->file('cover_image')->getClientOriginalExtension();
      //create new filename with timestamp
      $filenameToStore = $filename.'_'.time().'.'.$extension;

      //upload image
      $path=$request->file('cover_image')->storeAs('public/album_covers', $filenameToStore);
      return $path;
    }
}
