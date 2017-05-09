<?php
//
// Module: lottery.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
//

class Lottery {

    // database connection and table name
    private $conn;
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
    public $endDate

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function readAll() {
        $query = "SELECT ident, description, draw, numbers, upper_number, numbers_tag, specials, upper_special, specials_tag, is_bonus, base_url, last_modified, end_date FROM ".$this->table_name;
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function create() {
        $query               = "INSERT INTO ".$this->table_name." SET description=:description, draw=:draw, numbers=:numbers, upper_number=:upper_number, numbers_tag=:numbers_tag, specials=:specials, upper_special=:upper_special, specials_tag=:specials_tag, is_bonus=:is_bonus, base_url=:base_url, last_modified=now(), end_date=NULL";
        $stmt                = $this->conn->prepare($query);
        $this->description   = htmlspecialchars(strip_tags($this->description));
        $this->base_url      = htmlspecialchars(strip_tags($this->base_url));
        $stmt->bindParam(":description",   $this->description);
        $stmt->bindParam(":draw",          $this->draw);
        $stmt->bindParam(":numbers",       $this->numbers);
        $stmt->bindParam(":upper_number",  $this->upper_number);
        $stmt->bindParam(":numbers_tag",   $this->numbers_tag);
        $stmt->bindParam(":specials",      $this->specials);
        $stmt->bindParam(":upper_special", $this->upper_special);
        $stmt->bindParam(":specials_tag",  $this->specials_tag);
        $stmt->bindParam(":is_bonus",      $this->is_bonus);
        $stmt->bindParam(":base_url",      $this->base_url);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function read() {
        $query = "SELECT ident, description, draw, numbers, upper_number, numbers_tag, specials, upper_special, specials_tag, is_bonus, base_url, last_modified, end_date FROM ".$this->table_name." WHERE ident = ? LIMIT 0,1";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ident);
        $stmt->execute();
        $row                 = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->description   = $row['description'];
        $this->draw          = $row['draw'];
        $this->numbers       = $row['numbers'];
        $this->upper_number  = $row['upper_number'];
        $this->numbers_tag   = $row['numbers_tag'];
        $this->specials      = $row['specials'];
        $this->upper_special = $row['upper_special'];
        $this->specials_tag  = $row['specials_tag'];
        $this->is_bonus      = $row['is_bonus'];
        $this->base_url      = $row['base_url'];
        $this->last_modified = $row['last_modified'];
        $this->end_date      = $row['end_date'];
    }

    function update() {
        $query               = "UPDATE ".$this->table_name." SET description=:description, draw=:draw, numbers=:numbers, upper_number=:upper_number, numbers_tag=:numbers_tag, specials=:specials, upper_special=:upper_special, specials_tag=:specials_tag, is_bonus=:is_bonus, base_url=:base_url, last_modified=now(), end_date=:end_date WHERE ident = :ident";
        $stmt                = $this->conn->prepare($query);
        $this->description   = htmlspecialchars(strip_tags($this->description));
        $this->base_url      = htmlspecialchars(strip_tags($this->base_url));
        $stmt->bindParam(":description",   $this->description);
        $stmt->bindParam(":draw",          $this->draw);
        $stmt->bindParam(":numbers",       $this->numbers);
        $stmt->bindParam(":upper_number",  $this->upper_number);
        $stmt->bindParam(":numbers_tag",   $this->numbers_tag);
        $stmt->bindParam(":specials",      $this->specials);
        $stmt->bindParam(":upper_special", $this->upper_special);
        $stmt->bindParam(":specials_tag",  $this->specials_tag);
        $stmt->bindParam(":is_bonus",      $this->is_bonus);
        $stmt->bindParam(":base_url",      $this->base_url);
        $stmt->bindParam(":end_date",      $this->end_date);
        $stmt->bindParam(":ident",         $this->ident);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function disable() {
        $query = "UPDATE ".$this->table_name." SET end_date = now() WHERE ident = :ident";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':ident', $this->ident);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function enable() {
        $query = "UPDATE ".$this->table_name." SET end_date = NULL WHERE ident = :ident";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':ident', $this->ident);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function search($keywords) {
        $query = "SELECT ident, description, draw, numbers, upper_number, numbers_tag, specials, upper_special, specials_tag, is_bonus, base_url, last_modified, end_date FROM ".$this->table_name." WHERE description LIKE ? ORDER BY description DESC";
        $stmt  = $this->conn->prepare($query);
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        $stmt->bindParam(1, $keywords);
        $stmt->execute();
        return $stmt;
    }

    public function pagingRead($from_record_num, $records_per_page) {
        $query = "SELECT ident, description, draw, numbers, upper_number, numbers_tag, specials, upper_special, specials_tag, is_bonus, base_url, last_modified, end_date FROM ".$this->table_name." ORDER BY description DESC LIMIT ?, ?";
        $stmt  = $this->conn->prepare( $query );
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count() {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
        $stmt  = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }
}
