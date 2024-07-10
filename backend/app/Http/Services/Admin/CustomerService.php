<?php

namespace App\Http\Services\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function index(Request $request)
    {
        $customers = new Customer;

        if ($request->has('sortBy') && $request->has('sortDesc'))
        {
            $sortBy = $request->query('sortBy');
            $sortDesc = $request->query('sortDesc') === 'true' ? 'desc' : 'asc';
            $customers = $customers->orderBy($sortBy, $sortDesc);
        }else{
            $customers = $customers->latest();
        }

        $searchValue = $request->input('search');
        $itemsPerPage = $request->input('itemsPerPage');
        $defaultItemsPerPage = 10;

        if ($searchValue)
        {
            $customers->where(function ($query) use ($searchValue) {
                $query->where('first_name', 'like', '%' . $searchValue . '%');
            });

            $itemsPerPage = 10;

            if($request->has('itemsPerPage')) {
                $itemsPerPage = $request->get('itemsPerPage');

                return $customers->paginate($itemsPerPage, ['*'], $request->get('page'));
            }
        }

        if ($itemsPerPage)
        {
            return $customers->paginate($itemsPerPage);
        }

        return $customers->paginate($defaultItemsPerPage);
    }

    public function getAllCustomers()
    {
        $customers = Customer::latest()->get();

        return $customers;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $customer = new Customer();

            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;

            $customer->save();

            DB::commit();

            return $customer;

        }catch (\Throwable $th){

            throw $th;
        }
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return $customer;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $customer = Customer::findOrFail($id);

            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;

            $customer->save();

            DB::commit();

            return $customer;

        }catch (\Throwable $th){

            throw $th;
        }
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return $customer;
    }
}
