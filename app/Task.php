<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // fillableにstatus追加
    protected $fillable = ['content', 'status'];

    /**
     * このタスクを所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        // タスクが所属するユーザ
        return $this->belongsTo(User::class);
    }
}
