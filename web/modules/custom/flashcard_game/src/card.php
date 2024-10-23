<?php
namespace Drupal\flashcard_game;

// Define the Card class
class Card {
    public $question;
    public $answer;
    public $category;

    // Constructor method to initialize the object
    public function __construct($question, $answer, $category) {
        $this->question = $question;
        $this->answer = $answer;
        $this->category = $category;
    }
}
