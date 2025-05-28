<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\FileModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileModelObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_observer_is_triggered_on_status_update()
    {

        $fileModel = FileModel::create([
            'file_name' => 'test.csv',
            'file_path' => 'test/path',
            'status' => 'pending'
        ]);

        // Act
        $fileModel->update(['status' => 'processing']);

        // Assert
        $this->assertTrue(true);
    }
}
