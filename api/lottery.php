<?php
//
// Module: lottery.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
// 2017-05-10 v0.02   Use mySQLi not PDO, and return JSON result set
//

class Lottery {

    // database connection and table name
    private $dbConnection;
    private $table_name = "lottery_draws";

    // object properties
    public $ident;
    public $description;
    public $draw;
    public $numbers;
    public $upperNumber;
    public $numbersTag;
    public $specials;
    public $upperSpecial;
    public $specialsTag;
    public $isBonus;
    public $baseUrl;
    public $lastModified;
    public $endDate;

    public $numRows;
    public $data;

    // constructor with $db as database connection
    public function __construct($db){
        $this->dbConnection = $db;
    }

    public function readAll() {
        $data            = array();
        $data["records"] = array();
        $data["count"]   = 0;
        $data["success"] = "Fail";
        $query           = "SELECT ident, description, draw, numbers, upper_number, numbers_tag, specials, upper_special, specials_tag, is_bonus, base_url, last_modified, end_date FROM ".$this->table_name;
        $result          = $this->dbConnection->query($query);
        $this->numRows   = $result->num_rows;
        if ($this->numRows > 0) {
            while ($row = $result->fetch_assoc()){
                $item=array(
                    "ident"        => $row['ident'],
                    "description"  => $row['description'],
                    "draw"         => $row['draw'],
                    "numbers"      => $row['numbers'],
                    "upperNumber"  => $row['upper_number'],
                    "numbersTag"   => $row['numbers_tag'],
                    "specials"     => $row['specials'],
                    "upperSpecial" => $row['upper_special'],
                    "specialsTag"  => $row['specials_tag'],
                    "isBonus"      => $row['is_bonus'],
                    "baseUrl"      => $row['base_url'],
                    "lastModified" => $row['last_modified'],
                    "endDate"      => $row['end_date']
                );
                array_push($data["records"], $item);
            }
            $data["success"] = "Ok";
            $data["count"]   = $this->numRows;
        }
        return json_encode($data);
    }

    public function read($id) {
        $data            = array();
        $data["records"] = array();
        $data["count"]   = 0;
        $data["success"] = "Fail";
        $query           = "SELECT ident, description, draw, numbers, upper_number, numbers_tag, specials, upper_special, specials_tag, is_bonus, base_url, last_modified, end_date FROM ".$this->table_name." WHERE ident = ? LIMIT 0,1";
        $stmt            = $this->dbConnection->prepare($query);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $result          = $stmt->get_result();
            $this->numRows   = $result->num_rows;
            if ($this->numRows > 0) {
                while ($row = $result->fetch_assoc()){
                    $item=array(
                        "ident"        => $row['ident'],
                        "description"  => $row['description'],
                        "draw"         => $row['draw'],
                        "numbers"      => $row['numbers'],
                        "upperNumber"  => $row['upper_number'],
                        "numbersTag"   => $row['numbers_tag'],
                        "specials"     => $row['specials'],
                        "upperSpecial" => $row['upper_special'],
                        "specialsTag"  => $row['specials_tag'],
                        "isBonus"      => $row['is_bonus'],
                        "baseUrl"      => $row['base_url'],
                        "lastModified" => $row['last_modified'],
                        "endDate"      => $row['end_date']
                    );
                    array_push($data["records"], $item);
                }
            }
            $data["success"] = "Ok";
            $data["count"]   = $this->numRows;
        }
        return json_encode($data);
    }

    public function search($keywords) {
        $data            = array();
        $data["records"] = array();
        $data["count"]   = 0;
        $data["success"] = "Fail";
        $keywords        = htmlspecialchars(strip_tags($keywords));
        $keywords        = "%{$keywords}%";
        $query           = "SELECT ident, description, draw, numbers, upper_number, numbers_tag, specials, upper_special, specials_tag, is_bonus, base_url, last_modified, end_date FROM ".$this->table_name." WHERE description LIKE ? ORDER BY description DESC";
        $stmt            = $this->dbConnection->prepare($query);
        $stmt->bind_param('s', $keywords);
        if ($stmt->execute()) {
            $result          = $stmt->get_result();
            $this->numRows   = $result->num_rows;
            if ($this->numRows > 0) {
                while ($row = $result->fetch_assoc()){
                    $item=array(
                        "ident"        => $row['ident'],
                        "description"  => $row['description'],
                        "draw"         => $row['draw'],
                        "numbers"      => $row['numbers'],
                        "upperNumber"  => $row['upper_number'],
                        "numbersTag"   => $row['numbers_tag'],
                        "specials"     => $row['specials'],
                        "upperSpecial" => $row['upper_special'],
                        "specialsTag"  => $row['specials_tag'],
                        "isBonus"      => $row['is_bonus'],
                        "baseUrl"      => $row['base_url'],
                        "lastModified" => $row['last_modified'],
                        "endDate"      => $row['end_date']
                    );
                    array_push($data["records"], $item);
                }
            }
            $data["success"] = "Ok";
            $data["count"]   = $this->numRows;
        }
        return json_encode($data);
    }

    public function count() {
        $data            = array();
        $data["records"] = array();
        $data["count"]   = 0;
        $data["success"] = "Fail";
        $query           = "SELECT COUNT(*) as total_rows FROM ".$this->table_name;
        $result          = $this->dbConnection->query($query);
        $this->numRows   = $result->num_rows;
        if ($this->numRows > 0) {
            if ($row = $result->fetch_assoc()) {
                $data["success"] = "Ok";
                $data["count"]   = $row['total_rows'];
            }
        }
        return json_encode($data);
    }

    public function readPage($from, $count) {
        $data            = array();
        $data["records"] = array();
        $data["count"]   = 0;
        $data["success"] = "Fail";
        $query           = "SELECT ident, description, draw, numbers, upper_number, numbers_tag, specials, upper_special, specials_tag, is_bonus, base_url, last_modified, end_date FROM ".$this->table_name." ORDER BY description DESC LIMIT ?, ?";
        $stmt            = $this->dbConnection->prepare($query);
        $stmt->bind_param('ii', $from, $count);
        if ($stmt->execute()) {
            $result          = $stmt->get_result();
            $this->numRows   = $result->num_rows;
            if ($this->numRows > 0) {
                while ($row = $result->fetch_assoc()){
                    $item=array(
                        "ident"        => $row['ident'],
                        "description"  => $row['description'],
                        "draw"         => $row['draw'],
                        "numbers"      => $row['numbers'],
                        "upperNumber"  => $row['upper_number'],
                        "numbersTag"   => $row['numbers_tag'],
                        "specials"     => $row['specials'],
                        "upperSpecial" => $row['upper_special'],
                        "specialsTag"  => $row['specials_tag'],
                        "isBonus"      => $row['is_bonus'],
                        "baseUrl"      => $row['base_url'],
                        "lastModified" => $row['last_modified'],
                        "endDate"      => $row['end_date']
                    );
                    array_push($data["records"], $item);
                }
            }
            $data["success"] = "Ok";
            $data["count"]   = $this->numRows;
        }
        return json_encode($data);
    }

    public function insert() {
        $query             = "INSERT INTO ".$this->table_name." SET description = ?, draw = ?, numbers = ?, upper_number = ?, numbers_tag = ?, specials = ?, upper_special = ?, specials_tag = ?, is_bonus = ?, base_url = ?, last_modified = now(), end_date = NULL";
        $stmt              = $this->dbConnection->prepare($query);
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->base_url    = htmlspecialchars(strip_tags($this->base_url));
        $stmt->bind_param('siiisiisis', $this->description,$this->draw,$this->numbers,$this->upper_number,$this->numbers_tag,$this->specials,$this->upper_special,$this->specials_tag,$this->is_bonus,$this->base_url);
        $data             = array();
        $data["success"]  = "Fail";
        $data["count"]    = 0;
        $data["recordId"] = 0;
        if ($stmt->execute()) {
            $data["success"]  = "Ok";
            $data["count"]    = $this->dbConnection->affected_rows;
            $data["recordId"] = $this->dbConnection->insert_id;
        }
        return json_encode($data);
    }

    public function disable($id) {
        $query = "UPDATE ".$this->table_name." SET end_date = now() WHERE ident = ?";
        $stmt  = $this->dbConnection->prepare($query);
        $stmt->bind_param('i', $id);
        $data            = array();
        $data["success"] = "Fail";
        $data["count"]   = 0;
        if ($stmt->execute()) {
            $data["success"] = "Ok";
            $data["count"]   = $this->dbConnection->affected_rows;
        }
        return json_encode($data);
    }

    public function enable($id) {
        $query = "UPDATE ".$this->table_name." SET end_date = NULL WHERE ident = ?";
        $stmt  = $this->dbConnection->prepare($query);
        $stmt->bind_param('i', $id);
        $data            = array();
        $data["success"] = "Fail";
        $data["count"]   = 0;
        if ($stmt->execute()) {
            $data["success"] = "Ok";
            $data["count"]   = $this->dbConnection->affected_rows;
        }
        return json_encode($data);
    }

    public function delete($id) {
        $query = "DELETE FROM ".$this->table_name." WHERE ident = ?";
        $stmt  = $this->dbConnection->prepare($query);
        $stmt->bind_param('i', $id);
        $data            = array();
        $data["success"] = "Fail";
        $data["count"]   = 0;
        if ($stmt->execute()) {
            $data["success"] = "Ok";
            $data["count"]   = $this->dbConnection->affected_rows;
        }
        return json_encode($data);
    }

    public function update($id) {
        $query             = "UPDATE ".$this->table_name." SET description = ?, draw = ?, numbers = ?, upper_number = ?, numbers_tag = ?, specials = ?, upper_special = ?, specials_tag = ?, is_bonus = ?, base_url = ?, last_modified = now() WHERE ident = ?";
        $stmt              = $this->dbConnection->prepare($query);
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->base_url    = htmlspecialchars(strip_tags($this->base_url));
        $stmt->bind_param('siiisiisisi', $this->description,$this->draw,$this->numbers,$this->upper_number,$this->numbers_tag,$this->specials,$this->upper_special,$this->specials_tag,$this->is_bonus,$this->base_url,$id);
        $data            = array();
        $data["success"] = "Fail";
        $data["count"]   = 0;
        if ($stmt->execute()) {
            $data["success"] = "Ok";
            $data["count"]   = $this->dbConnection->affected_rows;
        }
        return json_encode($data);
    }
}

?>
