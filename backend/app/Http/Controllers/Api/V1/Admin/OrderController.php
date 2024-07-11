<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Helper\GlobalResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Http\Services\Admin\OrderService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $pagination = $request->get('pagination', true);

        if ($pagination === true)
        {
            $orders = $this->orderService->index($request);

            return GlobalResponse::success($orders, "All orders fetch successful with pagination", Response::HTTP_OK);
        }

        if ($pagination === 'false')
        {
            $orders = $this->orderService->getAllOrders();

            return GlobalResponse::success($orders, "All orders fetch successful", Response::HTTP_OK);
        }
    }

    public function store(OrderRequest $request)
    {
        try {

            $order = $this->orderService->store($request);

            return GlobalResponse::success($order, "Store successful", Response::HTTP_CREATED);

        }catch (ValidationException $exception){

            return GlobalResponse::error($exception->errors(), $exception->getMessage(), $exception->status);

        }catch (\Exception $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {

            $order = $this->orderService->show($id);

            return GlobalResponse::success($order, "Fetch successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }catch (\Exception $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(OrderRequest $request, $id)
    {
        try {

            $customer = $this->orderService->update($request, $id);

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

            $customer = $this->orderService->destroy($id);

            return GlobalResponse::success($customer, "Delete successful", Response::HTTP_OK);

        }catch (ModelNotFoundException $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }catch (\Exception $exception){

            return GlobalResponse::error("", $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
