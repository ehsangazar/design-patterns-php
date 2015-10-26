<?php

// Abstract Factory
// Problem: We want to have a multi support os class

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