<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use App\Models\FileModel;
use App\Models\ContentModel;

use function Illuminate\Log\log;

class FileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;
    protected $fileModel;

    /**
     * Create a new job instance.
     */
    public function __construct(FileModel $fileModel, $path)
    {
        $this->path = $path;
        $this->fileModel = $fileModel;
    }

    /**
     * Execute the job.
     */
    protected function clean($text)
    {
        return mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    }
    public function handle(): void
    {
        $this->fileModel->update(['status' => 'processing']);
        // Remove all non-UTF-8 characters
        $content = Storage::get($this->path);
        // Remove UTF-8 BOM (EF BB BF)
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        // Remove all non-UTF-8 characters
        $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');

        // Optionally, strip characters not allowed in printable UTF-8
        $content = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\xA0-\x{10FFFF}]/u', '', $content);
        $rows = array_map('str_getcsv', explode("\n", $content));
        if (count($rows) < 2) {
            $this->fileModel->update(['status' => 'failed']);
            return;
        }
        $headers = array_map('trim', $rows[0]); // First row as headers

        // Process each row after the header
        foreach (array_slice($rows, 1) as $row) {
            $data = array_combine($headers, $row); // Combine headers with row values
            ContentModel::updateOrCreate(
                ['UNIQUE_KEY' => $this->clean($data['UNIQUE_KEY'])],
                [
                    'UNIQUE_KEY' => $this->clean($data['UNIQUE_KEY']) ?? '',
                    'PRODUCT_TITLE' => $this->clean($data['PRODUCT_TITLE']) ?? '',
                    'PRODUCT_DESCRIPTION' => $this->clean($data['PRODUCT_DESCRIPTION']) ?? '',
                    'STYLE_NUMBER' => $this->clean($data['STYLE#']) ?? '',
                    'SANMAR_MAINFRAME_COLOR' => $this->clean($data['SANMAR_MAINFRAME_COLOR']) ?? '',
                    'SIZE' => $this->clean($data['SIZE']) ?? '',
                    'COLOR_NAME' => $this->clean($data['COLOR_NAME']) ?? '',
                    'PIECE_PRICE' => floatval($this->clean($data['PIECE_PRICE']) ?? 0),
                ]
            );
        }
        $this->fileModel->update(['status' => 'completed']);
    }
}
