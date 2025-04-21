<?php

declare(strict_types=1);

namespace App\Generator;

final class QuoteGenerator
{
    private const QUOTE_LIST = [
        "Believe you can and you're halfway there.",
        "Keep your face always toward the sunshine—and shadows will fall behind you.",
        "The only way to do great work is to love what you do.",
        "Start where you are. Use what you have. Do what you can.",
        "Dream big and dare to fail.",
        "Success is not final, failure is not fatal: It is the courage to continue that counts.",
        "You are never too old to set another goal or to dream a new dream.",
        "Believe in yourself and all that you are.",
        "What lies behind us and what lies before us are tiny matters compared to what lies within us.",
        "Act as if what you do makes a difference. It does.",
        "With the new day comes new strength and new thoughts.",
        "The best way to predict the future is to create it.",
        "Do something today that your future self will thank you for.",
        "Don’t watch the clock; do what it does. Keep going.",
        "It does not matter how slowly you go as long as you do not stop.",
        "You are braver than you believe, stronger than you seem, and smarter than you think.",
        "In the middle of difficulty lies opportunity.",
        "Happiness is not something ready made. It comes from your own actions.",
        "Hardships often prepare ordinary people for an extraordinary destiny.",
        "Push yourself, because no one else is going to do it for you.",
        "Great things never come from comfort zones.",
        "Sometimes we're tested not to show our weaknesses, but to discover our strengths.",
        "Don’t limit your challenges. Challenge your limits.",
        "It always seems impossible until it’s done.",
        "Success doesn’t just find you. You have to go out and get it.",
        "The harder you work for something, the greater you’ll feel when you achieve it.",
        "Don’t stop when you’re tired. Stop when you’re done.",
        "Wake up with determination. Go to bed with satisfaction.",
        "Do what you can with all you have, wherever you are.",
        "Small steps in the right direction can turn out to be the biggest step of your life.",
        "You don’t have to be great to start, but you have to start to be great.",
        "Don’t be pushed around by the fears in your mind. Be led by the dreams in your heart.",
        "If you want to achieve greatness, stop asking for permission.",
        "Opportunities don't happen. You create them.",
        "Work hard in silence, let your success be the noise.",
        "The best revenge is massive success.",
        "Your limitation—it’s only your imagination.",
        "Sometimes later becomes never. Do it now.",
        "The key to success is to focus on goals, not obstacles.",
        "Dream it. Wish it. Do it.",
        "Don’t wait for opportunity. Create it.",
        "Stay positive. Work hard. Make it happen.",
        "Great minds discuss ideas; average minds discuss events; small minds discuss people.",
        "Be so good they can't ignore you.",
        "Your only limit is your mind.",
        "Doubt kills more dreams than failure ever will.",
        "Failure is the condiment that gives success its flavor.",
        "A little progress each day adds up to big results.",
        "You miss 100% of the shots you don’t take.",
        "Life is 10% what happens to us and 90% how we react to it.",
    ];

    public function generateQuote(): string
    {
        return self::QUOTE_LIST[array_rand(self::QUOTE_LIST)];
    }
}
