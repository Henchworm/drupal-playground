<?php

namespace Drupal\flashcard_game\Service;

use Drupal\flashcard_game\Card;
use Drupal\flashcard_game\Deck;
use Drupal\flashcard_game\Round;
use Drupal\flashcard_game\Turn;


/**
 * Service class to manage the flashcard game logic.
 */
class FlashcardGameService {

    private $round;

    public function __construct() {
        $this->initializeGame();
    }

    /**
     * Initializes the game with a new round if not already initialized.
     */
    public function initializeGame() {
        if (!isset($_SESSION['round'])) {
            $card1 = new Card('What is the capital of France?', 'Paris', 'Geography');
            $card2 = new Card('What is the capital of USA?', 'Washington, D.C.', 'Geography');
            $card3 = new Card('Who is George Costanza\'s fiancée?', 'Susan', 'Pop Culture');
            $card4 = new Card('Who lives on Mt. Crumpit and terrorizes the Whos?', 'The Grinch', 'Pop Culture');

            $cards = [$card1, $card2, $card3, $card4];
            $deck = new Deck($cards);
            $this->round = new Round($deck);

            // Store the round in session.
            $_SESSION['round'] = serialize($this->round);
        } else {
            // Retrieve the round from session.
            $this->round = unserialize($_SESSION['round']);
        }
    }

    /**
     * Process the user's guess and return feedback.
     */
    public function processGuess($guess) {
        $turn = $this->round->take_turn($guess);
        $_SESSION['round'] = serialize($this->round);
        return $turn->feedback();
    }

    /**
     * Get the current card for the game round.
     */
    public function getCurrentCard() {
        return $this->round->current_card();
    }

    /**
     * Check if the game is over.
     */
    public function isGameOver() {
        return $this->getCurrentCard() === null;
    }

    /**
     * Get the player's final score after the game ends.
     */
    public function getFinalScore() {
        return [
            'correct' => $this->round->number_correct(),
            'total' => count($this->round->turns),
            'percent' => $this->round->percent_correct(),
        ];
    }

    /**
     * Clears the session after the game is over.
     */
    public function clearSession() {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
