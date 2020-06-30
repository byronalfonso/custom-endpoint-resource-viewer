<?php
namespace Includes;

use Includes\Managers\Manager;

class TestClass
{
	public function __construct()
	{
        // test autoloading
        $manager = new Manager();        
	}
}
