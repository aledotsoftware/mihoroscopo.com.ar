<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_log_id',
        'url',
        'clicked_at',
        'ip_address',
        'user_agent',
    ];

    public function emailLog()
    {
        return $this->belongsTo(EmailLog::class);
    }
}
