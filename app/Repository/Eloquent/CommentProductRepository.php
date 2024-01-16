<?php

namespace App\Repository\Eloquent;

use App\Models\Brand;
use App\Models\Comment;
use App\Repository\Contracts\BrandRepositoryInterface;
use App\Repository\Contracts\CommentProductRepositoryInterface;

class CommentProductRepository extends BaseRepository implements CommentProductRepositoryInterface
{
    public function model()
    {
        return Comment::class;
    }

}
