<?php
 class MY_Model {
    private $conn;
    public function __construct() {
        // Create connection
        $this->conn = new mysqli("localhost", "root",'', "smis1"); // connect to db
         
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    public function createTable($tableName, $columns) {
        $columnsDefinition = [];
        foreach ($columns as $columnName => $columnType) {
            $columnsDefinition[] = "$columnName $columnType";
        }
        $columnsDefinition = implode(", ", $columnsDefinition);

        $sql = "CREATE TABLE IF NOT EXISTS $tableName ($columnsDefinition)";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
    public function insert($table, $data) {   // dynamic func to innsert array of data for specified table
        $columns = implode(", ", array_keys($data));
        $values = array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($data));
        $values = implode(", ", $values);
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        if ($this->conn->query($sql) === TRUE) {
            
            return true;
        } else {
             
            return false;
        }
    }

    public function update($table, $data, $condition) {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = '$value'";
        }
        $set = implode(", ", $set);

        $where = [];
        foreach ($condition as $key => $value) {
            $where[] = "$key = '$value'";
        }
        $where = implode(" AND ", $where);

        $sql = "UPDATE $table SET $set WHERE $where";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($table, $condition) {
        $where = [];
        foreach ($condition as $key => $value) {
            $where[] = "$key = '$value'";
        }
        $where = implode(" AND ", $where);

        $sql = "DELETE FROM $table WHERE $where";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
    public function getAll($table) {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return [];
        }
    }
    public function getAllWhere($table, $condition = null) {
        $whereClause = '';
        
        if (!empty($condition)) {
            $where = [];
            foreach ($condition as $key => $value) {
                $where[] = "$key = '$value'";
            }
            $whereClause = "WHERE " . implode(" AND ", $where);
        }

        $sql = "SELECT * FROM $table $whereClause";
        $result = $this->conn->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return [];
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>