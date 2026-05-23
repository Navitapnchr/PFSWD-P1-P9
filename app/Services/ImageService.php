<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Upload file gambar
     */
    public function upload(
        UploadedFile $file,
        string $folder = 'products'
    ): string {

        // Nama unik
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        // Simpan ke storage/app/public/products
        $file->storeAs($folder, $filename, 'public');

        // Path yang disimpan ke DB
        return $folder . '/' . $filename;
    }

    /**
     * Hapus file lama
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {

            Storage::disk('public')->delete($path);
        }
    }
}