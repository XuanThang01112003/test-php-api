<?php
class Db {
    private $_numRow;
    private $dbh = null;

    public function __construct() {
        $driver = "mysql://root:HkufiVIsNjYOrCIhOeiSqTXbOGrCuDeM@trolley.proxy.rlwy.net:29198/railway";
        try {
            $this->dbh = new PDO($driver, 'root', 'HkufiVIsNjYOrCIhOeiSqTXbOGrCuDeM'); 
            $this->dbh->query("set names 'utf8'");
        } catch (PDOException $e) {
            echo "Err: " . $e->getMessage();
            exit();
        }
        
    }
  
    public function __destruct() {
        $this->dbh = null;
    }

    public function getRowCount() {
        return $this->_numRow;	
    }

    private function query($sql, $arr = array(), $mode = PDO::FETCH_ASSOC) {
        $stm = $this->dbh->prepare($sql);
        if (!$stm->execute($arr)) {
            echo "Sql lỗi."; exit;
        }
        $this->_numRow = $stm->rowCount();
        return $stm->fetchAll($mode);
    }

    public function select($sql, $arr = array(), $mode = PDO::FETCH_ASSOC) {
        return $this->query($sql, $arr, $mode);
    }

    public function insert($sql, $arr = array(), $mode = PDO::FETCH_ASSOC) {
        $this->query($sql, $arr, $mode);
        return $this->getRowCount();
    }

    public function update($sql, $arr = array(), $mode = PDO::FETCH_ASSOC) {
        $this->query($sql, $arr, $mode);
        return $this->getRowCount();
    }

    public function delete($sql, $arr = array(), $mode = PDO::FETCH_ASSOC) {
        $this->query($sql, $arr, $mode);
        return $this->getRowCount();
    }
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }
    public function getLatestProducts($tableName, $primaryKey = 'MaSanPham', $limit = 4) {
        $sql = "SELECT * FROM {$tableName} ORDER BY {$primaryKey} DESC LIMIT {$limit}";
        return $this->select($sql);
    }
    
}
?>
