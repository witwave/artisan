<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*  Columns:
***********************
    id          (increment)
    code        (string)
    description (text, nullable)
    amount      (float)
    is_percent  (boolean, default: false)
    start_date  (dateTime, nullable)
    end_date    (dateTime)
    created_at  (dateTime)
    updated_at  (dateTime)
    max_spent   (float, nullable)
    min_spent   (float, nullable)
    usage_limit_per_coupon  (integer, unsigned, nullable)
    usage_limit_per_user    (integer, unsigned, nullable)
    multiple_coupons        (boolean, default: false)
    exclude_sale_item       (boolean, default: false)
    usage_limit_per_coupon_count    (integer, unsigned, default: 0)
***********************/
class Coupon extends Model
{
    protected $table = 'coupons';
    
    public function pricelists()
    {
        return $this->belongsToMany('App\Models\Pricelist', 'coupon_pricelist');
    }
    
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'coupon_product');
    }
    
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'coupon_category');
    }
    
    public function bundles()
    {
        return $this->belongsToMany('App\Models\Bundle', 'bundle_coupon');
    }
    
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'coupon_order');
    }
    
    public function delete()
    {
        // Remove all relationships
        $this->pricelists()->detach();
        $this->products()->detach();
        $this->categories()->detach();
        $this->orders()->detach();
        $this->bundles()->detach();
        
        return parent::delete();
    }
}
