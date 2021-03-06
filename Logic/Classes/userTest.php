<?php 

require_once 'user.php';
require_once 'db_connection.php';
require_once 'db_queries.php';


class UserTest extends PHPUnit_Framework_TestCase {

	function testGetAgeCreateObject() {
		$user = new User('Jens', 'Hansen', 'jhansen', 'jens@hansen.dk', 'Copenhagen', 'Denmark', 45, 'male', 'carpenter', '1234');
		$this->assertNotNull($user);
	}

	/*
	 * Test getAge() method
	 * */
	function testGetAge() {
		$user = new User('Jens', 'Hansen', 'jhansen', 'jens@hansen.dk', 'Copenhagen', 'Denmark', 45, 'male', 'carpenter', '1234');
		$age = $user->getAge();
		$this->assertEquals($age, 45);
	}

	/*
	 * Test years left to live based on age and gender (male)
	 * TestCase1 of hybrid flow graph
	 */
	 
	function testCalculateYeasLeftToLiveMale() {
		$user = new User('Jens', 'Hansen', 'jhansen', 'jens@hansen.dk', 'Copenhagen', 'Denmark', 45, 'male', 'carpenter', '1234');
		$yearsLeftToLive = $user->calculateYeasLeftToLive($user->getAge(), $user->getGender());
		$this->assertEquals($yearsLeftToLive, 29);
	}

	/*
	 * Test years left to live based on age and gender (female)
	 * TestCase2 of hybrid flow graph
	 * */
	function testCalculateYeasLeftToLiveFemale() {
		$user = new User('Ulla', 'Hansen', 'uhansen', 'ulla@hansen.dk', 'Copenhagen', 'Denmark', 45, 'female', 'cleaner', '1234');
		$yearsLeftToLive = $user->calculateYeasLeftToLive($user->getAge(), $user->getGender());
		$this->assertEquals($yearsLeftToLive, 33);
	}

	/*
	 * Test years left to live based on age and gender. The age is lower than required. 
	 * TestCase3 of hybrid flow graph
	 * @return false
	 * */	
	function testCalculateYeasLeftToLiveLowAge() {
		$user = new User('Ulla', 'Hansen', 'uhansen', 'ulla@hansen.dk', 'Copenhagen', 'Denmark', 9, 'female', 'cleaner', '1234');
		$yearsLeftToLive = $user->calculateYeasLeftToLive($user->getAge(), $user->getGender());
		$this->assertFalse($yearsLeftToLive);
	}

	/*
	 * Test years left to live based on age and gender. The age is higher than required. 
	 * TestCase4 of hybrid flow graph
	 * @return false
	 * */
	function testCalculateYeasLeftToLiveHighAge() {
		$user = new User('Ulla', 'Hansen', 'uhansen', 'ulla@hansen.dk', 'Copenhagen', 'Denmark', 121, 'female', 'cleaner', '1234');
		$yearsLeftToLive = $user->calculateYeasLeftToLive($user->getAge(), $user->getGender());
		$this->assertFalse($yearsLeftToLive);
	}


	function testNumberOfUnachievedGoals() {
		$user = new User('Ulla', 'Hansen', 'uhansen', 'ulla@hansen.dk', 'Copenhagen', 'Denmark', 45, 'female', 'cleaner', '1234');
		$numberOfUnachievedGoals = $user->numberOfUnachievedGoals(10, 4);
		$this->assertEquals($numberOfUnachievedGoals, 6);
	}


	function testNumberOfUnachievedGoalsProcentage() {
		$user = new User('Ulla', 'Hansen', 'uhansen', 'ulla@hansen.dk', 'Copenhagen', 'Denmark', 45, 'female', 'cleaner', '1234');
		$number = $user->numberOfUnachievedGoalsProcentage(10, 4);
		$this->assertEquals($number, 40);
	}

	function testFearFactor() {
		$user = new User('Ulla', 'Hansen', 'uhansen', 'ulla@hansen.dk', 'Copenhagen', 'Denmark', 45, 'female', 'cleaner', '1234');

		$yearsLeftToLive = $user->calculateYeasLeftToLive($user->getAge(), $user->getGender());
		$numberOfUnachievedGoalsProcentage = $user->numberOfUnachievedGoalsProcentage(10, 4);

		// the $fearFactor varable needs to be parsed to a String (strval) in order to pass the test.
		$fearFactor = strval ($user->fearFactor($yearsLeftToLive, $numberOfUnachievedGoalsProcentage));

		$this->assertEquals($fearFactor, '1.862');
	}

}
?>