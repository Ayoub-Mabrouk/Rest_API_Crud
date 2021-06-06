<?php
class User
{
    //db
    private $conn;
    private $table = 'users';

    //user properties
    public $id;
    public $name;
    public $id_address;
    public $location;

    //constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }


    //Get users
    public function read()
    {
        $query = 'SELECT u.id as id,
        u.name as user_name,
        a.location as address
        from ' . $this->table . ' u
        INNER JOIN addresses a
        ON u.address=a.id
        ORDER BY u.id ASC';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();
        return $stmt;
    }

    //get single post
    public function read_single()
    {
        $query = 'SELECT u.id as id,
        u.name as user_name,
        a.location as address, a.id as id_address
        from ' . $this->table . ' u
        INNER JOIN addresses a
        ON u.address=a.id
        WHERE
        u.id = ?
        LIMIT 0,1';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //bind id
        $stmt->bindParam(1, $this->id);
        //Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //set properties
        $this->id = $row['id'];
        $this->name = $row['user_name'];
        $this->id_address = $row['id_address'];
        $this->location = $row['address'];
    }

    //create user
    public function create()
    {
        // create query
        if ($this->id_address > 0 && strlen($this->name) > 0) {
            try {
                $query = 'INSERT into ' . $this->table . ' (name,address) VALUES (:name,:address)';
                $stmt = $this->conn->prepare($query);

                //clean data
                $this->name = htmlspecialchars(strip_tags($this->name));
                $this->id_address = htmlspecialchars(strip_tags($this->id_address));

                //bind data
                $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindParam(':address', $this->id_address, PDO::PARAM_INT);

                // //execute query
                return $stmt->execute();
                
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    echo json_encode(
                        array('error' => 'User Not Created because of foreign key not existed')
                    );
                }
            }
        } else {
            echo json_encode(
                array('message' => 'empty inputs')
            );
        }
    }

    //update user
    public function update()
    {
        // create query
        if (($this->id && $this->id_address && strlen($this->name)) > 0) {
            try {
                $query = "UPDATE $this->table 
                SET 
                name=:name,
                address=:address
                WHERE id=:id";
                $stmt = $this->conn->prepare($query);

                //clean data
                $this->id = htmlspecialchars(strip_tags($this->id));
                $this->name = htmlspecialchars(strip_tags($this->name));
                $this->id_address = htmlspecialchars(strip_tags($this->id_address));

                //bind data
                $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindParam(':address', $this->id_address, PDO::PARAM_INT);
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

                // //execute query
                return $stmt->execute();
            } catch (PDOException $e) {

                echo json_encode(
                    array('error' => "User Not Created because " . $e->getMessage())
                );
            }
        } else {
            echo json_encode(
                array('message' => 'empty inputs')
            );
        }
    }

    //delete user
    public function delete()
    {
        // create query
        if ($this->id > 0) {
            try {
                $query = "DELETE FROM $this->table  
                WHERE id=:id";
                $stmt = $this->conn->prepare($query);

                //clean data
                $this->id = htmlspecialchars(strip_tags($this->id));

                //bind data
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

                //execute query
                return $stmt->execute();
            } catch (PDOException $e) {
                echo json_encode(
                    array('error' => "User Not Deleted because " . $e->getMessage())
                );
            }
        } else {
            echo json_encode(
                array('message' => 'empty inputs')
            );
        }
    }
}
