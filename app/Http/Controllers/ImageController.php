<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function test()
    {
        // Storage::disk('local')->put('public/example.txt', 'Contents');
        // $contents = Storage::disk('public')->get('example.txt');
        $json = json_encode(['name' => 'Yazılımcı Adam', 'state' => 'Türkiye']);
        Storage::disk('public')->put('example.json', $json);
        $temp_url = Storage::disk('public')->temporaryUrl('example.json', now()->addSecond(3));
        return response()->json(['url' => $temp_url]);
    }
    public function download(Request $request)
    {
        abort_if(!Storage::disk('public')->exists($request->path), 404, 'File not found');
        abort_if(!$request->hasValidSignature(), 403, 'Time out or invalid signature.');
        return Storage::disk('public')->download($request->path);
    }
}
