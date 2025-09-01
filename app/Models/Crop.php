<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'type', 'quantity'];

    public function farmer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
