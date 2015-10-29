<?php

class BookMediator {
    private $authorObject;
    private $titleObject;
    function __construct($author_in, $title_in) {
      $this->authorObject = new BookAuthorColleague($author_in,$this);
      $this->titleObject  = new BookTitleColleague($title_in,$this);
    }
    function getAuthor() {return $this->authorObject;}
    function getTitle() {return $this->titleObject;}
    // when title or author change case, this makes sure the other
    // stays in sync
    function change(BookColleague $changingClassIn) {
      if ($changingClassIn instanceof BookAuthorColleague) {
        if ('upper' == $changingClassIn->getState()) {
          if ('upper' != $this->getTitle()->getState()) {
            $this->getTitle()->setTitleUpperCase();
          }
        } elseif ('lower' == $changingClassIn->getState()) {
          if ('lower' != $this->getTitle()->getState()) {
            $this->getTitle()->setTitleLowerCase();
          }
        }
      } elseif ($changingClassIn instanceof BookTitleColleague) {
        if ('upper' == $changingClassIn->getState()) {
          if ('upper' != $this->getAuthor()->getState()) {
            $this->getAuthor()->setAuthorUpperCase();
          }
        } elseif ('lower' == $changingClassIn->getState()) {
          if ('lower' != $this->getAuthor()->getState()) {
            $this->getAuthor()->setAuthorLowerCase();
          }
        }
      }
    }
}

abstract class BookColleague {
    private $mediator;
    function __construct($mediator_in) {
        $this->mediator = $mediator_in;
    }
    function getMediator() {return $this->mediator;}
    function changed($changingClassIn) {
        getMediator()->titleChanged($changingClassIn);
    }
}

class BookAuthorColleague extends BookColleague {
    private $author;
    private $state;
    function __construct($author_in, $mediator_in) {
      $this->author = $author_in;
      parent::__construct($mediator_in);
    }
    function getAuthor() {return $this->author;}
    function setAuthor($author_in) {$this->author = $author_in;}
    function getState() {return $this->state;}
    function setState($state_in) {$this->state = $state_in;}
    function setAuthorUpperCase() {
      $this->setAuthor(strtoupper($this->getAuthor()));
      $this->setState('upper');
      $this->getMediator()->change($this);
    }
    function setAuthorLowerCase() {
      $this->setAuthor(strtolower($this->getAuthor()));
      $this->setState('lower');
      $this->getMediator()->change($this);
    }
}

class BookTitleColleague extends BookColleague {
    private $title;
    private $state;
    function __construct($title_in, $mediator_in) {
        $this->title = $title_in;
        parent::__construct($mediator_in);
    }
    function getTitle() {return $this->title;}
    function setTitle($title_in) {$this->title = $title_in;}
    function getState() {return $this->state;}
    function setState($state_in) {$this->state = $state_in;}
    function setTitleUpperCase() {
        $this->setTitle(strtoupper($this->getTitle()));
        $this->setState('upper');
        $this->getMediator()->change($this);
    }
    function setTitleLowerCase() {
        $this->setTitle(strtolower($this->getTitle()));
        $this->setState('lower');
        $this->getMediator()->change($this);
    }
}
 
  writeln('BEGIN TESTING MEDIATOR PATTERN');
  writeln('');

  $mediator = new BookMediator('Gamma, Helm, Johnson, and Vlissides', 'Design Patterns');
 
  $author = $mediator->getAuthor();
  $title = $mediator->getTitle();
 
  writeln('Original Author and Title: ');
  writeln('author: ' . $author->getAuthor());
  writeln('title: ' . $title->getTitle());
  writeln('');
 
  $author->setAuthorLowerCase();
 
  writeln('After Author set to Lower Case: ');
  writeln('author: ' . $author->getAuthor());
  writeln('title: ' . $title->getTitle());
  writeln('');

  $title->setTitleUpperCase();
 
  writeln('After Title set to Upper Case: ');
  writeln('author: ' . $author->getAuthor());
  writeln('title: ' . $title->getTitle());
  writeln('');
 
  writeln('END TESTING MEDIATOR PATTERN');

  function writeln($line_in) {
    echo $line_in.'<br/>';
  }
