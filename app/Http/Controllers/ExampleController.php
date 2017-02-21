<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

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

    public function replicate(Request $request)
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
