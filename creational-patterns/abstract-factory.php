<?php

// Abstract Factory
// Problem: We want to have a multi support os class
// If an application is to be portable, 
// it needs to encapsulate platform dependencies. 
// These "platforms" might include: windowing system, operating system, database, etc. 
// Too often, this encapsulatation is not engineered in advance, 
// and lots of #ifdef case statements with options for all currently 
// supported platforms begin to procreate like rabbits throughout the code.

class shape {
	public function draw(){}
}

class circle extends shape {
	public function draw(){
		echo "Circle\n";
	}
}
class square extends shape {
	public function draw(){
		echo "Square\n";
	}
}

class abstractFactory {
	public function get(){}
}

class shapeAbstractFactory extends abstractFactory {
	public function get() {
		// a condition for knowing the Operating System
		if (true){
			return new square;
		}else {
			return new circle;
		}
	}
}

$abstractObject = new shapeAbstractFactory;

$shape = $abstractObject->get();
$shape->draw();