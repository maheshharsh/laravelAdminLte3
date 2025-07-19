<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        dd('adsf');
        return redirect(route('admin.dashboard'));
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // public function fileServe($filePath, $disk=null)
    // {
    //     $disk = $disk ? $disk : config('constants.storage_disk');
    //     if (Storage::disk($disk)->exists($filePath)) {
    //           $content = Storage::disk($disk)->get($filePath);
    //           $mime = Storage::mimeType($filePath);
    //           $response = Response::make($content, 200);
    //           $response->header("Content-Type", $mime);

    //           return $response;
    //     }
    //         return abort('403');
    // }
}
