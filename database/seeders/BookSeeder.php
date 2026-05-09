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
            ['name' => 'Trending', 'slug' => 'trending'],
            ['name' => 'New Arrivals', 'slug' => 'new-arrivals'],
            ['name' => 'Coming Soon', 'slug' => 'coming-soon'],
            ['name' => 'Sale', 'slug' => 'sale'],
        ];

        $genres = [
            'Fiction',
            'Programming',
            'Business',
            'History',
            'Self Development',
            'Science',
            'Fantasy',
            'Mystery',
        ];

        $titleFragments = [
            'Fiction' => [
                ['The', 'Silent', 'Echo'],
                ['The', 'Last', 'Page'],
                ['A', 'Borrowed', 'Life'],
                ['After', 'the', 'Rain'],
                ['The', 'Midnight', 'Archive'],
            ],
            'Programming' => [
                ['Clean', 'Deployments', 'Guide'],
                ['Practical', 'API', 'Patterns'],
                ['Laravel', 'at', 'Scale'],
                ['Refactor', 'Without', 'Regret'],
                ['The', 'Quiet', 'Stack'],
            ],
            'Business' => [
                ['The', 'Productive', 'Founder'],
                ['Better', 'Teams', 'Everyday'],
                ['The', 'Simple', 'Strategy'],
                ['Founders', 'at', 'Work'],
                ['From', 'Idea', 'to', 'Income'],
            ],
            'History' => [
                ['Empire', 'of', 'Glass'],
                ['Maps', 'of', 'Memory'],
                ['Central', 'Europe', 'Chronicles'],
                ['The', 'Long', 'Archive'],
                ['Cities', 'in', 'Time'],
            ],
            'Self Development' => [
                ['Minimal', 'Mindset'],
                ['Small', 'Habits', 'That', 'Stick'],
                ['Quiet', 'Progress'],
                ['Focus', 'Without', 'Burnout'],
                ['The', 'Better', 'Routine'],
            ],
            'Science' => [
                ['Signals', 'and', 'Systems'],
                ['Data', 'Thinking'],
                ['Patterns', 'in', 'Nature'],
                ['The', 'Measured', 'World'],
                ['Science', 'in', 'Motion'],
            ],
            'Fantasy' => [
                ['Danube', 'Legends'],
                ['The', 'Fourth', 'Library'],
                ['Crown', 'of', 'Fog'],
                ['Moon', 'Over', 'Stone'],
                ['The', 'Hidden', 'Kingdom'],
            ],
            'Mystery' => [
                ['Bratislava', 'at', 'Dawn'],
                ['Night', 'Train', 'to', 'Kosice'],
                ['Mysteries', 'of', 'Orava'],
                ['The', 'Missing', 'Witness'],
                ['A', 'Case', 'in', 'Silence'],
            ],
        ];

        $genreDescriptions = [
            'Fiction' => [
                'A character-driven story built around memory, place, and a quietly changing life.',
                'A literary novel with a slow reveal and a strong emotional core.',
                'A contemporary story about the people who stay behind when everything changes.',
            ],
            'Programming' => [
                'A practical guide for teams shipping software in real environments.',
                'A hands-on technical book focused on maintainable code and calmer releases.',
                'A developer-friendly title covering architecture, testing, and day-to-day tradeoffs.',
            ],
            'Business' => [
                'A grounded business book for founders and managers making decisions under pressure.',
                'A practical read on leadership, operations, and building teams that scale.',
                'A concise guide to running a better company without unnecessary complexity.',
            ],
            'History' => [
                'A detailed historical survey with context, timelines, and human stories.',
                'A broad look at the forces that shaped regions, people, and institutions.',
                'A history title that connects old events to the way we live now.',
            ],
            'Self Development' => [
                'A calm, practical approach to better routines and clearer thinking.',
                'A realistic self-development book focused on habits that fit real life.',
                'A short guide to making progress without turning life into a project.',
            ],
            'Science' => [
                'A science title that explains complicated ideas without losing rigor.',
                'A readable book about patterns, systems, and how the world works.',
                'A grounded scientific overview with practical examples and clear explanations.',
            ],
            'Fantasy' => [
                'A richly imagined fantasy story with kingdoms, myths, and hidden power.',
                'A magical adventure set in a world where old rules still matter.',
                'A fantasy novel about memory, prophecy, and the cost of power.',
            ],
            'Mystery' => [
                'A mystery built around clues, silence, and the details people overlook.',
                'A suspenseful story where every answer opens another question.',
                'A regional mystery with secrets buried just under the surface.',
            ],
        ];

        $languages = ['English', 'Slovak'];
        $categorySlugs = ['trending', 'new-arrivals', 'coming-soon', 'sale'];
        $bookCount = 40;
        $bookSeeds = [];
        $usedTitles = [];

        while (count($bookSeeds) < $bookCount) {
            $genre = Arr::random($genres);
            $fragments = Arr::random($titleFragments[$genre], 1)[0];
            $title = implode(' ', $fragments);

            if (isset($usedTitles[$title])) {
                continue;
            }

            $usedTitles[$title] = true;

            $categoryCount = random_int(1, 2);
            $selectedCategorySlugs = collect(Arr::random($categorySlugs, $categoryCount))
                ->values()
                ->all();

            $bookSeeds[] = [
                'title' => $title,
                'genre' => $genre,
                'language' => Arr::random($languages),
                'description' => Arr::random($genreDescriptions[$genre]),
                'price' => random_int(1499, 3999) / 100,
                'discount' => random_int(1, 10) <= 3 ? random_int(5, 30) : 0,
                'publication_date' => random_int(1, 10) <= 7
                    ? now()->subDays(random_int(30, 1200))->toDateString()
                    : now()->addDays(random_int(14, 120))->toDateString(),
                'pages' => random_int(160, 640),
                'stock' => random_int(0, 45),
                'categories' => $selectedCategorySlugs,
            ];
        }

        $publishers = collect($publisherData)
            ->map(fn (array $publisher) => Publisher::firstOrCreate(['name' => $publisher['name']], $publisher));

        $authors = collect($authorNames)
            ->map(fn (string $name) => Author::firstOrCreate(['full_name' => $name]));

        $categories = collect($categoryData)
            ->map(fn (array $category) => Category::firstOrCreate(['slug' => $category['slug']], $category));

        $categoryMap = $categories->keyBy('slug');

        foreach ($bookSeeds as $index => $seed) {
            $book = Book::updateOrCreate(
                ['isbn' => '9781234567' . str_pad((string) ($index + 100), 3, '0', STR_PAD_LEFT)],
                [
                    'title' => $seed['title'],
                    'description' => $seed['description'],
                    'genre' => $seed['genre'],
                    'price' => $seed['price'],
                    'discount' => $seed['discount'],
                    'publication_date' => $seed['publication_date'],
                    'language' => $seed['language'],
                    'pages' => $seed['pages'],
                    'publisher_id' => Arr::random($publishers->all())->id,
                    'stock' => $seed['stock'],
                    'cover_image_url' => null,
                ]
            );

            $authorIds = collect(Arr::random($authors->all(), random_int(1, 2)))->pluck('id')->all();

            $categoryIds = collect($seed['categories'] ?? [])
                ->map(fn (string $slug) => $categoryMap->get($slug)?->id)
                ->filter()
                ->unique()
                ->values()
                ->all();

            $book->authors()->sync($authorIds);
            $book->categories()->sync($categoryIds);
        }
    }
}