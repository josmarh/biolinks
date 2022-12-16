<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginHistory;
use App\Http\Resources\LoginHistoryResource;

class LogsController extends Controller
{
    public function getLoginHistory(Request $request)
    {
        $email = $request->query('email');

        if(isset($email)) {
            $logs = LoginHistory::where('email', 'like', '%'.$email.'%')
                ->orderBy('id', 'desc')
                ->paginate(15)
                ->withQueryString();
        }else {
            $logs = LoginHistory::orderBy('id', 'desc')
                ->paginate(15);
        }

        return LoginHistoryResource::collection($logs);
    }
}
