<?php
// filepath: database/seeders/BookSeeder.php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $publisherData = [
            ['name' => 'Tatran Press', 'website' => 'https://tatran.example'],
            ['name' => 'Bratislava Books', 'website' => 'https://bratislavabooks.example'],
            ['name' => 'Eunoia House', 'website' => 'https://eunoia.example'],
            ['name' => 'Danube Publishing', 'website' => 'https://danube.example'],
        ];

        $authorNames = [
            'John Smith',
            'Anna Brown',
            'Peter Novak',
            'Lucia Horvath',
            'Marek Kral',
            'Zuzana Biela',
            'Martin Urban',
            'Katarina Soltes',
            'Tomas Varga',
            'Eva Malinova',
        ];

        $categoryData = [
            ['name' => 'Fiction', 'slug' => 'fiction'],
            ['name' => 'Programming', 'slug' => 'programming'],
            ['name' => 'Business', 'slug' => 'business'],
            ['name' => 'History', 'slug' => 'history'],
            ['name' => 'Self Development', 'slug' => 'self-development'],
            ['name' => 'Science', 'slug' => 'science'],
            ['name' => 'Fantasy', 'slug' => 'fantasy'],
            ['name' => 'Mystery', 'slug' => 'mystery'],
        ];

        $bookSeeds = [
            ['title' => 'The Silent Echo', 'genre' => 'Fiction', 'language' => 'English'],
            ['title' => 'Code Under Pressure', 'genre' => 'Programming', 'language' => 'English'],
            ['title' => 'Bratislava at Dawn', 'genre' => 'Mystery', 'language' => 'Slovak'],
            ['title' => 'Practical Laravel 13', 'genre' => 'Programming', 'language' => 'English'],
            ['title' => 'Danube Legends', 'genre' => 'Fantasy', 'language' => 'Slovak'],
            ['title' => 'The Productive Founder', 'genre' => 'Business', 'language' => 'English'],
            ['title' => 'Atomic Habits for Students', 'genre' => 'Self Development', 'language' => 'English'],
            ['title' => 'Empire of Glass', 'genre' => 'History', 'language' => 'English'],
            ['title' => 'Signals and Systems', 'genre' => 'Science', 'language' => 'English'],
            ['title' => 'Night Train to Kosice', 'genre' => 'Mystery', 'language' => 'Slovak'],
            ['title' => 'Fullstack Patterns', 'genre' => 'Programming', 'language' => 'English'],
            ['title' => 'The Fourth Library', 'genre' => 'Fantasy', 'language' => 'English'],
            ['title' => 'Minimal Mindset', 'genre' => 'Self Development', 'language' => 'English'],
            ['title' => 'History of Central Europe', 'genre' => 'History', 'language' => 'English'],
            ['title' => 'Data Thinking', 'genre' => 'Science', 'language' => 'English'],
            ['title' => 'Mesto bez tieňa', 'genre' => 'Fiction', 'language' => 'Slovak'],
            ['title' => 'Zero Downtime Deployments', 'genre' => 'Programming', 'language' => 'English'],
            ['title' => 'Quiet Leadership', 'genre' => 'Business', 'language' => 'English'],
            ['title' => 'Mysteries of Orava', 'genre' => 'Mystery', 'language' => 'Slovak'],
            ['title' => 'Road to Better Code', 'genre' => 'Programming', 'language' => 'English'],
        ];

        $publishers = collect($publisherData)
            ->map(fn (array $publisher) => Publisher::firstOrCreate(['name' => $publisher['name']], $publisher));

        $authors = collect($authorNames)
            ->map(fn (string $name) => Author::firstOrCreate(['full_name' => $name]));

        $categories = collect($categoryData)
            ->map(fn (array $category) => Category::firstOrCreate(['slug' => $category['slug']], $category));

        foreach ($bookSeeds as $index => $seed) {
            $book = Book::updateOrCreate(
                ['isbn' => '9781234567' . str_pad((string) ($index + 100), 3, '0', STR_PAD_LEFT)],
                [
                    'title' => $seed['title'],
                    'description' => $seed['title'] . ' is a generated sample book for development and testing.',
                    'genre' => $seed['genre'],
                    'price' => random_int(9, 35) + 0.99,
                    'discount' => random_int(0, 30),
                    'publication_date' => now()->subDays(random_int(30, 1800))->toDateString(),
                    'language' => $seed['language'],
                    'pages' => random_int(140, 620),
                    'publisher_id' => Arr::random($publishers->all())->id,
                    'stock' => random_int(3, 70),
                    'cover_image_url' => null,
                ]
            );

            $authorIds = collect(Arr::random($authors->all(), random_int(1, 2)))->pluck('id')->all();

            $categoryIds = $categories
                ->where('name', $seed['genre'])
                ->pluck('id')
                ->merge(collect(Arr::random($categories->all(), random_int(0, 1)))->pluck('id'))
                ->unique()
                ->values()
                ->all();

            $book->authors()->sync($authorIds);
            $book->categories()->sync($categoryIds);
        }
    }
}