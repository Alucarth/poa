<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ReportExport implements FromView
{
    /**
     * Set some values for Mobile::properties
     *
     * @param string device data
     */
    public function __construct ($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('report.excel', $this->data);
    }
}
