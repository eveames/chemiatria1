<?php

use Illuminate\Database\Seeder;

class TopicWordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wtList = [['word_id' => '1', 'topic_id' => '2'],
        ['word_id' => '2', 'topic_id' => '2'],
        ['word_id' => '3', 'topic_id' => '2'],
        ['word_id' => '4', 'topic_id' => '2'],
        ['word_id' => '5', 'topic_id' => '2'],
        ['word_id' => '6', 'topic_id' => '2'],

        ];

        for ($i = 0 ; $i < count($wtList) ; ++$i) {
      		DB::table('topic_word')->insert([
            'word_id' => $wtList[$i]['word_id'],
            'topic_id' => $wtList[$i]['topic_id'],
        ]);
      	}
    }
}

