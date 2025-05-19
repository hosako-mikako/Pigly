<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'weight',
        'calories',
        'exercise_time',
        'exercise_content', 
    ];

    /* 日付として扱う */
    protected $casts = [
        'date' => 'date',
        'exercise_time' => 'datetime',
    ];

    /* この体重記録を所有するユーザーを取得 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
