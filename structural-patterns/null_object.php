<?php

class Recipient {
        abstract function name();
};

class NullRecipient extends Recipient {
        public function name() { 
        	return "nobody"; 
        }
};

class World extends Recipient {
        public function name { 
        	return "world"; 
       	}
};

public function hello_world(Recipient && recipient = NullRecipient())
{
        echo "Hello". recipient.name(). " ! ";
}

hello_world(World());