<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use Sortable;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'surname',
        'name',
        'patronymic'
    ];

    public function books()
    {
        return $this->belongsToMany('App\Book');
    }

    public $sortable = [
        'surname'
    ];
}
