<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Requests\DeliveryRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\ImageService\ImageService;
use App\Models\Delivery;
use App\Repository\Contracts\DeliveryRepositoryInterface;

class DeliveryService
{

    public function __construct(
        public ImageService                $imageService,
        public DeliveryRepositoryInterface $deliveryRepository,
        public CacheApiService $cacheApiService
    )
    {
    }

    public function getAllDeliverys()
    {
        if($this->cacheApiService->useCache('deliveries')){
            return $this->cacheApiService->cacheApi('deliveries', $this->deliveryRepository->paginate());
        }
        return $this->deliveryRepository->paginate();
    }

    public function createDelivery(DeliveryRequest $request)
    {
        $this->deliveryRepository->create($request->fields());
    }

    public function updateDelivery(DeliveryRequest $request, $deliveryId)
    {
        return $this->deliveryRepository->update($request->fields(), $deliveryId);
    }

    public function updateDeliveryStatus(Delivery $delivery, $status)
    {
        return $this->deliveryRepository->update([
            'status' => (bool)$status
        ], $delivery->id);
    }

    public function deleteDelivery($id)
    {
        return $this->deliveryRepository->delete($id);
    }

}
