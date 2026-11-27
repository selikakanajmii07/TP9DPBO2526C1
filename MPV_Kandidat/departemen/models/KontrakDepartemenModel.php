<?php
interface KontrakDepartemenModel {
    public function getAllDepartemen(): array;
    public function getDepartemenById(int $id): ?array;
    public function addDepartemen(string $namaDepartemen, string $deskripsi): void;
    public function updateDepartemen(int $id, string $namaDepartemen, string $deskripsi): void;
    public function deleteDepartemen(int $id): void;
}
?>
