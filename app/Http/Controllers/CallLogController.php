<?php

namespace App\Http\Controllers;

use App\Models\PhoneCallLog;
use Illuminate\Http\Request;

class CallLogController extends Controller
{
    public function index()
    {
        $data = PhoneCallLog::latest()->paginate(20);
        return $data;
    }
}
