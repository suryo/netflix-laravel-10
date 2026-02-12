<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Movie;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            'Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi',
            'Thriller', 'Romance', 'Animation', 'Documentary', 'Adventure'
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }

        // Create sample Movies
        $movies = [
            ['title' => 'The Dark Knight', 'category' => 'Action', 'description' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological tests of his ability to fight injustice.', 'rating' => '9.0', 'release_year' => 2008, 'duration' => '2h 32m', 'director' => 'Christopher Nolan', 'cast' => 'Christian Bale, Heath Ledger, Aaron Eckhart', 'is_featured' => true],
            ['title' => 'Inception', 'category' => 'Sci-Fi', 'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.', 'rating' => '8.8', 'release_year' => 2010, 'duration' => '2h 28m', 'director' => 'Christopher Nolan', 'cast' => 'Leonardo DiCaprio, Joseph Gordon-Levitt', 'is_featured' => true],
            ['title' => 'Interstellar', 'category' => 'Sci-Fi', 'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanitys survival.', 'rating' => '8.6', 'release_year' => 2014, 'duration' => '2h 49m', 'director' => 'Christopher Nolan', 'cast' => 'Matthew McConaughey, Anne Hathaway', 'is_featured' => false],
            ['title' => 'The Shawshank Redemption', 'category' => 'Drama', 'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 'rating' => '9.3', 'release_year' => 1994, 'duration' => '2h 22m', 'director' => 'Frank Darabont', 'cast' => 'Tim Robbins, Morgan Freeman', 'is_featured' => true],
            ['title' => 'Parasite', 'category' => 'Thriller', 'description' => 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.', 'rating' => '8.5', 'release_year' => 2019, 'duration' => '2h 12m', 'director' => 'Bong Joon Ho', 'cast' => 'Song Kang-ho, Lee Sun-kyun', 'is_featured' => false],
            ['title' => 'Spirited Away', 'category' => 'Animation', 'description' => 'During her familys move to the suburbs, a sullen 10-year-old girl wanders into a world ruled by gods, witches, and spirits.', 'rating' => '8.6', 'release_year' => 2001, 'duration' => '2h 5m', 'director' => 'Hayao Miyazaki', 'cast' => 'Rumi Hiiragi, Miyu Irino', 'is_featured' => false],
            ['title' => 'The Hangover', 'category' => 'Comedy', 'description' => 'Three buddies wake up from a bachelor party in Las Vegas with no memory of the previous night and the bachelor missing.', 'rating' => '7.7', 'release_year' => 2009, 'duration' => '1h 40m', 'director' => 'Todd Phillips', 'cast' => 'Zach Galifianakis, Bradley Cooper', 'is_featured' => false],
            ['title' => 'Get Out', 'category' => 'Horror', 'description' => 'A young African-American visits his white girlfriends parents for the weekend, where his simmering uneasiness about their reception of him eventually reaches a boiling point.', 'rating' => '7.7', 'release_year' => 2017, 'duration' => '1h 44m', 'director' => 'Jordan Peele', 'cast' => 'Daniel Kaluuya, Allison Williams', 'is_featured' => false],
            ['title' => 'Titanic', 'category' => 'Romance', 'description' => 'A seventeen-year-old aristocrat falls in love with a kind but poor artist aboard the luxurious, ill-fated R.M.S. Titanic.', 'rating' => '7.9', 'release_year' => 1997, 'duration' => '3h 14m', 'director' => 'James Cameron', 'cast' => 'Leonardo DiCaprio, Kate Winslet', 'is_featured' => false],
            ['title' => 'Planet Earth II', 'category' => 'Documentary', 'description' => 'David Attenborough returns to the worlds most spectacular landscapes to explore how animals meet the challenges of survival.', 'rating' => '9.5', 'release_year' => 2016, 'duration' => '4h 58m', 'director' => 'David Attenborough', 'cast' => 'David Attenborough', 'is_featured' => false],
            ['title' => 'Avengers: Endgame', 'category' => 'Action', 'description' => 'After devastating events that wiped out half of all life, the remaining Avengers must assemble once more to reverse Thanos actions and restore balance to the universe.', 'rating' => '8.4', 'release_year' => 2019, 'duration' => '3h 1m', 'director' => 'Anthony Russo, Joe Russo', 'cast' => 'Robert Downey Jr., Chris Evans', 'is_featured' => false],
            ['title' => 'Jurassic Park', 'category' => 'Adventure', 'description' => 'A pragmatic paleontologist touring an almost complete theme park is tasked with protecting a couple of kids after a power failure causes the parks cloned dinosaurs to run loose.', 'rating' => '8.2', 'release_year' => 1993, 'duration' => '2h 7m', 'director' => 'Steven Spielberg', 'cast' => 'Sam Neill, Laura Dern', 'is_featured' => false],
            ['title' => 'The Matrix', 'category' => 'Sci-Fi', 'description' => 'When a beautiful stranger leads computer hacker Neo to a forbidding underworld, he discovers the shocking truth about his reality.', 'rating' => '8.7', 'release_year' => 1999, 'duration' => '2h 16m', 'director' => 'Wachowski Brothers', 'cast' => 'Keanu Reeves, Laurence Fishburne', 'is_featured' => false],
            ['title' => 'Forrest Gump', 'category' => 'Drama', 'description' => 'The presidencies of Kennedy and Johnson, the Vietnam War, the Watergate scandal and other historical events unfold from the perspective of an Alabama man.', 'rating' => '8.8', 'release_year' => 1994, 'duration' => '2h 22m', 'director' => 'Robert Zemeckis', 'cast' => 'Tom Hanks, Robin Wright', 'is_featured' => false],
            ['title' => 'Your Name', 'category' => 'Animation', 'description' => 'Two teenagers share a profound, magical connection upon discovering they are swapping bodies.', 'rating' => '8.4', 'release_year' => 2016, 'duration' => '1h 46m', 'director' => 'Makoto Shinkai', 'cast' => 'Ryunosuke Kamiki, Mone Kamishiraishi', 'is_featured' => false],
        ];

        foreach ($movies as $movieData) {
            $categoryName = $movieData['category'];
            unset($movieData['category']);

            $category = Category::where('name', $categoryName)->first();
            $movieData['category_id'] = $category->id;

            Movie::create($movieData);
        }

        $this->call([
            UserSeeder::class,
        ]);
    }
}
