<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "title"=>$this->title,
            'trainer_id'=>$this->trainer_id,
            'user_id'=>$this->user_id,
            'category'=>$this->categories,
            'body'=>$this->body,
            'image'=>'http://127.0.0.1:8090/images/'.$this->image,
            'createdAt' => $this->created_at
        ];
    }
}
