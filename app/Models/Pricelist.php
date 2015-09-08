<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*  Columns:
 * id (integer)
 * price (decimal, 8, 2, default 0)
 * module_id (integer)
 * membership_id (integer)
 * module_id, membership_id (unique)
 * active (bool)
 * created_at (date)
 * updated_at (date)
 */

class Pricelist extends Model
{
    protected $table = 'pricelists';
    
    public function module()
    {
        return $this->belongsTo('App\Models\Module');
    }

    public function membership()
    {
        return $this->belongsTo('App\Models\Membership');
    }
    
    public function coupons()
    {
        return $this->belongsToMany('App\Models\Coupon', 'coupon_pricelist');
    }
    
    public function bundles()
    {
        return $this->belongsToMany('App\Models\Bundle', 'bundle_pricelist');
    }
    
    public function delete()
    {
        // Remove all relationships
        $this->coupons()->detach();
        $this->bundles()->detach();
        
        return parent::delete();
    }
}
