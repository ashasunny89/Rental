<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Userprofile;
use App\Models\payment_tb;

class ReportController extends Controller
{
    public function PaymentReport()
    {
        return view('pages.reports.payment');
    }

    public function UserReport()
    {
        return view('pages.reports.user');
    }
    
    
    // public function district_wise(Request $request)
    // {
    //      $start_date = $request->created_at;
    //     $end_date = $request->created_at;

    //         $dist = DB::table('user_profile')
    //         // ->where('created_at', '>=', $start_date)
    //         // ->where('created_at', '<=', $end_date)
    //         ->join('payment_tb', 'user_profile.user_name', '=', 'payment_tb.phone')
    //         ->select('user_profile.district', DB::raw('SUM(payment_tb.amount)as total_amount'))
    //         // ->whereBetween('payment_tb.created_at', ['start_date', 'end_date' ])
    //         ->groupBy('user_profile.district')
    //         ->get();
            
    //         return view('pages.reports.payment', compact('dist'));
    //     }

    public function district_wise(Request $request)
{
    // Get the start and end dates from the request
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    // Retrieve the district-wise payment information within the specified date range
    $districts = DB::table('user_profile')
        ->join('payment_tb', 'user_profile.user_name', '=', 'payment_tb.phone')
        ->select('user_profile.district', DB::raw('SUM(payment_tb.amount) as total_amount'))
        ->whereBetween('user_profile.created_at', [$start_date, $end_date])
        ->groupBy('user_profile.district')
        ->get();

    return view('pages.reports.payment', compact('districts'));
}

// public function district_wise(Request $request)
// {
//     $start_date = $request->input('start_date');
//     $end_date = $request->input('end_date');

//     $districts = UserProfile::whereBetween('created_at', [$start_date, $end_date])
//         ->select('district', DB::raw('SUM(payment) as total_amount'))
//         ->groupBy('district')
//         ->get();

//     return view('reports.payment', ['districts' => $districts]);
// }

    // public function user_wise(Request $request)
    // {
    //         $results = DB::table('user_profile')
    //         ->join('payment_tb', 'user_profile.user_name', '=', 'payment_tb.phone')
    //         ->select('user_profile.user_name', DB::raw('SUM(payment_tb.amount)as total_amount'))
    //         // ->whereBetween('payment_tb.created_at', ['start_date', 'end_date' ])
    //         ->groupBy('user_profile.user_name')
    //         ->orderBy('total_amount', 'results')
    //         ->get();
            
    //         return view('pages.reports.payment', compact('results'));
    //     }

        // public function user_wise(Request $request)
        // {
        //     $results = DB::table('user_profile')
        //     ->join('payment_tb', 'user_profile.user_name', '=', 'payment_tb.phone')
        //     ->select('user_profile.user_name', DB::raw('SUM(payment_tb.amount) as total_amount'))
        //     ->groupBy('user_profile.user_name')
        //     ->orderBy('total_amount', 'desc')
        //     ->get();

        //     // // Loop through the results and display them
        //     foreach ($results as $row) {
        //         // echo "Name: " . $result->name . "<br>";
        //         echo "User Name: " . $row->user_name . "<br>";
        //         // echo "District: " . $result->district . "<br>";
        //         echo "Total Payment: $" . $row->total_amount . "<br>";
        //         echo "<br>";
        //     // }
        // }
        public function user_wise()
        {
            // Retrieve the user-wise payment information
            $results = DB::table('user_profile')
                ->join('payment_tb', 'user_profile.user_name', '=', 'payment_tb.phone')
                ->select('user_profile.user_name', DB::raw('SUM(payment_tb.amount) as total_amount'))
                ->groupBy('user_profile.user_name')
                ->orderBy('total_amount', 'desc')
                ->get();

            return view('pages.reports.user', compact('results'));
        }
}