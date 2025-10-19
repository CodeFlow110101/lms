<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\File;

class VideoController extends Controller
{
    public function stream($filename)
    {
        $fullPath = storage_path('app/private/files/' . $filename);

        if (!File::exists($fullPath)) {
            abort(404, 'File not found');
        }

        $stream = fopen($fullPath, 'rb');

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => 'video/mp4',
            'Content-Length' => File::size($fullPath),
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
            'Accept-Ranges' => 'bytes',
        ]);
    }

    public function thumbNail($filename)
    {
        $path = storage_path('app/private/files/' . $filename);

        if (!File::exists($path)) {
            abort(404, 'Image not found');
        }

        $mimeType = File::mimeType($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }
}
