<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function index($projectId)
    {
        $orders = Order::where('project_id', $projectId)
            ->orderBy('id','desc')
            ->paginate(15);

        return OrderResource::collection($orders);
    }

    public function subscription($projectId)
    {
        $orders = Order::where('project_id', $projectId)
            ->where('product_source','member_product')
            ->orderBy('id','desc')
            ->paginate(15);

        return OrderResource::collection($orders);
    }
}
