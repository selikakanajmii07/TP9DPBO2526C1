<?php
require_once __DIR__ . '/KontrakDepartemenPresenter.php';
require_once __DIR__ . '/../models/KontrakDepartemenModel.php';
require_once __DIR__ . '/../views/KontrakDepartemenView.php';

class PresenterDepartemen implements KontrakDepartemenPresenter {
    private KontrakDepartemenModel $model;
    private KontrakDepartemenView $view;

    public function __construct(KontrakDepartemenModel $model, KontrakDepartemenView $view) {
        $this->model = $model;
        $this->view = $view;
    }

    private function buildRowHtml(int $no, array $departemen): string {
        $id = (int)$departemen['id'];
        $nama = htmlspecialchars($departemen['nama_departemen']);
        $deskripsi = htmlspecialchars($departemen['deskripsi']);

        return "<tr>
            <td>{$no}</td>
            <td><strong>{$nama}</strong></td>
            <td>{$deskripsi}</td>
            <td>
                <a href='index.php?menu=departemen&screen=edit&id={$id}' class='btn btn-edit'>Edit</a>

                <form method='post' action='index.php?menu=departemen' style='display:inline;' onsubmit=\"return confirm('Hapus departemen ini?')\">
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    public function tampilkanDepartemen(): string {
        $listDepartemen = $this->model->getAllDepartemen();
        $totalDepartemen = count($listDepartemen);

        $rowsHtml = '';

        if (empty($listDepartemen)) {
            $rowsHtml = '<tr><td colspan="4" style="text-align:center;padding:24px;">Belum ada data departemen.</td></tr>';
        } else {
            $no = 1;

            foreach ($listDepartemen as $departemen) {
                $rowsHtml .= $this->buildRowHtml($no, $departemen);
                $no++;
            }
        }

        return $this->view->renderDaftar($rowsHtml, $totalDepartemen);
    }

    public function tampilkanFormDepartemen(?int $id = null): string {
        if ($id !== null) {
            $departemen = $this->model->getDepartemenById($id);

            if ($departemen === null) {
                header("Location: index.php?menu=departemen");
                exit();
            }

            $formData = [
                'id' => $departemen['id'],
                'nama_departemen' => $departemen['nama_departemen'],
                'deskripsi' => $departemen['deskripsi']
            ];

            return $this->view->renderForm("Ubah Data Departemen", "ubah", $formData);
        }

        return $this->view->renderForm("Tambah Departemen Baru", "tambah", []);
    }

    public function tambahDepartemen(string $namaDepartemen, string $deskripsi): void {
        $this->model->addDepartemen($namaDepartemen, $deskripsi);

        header("Location: index.php?menu=departemen");
        exit();
    }

    public function ubahDepartemen(int $id, string $namaDepartemen, string $deskripsi): void {
        $this->model->updateDepartemen($id, $namaDepartemen, $deskripsi);

        header("Location: index.php?menu=departemen");
        exit();
    }

    public function hapusDepartemen(int $id): void {
        $this->model->deleteDepartemen($id);

        header("Location: index.php?menu=departemen");
        exit();
    }
}
?>
