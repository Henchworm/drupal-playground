<?php

namespace Drupal\flashcard_game\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Controller\ControllerBase;
use Drupal\flashcard_game\Service\FlashcardGameService;

class FlashcardController extends ControllerBase {

    /**
     * The main method that handles the game flow.
     */
    public function play(Request $request) {
        session_start();

        // Use the FlashcardGameService to handle game logic.
        $gameService = new FlashcardGameService();
        $output = '<div id="flashcard-game"><h2>Flashcard Game</h2>';

        // If the user submitted a guess, process it.
        if ($request->isMethod('POST') && $request->request->has('guess')) {
            $guess = $request->request->get('guess');
            $feedback = $gameService->processGuess($guess);
            $output .= '<p>' . $feedback . '</p>';
        }

        // If the game is over, display the final score.
        if ($gameService->isGameOver()) {
            $score = $gameService->getFinalScore();
            $output .= '
                <p>Game over! You got ' . $score['correct'] . ' out of ' . $score['total'] . ' correct.</p>
                <p>Percentage correct: ' . $score['percent'] . '%</p>';
            $gameService->clearSession();
            $output .= '<a href="' . $request->getUri() . '">Play Again</a>';
        } else {
            // Display the current question.
            $currentCard = $gameService->getCurrentCard();
            $output .= '
                <form method="post">
                    <p>Current question: <strong>' . $currentCard->question . '</strong></p>
                    <label for="guess">Enter your guess:</label>
                    <input type="text" id="guess" name="guess" required>
                    <button type="submit">Submit</button>
                </form>';
        }

        $output .= '</div>';

        // Return the final response.
        return new Response($output);
    }
}
