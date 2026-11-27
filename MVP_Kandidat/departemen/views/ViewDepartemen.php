<?php
require_once __DIR__ . '/KontrakDepartemenView.php';

class ViewDepartemen implements KontrakDepartemenView {
    private string $daftarPath;
    private string $formPath;

    public function __construct(string $daftarPath = '', string $formPath = '') {
        $this->daftarPath = $daftarPath ?: __DIR__ . '/../template/daftar.html';
        $this->formPath = $formPath ?: __DIR__ . '/../template/form.html';
    }

    public function renderDaftar(string $tableRowsHtml, int $totalData): string {
        $template = file_get_contents($this->daftarPath);

        $tokens = [
            '{{TABLE_ROWS}}' => $tableRowsHtml,
            '{{TOTAL_DATA}}' => (string)$totalData
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }

    public function renderForm(string $title, string $action, array $formData = []): string {
        $template = file_get_contents($this->formPath);

        $tokens = [
            '{{FORM_TITLE}}' => htmlspecialchars($title),
            '{{ACTION}}' => htmlspecialchars($action),
            '{{ID}}' => htmlspecialchars((string)($formData['id'] ?? '')),
            '{{NAMA_DEPARTEMEN}}' => htmlspecialchars($formData['nama_departemen'] ?? ''),
            '{{DESKRIPSI}}' => htmlspecialchars($formData['deskripsi'] ?? '')
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }
}
?>
