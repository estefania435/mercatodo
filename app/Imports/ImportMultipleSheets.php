<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportMultipleSheets implements WithMultipleSheets
{
    /**
     * Specify sheets to import
     *
     * @return array
     */
    public function sheets(): array
    {
        return [
            'Worksheet' => new ProductImport(),
        ];
    }
}
