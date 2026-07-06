<?php

namespace App\Http\Resources\BookChapter;

use App\Http\Resources\Book\BookResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class BookChapterResource extends SuccessResource
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
            'book_id' => $this->book_id,
            'name' => $this->name,
            'description' => $this->description,
            'book' => new BookResource($this->whenLoaded('book')),
        ];
    }
}
