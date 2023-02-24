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
        $commentNames = $this->comments->map(function ($comment) {
            return $comment->comment;
        });
        $tagNames = $this->tags->map(function ($tag) {
            return $tag->tag;
        });

        return [
            'title'=>$this->title,
            'description'=>$this->description,
            'content'=>$this->content,
            'category'=>$this->category->category ?? null,
            'tag'=>$tagNames,
            'comment' => $commentNames,
            // 'comment' =>$this->comments->comment,
            'category_id'=>$this->category_id,
           
            


            
            // 'category'=>$this->categorie->category ?? null,
            // 'tag'=>$this->tags->tag,
            // 'comment'=>$this->comments->comment,
            // 'user'=>$this->user->name

        ];
    }
}
