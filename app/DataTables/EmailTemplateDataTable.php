<?php

namespace App\DataTables;

use App\Models\EmailTemplate;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class EmailTemplateDataTable extends DataTable
{
    use CustomDataTable;

    protected $printColumns = ['subject','cc','bcc','created_at','updated_at'];
    protected $exportColumns = ['subject','cc','bcc','created_at','updated_at'];
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $_this = $this;

        return datatables($query)
            ->addColumn('created_at',function($row) use($_this){

                return $_this->printDateTime($row->created_at);
            })
            ->addColumn('updated_at',function($row) use($_this){

                return $_this->printDateTime($row->updated_at);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EmailTemplate $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EmailTemplate $model)
    {
        return $model->newQuery()->select($this->getColumns());
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()                    
                    ->columns($this->getColumns())
                    ->addColumnBefore($this->getSrNoColumn())
                    ->addColumn($this->getActionColumn())
                    ->ajax([
                        'url' => url('admin/email-template'),
                        'type' => 'GET',
                        'data' => 'function(d) { d.timezone = $.laravel.datetime.getTimeZone(); }',
                    ])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'subject',
            'body',
            'bcc',
            'cc',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'emailtemplate_' . time();
    }

    /**
     * SRno. column
     * @return  array
     */
    protected function getSrNoColumn()
    {
        return [
            'data'=>'id',
            'render'=>'$.laravel.dataTables.srNoColumn(data,type,full,meta)',
            'title'=>'#',
            'orderable'=>false,
        ];
    }

    /**
     * Get Action Column
     * @return   Array
     */
    
    protected function getActionColumn()
    {
        return [
            'data'=>'id',
            'render'=>'$.laravel.dataTables.actionColumn(data,type,full,meta,"email-template")',
            'title'=>'Action',
            'orderable'=>false,
        ];
    }
}
