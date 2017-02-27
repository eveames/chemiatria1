<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(WordsTableSeeder::class);
        $this->call(AltwordsTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
        $this->call(TopicWordTableSeeder::class);
        $this->call(SkillsTableSeeder::class);
    }
}
