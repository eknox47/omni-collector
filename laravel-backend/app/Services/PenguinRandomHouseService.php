<?php

namespace App\Services;

class PenguinRandomHouseService
{
    public function mapPrhBook(array $prhBook): array
    {
        $links = collect($prhBook['links'] ?? $prhBook['_links'] ?? []);
        $coverUrl = $links->firstWhere('rel', 'icon')['href'] ?? null;

        $format = $prhBook['format'] ?? [];
        $dimensions = $prhBook['dimensions'] ?? [];
        $price = collect($prhBook['price'] ?? [])->first();

        return [
            'isbn' => $prhBook['isbn'] ?? null,
            'work_id' => $prhBook['workId'] ?? null,
            'asin' => $prhBook['asin'] ?? null,

            'title' => $prhBook['title'],
            'subtitle' => $prhBook['subtitle'] ?? null,
            'author' => $prhBook['author'] ?? null,
            'description' => $prhBook['description'] ?? null,
            'publisher' => $prhBook['publisher']['description'] ?? null,
            'language' => $prhBook['language'] ?? null,
            'published_date' => $prhBook['onsale'] ?? null,
            'page_count' => $prhBook['pages'] ?? null,

            'format_code' => $format['code'] ?? null,
            'format_description' => $format['description'] ?? null,

            'price_amount' => $price['amount'] ?? null,
            'price_currency' => $price['currencyCode'] ?? null,

            'length' => $dimensions['length'] ?? null,
            'width' => $dimensions['width'] ?? null,
            'depth' => $dimensions['depth'] ?? null,
            'gross_weight' => $dimensions['grossWeight'] ?? null,

            'cover_url' => $coverUrl,
        ];
    }
}