<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index');
    }

    public function memberPaymentReport(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];


        $records = User::role('member')->with('roles')->active()->verify()->approve()->with(['payment_collect' => function ($query) {
            $query->where('status', 'success');
        }])->with(['player' => function ($query1) {
            $query1->where('status', 'success');
        }])->with(['team_payment' => function ($query2) {
            $query2->where('status', 'success');
        }])->with(['event_payment' => function ($query2) {
            $query2->where('status', 'success')->where('payment_for', 'purchase_team');;
        }])->withCount(['event_payment as total_participant_amount' => function ($query) {
            $query->select(DB::raw('sum(amount)'))
                ->where('status', 'success');
        }]);

        $totalRecords = $records->get()->count();
        $type = $request->input('type');

        $totalRecordswithFilter = $records->get()->count();

        if (isset($request->date_range)) {
            $date_range_array = explode('-', $request->date_range);
            $from_date = date('Y-m-d', strtotime(trim($date_range_array[0])));
            $to_date = date('Y-m-d', strtotime(trim($date_range_array[1])));
        }

        if (isset($request->date_range)) {
            $records = $records->whereBetween(DB::raw('date(created_at)'), [$from_date, $to_date]);
        }
        if ($searchValue) {
            $records = $records->where(function ($query) use ($searchValue) {
                $query->where('first_name', 'LIKE', '%' . $searchValue . '%')->orWhere('last_name', 'LIKE', '%' . $searchValue . '%')->orWhere('email', 'LIKE', '%' . $searchValue . '%')->orWhere('phone', 'LIKE', '%' . $searchValue . '%')
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $searchValue . '%'])->orWhere('created_at', 'LIKE', '%' . $searchValue . '%')
                    ->orWhereHas('payment_collect', function ($q) use ($searchValue) {
                        $q->where('expired_date', 'LIKE', '%' . $searchValue . '%')->orWhere('amount', 'LIKE', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('team_payment', function ($q) use ($searchValue) {
                        $q->where('amount', 'LIKE', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('player', function ($q) use ($searchValue) {
                        $q->where('amount', 'LIKE', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('event_payment', function ($q) use ($searchValue) {
                        $q->where('amount', 'LIKE', '%' . $searchValue . '%');
                    });
            });
        }

        $records = $records
            ->orderBy('id', 'DESC')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        foreach (@$records as $rData) {
            $createdAt = \Carbon\Carbon::parse($rData->created_at);
            $rData->created_at_formate = $createdAt->format('Y-m-d');
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $records
        );

        return response()->json($response);
    }
}
