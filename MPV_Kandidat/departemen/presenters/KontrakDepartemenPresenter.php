<?php
interface KontrakDepartemenPresenter {
    public function tampilkanDepartemen(): string;
    public function tampilkanFormDepartemen(?int $id = null): string;
    public function tambahDepartemen(string $namaDepartemen, string $deskripsi): void;
    public function ubahDepartemen(int $id, string $namaDepartemen, string $deskripsi): void;
    public function hapusDepartemen(int $id): void;
}
?>
