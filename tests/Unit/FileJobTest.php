<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use App\Models\FileModel;
use App\Models\ContentModel;
use App\Jobs\FileJob;

class FileJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_handle_processes_csv_and_updates_status()
    {
        // Create a FileModel instance
        $fileModel = FileModel::first();
        if (!$fileModel) {
            $fileModel = FileModel::create([
                'file_name' => 'test.csv',
                'file_path' => 'uploads\8kXhbdvF3V8fctxp1rsoPRlJQcjOmPt0WPVeUG2L.csv',
                'status' => 'pending',
                'timestamp' => now(),
            ]);
        }

        // Dispatch the job
        $job = new FileJob($fileModel, $fileModel->file_path);
        $job->handle();

        // Assert the fileModel status is updated
        $fileModel->refresh();
        $this->assertEquals('completed', $fileModel->status);

        // Assert ContentModel was created
        $this->assertTrue(ContentModel::count() > 0);
    }
}
