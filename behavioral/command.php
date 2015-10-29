<?php

class BookCommandee {
    private $author;
    private $title;
    function __construct($title_in, $author_in) {
        $this->setAuthor($author_in);
        $this->setTitle($title_in);
    }
    function getAuthor() {
        return $this->author;
    }
    function setAuthor($author_in) {
        $this->author = $author_in;
    }
    function getTitle() {
        return $this->title;
    }
    function setTitle($title_in) {
        $this->title = $title_in;
    }
    function setStarsOn() {
        $this->setAuthor(Str_replace(' ','*',$this->getAuthor()));
        $this->setTitle(Str_replace(' ','*',$this->getTitle()));
    }
    function setStarsOff() {
        $this->setAuthor(Str_replace('*',' ',$this->getAuthor()));
        $this->setTitle(Str_replace('*',' ',$this->getTitle()));
    }
    function getAuthorAndTitle() {
        return $this->getTitle().' by '.$this->getAuthor();
    }
}

abstract class BookCommand {
    protected $bookCommandee;
    function __construct($bookCommandee_in) {
        $this->bookCommandee = $bookCommandee_in;
    }
    abstract function execute();
}

class BookStarsOnCommand extends BookCommand {
    function execute() {
        $this->bookCommandee->setStarsOn();
    }
}

class BookStarsOffCommand extends BookCommand {
    function execute() {
        $this->bookCommandee->setStarsOff();
    }
}

  writeln('BEGIN TESTING COMMAND PATTERN');
  writeln('');
 
  $book = new BookCommandee('Design Patterns', 'Gamma, Helm, Johnson, and Vlissides');
  writeln('book after creation: ');
  writeln($book->getAuthorAndTitle());
  writeln('');
 
  $starsOn = new BookStarsOnCommand($book);
  callCommand($starsOn);
  writeln('book after stars on: ');
  writeln($book->getAuthorAndTitle());
  writeln('');
 
  $starsOff = new BookStarsOffCommand($book);
  callCommand($starsOff);
  writeln('book after stars off: ');
  writeln($book->getAuthorAndTitle());
  writeln('');

  writeln('END TESTING COMMAND PATTERN');
 
  // the callCommand function demonstrates that a specified
  // function in BookCommandee can be executed with only 
  // an instance of BookCommand.
  function callCommand(BookCommand $bookCommand_in) {
    $bookCommand_in->execute();
  }

  function writeln($line_in) {
    echo $line_in."<br/>";
  }
