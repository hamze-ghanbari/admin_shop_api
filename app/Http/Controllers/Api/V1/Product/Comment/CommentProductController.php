<?php

namespace App\Http\Controllers\Api\V1\Product\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Comment;
use App\Models\Product;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;

class CommentProductController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public CommentProductService $commentProductService,
        public PolicyService         $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:commentProduct,5')->only('store', 'update', 'status', 'approved', 'answer');
    }

    public function index(Product $product)
    {
        if (!$this->policyService->authorize(['admin'], ['read-comment-product']))
            return $this->forbiddenResponse();

        return new CommentCollection($this->commentProductService->getAllCommentsProduct($product));
    }

    public function store(CommentRequest $request, Product $product)
    {
        if (!$this->policyService->authorize(['admin'], ['create-comment-product']))
            return $this->forbiddenResponse();

        $this->commentProductService->addCommentToProduct($request, $product);
        return $this->apiResponse(null);
    }

    public function update(CommentRequest $request, Product $product, Comment $comment)
    {
        if (!$this->policyService->authorize(['admin'], ['update-comment-product']))
            return $this->forbiddenResponse();

        $this->commentProductService->updateComment($request, $comment->id);
        return $this->apiResponse(null);

    }

    public function show(Product $product, Comment $comment)
    {
        if (!$this->policyService->authorize(['admin'], ['read-comment-product']))
            return $this->forbiddenResponse();

        return $this->apiResponse(new CommentResource($comment));

    }

    public function status(Product $product, Comment $comment, $status){
        if (!$this->policyService->authorize(['admin'], ['update-comment-product']))
            return $this->forbiddenResponse();

        $updated = $this->commentProductService->updateCommentStatus($status, $comment->id);
        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش وضعیت نظر');
        }
    }
    public function approved(Product $product, Comment $comment, $approved){
        if (!$this->policyService->authorize(['admin'], ['update-comment-product']))
            return $this->forbiddenResponse();

        $updated = $this->commentProductService->updateCommentApproved($approved, $comment->id);
        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش وضعیت نمایش');
        }
    }
    public function answer(CommentRequest $request, Product $product, Comment $comment){
        if (!$this->policyService->authorize(['admin'], ['create-comment-product']))
            return $this->forbiddenResponse();
        $this->commentProductService->answerComment($request, $product, $comment->id);
        return $this->apiResponse(null);
    }

    public function destroy(Product $product, Comment $comment)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-comment-product']))
            return $this->forbiddenResponse();

        $commentDelete = $this->commentProductService->deleteComment($comment->id);

        return $this->apiResponse(null, hasError: !(bool)$commentDelete);
    }

}
