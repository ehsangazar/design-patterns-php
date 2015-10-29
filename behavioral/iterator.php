<?php

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

class BookList {
    private $books = array();
    private $bookCount = 0;
    public function __construct() {
    }
    public function getBookCount() {
      return $this->bookCount;
    }
    private function setBookCount($newCount) {
      $this->bookCount = $newCount;
    }
    public function getBook($bookNumberToGet) {
      if ( (is_numeric($bookNumberToGet)) && 
           ($bookNumberToGet <= $this->getBookCount())) {
           return $this->books[$bookNumberToGet];
         } else {
           return NULL;
         }
    }
    public function addBook(Book $book_in) {
      $this->setBookCount($this->getBookCount() + 1);
      $this->books[$this->getBookCount()] = $book_in;
      return $this->getBookCount();
    }
    public function removeBook(Book $book_in) {
      $counter = 0;
      while (++$counter <= $this->getBookCount()) {
        if ($book_in->getAuthorAndTitle() == 
          $this->books[$counter]->getAuthorAndTitle())
          {
            for ($x = $counter; $x < $this->getBookCount(); $x++) {
              $this->books[$x] = $this->books[$x + 1];
          }
          $this->setBookCount($this->getBookCount() - 1);
        }
      }
      return $this->getBookCount();
    }
}

class BookListIterator {
    protected $bookList;
    protected $currentBook = 0;

    public function __construct(BookList $bookList_in) {
      $this->bookList = $bookList_in;
    }
    public function getCurrentBook() {
      if (($this->currentBook > 0) && 
          ($this->bookList->getBookCount() >= $this->currentBook)) {
        return $this->bookList->getBook($this->currentBook);
      }
    }
    public function getNextBook() {
      if ($this->hasNextBook()) {
        return $this->bookList->getBook(++$this->currentBook);
      } else {
        return NULL;
      }
    }
    public function hasNextBook() {
      if ($this->bookList->getBookCount() > $this->currentBook) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}

class BookListReverseIterator extends BookListIterator {
    public function __construct(BookList $bookList_in) {
      $this->bookList = $bookList_in;
      $this->currentBook = $this->bookList->getBookCount() + 1;
    }
    public function getNextBook() {
      if ($this->hasNextBook()) {
        return $this->bookList->getBook(--$this->currentBook);
      } else {
        return NULL;
      }
    }
    public function hasNextBook() {
      if (1 < $this->currentBook) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}


  writeln('BEGIN TESTING ITERATOR PATTERN');
  writeln('');
 
  $firstBook = new Book('Core PHP Programming, Third Edition', 'Atkinson and Suraski');
  $secondBook = new Book('PHP Bible', 'Converse and Park');
  $thirdBook = new Book('Design Patterns', 'Gamma, Helm, Johnson, and Vlissides');

  $books = new BookList();
  $books->addBook($firstBook);
  $books->addBook($secondBook);
  $books->addBook($thirdBook);
 
  writeln('Testing the Iterator');
 
  $booksIterator = new BookListIterator($books);

  while ($booksIterator->hasNextBook()) {
    $book = $booksIterator->getNextBook();
    writeln('getting next book with iterator :');
    writeln($book->getAuthorAndTitle());
    writeln('');
  }
 
  $book = $booksIterator->getCurrentBook();
  writeln('getting current book with iterator :');
  writeln($book->getAuthorAndTitle());
  writeln('');  

  writeln('Testing the Reverse Iterator');

  $booksReverseIterator = new BookListReverseIterator($books);

  while ($booksReverseIterator->hasNextBook()) {
    $book = $booksReverseIterator->getNextBook();
    writeln('getting next book with reverse iterator :');
    writeln($book->getAuthorAndTitle());
    writeln('');
  }
 
  $book = $booksReverseIterator->getCurrentBook();
  writeln('getting current book with reverse iterator :');
  writeln($book->getAuthorAndTitle());
  writeln('');

  writeln('END TESTING ITERATOR PATTERN');
 
  function writeln($line_in) {
    echo $line_in."<br/>";
  }
