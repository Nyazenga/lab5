<?php
class Database
{
    private $dsn = "mysql:host=localhost;dbname=iotlab5";   // Conect with MySQL
    private $username = "root";
    private $pass = "";
    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->username, $this->pass);
            // echo "Succesfully Conected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function insert($user_id, $tank_name){
        $sql = "INSERT INTO tanks (user_id,tank_name) VALUES (:user_id,:tank_name)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'tank_name' => $tank_name]);
        return true; 
    }

    public function read()
    {
        $data = array();
        $sql = "SELECT * FROM tanks";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $data[] = $row;
        }
        return $data;
    }


    public function getTankBiId($id)
    { 
        $sql = "SELECT id, user_id, tank_name FROM tanks WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function update($id, $user_id, $tank_name)
    {
        $sql = "UPDATE tanks SET user_id= :user_id, tank_name= :tank_name WHERE id= :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'tank_name' => $tank_name, 'id' => $id]);
        return true;
    }


    public function delete($id)
    {
        $sql = "DELETE FROM tanks WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return true;
    }

    public function totalRowCount()
    {
        $sql = "SELECT count(*)  FROM tanks";
        $result = $this->conn->prepare($sql);
        $result->execute();
        $number_of_rows = $result->fetchColumn();
        return $number_of_rows;
    }

}
$ob = new Database();
// print_r($ob->insert(6,"tank1"));
// print_r($ob->insert(6,"tank2: strawberry"));
// print_r($ob->read());
// print_r($ob->getTankBiId(2));
// print_r($ob->update(4, 9,"tank 3"));
// print_r($ob->totalRowCount());
// print_r($ob->addSensor(5,"temp1","tank1","temperature"));
// print_r($ob->addtank(5,"tank1"));
// print_r($ob->addTank(5,"Tank1"));
// print_r($ob->delete(20));