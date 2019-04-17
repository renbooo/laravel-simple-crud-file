<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = File::all();
        return view('file',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new File;
        $data->file_name = $request->input('file_name');
        $file_path = $request->file('file_path');
        $ext = $file_path->getClientOriginalExtension();
        $newName = rand(100000,1001238912).".".$ext;
        $file_path->move('/uploads/file',$newName);
        $data->file_path = $newName;
        $data->save();
        return redirect()->route('file.index')->with('alert-success','Data berhasil ditambahkan!');
    }
    public function edit($id)
    {
        //
        $data = File::findOrFail($id);
        return view('edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = File::findOrFail($id);
        $data->file_name = $request->input('file_name');
        if (empty($request->file('file_path'))){
            $data->file_path = $data->file_path;
        }
        else{
            unlink('uploads/file/'.$data->file_path); //menghapus file lama
            $file_path = $request->file('file_path');
            $ext = $file_path->getClientOriginalExtension();
            $newName = rand(100000,1001238912).".".$ext;
            $file_path->move('uploads/file',$newName);
            $data->file_path = $newName;
        }
        $data->save();
        return redirect()->route('file.index')->with('alert-success','Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = File::findOrFail($id);
        $data->delete();
        return redirect()->route('file.index')->with('alert-success','Data berhasil dihapus!');
    }
}