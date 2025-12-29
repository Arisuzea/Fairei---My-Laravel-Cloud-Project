<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function index()
    {
        $files = auth()->user()->files()->latest()->get();
        return view('files.index', compact('files'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:102400', // 100MB max
        ]);

        $file = $request->file('file');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads/' . auth()->id(), $fileName, 'local');

        File::create([
            'user_id' => auth()->id(),
            'name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        return redirect()->route('files.index')->with('success', 'File uploaded successfully!');
    }

    public function download(File $file)
    {
        abort_if($file->user_id !== auth()->id(), 403);

        return Storage::download($file->path, $file->original_name);
    }

    public function thumbnail(File $file)
    {
        abort_if($file->user_id !== auth()->id(), 403);

        if ($file->file_type !== 'image') {
            abort(404, 'Not an image file');
        }

        // Use Storage facade to get the path
        if (!Storage::disk('local')->exists($file->path)) {
            abort(404, 'File not found in storage');
        }

        // Get the file content
        $content = Storage::disk('local')->get($file->path);
        
        // Return image with proper headers
        return response($content, 200, [
            'Content-Type' => $file->mime_type,
            'Content-Length' => strlen($content),
            'Cache-Control' => 'public, max-age=604800',
        ]);
    }

    public function destroy(File $file)
    {
        abort_if($file->user_id !== auth()->id(), 403);

        Storage::delete($file->path);
        $file->delete();

        return redirect()->route('files.index')->with('success', 'File deleted successfully!');
    }
}