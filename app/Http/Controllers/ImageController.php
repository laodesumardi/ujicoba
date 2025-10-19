<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Upload gambar ke public/images
     */
    public function uploadToPublic(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke public/images
            $file->move(public_path('images'), $filename);
            
            return response()->json([
                'success' => true,
                'filename' => $filename,
                'url' => asset('images/' . $filename),
                'message' => 'Gambar berhasil diupload ke public/images'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal upload gambar'
        ], 400);
    }

    /**
     * Upload gambar ke storage
     */
    public function uploadToStorage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke storage/app/public/uploads
            $path = $file->storeAs('uploads', $filename, 'public');
            
            return response()->json([
                'success' => true,
                'filename' => $filename,
                'path' => $path,
                'url' => Storage::url($path),
                'message' => 'Gambar berhasil diupload ke storage'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal upload gambar'
        ], 400);
    }

    /**
     * Tampilkan form upload
     */
    public function showUploadForm()
    {
        return view('image-upload');
    }

    /**
     * Hapus gambar dari public/images
     */
    public function deleteFromPublic(Request $request)
    {
        $filename = $request->input('filename');
        $filepath = public_path('images/' . $filename);
        
        if (file_exists($filepath)) {
            unlink($filepath);
            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus dari public/images'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File tidak ditemukan'
        ], 404);
    }

    /**
     * Hapus gambar dari storage
     */
    public function deleteFromStorage(Request $request)
    {
        $path = $request->input('path');
        
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus dari storage'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File tidak ditemukan'
        ], 404);
    }
}

