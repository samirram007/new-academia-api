<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Subject\SubjectResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class BookResource extends SuccessResource
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
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'subject_id' => $this->subject_id,
            'publication_year' => $this->publication_year,
            'page_count' => $this->page_count,
            'price' => $this->price,
            'published_at' => $this->published_at,
            'publisher' => $this->publisher,
            'author' => $this->author,
            'illustrator' => $this->illustrator,
            'translator' => $this->translator,
            'cover_image_id' => $this->cover_image_id,
            'subject' => new SubjectResource($this->whenLoaded('subject')),
        ];
    }
}
