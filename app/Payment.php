<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = ['user_id', 'expires_at', 'clp_usd', 'status', 'payment_date'];
    protected $primaryKey = "uuid";
    public $timestamps = false;
    protected static function boot(){
        parent::boot();

        static::creating(function ($payment) {
            $payment->uuid = (string) Str::uuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function client(){
        return $this->belongsTo('App\Client', 'user_id');
    }
}
