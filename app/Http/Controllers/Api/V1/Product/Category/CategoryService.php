<?php

namespace App\Http\Controllers\Api\V1\Product\Category;

use App\Http\Requests\CategoryRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\UploadService\Algoritms\Base64FIle;
use App\Http\Services\UploadService\UploadService;
use App\Models\CategoryProduct;
use App\Repository\Contracts\CategoryRepositoryInterface;

class CategoryService
{

    public function __construct(
        public ImageService                $imageService,
        public CategoryRepositoryInterface $categoryRepository,
        public CacheApiService $cacheApiService
    )
    {
    }

    public function getAllCategories()
    {
        if($this->cacheApiService->useCache('categories')){
            return $this->cacheApiService->cacheApi('categories', $this->categoryRepository->with(['parent', 'childrens'])->paginate());
        }
        return $this->categoryRepository->with(['parent', 'childrens'])->paginate();
    }

    public function searchCategory($value){
        return $this->categoryRepository->getCategorySearch($value);
    }

    public function categoryExists(string $name)
    {
        return $this->categoryRepository->getCategoryWithTrashed($name);
    }

    public function createCategory(CategoryRequest $request, $image)
    {
        $this->categoryRepository->create($request->fields(attributes: [
            'slug' => $request->fields()['name'],
            'image' => $image
        ]));
    }

    public function updateCategory(CategoryRequest $request, $categoryId, $imageUrl)
    {
        return $this->categoryRepository->update($request->fields(attributes: [
            'slug' => $request->fields()['name'],
            'image' => $imageUrl
        ]), $categoryId);
    }

    public function updateCategoryStatus(CategoryProduct $category, $status)
    {
        return $this->categoryRepository->update([
            'show_in_menu' => (bool)$status
        ], $category->id);
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }

    public function uploadImage($image)
    {
        $this->imageService->setExclusiveDirectory('uploads' . DIRECTORY_SEPARATOR . 'category_products');

        $file = new Base64File($this->imageService, $image);
        $upload = new UploadService($file);
        $imageAddress = $upload->upload();

        return $imageAddress ?? false;
    }

}
