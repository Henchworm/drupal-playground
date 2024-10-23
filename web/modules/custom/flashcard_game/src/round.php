<?php
namespace Drupal\flashcard_game;

// Define the Round class - processes responses and records guesses
class Round {
    public $deck;
    public $turns;

    // Constructor method to initialize the object
    public function __construct($deck) {
        $this->deck = $deck;
        $this->turns = []; // Initialize turns as an empty array
    }

    // Method to get the current card
    public function current_card() {
        return array_values($this->deck->cards)[0];
    }

    // Method to take a turn and return a Turn object
    public function take_turn($playerGuess) {
        // Get the current card
        $card = $this->current_card();

        // Create a new Turn object
        $turn = new Turn($playerGuess, $card);

        // Add the new turn to the turns array
        $this->turns[] = $turn;

        // Move on to the next card in the deck by removing the first card
        array_shift($this->deck->cards);

        // Return the new Turn object at the end 
        return $turn;
    }

    // Method to filter and return correct turns
    public function correct_turns() {
        $correct_turns = array_filter($this->turns, function($turn) {
            return $turn->isCorrect() === true;
        });
        return $correct_turns; 
    }

    // Method to count the number of correct turns
    public function number_correct() {
        $correct_turns = $this->correct_turns(); // Call correct_turns() method with this 
        return count($correct_turns); 
    }

    // Method to count correct turns by category
    public function number_correct_by_category($category) {
        $correct_turns_by_category = array_filter($this->turns, function($turn) use ($category) {
            return $turn->isCorrect() === true && $turn->card->category === $category;
        });
        return count($correct_turns_by_category);
    }

    // Method to calculate percentage of correct turns
    public function percent_correct() {
        $correct_turns = $this->correct_turns();
    
        // Count total number of turns
        $total_turns = count($this->turns);
    
        // Calculate and return the percentage of correct turns
        return ($total_turns > 0) ? (count($correct_turns) / $total_turns) * 100 : 0;
    }

    // Method to calculate percentage of correct turns by category
    public function percent_correct_by_category($category) {
        // Filter correct turns by category using correct_turns() method
        $correct_turns_by_category = array_filter($this->turns, function($turn) use ($category) {
            return $turn->isCorrect() === true && $turn->card->category === $category;
        });
    
        // Filter total turns by category
        $total_turns_by_category = array_filter($this->turns, function($turn) use ($category) {
            return $turn->card->category === $category;
        });
    
        // Calculate percentage of correct turns in the given category
        $total_turns = count($total_turns_by_category);
        $correct_turns = count($correct_turns_by_category);
    
        return ($total_turns > 0) ? ($correct_turns / $total_turns) * 100 : 0;
    }
}
?>
