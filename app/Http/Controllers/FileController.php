<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileModel;
use App\Models\ContentModel;

use App\Jobs\ContentJob;
use App\Jobs\FileJob;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:csv,txt', // Validate CSV file upload
            ]);
            $file = $request->file('file');

            // processing file
            $path = $file->store('uploads');
            $name = $file->getClientOriginalName();
            $fileModel = FileModel::create([
                'file_path' => $path,
                'file_name' => $name,
                'status' => 'processing'
            ]);
            FileJob::dispatch($fileModel, $path);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'File upload failed',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
