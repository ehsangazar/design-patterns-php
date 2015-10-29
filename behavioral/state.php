<?php

class BookContext {
    private $book = NULL;
    private $bookTitleState = NULL; 
    //bookList is not instantiated at construct time
    public function __construct($book_in) {
      $this->book = $book_in;
      $this->setTitleState(new BookTitleStateStars());
    }
    public function getBookTitle() {
      return $this->bookTitleState->showTitle($this);
    }  
    public function getBook() {
      return $this->book;
    }
    public function setTitleState($titleState_in) {
      $this->bookTitleState = $titleState_in;
    }
}

interface BookTitleStateInterface {
    public function showTitle($context_in);
}
 
class BookTitleStateExclaim implements BookTitleStateInterface {
    private $titleCount = 0; 
    public function showTitle($context_in) {
      $title = $context_in->getBook()->getTitle();
      $this->titleCount++;
      $context_in->setTitleState(new BookTitleStateStars());
      return Str_replace(' ','!',$title);
    }
}

class BookTitleStateStars implements BookTitleStateInterface {
    private $titleCount = 0; 
    public function showTitle($context_in) {
      $title = $context_in->getBook()->getTitle();
      $this->titleCount++;
      if (1 < $this->titleCount) {
        $context_in->setTitleState(new BookTitleStateExclaim); 
      }
      return Str_replace(' ','*',$title);
    }
}

class Book {
    private $author;
    private $title;
    function __construct($title_in, $author_in) {
      $this->author = $author_in;
      $this->title  = $title_in;
    }
    function getAuthor() {return $this->author;}
    function getTitle() {return $this->title;}
    function getAuthorAndTitle() {
      return $this->getTitle() . ' by ' . $this->getAuthor();
    }
}

  writeln('BEGIN TESTING STATE PATTERN');
  writeln('');
 
  $book = new Book('PHP for Cats','Larry Truett');;
  $context = new bookContext($book);
 
  writeln('test 1 - show name');
  writeln($context->getBookTitle());
  writeln('');

  writeln('test 2 - show name');
  writeln($context->getBookTitle());
  writeln('');
 
  writeln('test 3 - show name');
  writeln($context->getBookTitle());
  writeln('');
 
  writeln('test 4 - show name');
  writeln($context->getBookTitle());
  writeln('');

  writeln('END TESTING STATE PATTERN');
 
  function writeln($line_in) {
    echo $line_in."<br/>";
  }
