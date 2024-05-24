<?php
include __DIR__ . "/../../config/database.php";

class Model
{
    private $conn;

    public function __construct()
    {
    }

    public function connection()
    {
        try {
            // Create connection
            $host = HOST;
            $username = USERNAME;
            $dbname = DBNAME;
            $password = PASSWORD;
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            // Connection failed, handle the exception
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getSingleResult($sql, $params = [])
    {
        $this->connection();
        $stmt = $this->conn->prepare($sql);
        if (isset($params)) {
            if (is_array($params)) {
                for ($i = 0; $i < count($params); $i++) {
                    $stmt->bindValue($i + 1, $params[$i]);
                }
            } else {
                $stmt->bindParam(1, $params);
            }
            $stmt->execute();
            // Fetch the results
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->conn = null;
            return $result;
        }
    }

    public function getResults($sql, $params = null)
    {
        $this->connection();
        $stmt = $this->conn->prepare($sql);
        if (isset($params)) {
            if (is_array($params)) {
                for ($i = 0; $i < count($params); $i++) {
                    $stmt->bindValue($i + 1, $params[$i]);
                }
            } else {
                $stmt->bindParam(1, $params);
            }
        }
        $stmt->execute();
        // Fetch all the results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->conn = null;
        return $results;
    }


    public function setOrDeleteData($sql, $params)
    {
        $this->connection();
        $stmt = $this->conn->prepare($sql);
        if (isset($params)) {
            if (is_array($params)) {
                for ($i = 0; $i < count($params); $i++) {
                    $stmt->bindValue($i + 1, $params[$i]);
                }
            } else {
                $stmt->bindParam(1, $params);
            }
            $stmt->execute();
            $this->conn = null;
        }
    }

    public function isUniqueUUID($table, $uuid)
    {
        $sql = "SELECT COUNT(*) as count FROM $table WHERE uuid='" . $uuid . "'";
        $this->connection();
        $stmt = $this->conn->prepare($sql);
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($count == 0) ? true : false;
    }

    public function generateUUID($table)
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set variant to RFC 4122
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        if ($this->isUniqueUUID($table, $uuid)) {
            return $uuid;
        } else {
            $this->generateUUID($table);
        }
    }
}
