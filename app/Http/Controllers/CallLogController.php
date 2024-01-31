<?php

namespace App\Http\Controllers;

use App\Models\PhoneCallLog;
use Illuminate\Http\Request;

class CallLogController extends Controller
{
    public function index(Request $request)
    {
        $query = PhoneCallLog::query();

     if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('call_date', [$request->start_date, $request->end_date]);
    }

    $phoneLogs = $query->paginate(25);
    $phoneCount = $query->selectRaw("DATE_FORMAT(call_date, '%Y-%m-%d') as date, COUNT(DISTINCT phone_number) as phone_count")
        ->groupBy('date')
        ->paginate(500);

    return response()->json([
        'phoneLogs' => $phoneLogs,
        'phoneCount' => $phoneCount,
    ]);
    }
}
