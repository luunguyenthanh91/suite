<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\FromArray;

class CollaboratorsExport implements FromArray
{
    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        return $this->invoices;
    }
}