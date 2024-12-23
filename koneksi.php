<?php
// koneksi.php
class Koneksi {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "medical_equipment_db";
    public $db;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getEquipment() {
        try {
            $query = $this->db->prepare("SELECT * FROM medical_equipment");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Failed to fetch equipment data: " . $e->getMessage());
        }
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            switch ($action) {
                case 'addEquipment':
                    $this->addEquipment();
                    break;
                case 'editEquipment':
                    $this->editEquipment();
                    break;
                case 'deleteEquipment':
                    $this->deleteEquipment();
                    break;
            }
        }
    }

    public function addEquipment() {
        try {
            $query = $this->db->prepare("INSERT INTO medical_equipment (equipment_code, name, category, manufacturer, purchase_date, warranty_expiry, maintenance_status, location, last_inspection_date, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $query->execute([
                $_POST['equipment_code'],
                $_POST['name'],
                $_POST['category'],
                $_POST['manufacturer'],
                $_POST['purchase_date'],
                $_POST['warranty_expiry'],
                $_POST['maintenance_status'],
                $_POST['location'],
                $_POST['last_inspection_date'],
                $_POST['notes'] ?? ''
            ]);
            
            header("Location: cms.php");
            exit;
        } catch (PDOException $e) {
            die("Failed to add equipment: " . $e->getMessage());
        }
    }

    public function editEquipment() {
        try {
            $query = $this->db->prepare("UPDATE medical_equipment SET 
                equipment_code = ?,
                name = ?,
                category = ?,
                manufacturer = ?,
                purchase_date = ?,
                warranty_expiry = ?,
                maintenance_status = ?,
                location = ?,
                last_inspection_date = ?,
                notes = ?
                WHERE id = ?");

            $query->execute([
                $_POST['equipment_code'],
                $_POST['name'],
                $_POST['category'],
                $_POST['manufacturer'],
                $_POST['purchase_date'],
                $_POST['warranty_expiry'],
                $_POST['maintenance_status'],
                $_POST['location'],
                $_POST['last_inspection_date'],
                $_POST['notes'] ?? '',
                $_POST['id']
            ]);

            header("Location: cms.php");
            exit;
        } catch (PDOException $e) {
            die("Failed to edit equipment: " . $e->getMessage());
        }
    }

    public function deleteEquipment() {
        try {
            $query = $this->db->prepare("DELETE FROM medical_equipment WHERE id = ?");
            $query->execute([$_POST['id']]);
            header("Location: cms.php");
            exit;
        } catch (PDOException $e) {
            die("Failed to delete equipment: " . $e->getMessage());
        }
    }
}

$conn = new Koneksi();
$conn->handleRequest();
?>