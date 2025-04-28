<?php
/**
 * File: DataExportTrait.php
 * Description:
 *   مدیریت استخراج داده شامل:
 *   - ایجاد فایل CSV
 *   - ایجاد فایل JSON
 *   - دانلود فایل
 */

namespace Cardifa\Elementor\Traits;

if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

trait DataExportTrait {

    /**
     * استخراج داده به فرمت CSV
     *
     * @param array $data آرایه داده
     * @param string $filename نام فایل CSV
     */
    public function export_to_csv(array $data, $filename = 'export.csv') {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        if (!empty($data)) {
            fputcsv($output, array_keys($data[0]));
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
        }
        fclose($output);
        exit;
    }

    /**
     * استخراج داده به فرمت JSON
     *
     * @param array $data آرایه داده
     * @param string $filename نام فایل JSON
     */
    public function export_to_json(array $data, $filename = 'export.json') {
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
}
