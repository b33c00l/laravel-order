<?php

namespace App\Http\Controllers;

use App\Services\ExportService;

class OrderExportController extends Controller
{
    public function __construct(ExportService $exportExcelService)
    {
        $this->exportExcelService = $exportExcelService;
    }
    public function export($type)
    {
        $this->exportExcelService->generateExcel($type);
    }
}
