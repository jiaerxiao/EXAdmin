<?php

namespace App\Http\Controllers;

use App\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth:sanctum']);
    }

    public function image(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'max:2048']
        ], ['file.max' => '图片不能超过2MB']);

        $url = app(UploadService::class)->image(request('file'));

        return $this->success('', ["url" => $url]);
    }
}
