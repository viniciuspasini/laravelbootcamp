<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        $users = User::factory(10)->create();
        $courses = Course::factory(10)->create();

        $courses->each(function (Course $course) use ($users) {
            $lessons = Lesson::factory(5)->create([
                'course_id' => $course->id,
            ]);

            $lessons->each(function (Lesson $lesson) use ($users) {
                $comments = Comment::factory(3)
                    ->sequence(fn() => ['user_id' => $users->random()->id])
                    ->create([
                        'lesson_id' => $lesson->id,
                    ]);

                $comments->each(function (Comment $comment) use ($users) {
                    Reply::factory(2)
                        ->sequence(fn() => ['user_id' => $users->random()->id])
                        ->create([
                            'comment_id' => $comment->id,
                        ]);
                });
            });
        });
    }
}
