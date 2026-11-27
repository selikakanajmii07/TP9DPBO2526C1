<?php
require_once __DIR__ . '/../../models/DB.php';
require_once __DIR__ . '/KontrakDepartemenModel.php';

class TabelDepartemen extends DB implements KontrakDepartemenModel {

    public function __construct(
        string $host = "localhost",
        string $db_name = "mvp_kandidat_db",
        string $username = "root",
        string $password = ""
    ) {
        parent::__construct($host, $db_name, $username, $password);
    }

    public function getAllDepartemen(): array {
        $query = "SELECT * FROM departemen ORDER BY id ASC";
        $this->executeQuery($query);
        return $this->getAllResult();
    }

    public function getDepartemenById(int $id): ?array {
        $query = "SELECT * FROM departemen WHERE id = :id LIMIT 1";
        $this->executeQuery($query, [':id' => $id]);

        $rows = $this->getAllResult();

        if (empty($rows)) {
            return null;
        }

        return $rows[0];
    }

    public function addDepartemen(string $namaDepartemen, string $deskripsi): void {
        $query = "INSERT INTO departemen (nama_departemen, deskripsi)
                  VALUES (:nama_departemen, :deskripsi)";

        $params = [
            ':nama_departemen' => $namaDepartemen,
            ':deskripsi' => $deskripsi
        ];

        $this->executeQuery($query, $params);
    }

    public function updateDepartemen(int $id, string $namaDepartemen, string $deskripsi): void {
        $query = "UPDATE departemen
                  SET nama_departemen = :nama_departemen,
                      deskripsi = :deskripsi
                  WHERE id = :id";

        $params = [
            ':id' => $id,
            ':nama_departemen' => $namaDepartemen,
            ':deskripsi' => $deskripsi
        ];

        $this->executeQuery($query, $params);
    }

    public function deleteDepartemen(int $id): void {
        $query = "DELETE FROM departemen WHERE id = :id";
        $this->executeQuery($query, [':id' => $id]);
    }
}
?>
