<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

use App\Observers\FileModelObserver;

#[ObservedBy([FileModelObserver::class])]
class FileModel extends Model
{
    use HasFactory;
    protected $fillable = ['file_name', 'file_path', 'status'];

    public function content()
    {
        return $this->hasMany(ContentModel::class);
    }
}
