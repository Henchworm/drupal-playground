<?php
namespace Drupal\flashcard_game;

// Define the Turn class
class Turn {
    public $string;
    public $card;

    // Constructor method to initialize the object with string and Card object
    public function __construct($guess, $card) {
        $this->guess = $guess;
        $this->card = $card;
    }

    // Method to check if the guess is correct
    public function isCorrect() {
        return $this->guess === $this->card->answer;
    }

    // Method to check correct && give feedback string
    public function feedback() {
        if ($this->isCorrect()) {
            print "Correct!";
        } else {
            print "Incorrect.";
        }
    }
}