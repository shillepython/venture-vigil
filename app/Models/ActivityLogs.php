<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'data'];

    protected $casts = [
        'data' => 'array', // Автоматическое преобразование данных в массив
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
