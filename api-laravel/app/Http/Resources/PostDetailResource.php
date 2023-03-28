<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'author' => $this->author,
            'created_at' => date('d-m-Y H:i:s', strtotime($this->created_at)),
            /*whenLoaded() merupakan eager loading yang digunakan untuk mengatur apakah data di relasi atau tidak
            jika data di relasi maka akan ditampilkan dengan with() jika tidak maka tidak akan ditampilkan*/
            'penulis' => $this->whenLoaded('user'),
        ];
    }
}
