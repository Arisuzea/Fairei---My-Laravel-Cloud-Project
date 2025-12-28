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
            'file' => 'required|file',
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

    public function destroy(File $file)
    {
        abort_if($file->user_id !== auth()->id(), 403);

        Storage::delete($file->path);
        $file->delete();

        return redirect()->route('files.index')->with('success', 'File deleted successfully!');
    }
}