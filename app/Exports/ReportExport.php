<?php


namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements fromView
{

    private $data;
    private $view;

    function __construct($data,$view)
    {
        $this->data = $data;
        $this->view = $view;

    }

    public function view(): View
    {
        return view($this->view, [
            'data' => $this->data
        ]);
    }
}
