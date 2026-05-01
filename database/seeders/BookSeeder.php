<?php
// filepath: database/seeders/BookSeeder.php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    private const CATEGORY_POOL = [
        ['name' => 'Trending', 'slug' => 'trending'],
        ['name' => 'New Arrivals', 'slug' => 'new-arrivals'],
        ['name' => 'Comming Soon', 'slug' => 'comming-soon'],
        ['name' => 'Sale', 'slug' => 'sale']
    ];

    public function run(): void
    {
        $booksPath = database_path('seeders/books.json');
        $bookSeeds = json_decode(file_get_contents($booksPath), true, 512, JSON_THROW_ON_ERROR);

        DB::transaction(function () use ($bookSeeds): void {
            Book::query()->delete();
            Author::query()->delete();
            Category::query()->delete();
            Publisher::query()->delete();

            foreach ($bookSeeds as $seed) {
                $publisherData = $seed['publisher'] ?? [];
                $publisher = null;

                if (! empty($publisherData['name'])) {
                    $publisher = Publisher::firstOrCreate(
                        ['name' => $publisherData['name']],
                        ['website' => $publisherData['website'] ?? null]
                    );
                }

                $authorIds = collect($seed['authors'] ?? [])
                    ->filter(fn (array $author) => ! empty($author['full_name']))
                    ->map(fn (array $author) => Author::firstOrCreate(['full_name' => $author['full_name']])->id)
                    ->all();

                $categoryIds = collect(self::CATEGORY_POOL)
                    ->shuffle()
                    ->take(random_int(1, 3))
                    ->map(function (array $category) {
                        return Category::firstOrCreate(
                            ['slug' => $category['slug']],
                            ['name' => $category['name']]
                        )->id;
                    })
                    ->all();

                $book = Book::create([
                    'isbn' => $seed['isbn'],
                    'title' => $seed['title'],
                    'description' => $seed['description'] ?? null,
                    'genre' => $seed['genre'] ?? null,
                    'price' => $seed['price'],
                    'discount' => random_int(5, 35),
                    'publication_date' => $seed['publication_date'] ?? null,
                    'language' => $seed['language'] ?? null,
                    'pages' => $seed['pages'] ?? null,
                    'publisher_id' => $publisher?->id,
                    'stock' => random_int(5, 20),
                    'cover_image_url' => $seed['cover_image_url'] ?? null,
                ]);

                $book->authors()->sync($authorIds);
                $book->categories()->sync($categoryIds);
            }
        });
    }
}