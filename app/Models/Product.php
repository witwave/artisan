<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\RHelper;

/*  Columns:
***********************
    id                  (increment)
    name                (string, 255)
    sku                 (string, 255)
    short_description   (string, 255)
    long_description    (text, nullable)
    price               (float, 0)
    featured            (boolean, false)
    active              (boolean, true)
    options             (text, nullable)
    category_id         (unsigned, nullable)
    created_at  (dateTime)
    updated_at  (dateTime)
***********************/
class Product extends Model
{
    protected $table = 'products';
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
    
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }
    
    public function coupons()
    {
        return $this->belongsToMany('App\Models\Coupon', 'coupon_product');
    }
    
    public function bundles()
    {
        return $this->belongsToMany('App\Models\Bundle', 'bundle_product');
    }
    
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_product');
    }
    
    public function translations()
    {
        return $this->morphMany('App\Models\Translation', 'translatable');
    }
    
    public function delete()
    {
        // Remove all relationships
        $this->tags()->detach();
        $this->coupons()->detach();
        $this->bundles()->detach();
        $this->orders()->detach();
        
        // Delete all images
        foreach ($this->images as $image) {
            $image->delete();
        }
        
        // Delete all translations
        $this->translations()->delete();
        
        // Delete asset images folder
        $upload_dir = \Config::get('image.upload_dir');
        $deleteFolder = new Image;
        $url_path = RHelper::joinPaths($upload_dir, $this->table, $this->id);
        $deleteFolder->deleteFiles($url_path);
        
        return parent::delete();
    }
}
