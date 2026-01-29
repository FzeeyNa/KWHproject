<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Board;
use App\Models\Pin;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user
        $user = User::create([
            "name" => "Test User",
            "email" => "test@example.com",
            "password" => Hash::make("password"),
            "username" => "testuser",
            "bio" => "This is a test user for My Pins system",
        ]);

        // Create sample boards
        $designBoard = Board::create([
            "user_id" => $user->id,
            "name" => "Design Inspiration",
            "description" => "Beautiful designs and UI inspiration",
            "is_private" => false,
        ]);

        $photographyBoard = Board::create([
            "user_id" => $user->id,
            "name" => "Photography",
            "description" => "Amazing photography collection",
            "is_private" => false,
        ]);

        $personalBoard = Board::create([
            "user_id" => $user->id,
            "name" => "Personal Collection",
            "description" => "My private collection",
            "is_private" => true,
        ]);

        // Create sample pins
        Pin::create([
            "user_id" => $user->id,
            "board_id" => $designBoard->id,
            "title" => "Modern UI Design",
            "description" =>
                "A beautiful modern user interface design with clean lines and great typography.",
            "image_url" => "pins/sample1.jpg",
            "link" => "https://dribbble.com",
        ]);

        Pin::create([
            "user_id" => $user->id,
            "board_id" => $designBoard->id,
            "title" => "Minimalist Website",
            "description" =>
                "Clean and minimalist website design with focus on content.",
            "image_url" => "pins/sample2.jpg",
            "link" => "https://behance.net",
        ]);

        Pin::create([
            "user_id" => $user->id,
            "board_id" => $photographyBoard->id,
            "title" => "Sunset Landscape",
            "description" =>
                "Beautiful sunset landscape photography with warm colors.",
            "image_url" => "pins/sample3.jpg",
        ]);

        Pin::create([
            "user_id" => $user->id,
            "board_id" => $photographyBoard->id,
            "title" => "Urban Architecture",
            "description" =>
                "Modern urban architecture with interesting geometric patterns.",
            "image_url" => "pins/sample4.jpg",
        ]);

        Pin::create([
            "user_id" => $user->id,
            "board_id" => $personalBoard->id,
            "title" => "Personal Memory",
            "description" => "A special moment captured in time.",
            "image_url" => "pins/sample5.jpg",
        ]);

        echo "✅ Created test user (email: test@example.com, password: password)\n";
        echo "✅ Created 3 boards and 5 sample pins\n";
        echo "🚀 You can now login and test the My Pins system!\n";
    }
}
