<?php


// Problem
// Application needs to manipulate a hierarchical collection of "primitive" and 
// "composite" objects. Processing of a primitive object is handled one way, 
// and processing of a composite object is handled differently. 
// Having to query the "type" of each object before attempting to process it is not desirable.



abstract class OnTheBookShelf {
    abstract function getBookInfo($previousBook);
    abstract function getBookCount();
    abstract function setBookCount($new_count);
    abstract function addBook($oneBook);
    abstract function removeBook($oneBook);
}

class OneBook extends OnTheBookShelf {
    private $title;
    private $author;
    function __construct($title, $author) {
      $this->title = $title;
      $this->author = $author;
    }
    function getBookInfo($bookToGet) {
      if (1 == $bookToGet) {
        return $this->title." by ".$this->author;
      } else {
        return FALSE;
      }
    }
    function getBookCount() {
      return 1;
    }
    function setBookCount($newCount) {
      return FALSE;
    }
    function addBook($oneBook) {
      return FALSE;
    }
    function removeBook($oneBook) {
      return FALSE;
    }
}

class SeveralBooks extends OnTheBookShelf {
    private $oneBooks = array();
    private $bookCount;
    public function __construct() {
      $this->setBookCount(0);
    }
    public function getBookCount() {
      return $this->bookCount;
    }
    public function setBookCount($newCount) {
      $this->bookCount = $newCount;
    }
    public function getBookInfo($bookToGet) {   
      if ($bookToGet <= $this->bookCount) {
        return $this->oneBooks[$bookToGet]->getBookInfo(1);
      } else {
        return FALSE;
      }
    }
    public function addBook($oneBook) {
      $this->setBookCount($this->getBookCount() + 1);
      $this->oneBooks[$this->getBookCount()] = $oneBook;
      return $this->getBookCount();
    }
    public function removeBook($oneBook) {
      $counter = 0;
      while (++$counter <= $this->getBookCount()) {
        if ($oneBook->getBookInfo(1) == 
          $this->oneBooks[$counter]->getBookInfo(1)) {
          for ($x = $counter; $x < $this->getBookCount(); $x++) {
            $this->oneBooks[$x] = $this->oneBooks[$x + 1];
          }
          $this->setBookCount($this->getBookCount() - 1);
        }
      }
      return $this->getBookCount();
    }
}

  writeln("BEGIN TESTING COMPOSITE PATTERN");
  writeln('');
 
  $firstBook = new OneBook('Core PHP Programming, Third Edition', 'Atkinson and Suraski');
  writeln('(after creating first book) oneBook info: ');
  writeln($firstBook->getBookInfo(1));
  writeln('');
 
  $secondBook = new OneBook('PHP Bible', 'Converse and Park');
  writeln('(after creating second book) oneBook info: ');
  writeln($secondBook->getBookInfo(1));
  writeln('');

  $thirdBook = new OneBook('Design Patterns', 'Gamma, Helm, Johnson, and Vlissides');
  writeln('(after creating third book) oneBook info: ');
  writeln($thirdBook->getBookInfo(1));
  writeln('');

  $books = new SeveralBooks();

  $booksCount = $books->addBook($firstBook);
  writeln('(after adding firstBook to books) SeveralBooks info : ');
  writeln($books->getBookInfo($booksCount));
  writeln('');

  $booksCount = $books->addBook($secondBook);
  writeln('(after adding secondBook to books) SeveralBooks info : ');
  writeln($books->getBookInfo($booksCount));
  writeln('');

  $booksCount = $books->addBook($thirdBook);
  writeln('(after adding thirdBook to books) SeveralBooks info : ');
  writeln($books->getBookInfo($booksCount));
  writeln('');

  $booksCount = $books->removeBook($firstBook);
  writeln('(after removing firstBook from books) SeveralBooks count : ');
  writeln($books->getBookCount());
  writeln('');
 
  writeln('(after removing firstBook from books) SeveralBooks info 1 : ');
  writeln($books->getBookInfo(1));
  writeln('');
 
  writeln('(after removing firstBook from books) SeveralBooks info 2 : ');
  writeln($books->getBookInfo(2));
  writeln('');

  writeln('END TESTING COMPOSITE PATTERN');
 
  function writeln($line_in) {
    echo $line_in."<br/>";
  }
