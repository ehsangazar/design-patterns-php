<?php

abstract class Visitee {
    abstract function accept(Visitor $visitorIn);
}

class BookVisitee extends Visitee {
    private $author;
    private $title;
    function __construct($title_in, $author_in) {
        $this->author = $author_in;
        $this->title  = $title_in;
    }
    function getAuthor() {return $this->author;}
    function getTitle() {return $this->title;}
    function accept(Visitor $visitorIn) {
        $visitorIn->visitBook($this);
    }
}

class SoftwareVisitee extends Visitee {
    private $title;
    private $softwareCompany;
    private $softwareCompanyURL;
    function __construct($title_in, $softwareCompany_in, $softwareCompanyURL_in) {
        $this->title  = $title_in;
        $this->softwareCompany = $softwareCompany_in;
        $this->softwareCompanyURL = $softwareCompanyURL_in;
    }
    function getSoftwareCompany() {return $this->softwareCompany;}
    function getSoftwareCompanyURL() {return $this->softwareCompanyURL;}
    function getTitle() {return $this->title;}
    function accept(Visitor $visitorIn) {
        $visitorIn->visitSoftware($this);
    }
}

abstract class Visitor {
    abstract function visitBook(BookVisitee $bookVisitee_In);
    abstract function visitSoftware(SoftwareVisitee $softwareVisitee_In);
}

class PlainDescriptionVisitor extends Visitor {  
    private $description = NULL;
    function getDescription() {
        return $this->description;
    }
    function setDescription($descriptionIn) { 
        $this->description = $descriptionIn;
    }
    function visitBook(BookVisitee $bookVisiteeIn) {
        $this->setDescription($bookVisiteeIn->getTitle().'. written by '.$bookVisiteeIn->getAuthor());
    }
    function visitSoftware(SoftwareVisitee $softwareVisiteeIn) {
        $this->setDescription($softwareVisiteeIn->getTitle().
           '. made by '.$softwareVisiteeIn->getSoftwareCompany().
           '. website at '.$softwareVisiteeIn->getSoftwareCompanyURL());
    }
}

class FancyDescriptionVisitor extends Visitor {
    private $description = NULL;
    function getDescription() { return $this->description; }
    function setDescription($descriptionIn) { 
      $this->description = $descriptionIn;
    }
    function visitBook(BookVisitee $bookVisiteeIn) {
        $this->setDescription($bookVisiteeIn->getTitle().
            '...!*@*! written !*! by !@! '.$bookVisiteeIn->getAuthor());
    }
    function visitSoftware(SoftwareVisitee $softwareVisiteeIn) {
        $this->setDescription($softwareVisiteeIn->getTitle().
            '...!!! made !*! by !@@! '.$softwareVisiteeIn->getSoftwareCompany().
            '...www website !**! at http://'.$softwareVisiteeIn->getSoftwareCompanyURL());
    }
}

  writeln('BEGIN TESTING VISITOR PATTERN');
  writeln('');
 
  $book = new BookVisitee('Design Patterns', 'Gamma, Helm, Johnson, and Vlissides');
  $software = new SoftwareVisitee('Zend Studio', 'Zend Technologies', 'www.zend.com');

  $plainVisitor = new PlainDescriptionVisitor();
 
  acceptVisitor($book,$plainVisitor);
  writeln('plain description of book: '.$plainVisitor->getDescription());
  acceptVisitor($software,$plainVisitor);
  writeln('plain description of software: '.$plainVisitor->getDescription());
  writeln('');
 
  $fancyVisitor = new FancyDescriptionVisitor();
 
  acceptVisitor($book,$fancyVisitor);
  writeln('fancy description of book: '.$fancyVisitor->getDescription());
  acceptVisitor($software,$fancyVisitor);
  writeln('fancy description of software: '.$fancyVisitor->getDescription());

  writeln('END TESTING VISITOR PATTERN');

  //double dispatch any visitor and visitee objects
  function acceptVisitor(Visitee $visitee_in, Visitor $visitor_in) {
    $visitee_in->accept($visitor_in);
  }

  function writeln($line_in) {
    echo $line_in."<br/>";
  }
