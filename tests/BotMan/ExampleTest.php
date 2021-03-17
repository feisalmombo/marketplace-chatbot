<?php

namespace Tests\BotMan;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testBasicTest()
    {
        $this->bot
            ->receives('compare')
            ->assertReply('Compare!');
    }

    /**
     * A conversation test example.
     */
    public function testConversationBasicTest()
    {
        $quotes = [
            'When there is no desire, all things are at peace. - Laozi',
            'Simplicity is the ultimate sophistication. - Leonardo da Vinci',
            'Simplicity is the essence of happiness. - Cedric Bledsoe',
            'Smile, breathe, and go slowly. - Thich Nhat Hanh',
            'Simplicity is an acquired taste. - Katharine Gerould',
            'Well begun is half done. - Aristotle',
            'He who is contented is rich. - Laozi',
            'Very little is needed to make a happy life. - Marcus Antoninus',
            'It is quality rather than quantity that matters. - Lucius Annaeus Seneca',
            'Genius is one percent inspiration and ninety-nine percent perspiration. - Thomas Edison',
            'Computer science is no more about computers than astronomy is about telescopes. - Edsger Dijkstra',
        ];

        $this->bot
            ->receives('Start Conversation')
            ->assertQuestion('Huh - you woke me up. What do you need?')
            ->receivesInteractiveMessage('quote')
            ->assertReplyIn($quotes);
    }
}
