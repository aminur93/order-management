<?php

namespace App\Http\Services\Admin;

use App\Helper\GlobalResponse;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function index(Request $request)
    {
        $products = new Product;

        if ($request->has('sortBy') && $request->has('sortDesc'))
        {
            $sortBy = $request->query('sortBy');
            $sortDesc = $request->query('sortDesc') === 'true' ? 'desc' : 'asc';
            $products = $products->orderBy($sortBy, $sortDesc);
        }else{
            $products = $products->latest();
        }

        $searchValue = $request->input('search');
        $itemsPerPage = $request->input('itemsPerPage');
        $defaultItemsPerPage = 10;

        if ($searchValue)
        {
            $products->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            });

            $itemsPerPage = 10;

            if($request->has('itemsPerPage')) {
                $itemsPerPage = $request->get('itemsPerPage');

                return $products->paginate($itemsPerPage, ['*'], $request->get('page'));
            }
        }

        if ($itemsPerPage)
        {
            return $products->paginate($itemsPerPage);
        }

        return $products->paginate($defaultItemsPerPage);
    }

    public function getAllProducts()
    {
        $products = Product::latest()->get();

        return $products;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $product = new Product();

            $product->name = $request->name;
            $product->description = $request->description;
            $product->image = GlobalResponse::uploadImage($request->image, 'product/images');
            $product->price = $request->price;

            $product->save();

            DB::commit();

            return $product;

        }catch (\Throwable $th){

            DB::rollBack();

            throw $th;
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return $product;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $product = Product::findOrFail($id);

            // Update the product fields
            $product->name = $request->name;
            $product->description = $request->description;

            // Check if a new image is provided
            if ($request->hasFile('image')) {
                // Optionally, delete the old image from the server
                if ($product->image) {
                    GlobalResponse::deleteImage($product->image);
                }

                // Upload the new image
                $product->image = GlobalResponse::uploadImage($request->file('image'), 'product/images');
            }

            // Update the price
            $product->price = $request->price;

            // Save the updated product
            $product->save();

            DB::commit();

            return $product;

        }catch (\Throwable $th){

            DB::rollBack();

            throw $th;
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);


        if ($product->image) {
            GlobalResponse::deleteImage($product->image);
        }


        $product->delete();

        return $product;
    }
}
