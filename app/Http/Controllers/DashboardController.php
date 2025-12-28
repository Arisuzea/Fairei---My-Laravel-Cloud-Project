<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Recent files (last 10)
        $recentFiles = File::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();
        
        // Storage stats
        $totalSize = File::where('user_id', $user->id)->sum('size');
        $totalFiles = File::where('user_id', $user->id)->count();
        
        // Files by type
        $filesByType = File::where('user_id', $user->id)
            ->select('mime_type', DB::raw('count(*) as count'), DB::raw('sum(size) as total_size'))
            ->groupBy('mime_type')
            ->get()
            ->map(function ($item) {
                $type = explode('/', $item->mime_type)[0];
                return [
                    'type' => $type,
                    'count' => $item->count,
                    'size' => $item->total_size,
                ];
            })
            ->groupBy('type')
            ->map(function ($group) {
                return [
                    'count' => $group->sum('count'),
                    'size' => $group->sum('size'),
                ];
            });
        
        return view('dashboard', compact('recentFiles', 'totalSize', 'totalFiles', 'filesByType'));
    }
}