<?php

namespace App\DataTables\Admin;

use App\Facades\UtilityFacades;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TestimonialDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return UtilityFacades::date_time_format($request->created_at);
            })
            ->editColumn('image', function (Testimonial $testimonial) {
                if ($testimonial->image) {
                    if (File::exists(Storage::path($testimonial->image))) {
                        $return = "<img src='" . Storage::url(tenant('id') . '/' . $testimonial->image) . "' width='50' />";
                    } else {
                        $return = "<img src='" . Storage::url('seeder-image/350x250.png') . "' width='50' />";
                    }
                } else {
                    $return = "<img src='" . Storage::url('seeder-image/350x250.png') . "' width='50' />";
                }
                return $return;
            })
            ->editColumn('rating', function (Testimonial $testimonial) {
                $starrating = '<div class="text-center">';
                for ($i = 1; $i <= 5; $i++) {
                    if ($testimonial->rating < $i) {
                        if (is_float($testimonial->rating) && (round($testimonial->rating) == $i)) {
                            $starrating .= '<i class="text-warning fas fa-star-half-alt"></i>';
                        } else {
                            $starrating .= '<i class="fas fa-star"></i>';
                        }
                    } else {
                        $starrating .= '<i class="text-warning fas fa-star"></i>';
                    }
                }
                $starrating .= '<br><span class="theme-text-color">(' . number_format($testimonial->rating, 1) . ')</span></div>';
                return $starrating;
            })
            ->addColumn('action', function (Testimonial $testimonial) {
                return view('admin.testimonial.action', compact('testimonial'));
            })
            ->editColumn('status', function (Testimonial $testimonial) {
                $checked = ($testimonial->status == 1) ? 'checked' : '';
                $status   = '<label class="form-switch">
                             <input class="form-check-input chnageStatus" name="custom-switch-checkbox" ' . $checked . ' data-id="' . $testimonial->id . '" data-url="' . route('testimonial.status', $testimonial->id) . '" type="checkbox">
                             </label>';
                return $status;
            })
            ->rawColumns(['rating', 'image', 'action', 'status']);
    }

    public function query(Testimonial $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('testimonial-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>'
                ],
                'lengthMenu' => __('_MENU_ entries per page'),
                "searchPlaceholder" => __('Search...'), "search" => ""
            ])
            ->initComplete('function() {
                        var table = this;
                        var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
                        searchInput.removeClass(\'form-control form-control-sm\');
                        searchInput.addClass(\'dataTable-input\');
                        var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');
                    }')
            ->parameters([

                "dom" =>  "
                                    <'dataTable-top row'<'dataTable-dropdown page-dropdown col-lg-2 col-sm-12'l><'dataTable-botton table-btn col-lg-6 col-sm-12'B><'dataTable-search tb-search col-lg-3 col-sm-12'f>>
                                    <'dataTable-container'<'col-sm-12'tr>>
                                    <'dataTable-bottom row'<'col-sm-5'i><'col-sm-7'p>>
                                       ",
                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-light-primary no-corner me-1 add_module', 'action' => " function ( e, dt, node, config ) {
                                window.location = '" . route('testimonial.create') . "';
                           }"],
                    [
                        'extend' => 'collection', 'className' => 'btn btn-light-secondary me-1 dropdown-toggle', 'text' => '<i class="ti ti-download"></i> Export', "buttons" => [
                            ["extend" => "print", "text" => '<i class="fas fa-print"></i> Print', "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                            ["extend" => "csv", "text" => '<i class="fas fa-file-csv"></i> CSV', "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                            ["extend" => "excel", "text" => '<i class="fas fa-file-excel"></i> Excel', "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                            ["extend" => "pdf", "text" => '<i class="fas fa-file-pdf"></i> PDF', "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                        ],
                    ],
                    ['extend' => 'reset', 'className' => 'btn btn-light-danger me-1'],
                    ['extend' => 'reload', 'className' => 'btn btn-light-warning'],
                ],
                "scrollX" => true,
                "drawCallback" => 'function( settings ) {
                            var tooltipTriggerList = [].slice.call(
                                document.querySelectorAll("[data-bs-toggle=tooltip]")
                              );
                              var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                              });
                              var popoverTriggerList = [].slice.call(
                                document.querySelectorAll("[data-bs-toggle=popover]")
                              );
                              var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                                return new bootstrap.Popover(popoverTriggerEl);
                              });
                              var toastElList = [].slice.call(document.querySelectorAll(".toast"));
                              var toastList = toastElList.map(function (toastEl) {
                                return new bootstrap.Toast(toastEl);
                              });
                        }'
            ])->language([
                'buttons' => [
                    'create' => __('Create'),
                    'export' => __('Export'),
                    'print' => __('Print'),
                    'reset' => __('Reset'),
                    'reload' => __('Reload'),
                    'excel' => __('Excel'),
                    'csv' => __('CSV'),
                ]
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('No')->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('name')->title(__('Name')),
            Column::make('title')->title(__('Title')),
            Column::make('image')->title(__('Image')),
            Column::make('rating')->title(__('Rating'))->addClass('text-center'),
            Column::make('created_at')->title(__('Created At')),
            Column::make('status')->title(__('Status')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->width('20%'),
        ];
    }

    protected function filename(): string
    {
        return 'Testimonial_' . date('YmdHis');
    }
}
