<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplySupport extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;
    public $keyType = 'uuid';

    protected $fillable = ['description', 'support_id', 'user_id'];

    protected $touches = ['support']; // Atualiza os timestamps sempre que houver alguma alteração

    public function support()
    {
        return $this->belongsTo(Support::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
