<?php
// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'deleted',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            $category->deleted = 1;
            $category->save();
            $category->products()->delete();
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
