<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'original_name',
        'path',
        'mime_type',
        'size',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileTypeAttribute(): string
    {
        $extension = strtolower(pathinfo($this->original_name, PATHINFO_EXTENSION));
        $mimeType = explode('/', $this->mime_type)[0];

        // Images
        if ($mimeType === 'image') {
            return 'image';
        }

        // Videos
        if ($mimeType === 'video') {
            return 'video';
        }

        // Audio
        if ($mimeType === 'audio') {
            return 'audio';
        }

        // Archives
        if (in_array($extension, ['zip', 'rar', '7z', 'tar', 'gz', 'bz2'])) {
            return 'archive';
        }

        // PDFs
        if ($extension === 'pdf' || $this->mime_type === 'application/pdf') {
            return 'pdf';
        }

        // Documents
        if (in_array($extension, ['doc', 'docx', 'odt'])) {
            return 'document';
        }

        // Spreadsheets
        if (in_array($extension, ['xls', 'xlsx', 'ods', 'csv'])) {
            return 'spreadsheet';
        }

        // Presentations
        if (in_array($extension, ['ppt', 'pptx', 'odp'])) {
            return 'presentation';
        }

        // Code files
        if (in_array($extension, ['php', 'js', 'py', 'java', 'cpp', 'c', 'html', 'css', 'json', 'xml'])) {
            return 'code';
        }

        // Text files
        if (in_array($extension, ['txt', 'md', 'log'])) {
            return 'text';
        }

        return 'file';
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->file_type === 'image') {
            // Use Storage facade for proper path handling
            if (Storage::disk('local')->exists($this->path)) {
                $imageData = base64_encode(Storage::disk('local')->get($this->path));
                return 'data:' . $this->mime_type . ';base64,' . $imageData;
            }
        }
        return null;
    }
}