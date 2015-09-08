<?php namespace App\Http\Controllers;

use App\Models\Mailinglist;
use App\Models\UserPricelist;
use App\Models\Order;

class ReportController extends Controller
{
    public function getIndex()
    {
        return \View::make('pages/404');
    }

    public function postMailinglist()
    {
        $input_start_date = \Input::get('start_date');
        if ($input_start_date == "") {
            $input_start_date = "01/01/1900";
        }
        $start_date = \DateTime::createFromFormat('d/m/Y', $input_start_date);

        $input_end_date = \Input::get('end_date');

        if ($input_end_date == "") {
            $end_date = new \DateTime("NOW");
        } else {
            $end_date = \DateTime::createFromFormat('d/m/Y', $input_end_date);
        }

        $data = Mailinglist::where('updated_at', '>=', $start_date)
            ->where('updated_at', '<=', $end_date)
            ->orderBy('email')
            ->get();

        if (count($data) == 0) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('downloadError', "There's no data within the dates specified.");
            return \Redirect::to('admin/mailinglists')->withErrors($errors);
        }

        \Excel::create('Redmin_Mailinglist_Report', function($excel) use ($data) {

            $excel->sheet('Mailinglist Report', function($sheet) use ($data) {

                $sheet->loadView('reports/mailinglist')->with('data', $data);

            });

        })->download('csv');
    }

    public function postPurchases()
    {
        $input_start_date = \Input::get('start_date');
        if ($input_start_date == "") {
            $input_start_date = "01/01/1900";
        }
        $start_date = \DateTime::createFromFormat('d/m/Y', $input_start_date);

        $input_end_date = \Input::get('end_date');

        if ($input_end_date == "") {
            $end_date = new \DateTime("NOW");
        } else {
            $end_date = \DateTime::createFromFormat('d/m/Y', $input_end_date);
        }

        $data = UserPricelist::where('created_at', '>=', $start_date)
            ->where('created_at', '<=', $end_date)
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($data) == 0) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('downloadError', "There's no data within the dates specified.");
            return \Redirect::to('admin/purchases')->withErrors($errors);
        }

        \Excel::create('Redmin_Purchases_Report', function($excel) use ($data) {

            $excel->sheet('Purchases Report', function($sheet) use ($data) {

                $sheet->loadView('reports/purchases')->with('data', $data);

            });

        })->download('csv');
    }
    
    public function postOrders()
    {
        $input_start_date = \Input::get('start_date');
        if ($input_start_date == "") {
            $input_start_date = "01/01/1900";
        }
        $start_date = \DateTime::createFromFormat('d/m/Y', $input_start_date);

        $input_end_date = \Input::get('end_date');

        if ($input_end_date == "") {
            $end_date = new \DateTime("NOW");
        } else {
            $end_date = \DateTime::createFromFormat('d/m/Y', $input_end_date);
        }

        $data = Order::where('created_at', '>=', $start_date)
            ->where('created_at', '<=', $end_date)
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($data) == 0) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('downloadError', "There's no data within the dates specified.");
            return \Redirect::to('admin/orders')->withErrors($errors);
        }

        \Excel::create('Redmin_Orders_Report', function($excel) use ($data) {

            $excel->sheet('Orders Report', function($sheet) use ($data) {

                $sheet->loadView('reports/orders')->with('data', $data);

            });

        })->download('csv');
    }
}
