<?php

namespace App\Http\Controllers\Api\V1\Product\Comment;

use App\Http\Requests\CommentRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Product;
use App\Repository\Contracts\CommentProductRepositoryInterface;

class CommentProductService
{

    public function __construct(
        public CommentProductRepositoryInterface $commentProductRepository,
        public CacheApiService                $cacheApiService
    )
    {
    }

    public function getAllCommentsProduct(Product $product)
    {
        if ($this->cacheApiService->useCache('comment')) {
            return $this->cacheApiService->cacheApi('comment', $product->comments()->paginate());
        }
        return $product->comments()->paginate();
    }

    public function addCommentToProduct(CommentRequest $request, $product)
    {
        $product->comments()->create($request->fields());
    }

    public function updateComment(CommentRequest $request, $commentId)
    {
        return $this->commentProductRepository->update($request->fields(), $commentId);
    }

    public function updateCommentStatus($status, $commentId){
        return $this->commentProductRepository->update([
            'status' => (bool)$status
        ], $commentId);
    }

    public function updateCommentApproved($approved, $commentId){
        return $this->commentProductRepository->update([
            'approved' => (bool)$approved
        ], $commentId);
    }

    public function answerComment(CommentRequest $request, $product, $parentId){
        $product->comments()->create($request->fields(attributes:[
            'parent_id' => $parentId
        ]));
    }

    public function deleteComment($commentId)
    {
         return $this->commentProductRepository->find($commentId)->delete();
    }
}
