<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use Sortable;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image_src',
        'publication_date'
    ];

    public function authors()
    {
        return $this->belongsToMany('App\Author');
    }

    public $sortable = [
        'name'
    ];
}
