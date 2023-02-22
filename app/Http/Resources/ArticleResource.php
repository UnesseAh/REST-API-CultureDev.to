<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
           
            'title'=>$this->title,
            'description'=>$this->description,
            'content'=>$this->content,
            'category'=>$this->categorie,

            'category_id'=>$this->category_id,


            
            // 'category'=>$this->categorie->category ?? null,
            // 'tag'=>$this->tags->tag,
            // 'comment'=>$this->comments->comment,
            // 'user'=>$this->user->name

        ];
    }
}
