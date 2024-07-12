<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exports\CustomerExport;
use App\Helper\GlobalResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\Admin\CustomerService;
use App\Imports\CustomerImport;
use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(Request $request)
    {
        $pagination = $request->get('pagination', true);

        if ($pagination === true)
        {
            $customers = $this->customerService->index($request);

            return GlobalResponse::success($customers, "All customers fetch successful with pagination", Response::HTTP_OK);
        }

        if ($pagination === 'false')
        {
            $customers = $this->customerService->getAllCustomers();

            return GlobalResponse::success($customers, "All customers fetch successful", Response::HTTP_OK);
        }
    }

    public function store(Request $request)
    {
        try {

            $customer = $this->customerService->store($request);

            return GlobalResponse::success($customer, "Store successful", Response::HTTP_CREATED);

        }catch (ValidationException $exception){

            return GlobalResponse::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (\Exception $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {

            $customer = $this->customerService->show($id);

            return GlobalResponse::success($customer, "Fetch successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }catch (\Exception $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $customer = $this->customerService->update($request, $id);

            return GlobalResponse::success($customer, "Update successful", Response::HTTP_OK);

        }catch (ValidationException $exception){

            return GlobalResponse::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (ModelNotFoundException $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }catch (\Exception $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {

            $customer = $this->customerService->destroy($id);

            return GlobalResponse::success($customer, "Delete successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }catch (\Exception $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new CustomerImport(), $file);

        return GlobalResponse::success('', "Import successful", Response::HTTP_OK);
    }

    public function download()
    {
        return Excel::download(new CustomerExport(), 'customers.xlsx');
    }
}
