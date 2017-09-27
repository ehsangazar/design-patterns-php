<?php

abstract class AbstractBookTopic {
    abstract function getTopic();
    abstract function getTitle();
    abstract function setTitle($title_in);
}
 
class BookTopic extends AbstractBookTopic {
    private $topic;
    private $title;
    function __construct($topic_in) {
      $this->topic = $topic_in;
      $this->title = NULL;
    }
    function getTopic() {
      return $this->topic;
    }
    //this is the end of the chain - returns title or says there is none
    function getTitle() {
      if (NULL != $this->title) {
        return $this->title;
      } else {
        return 'there is no title avaialble';
      }
    }
    function setTitle($title_in) {$this->title = $title_in;}
}

class BookSubTopic extends AbstractBookTopic {
    private $topic;
    private $parentTopic;
    private $title;
    function __construct($topic_in, BookTopic $parentTopic_in) {
      $this->topic = $topic_in;
      $this->parentTopic = $parentTopic_in;
      $this->title = NULL;
    }
    function getTopic() {
      return $this->topic;
    }
    function getParentTopic() {
      return $this->parentTopic;
    }   
    function getTitle() {
      if (NULL != $this->title) {
        return $this->title;
      } else {
        return $this->parentTopic->getTitle();
      }
    }
    function setTitle($title_in) {$this->title = $title_in;}
}

class BookSubSubTopic extends AbstractBookTopic {
    private $topic;
    private $parentTopic;
    private $title;
    function __construct($topic_in, BookSubTopic $parentTopic_in) {
      $this->topic = $topic_in;
      $this->parentTopic = $parentTopic_in;
      $this->title = NULL;
    }
    function getTopic() {
      return $this->topic;
    }
    function getParentTopic() {
      return $this->parentTopic;
    }   
    function getTitle() {
      if (NULL != $this->title) {
        return $this->title;
      } else {
        return $this->parentTopic->getTitle();
      }
    }
    function setTitle($title_in) {$this->title = $title_in;}
}

  writeln("BEGIN TESTING CHAIN OF RESPONSIBILITY PATTERN");
  writeln("");

  $bookTopic = new BookTopic("PHP 5");
  writeln("bookTopic before title is set:");
  writeln("topic: " . $bookTopic->getTopic());
  writeln("title: " . $bookTopic->getTitle());
  writeln("");

  $bookTopic->setTitle("PHP 5 Recipes by Babin, Good, Kroman, and Stephens");
  writeln("bookTopic after title is set: ");
  writeln("topic: " . $bookTopic->getTopic());
  writeln("title: " . $bookTopic->getTitle());
  writeln("");
 
  $bookSubTopic = new BookSubTopic("PHP 5 Patterns",$bookTopic);
  writeln("bookSubTopic before title is set: ");
  writeln("topic: " . $bookSubTopic->getTopic());
  writeln("title: " . $bookSubTopic->getTitle());
  writeln("");

  $bookSubTopic->setTitle("PHP 5 Objects Patterns and Practice by Zandstra");
  writeln("bookSubTopic after title is set: ");
  writeln("topic: ". $bookSubTopic->getTopic());
  writeln("title: ". $bookSubTopic->getTitle());
  writeln("");
 
  $bookSubSubTopic = new BookSubSubTopic("PHP 5 Patterns for Cats",
    $bookSubTopic);
  writeln("bookSubSubTopic with no title set: ");
  writeln("topic: " . $bookSubSubTopic->getTopic());
  writeln("title: " . $bookSubSubTopic->getTitle());
  writeln("");

  $bookSubTopic->setTitle(NULL);
  writeln("bookSubSubTopic with no title for set for bookSubTopic either:");
  writeln("topic: " . $bookSubSubTopic->getTopic());
  writeln("title: " . $bookSubSubTopic->getTitle());
  writeln("");

  writeln("END TESTING CHAIN OF RESPONSIBILITY PATTERN");

  function writeln($line_in) {
    echo $line_in."<br/>";
  }