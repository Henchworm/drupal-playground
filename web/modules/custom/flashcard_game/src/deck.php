<?php
namespace Drupal\flashcard_game;

// Define the Deck class
class Deck {
    public $cards;

    // Constructor method to initialize the object w/ Card objects
    public function __construct($cards) {
        $this->cards = $cards;
    }

    // Method to count the number of cards
    public function count() {
        return count($this->cards); 
    }

    public function cards_in_category($searchCategory) {
        $cards_sorted = []; // Initialize an empty array
    
        foreach ($this->cards as $card) { 
            if ($card->category == $searchCategory) {
                $cards_sorted[] = $card; // Add card to the new array
            }
        }
    
        return($cards_sorted); // Return the cards sorted by catagory
    }
}
