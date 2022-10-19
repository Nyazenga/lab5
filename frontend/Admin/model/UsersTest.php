<?php

class UsersTest extends \PHPUnit\Framework\TestCase{

    public function testInsert(){
        require 'customer.php';

        $Database = new Database;

        $result = $Database->delete(8);

        $this->assertEquals(1, $result);
    }
}

?>