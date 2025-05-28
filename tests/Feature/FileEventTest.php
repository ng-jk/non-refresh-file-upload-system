<?php

namespace Tests\Feature;

use App\Events\fileEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Broadcast;
use Tests\TestCase;

class FileEventTest extends TestCase
{
    public function test_file_event_contains_correct_data(): void
    {
        // Arrange
        $status = 'completed';
        $fileName = 'test.csv';

        // Act
        $event = new fileEvent($status, $fileName);

        // Assert
        $this->assertEquals($status, $event->status);
        $this->assertEquals($fileName, $event->fileName);
    }

    public function test_file_event_broadcasts_correctly(): void
    {
        // Arrange
        Event::fake();
        $status = 'completed';
        $fileName = 'test.csv';

        // Act
        event(new fileEvent($status, $fileName));

        // Assert
        Event::assertDispatched(fileEvent::class, function($event) use ($status, $fileName) {
            return $event->status === $status
                && $event->fileName === $fileName;
        });
    }

    public function test_file_event_broadcasts_on_correct_channel(): void
    {
        // Arrange
        Event::fake([fileEvent::class]);  // Use Event::fake instead
        $status = 'completed';
        $fileName = 'test.csv';

        // Act
        event(new fileEvent($status, $fileName));

        // Assert
        Event::assertDispatched(fileEvent::class, function($event) use ($status, $fileName) {
            return $event->broadcastOn()->name === 'statusChannel'
                && $event->status === $status
                && $event->fileName === $fileName;
        });
    }
}
