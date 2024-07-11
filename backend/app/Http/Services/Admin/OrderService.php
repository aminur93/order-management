<?php

namespace App\Http\Services\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function index(Request $request)
    {
        $order = Order::with('orderItems', 'customer');

        if ($request->has('sortBy') && $request->has('sortDesc'))
        {
            $sortBy = $request->query('sortBy');
            $sortDesc = $request->query('sortDesc') === 'true' ? 'desc' : 'asc';
            $order = $order->orderBy($sortBy, $sortDesc);
        }else{
            $order = $order->latest();
        }

        $searchValue = $request->input('search');
        $itemsPerPage = $request->input('itemsPerPage');
        $defaultItemsPerPage = 10;

        if ($searchValue)
        {
            $order->whereHas('customers', function ($query) use ($searchValue) {
                $query->where('first_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%');
            });

            $itemsPerPage = 10;

            if($request->has('itemsPerPage')) {
                $itemsPerPage = $request->get('itemsPerPage');

                return $order->paginate($itemsPerPage, ['*'], $request->get('page'));
            }
        }

        if ($itemsPerPage)
        {
            return $order->paginate($itemsPerPage);
        }

        return $order->paginate($defaultItemsPerPage);
    }

    public function getAllOrders()
    {
        $orders = Order::with('orderItems', 'customers')->get();
        return $orders;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $order = new Order();

            $order->customer_id = $request->customer_id;
            $order->total_amount = $request->total_amount;
            $order->status = $request->status;
            $order->save();

            $order->orderItems()->createMany($request->orderItems);

            DB::commit();

            return $order;

        }catch (\Throwable $th){

            DB::rollBack();

            throw $th;
        }
    }

    public function show($id)
    {
        $order = Order::with('orderItems', 'customer')->find($id);
        return $order;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $order = Order::find($id);

            $order->customer_id = $request->customer_id;
            $order->total_amount = $request->total_amount;
            $order->status = $request->status;
            $order->save();

            $order->orderItems()->delete();
            $order->orderItems()->createMany($request->orderItems);

            DB::commit();

            return $order;

        }catch (\Throwable $th){
            DB::rollBack();

            throw $th;
        }
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        $order->orderItems()->delete();

        $order->delete();

        return $order;
    }
}
