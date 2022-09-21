<?php

namespace App\ValueObject\Buku;

class BukuValueObject
{
    public ?string $id;
    public ?string $title;
    public ?string $cover_url;
    public ?string $summary;
    public ?int $category;
    public ?string $author;
    public ?int $price;

    public function __construct(?string $id, ?string $title, ?string $cover_url, ?string $summary, ?int $category, ?string $author, ?int $price)
    {
        $this->id = $id;
        $this->title = $title;
        $this->cover_url = $cover_url;
        $this->summary = $summary;
        $this->category = $category;
        $this->author = $author;
        $this->price = $price;
    }
}
