<?php

namespace App\Http\Controllers\Api\V1\Delivery;

use App\Http\Requests\DeliveryRequest;
use App\Http\Resources\DeliveryCollection;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Delivery;
use App\Http\Controllers\Controller;
use App\Traits\Response\ApiResponse;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    use ApiResponse;

    public function __construct(
        public PolicyService $policyService,
        public DeliveryService $deliveryService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:delivery,5')->only('store', 'update', 'changeStatus');
    }

    public function index()
    {
        if (!$this->policyService->authorize(['admin'], ['read-delivery']))
            return $this->forbiddenResponse();

        return new DeliveryCollection($this->deliveryService->getAllDeliverys());
    }
//
//    public function searchDelivery(Request $request)
//    {
//        if (!$this->policyService->authorize(['admin'], ['read-delivery']))
//            return $this->forbiddenResponse();
//
//        return new DeliveryCollection($this->deliveryService->searchDelivery($request->input('search')));
//    }

    public function store(DeliveryRequest $request)
    {
        if (!$this->policyService->authorize(['admin'], ['create-delivery']))
            return $this->forbiddenResponse();

        $this->deliveryService->createDelivery($request);
        return $this->apiResponse(null);
    }

    public function update(DeliveryRequest $request, Delivery $delivery)
    {
        if (!$this->policyService->authorize(['admin'], ['update-delivery']))
            return $this->forbiddenResponse();

        $this->deliveryService->updateDelivery($request, $delivery->id);
        return $this->apiResponse(null);
    }

    public function changeStatus(Delivery $delivery, $status)
    {
        if (!$this->policyService->authorize(['admin'], ['update-delivery']))
            return $this->forbiddenResponse();

        $updated = $this->deliveryService->updateDeliveryStatus($delivery, $status);

        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش وضعیت روش ارسال');
        }
    }

    public function destroy(ImageService $imageService, Delivery $delivery)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-delivery']))
            return $this->forbiddenResponse();

        $deliveryDelete = $this->deliveryService->deleteDelivery($delivery->id);

        return $this->apiResponse(null, hasError: (bool)$deliveryDelete);
    }
}
