<?php

class FlyweightBook {
    private $author;
    private $title;    
    function __construct($author_in, $title_in) {
        $this->author = $author_in;
        $this->title  = $title_in;
    }      
    function getAuthor() {
        return $this->author;
    }    
    function getTitle() {
        return $this->title;
    }
}
 
class FlyweightFactory {
    private $books = array();     
    function __construct() {
        $this->books[1] = NULL;
        $this->books[2] = NULL;
        $this->books[3] = NULL;
    }  
    function getBook($bookKey) {
        if (NULL == $this->books[$bookKey]) {
            $makeFunction = 'makeBook'.$bookKey;
            $this->books[$bookKey] = $this->$makeFunction(); 
        } 
        return $this->books[$bookKey];
    }    
    //Sort of an long way to do this, but hopefully easy to follow.  
    //How you really want to make flyweights would depend on what 
    //your application needs.  This, while a little clumbsy looking,
    //does work well.
    function makeBook1() {
        $book = new FlyweightBook('Larry Truett','PHP For Cats'); 
        return $book;
    }
    function makeBook2() {
        $book = new FlyweightBook('Larry Truett','PHP For Dogs'); 
        return $book;
    }
    function makeBook3() {
        $book = new FlyweightBook('Larry Truett','PHP For Parakeets'); 
        return $book;
    }
}
 
class FlyweightBookShelf {
    private $books = array();
    function addBook($book) {
        $this->books[] = $book;
    }    
    function showBooks() {
        $return_string = NULL;
        foreach ($this->books as $book) {
            $return_string .= 'title: '.$book->getAuthor().'  author: '.$book->getTitle();
        };
        return $return_string;
    }
}

  writeln('BEGIN TESTING FLYWEIGHT PATTERN');
 
  $flyweightFactory = new FlyweightFactory();
  $flyweightBookShelf1 =  new FlyweightBookShelf();
  $flyweightBook1 = $flyweightFactory->getBook(1);
  $flyweightBookShelf1->addBook($flyweightBook1);
  $flyweightBook2 = $flyweightFactory->getBook(1);
  $flyweightBookShelf1->addBook($flyweightBook2);
 
  writeln('test 1 - show the two books are the same book');
  if ($flyweightBook1 === $flyweightBook2) {
     writeln('1 and 2 are the same');
  } else {
     writeln('1 and 2 are not the same');    
  }
  writeln('');

  writeln('test 2 - with one book on one self twice');
  writeln($flyweightBookShelf1->showBooks());
  writeln('');

  $flyweightBookShelf2 =  new FlyweightBookShelf(); 
  $flyweightBook1 = $flyweightFactory->getBook(2);  
  $flyweightBookShelf2->addBook($flyweightBook1);
  $flyweightBookShelf1->addBook($flyweightBook1);

  writeln('test 3 - book shelf one');
  writeln($flyweightBookShelf1->showBooks());
  writeln('');

  writeln('test 3 - book shelf two');
  writeln($flyweightBookShelf2->showBooks());
  writeln('');

  writeln('END TESTING FLYWEIGHT PATTERN');
 
  function writeln($line_in) {
    echo $line_in."<br/>";
  }
