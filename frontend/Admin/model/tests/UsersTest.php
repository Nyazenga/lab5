<?php

class UsersTest extends \PHPUnit\Framework\TestCase{

    public function testDelete(){
        require 'manage-users.php';

        $Database = new Database;

        $result = $Database->delete(9);

        $this->assertEquals(1, $result);
    }

    public function testInsert(){
        require 'manage-users.php';

        $db2 = new Database;

        $result = $db2->insert("Cho Chang", "chang@gmail.com", "12345678", "0550901234", "12.00", "Chang farms");

        $this->assertEquals(1, $result);
    }

    public function testBedUpdate(){
        require 'beds.php';

        $db3 = new Database;

        $result = $db3->update(7, 33, "Bed 3: Groundnut");

        $this->assertEquals(1, $result);
    }

    public function testTankNumberOfRows(){
        require 'tanks.php';

        $db4 = new Database;

        $result = $db4->totalRowCount();

        $this->assertEquals(9, $result);
    }
}

?>