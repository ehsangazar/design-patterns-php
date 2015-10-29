<?php


// Problem
// "Hardening of the software arteries" has occurred by using subclassing 
// of an abstract base class to provide alternative implementations. 
// This locks in compile-time binding between interface and implementation. 
// The abstraction and implementation cannot be independently extended or composed.


abstract class BridgeBook {     
    private $bbAuthor;
    private $bbTitle;
    private $bbImp;
    function __construct($author_in, $title_in, $choice_in) {
      $this->bbAuthor = $author_in;
      $this->bbTitle  = $title_in;
      if ('STARS' == $choice_in) {
        $this->bbImp = new BridgeBookStarsImp();
      } else {
        $this->bbImp = new BridgeBookCapsImp();
      }
    }    
    function showAuthor() {
      return $this->bbImp->showAuthor($this->bbAuthor);
    }
    function showTitle() {
      return $this->bbImp->showTitle($this->bbTitle);
    }
}
 
class BridgeBookAuthorTitle extends BridgeBook {    
    function showAuthorTitle() {
      return $this->showAuthor() . "'s " . $this->showTitle();
    }
}  
 
class BridgeBookTitleAuthor extends BridgeBook {    
    function showTitleAuthor() {
      return $this->showTitle() . ' by ' . $this->showAuthor();
    }
}
 
abstract class BridgeBookImp {    
    abstract function showAuthor($author);
    abstract function showTitle($title);
}

class BridgeBookCapsImp extends BridgeBookImp {    
    function showAuthor($author_in) {
      return strtoupper($author_in); 
    }
    function showTitle($title_in) {
      return strtoupper($title_in); 
    }
}

class BridgeBookStarsImp extends BridgeBookImp {    
    function showAuthor($author_in) {
      return Str_replace(" ","*",$author_in); 
    }
    function showTitle($title_in) {
      return Str_replace(" ","*",$title_in); 
    }
}

  writeln('BEGIN TESTING BRIDGE PATTERN');
  writeln('');
 
  writeln('test 1 - author title with caps');
  $book = new BridgeBookAuthorTitle('Larry Truett','PHP for Cats','CAPS');
  writeln($book->showAuthorTitle());
  writeln('');

  writeln('test 2 - author title with stars');
  $book = new BridgeBookAuthorTitle('Larry Truett','PHP for Cats','STARS');
  writeln($book->showAuthorTitle());
  writeln('');

  writeln('test 3 - title author with caps');
  $book = new BridgeBookTitleAuthor('Larry Truett','PHP for Cats','CAPS');
  writeln($book->showTitleAuthor());
  writeln('');

  writeln('test 4 - title author with stars');
  $book = new BridgeBookTitleAuthor('Larry Truett','PHP for Cats','STARS');
  writeln($book->showTitleAuthor());
  writeln('');

  writeln('END TESTING BRIDGE PATTERN');

  function writeln($line_in) {
    echo $line_in."<br/>";
  }