<?php namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Bundle;
use App\Models\Coupon;

class OrderController extends Controller
{
    public function getIndex()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(20);

        return view('orders/view')->with('orders', $orders);
    }

    public function getDetail($id)
    {
        $order=Order::where('out_order_id','=',$id)->first();
        return view('orders/detail')->with('order', $order);
    }

    public function getEmails()
    {
        $emails = User::lists('email');

        return \Response::json($emails);
    }

    public function getCreate()
    {
        $products = Product::orderBy('name')->lists('name', 'id');
        $bundles = Bundle::orderBy('name')->lists('name', 'id');
        $coupons = Coupon::orderBy('code')->lists('code', 'id');

        $payment_statuses = array(
            'Completed'     => 'Completed',
            'Pending'       => 'Pending',
            'In Progress'   => 'In Progress',
            'Canceled'      => 'Canceled',
            'Refunded'      => 'Refunded'
        );

        return view('orders/create')
            ->with('products', $products)
            ->with('bundles', $bundles)
            ->with('coupons', $coupons)
            ->with('payment_statuses', $payment_statuses);
    }

    public function getEdit($sid = null)
    {
        $sid = null;
        $errors = new \Illuminate\Support\MessageBag;
        $errors->add(
            'editError',
            "The edit function has been disabled for all orders."
        );
        return redirect('/admin/orders')->withErrors($errors);
    }

    public function postStore()
    {
        $sid = \Input::get('id');

        $rules = array(
            'product_id'        => 'required_without:bundle_id',
            'bundle_id'         => 'required_without:product_id',
            'transaction_id'    => 'required',
            'payment_status'    => 'required',
            'paid'              => 'numeric',
            'email'             => 'required|email'
        );

        $validation = \Validator::make(\Input::all(), $rules);

        $redirect_url = (isset($sid)) ? 'admin/orders/edit/' . $sid : 'admin/orders/create';

        if ($validation->fails()) {
            return redirect($redirect_url)->withErrors($validation)->withInput();
        }

        $transaction_id = \Input::get('transaction_id');
        $payment_status = \Input::get('payment_status');
        $paid           = \Input::get('paid');
        $email          = \Input::get('email');

        $apply_to_models = array();

        // Save products to order
        $products = \Input::get('product_id');
        if (count($products) > 0) {
            foreach ($products as $item) {
                $model = Product::find($item);
                if ($model != null) {
                    $apply_to_models[] = $model;
                }
            }
        }
        // Save bundles to order
        $bundles = \Input::get('bundle_id');
        if (count($bundles) > 0) {
            foreach ($bundles as $item) {
                $model = Bundle::find($item);
                if ($model != null) {
                    $apply_to_models[] = $model;
                }
            }
        }

        // No product/bundle to add
        if (count($apply_to_models) == 0) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('productError', "The items selected may have been deleted. Please try again.");
            return redirect($redirect_url)->withErrors($errors)->withInput();
        }

        $user = User::where('email', $email)->first();

        if ($user == null) {
            // No such user
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('userError', "The user may have been deleted. Please try again.");
            return redirect($redirect_url)->withErrors($errors)->withInput();
        }

        $new_order = new Order;
        $new_order->user_id = $user->id;
        $new_order->paid = $paid;
        $new_order->transaction_id = $transaction_id;
        $new_order->payment_status = $payment_status;
        $new_order->save();

        // Save the products/bundles
        foreach ($apply_to_models as $apply_to_model) {
            $apply_to_model->orders()->save($new_order);
        }

        // Save coupons to order
        $coupons = \Input::get('coupon_id');
        if (count($coupons) > 0) {
            $errors = new \Illuminate\Support\MessageBag;
            foreach ($coupons as $item) {
                $model = Coupon::find($item);
                if ($model != null) {
                    try {
                        $new_order->addCoupon($model);
                    } catch (Exception $exp) {
                        $errors->add('couponError',
                            "Coupon " . $model->code . " cannot be added because: " . $exp->getMessage()
                        );

                    }
                }
            }

            // Set coupon discount
            $new_order->setDiscounts();

            if (count($errors) > 0) {
                return redirect('admin/orders')->withErrors($errors);
            }
        }

        return redirect('admin/orders');
    }

    public function getDelete($sid)
    {
        $order = Order::find($sid);

        if ($order == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('userError', "The order record may have already been deleted.");
            return redirect('admin/orders')->withErrors($errors);
        }

        $order->delete();

        return redirect('admin/orders');
    }
}
