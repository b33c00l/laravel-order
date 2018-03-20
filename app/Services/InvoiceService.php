<?php

namespace App\Services;


use App\Invoice;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{

    public function generateName($file)
    {
        $filenameWithExt = $file->getClientOriginalName();
        $fileName = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $a = 1;
        while (Storage::exists('public/invoices/' . $filenameWithExt) || Invoice::where('filename', $filenameWithExt)->first())
        {
            $filenameWithExt = $fileName . '-' . $a++ . '.' . $extension;
        }
        return $filenameWithExt;
    }
}