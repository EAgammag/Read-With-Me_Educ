<?php

namespace Database\Seeders;

use App\Models\Word;
use App\Models\Phrase;
use App\Models\Sentence;
use App\Models\Story;
use App\Models\StoryQuestion;
use Illuminate\Database\Seeder;

class LevelContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedWords();
        $this->seedPhrases();
        $this->seedSentences();
        $this->seedStories();
    }

    private function seedWords(): void
    {
        // Level 1: 30 words for Phonetic Foundations
        $words = [
            // Basic sight words
            ['word' => 'the', 'phonemes' => ['th', 'e'], 'example_sentence' => 'The cat is sleeping.'],
            ['word' => 'and', 'phonemes' => ['a', 'n', 'd'], 'example_sentence' => 'Mom and Dad are home.'],
            ['word' => 'is', 'phonemes' => ['i', 's'], 'example_sentence' => 'She is my friend.'],
            ['word' => 'it', 'phonemes' => ['i', 't'], 'example_sentence' => 'It is a sunny day.'],
            ['word' => 'you', 'phonemes' => ['y', 'ou'], 'example_sentence' => 'You are amazing!'],
            ['word' => 'that', 'phonemes' => ['th', 'a', 't'], 'example_sentence' => 'That is my toy.'],
            ['word' => 'he', 'phonemes' => ['h', 'e'], 'example_sentence' => 'He runs fast.'],
            ['word' => 'was', 'phonemes' => ['w', 'a', 's'], 'example_sentence' => 'It was fun!'],
            ['word' => 'for', 'phonemes' => ['f', 'or'], 'example_sentence' => 'This is for you.'],
            ['word' => 'on', 'phonemes' => ['o', 'n'], 'example_sentence' => 'The book is on the table.'],
            // More common words
            ['word' => 'are', 'phonemes' => ['a', 're'], 'example_sentence' => 'We are friends.'],
            ['word' => 'with', 'phonemes' => ['w', 'i', 'th'], 'example_sentence' => 'Come with me.'],
            ['word' => 'his', 'phonemes' => ['h', 'i', 's'], 'example_sentence' => 'That is his ball.'],
            ['word' => 'they', 'phonemes' => ['th', 'ey'], 'example_sentence' => 'They play together.'],
            ['word' => 'at', 'phonemes' => ['a', 't'], 'example_sentence' => 'Look at me!'],
            ['word' => 'be', 'phonemes' => ['b', 'e'], 'example_sentence' => 'I want to be happy.'],
            ['word' => 'this', 'phonemes' => ['th', 'i', 's'], 'example_sentence' => 'This is my house.'],
            ['word' => 'have', 'phonemes' => ['h', 'a', 've'], 'example_sentence' => 'I have a dog.'],
            ['word' => 'from', 'phonemes' => ['f', 'r', 'o', 'm'], 'example_sentence' => 'I am from here.'],
            ['word' => 'or', 'phonemes' => ['o', 'r'], 'example_sentence' => 'Do you want red or blue?'],
            // Additional words to reach 30
            ['word' => 'one', 'phonemes' => ['w', 'u', 'n'], 'example_sentence' => 'I have one apple.'],
            ['word' => 'had', 'phonemes' => ['h', 'a', 'd'], 'example_sentence' => 'She had a great day.'],
            ['word' => 'by', 'phonemes' => ['b', 'y'], 'example_sentence' => 'Sit by me.'],
            ['word' => 'but', 'phonemes' => ['b', 'u', 't'], 'example_sentence' => 'I tried but I fell.'],
            ['word' => 'not', 'phonemes' => ['n', 'o', 't'], 'example_sentence' => 'I am not tired.'],
            ['word' => 'what', 'phonemes' => ['wh', 'a', 't'], 'example_sentence' => 'What is your name?'],
            ['word' => 'all', 'phonemes' => ['a', 'll'], 'example_sentence' => 'We all love cookies.'],
            ['word' => 'were', 'phonemes' => ['w', 'e', 'r'], 'example_sentence' => 'They were happy.'],
            ['word' => 'can', 'phonemes' => ['c', 'a', 'n'], 'example_sentence' => 'I can do it!'],
            ['word' => 'said', 'phonemes' => ['s', 'e', 'd'], 'example_sentence' => 'She said hello.'],
        ];

        foreach ($words as $word) {
            Word::updateOrCreate(['word' => $word['word']], $word);
        }
    }

    private function seedPhrases(): void
    {
        // Level 2: 15 phrases for Articulation & Flow
        $phrases = [
            ['phrase' => 'good morning', 'meaning' => 'A greeting used in the morning', 'example_sentence' => 'Good morning, class!'],
            ['phrase' => 'thank you', 'meaning' => 'Expressing gratitude', 'example_sentence' => 'Thank you for helping me.'],
            ['phrase' => 'please help', 'meaning' => 'Asking for assistance politely', 'example_sentence' => 'Please help me tie my shoes.'],
            ['phrase' => 'I love', 'meaning' => 'Expressing affection', 'example_sentence' => 'I love my family.'],
            ['phrase' => 'come here', 'meaning' => 'Asking someone to approach', 'example_sentence' => 'Come here and see this!'],
            ['phrase' => 'let us go', 'meaning' => 'Suggesting to leave together', 'example_sentence' => 'Let us go to the park.'],
            ['phrase' => 'look at', 'meaning' => 'Directing attention', 'example_sentence' => 'Look at the rainbow!'],
            ['phrase' => 'I want', 'meaning' => 'Expressing a desire', 'example_sentence' => 'I want to play outside.'],
            ['phrase' => 'my name is', 'meaning' => 'Introducing yourself', 'example_sentence' => 'My name is Sam.'],
            ['phrase' => 'how are you', 'meaning' => 'Asking about wellbeing', 'example_sentence' => 'How are you today?'],
            ['phrase' => 'very good', 'meaning' => 'Expressing approval', 'example_sentence' => 'Very good job!'],
            ['phrase' => 'I can', 'meaning' => 'Expressing ability', 'example_sentence' => 'I can jump high.'],
            ['phrase' => 'do not', 'meaning' => 'Negative instruction', 'example_sentence' => 'Do not run inside.'],
            ['phrase' => 'come back', 'meaning' => 'Requesting return', 'example_sentence' => 'Come back soon!'],
            ['phrase' => 'sit down', 'meaning' => 'Instruction to sit', 'example_sentence' => 'Please sit down.'],
        ];

        foreach ($phrases as $phrase) {
            Phrase::updateOrCreate(['phrase' => $phrase['phrase']], $phrase);
        }
    }

    private function seedSentences(): void
    {
        // Level 3: 15 sentences for Syntactic Precision
        $sentences = [
            ['sentence' => 'The cat sat on the mat.', 'category' => 'animals'],
            ['sentence' => 'I like to play in the park.', 'category' => 'activities'],
            ['sentence' => 'She has a red ball.', 'category' => 'objects'],
            ['sentence' => 'The sun is very bright today.', 'category' => 'nature'],
            ['sentence' => 'My dog runs very fast.', 'category' => 'animals'],
            ['sentence' => 'We go to school every day.', 'category' => 'daily life'],
            ['sentence' => 'The bird can fly high in the sky.', 'category' => 'animals'],
            ['sentence' => 'I love to read books with my mom.', 'category' => 'activities'],
            ['sentence' => 'The flowers are pink and yellow.', 'category' => 'nature'],
            ['sentence' => 'Dad makes yummy pancakes.', 'category' => 'food'],
            ['sentence' => 'The little fish swims in the pond.', 'category' => 'animals'],
            ['sentence' => 'I can count to ten.', 'category' => 'learning'],
            ['sentence' => 'The stars come out at night.', 'category' => 'nature'],
            ['sentence' => 'We play games with our friends.', 'category' => 'activities'],
            ['sentence' => 'I am happy to see you!', 'category' => 'emotions'],
        ];

        foreach ($sentences as $sentence) {
            Sentence::updateOrCreate(['sentence' => $sentence['sentence']], $sentence);
        }
    }

    private function seedStories(): void
    {
        // Level 4: Stories for Cognitive Integration / Reading Comprehension

        // Story 1: The Little Red Hen
        $story1 = Story::updateOrCreate(
            ['title' => 'The Little Red Hen'],
            [
                'content' => "Once upon a time, there was a little red hen. She lived on a farm with a lazy cat, a sleepy dog, and a noisy duck.\n\nOne day, the little red hen found some wheat seeds. \"Who will help me plant these seeds?\" she asked.\n\n\"Not I,\" said the cat.\n\"Not I,\" said the dog.\n\"Not I,\" said the duck.\n\n\"Then I will do it myself,\" said the little red hen. And she did.\n\nThe wheat grew tall and golden. \"Who will help me cut the wheat?\" asked the hen.\n\n\"Not I,\" said all the animals.\n\nSo the little red hen cut the wheat herself. She made flour and baked a delicious loaf of bread.\n\n\"Who will help me eat this bread?\" she asked.\n\n\"I will!\" said the cat, the dog, and the duck.\n\n\"No,\" said the little red hen. \"I will eat it myself!\" And she did. It was the best bread ever!",
                'image_emoji' => '🐔',
                'difficulty' => 1,
            ]
        );

        $questions1 = [
            ['question' => 'What did the little red hen find?', 'options' => ['Wheat seeds', 'Corn', 'Apples', 'Flowers'], 'correct_answer' => 'Wheat seeds', 'order' => 1],
            ['question' => 'Who helped the hen plant the seeds?', 'options' => ['The cat', 'The dog', 'No one', 'The duck'], 'correct_answer' => 'No one', 'order' => 2],
            ['question' => 'What did the hen make with the wheat?', 'options' => ['Soup', 'Bread', 'Cake', 'Cookies'], 'correct_answer' => 'Bread', 'order' => 3],
            ['question' => 'Who ate the bread at the end?', 'options' => ['Everyone', 'Just the hen', 'The cat', 'The duck'], 'correct_answer' => 'Just the hen', 'order' => 4],
        ];

        foreach ($questions1 as $q) {
            StoryQuestion::updateOrCreate(
                ['story_id' => $story1->id, 'question' => $q['question']],
                $q
            );
        }

        // Story 2: The Three Little Pigs
        $story2 = Story::updateOrCreate(
            ['title' => 'The Three Little Pigs'],
            [
                'content' => "Once upon a time, three little pigs left home to build their own houses.\n\nThe first pig was lazy. He built his house out of straw. It was very fast!\n\nThe second pig built his house out of sticks. It was a bit stronger.\n\nThe third pig worked very hard. He built his house out of bricks. It took a long time, but it was very strong.\n\nOne day, a big bad wolf came. He went to the straw house first.\n\n\"Little pig, let me in!\" said the wolf.\n\"Not by the hair on my chin!\" said the pig.\n\nSo the wolf huffed and puffed and blew the house down! The first pig ran to his brother's stick house.\n\nThe wolf followed and blew that house down too! Both pigs ran to the brick house.\n\nThe wolf huffed and puffed, but he could not blow down the brick house! He tried to climb down the chimney, but there was a pot of hot water. The wolf ran away and never came back.\n\nThe three little pigs lived happily ever after in the strong brick house!",
                'image_emoji' => '🐷',
                'difficulty' => 1,
            ]
        );

        $questions2 = [
            ['question' => 'What did the first pig build his house with?', 'options' => ['Bricks', 'Straw', 'Sticks', 'Stone'], 'correct_answer' => 'Straw', 'order' => 1],
            ['question' => 'Which house was the strongest?', 'options' => ['Straw house', 'Stick house', 'Brick house', 'All the same'], 'correct_answer' => 'Brick house', 'order' => 2],
            ['question' => 'What did the wolf do to the straw house?', 'options' => ['Knocked on the door', 'Blew it down', 'Set it on fire', 'Walked away'], 'correct_answer' => 'Blew it down', 'order' => 3],
            ['question' => 'Where did the pigs live at the end?', 'options' => ['The straw house', 'The forest', 'The brick house', 'With the wolf'], 'correct_answer' => 'The brick house', 'order' => 4],
        ];

        foreach ($questions2 as $q) {
            StoryQuestion::updateOrCreate(
                ['story_id' => $story2->id, 'question' => $q['question']],
                $q
            );
        }

        // Story 3: The Tortoise and the Hare
        $story3 = Story::updateOrCreate(
            ['title' => 'The Tortoise and the Hare'],
            [
                'content' => "Once upon a time, there was a very fast hare and a very slow tortoise.\n\nThe hare loved to brag about how fast he was. \"I am the fastest animal in the forest!\" he said every day.\n\nOne day, the tortoise got tired of listening. \"Let's have a race,\" he said.\n\nThe hare laughed. \"A race? With you? I will win easily!\"\n\nAll the forest animals came to watch. \"Ready, set, go!\" said the fox.\n\nThe hare ran so fast that he was far ahead very quickly. He looked back and saw the tortoise was very far behind.\n\n\"I have time for a nap,\" said the hare. He lay down under a tree and fell asleep.\n\nThe tortoise kept walking slowly. He passed the sleeping hare and kept going.\n\nWhen the hare woke up, he saw the tortoise near the finish line! He ran as fast as he could, but it was too late.\n\nThe tortoise crossed the finish line first! \"Slow and steady wins the race,\" said the tortoise with a smile.",
                'image_emoji' => '🐢',
                'difficulty' => 2,
            ]
        );

        $questions3 = [
            ['question' => 'Why did the tortoise want to race?', 'options' => ['He was bored', 'He was tired of the hare bragging', 'He wanted exercise', 'The fox asked him to'], 'correct_answer' => 'He was tired of the hare bragging', 'order' => 1],
            ['question' => 'What did the hare do during the race?', 'options' => ['Kept running', 'Took a nap', 'Helped the tortoise', 'Got lost'], 'correct_answer' => 'Took a nap', 'order' => 2],
            ['question' => 'Who won the race?', 'options' => ['The hare', 'The tortoise', 'It was a tie', 'The fox'], 'correct_answer' => 'The tortoise', 'order' => 3],
            ['question' => 'What is the lesson of this story?', 'options' => ['Be the fastest', 'Slow and steady wins the race', 'Never race', 'Sleep is important'], 'correct_answer' => 'Slow and steady wins the race', 'order' => 4],
        ];

        foreach ($questions3 as $q) {
            StoryQuestion::updateOrCreate(
                ['story_id' => $story3->id, 'question' => $q['question']],
                $q
            );
        }

        // Story 4: Goldilocks and the Three Bears
        $story4 = Story::updateOrCreate(
            ['title' => 'Goldilocks and the Three Bears'],
            [
                'content' => "Once upon a time, a little girl named Goldilocks went for a walk in the forest. She found a cottage and went inside.\n\nThe cottage belonged to three bears: Papa Bear, Mama Bear, and Baby Bear. They were out for a walk while their porridge cooled.\n\nGoldilocks saw three bowls of porridge. Papa Bear's was too hot. Mama Bear's was too cold. But Baby Bear's was just right! She ate it all up.\n\nThen she found three chairs. Papa Bear's was too big. Mama Bear's was too soft. Baby Bear's was just right! But she sat so hard that it broke!\n\nFeeling tired, she went upstairs and found three beds. Papa Bear's was too hard. Mama Bear's was too soft. Baby Bear's was just right! She fell asleep.\n\nWhen the three bears came home, they found their house in a mess! They went upstairs and found Goldilocks sleeping.\n\n\"Someone is in my bed!\" cried Baby Bear.\n\nGoldilocks woke up, saw the bears, and ran out of the cottage as fast as she could. She never went back again!",
                'image_emoji' => '🐻',
                'difficulty' => 2,
            ]
        );

        $questions4 = [
            ['question' => 'Where did Goldilocks find the cottage?', 'options' => ['In the city', 'In the forest', 'By the ocean', 'On a mountain'], 'correct_answer' => 'In the forest', 'order' => 1],
            ['question' => 'Whose porridge did Goldilocks eat?', 'options' => ['Papa Bear\'s', 'Mama Bear\'s', 'Baby Bear\'s', 'All three'], 'correct_answer' => 'Baby Bear\'s', 'order' => 2],
            ['question' => 'What happened to Baby Bear\'s chair?', 'options' => ['It was too big', 'It broke', 'It was just right', 'Nothing'], 'correct_answer' => 'It broke', 'order' => 3],
            ['question' => 'What did Goldilocks do when she saw the bears?', 'options' => ['Said hello', 'Made breakfast', 'Ran away', 'Fell asleep'], 'correct_answer' => 'Ran away', 'order' => 4],
        ];

        foreach ($questions4 as $q) {
            StoryQuestion::updateOrCreate(
                ['story_id' => $story4->id, 'question' => $q['question']],
                $q
            );
        }
    }
}
