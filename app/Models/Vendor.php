<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['nama_vendor', 'alamat', 'kontak'];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
