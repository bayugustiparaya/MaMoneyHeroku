<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyVoucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'voucher_id', 'voucher_name', 'kode', 'image',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
