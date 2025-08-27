<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    use HasFactory;
    protected $fillable = ['invoice_id','paid_at','method','reference','amount','note'];
    protected $casts = ['paid_at' => 'datetime'];
    public function invoice(){ return $this->belongsTo(Invoice::class); }
}
