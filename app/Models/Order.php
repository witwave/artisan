<?php namespace App\Models;

use DateTime, Exception;
use Illuminate\Database\Eloquent\Model;

/* Columns
 *
 * id           (increment)
 * user_id      (integer, unsigned)
 * paid         (decimal, 8, 2, default 0)
 * transaction_id (string, default 'Unknown', nullable)
 * payment_status (string, default 'Completed', nullable)
 * options      (text, nullable)
 * created_at   (dateTime)
 * updated_at   (dateTime)
 *
 */

class Order extends Model
{
    protected $table = 'orders';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function products()
    {
        //return $this->belongsToMany('App\Models\OrderProduct', 'order_product')->pluck('order_product.price', 'order_product.price as product_price');
        return $this->hasMany('App\Models\OrderProduct','order_id','id');
    }

    // public function bundles()
    // {
    //     return $this->belongsToMany('App\Models\Bundle', 'bundle_order');
    // }
    //
    // public function coupons()
    // {
    //     return $this->belongsToMany('App\Models\Coupon', 'coupon_order');
    // }

    public function delete()
    {
        // Remove product association
        $this->products()->detach();
        // $this->bundles()->detach();
        // $this->coupons()->detach();

        return parent::delete();
    }

    /*
     * Return the sum of all products and bundles prices.
     *
     * @return Float
     */
    public function getTotalprice()
    {
        $totalprice = 0;
        // $totalprice += $this->bundles()->sum('price');
      //  $totalprice += $this->products()->sum('price');
      //  return $totalprice;
      return $this->product_total_price;
    }



}
