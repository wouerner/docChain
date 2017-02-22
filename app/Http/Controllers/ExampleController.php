<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\File as FileModel;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return response()->json('success');

    }

    public function store(Request $request)
    {
        $fileModel = new FileModel;
        $file = $request->file('file');

        if ($request->file('file')->isValid()) {

            $name = date('Y-m-d_H:s') . $file->getClientOriginalName();

            Storage::disk('local')->put($name, File::get($file));

            $contents = Storage::get($name);
            $hash = hash('sha512', $contents);

            $fileModel->originalName = $file->getClientOriginalName();
            $fileModel->hash = $hash;
            $fileModel->path = $name;

            $fileModel->save();

            return response()->json([ $file->getClientOriginalName(), $hash ]);
        }
        return response()->json('error');
    }

    public function replicateStore(Request $request)
    {
        $file = $request->file('file');

        if ($request->file('file')->isValid()) {
            Storage::disk('local')->put($file->getClientOriginalName(), File::get($file));

            $contents = Storage::get($file->getClientOriginalName());
            $hash = hash('sha512', $contents);
            //dd($contents);


            return response()->json([ $file->getClientOriginalName(), $hash ]);
        }
        return response()->json('error');
    }
}
