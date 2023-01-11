<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCoupon;
use App\Http\Resources\ProductCouponResource;

class ProductCouponController extends Controller
{
    public function index($projectId)
    {
        $coupons = ProductCoupon::where('project_id', $projectId)
            ->orderBy('id', 'desc')
            ->paginate(15);

        return ProductCouponResource::collection($coupons);
    }

    public function store(Request $request)
    {
        $coupon = ProductCoupon::create([
            'project_id' => $request->projectId,
            'coupon_code' => $request->couponCode,
            'apply_to' => $request->applyTo,
            'discount' => $request->discount,
            'coupon_limit_type' => $request->couponLimitType,
            'coupon_limited_count' => $request->couponLimitedCount,
            'limit_per_customer' => $request->limitPerCustomer,
            'is_expires' => $request->isExpires,
            'expiry_date' => $request->expiryDate
        ]);

        return response([
            'message' => 'Coupon created.',
            'couponId' => $coupon->id,
            'status_code' => 201
        ], 201);
    }

    public function show($id)
    {
        $coupon = ProductCoupon::findOrFail($id);

        return new ProductCouponResource($coupon);
    }

    public function update(Request $request, $id)
    {
        $coupon = ProductCoupon::findOrFail($id);

        $coupon->update([
            'coupon_code' => $request->couponCode,
            'apply_to' => $request->applyTo,
            'discount' => $request->discount,
            'coupon_limit_type' => $request->couponLimitType,
            'coupon_limited_count' => $request->couponLimitedCount,
            'limit_per_customer' => $request->limitPerCustomer,
            'is_expires' => $request->isExpires,
            'expiry_date' => $request->expiryDate
        ]);

        return response([
            'message' => 'Coupon updated.',
            'coupon' => new ProductCouponResource($coupon),
            'status_code' => 201
        ], 201);
    }

    public function destroy($id)
    {
        $coupon = ProductCoupon::findOrFail($id);

        $coupon->delete();

        return response([
            'message' => 'Coupon deleted.',
            'status_code' => 204
        ]);
    }
}
