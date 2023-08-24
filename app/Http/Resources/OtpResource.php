<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OtpResource extends JsonResource
{

//    public $preserveKeys = true;
//    public static $wrap = 'result';


    public function toArray(Request $request): array
    {
        return [
                'hasError' => false
//            'id' => $this->id,
//            'token' => $this->when(isset($this->token), $this->token),
//            'otp_code' => $this->whenHas('otp_code'),
//            'login_id' => $this->whenNotNull($this->login_id),
////            'posts' => PostResource::collection($this->whenLoaded('posts')),
////            'posts_count' => $this->whenCounted('posts'),
//            $this->mergeWhen($this->type === 0 && $this->status === 0, [
//                'type' => $this->type,
//                'status' => $this->status
//            ])
        ];
    }


}
