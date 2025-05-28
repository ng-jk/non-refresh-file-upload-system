<?php

namespace App\Observers;

use App\Models\FileModel;
use App\Events\fileEvent;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class FileModelObserver
{
    /**
     * Handle the FileModel "created" event.
     */
    public function created(FileModel $fileModel): void
    {
        $this->updated($fileModel); // Call the updated method to handle the event
    }

    /**
     * Handle the FileModel "updated" event.
     */
    public function updated(FileModel $fileModel): void
    {
        // Check if the status column is changing
        $newStatus = $fileModel->status;
        $fileName = $fileModel->file_name;
        broadcast(new fileEvent($newStatus, $fileName));
    }

    /**
     * Handle the FileModel "deleted" event.
     */
    public function deleted(FileModel $fileModel): void
    {
        //
    }

    /**
     * Handle the FileModel "restored" event.
     */
    public function restored(FileModel $fileModel): void
    {
        //
    }

    /**
     * Handle the FileModel "force deleted" event.
     */
    public function forceDeleted(FileModel $fileModel): void
    {
        //
    }
}
