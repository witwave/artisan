<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    protected $table = 'category_attributes';
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    
}
