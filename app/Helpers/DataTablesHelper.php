<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DataTablesHelper
 * @author Duran Can Yılmaz
 * @version 1.0.0 
 * @package App\Helpers
 * 
 * @Usage in Controller: 
 * 
 * use App\Helpers\DataTablesHelper;
 * use App\Models\Category;
 * 
 * $this->model, $this->datatable_helper, $this->datatable, $this->datatable_js;
 * 
 * public function __construct()
 * {
 *      $this->model = new Category();
 *      $this->datatable_helper = new DataTablesHelper($this->model, route('api.user.get.all'), 'GET');
 * } 
 * 
 *  public function view_all_users(Request $request) {
 *      $datatable = $this->datatable_helper->create_table($request);
 *      $datatable_js = $this->datatable_helper->create_js();
 *      return view('admin.users.index', compact('datatable', 'datatable_js'));
 *  }
 * 
 * @Usage in Blade:
 * {!! $datatable !!}
 * {!! $datatable_js !!}
 * 
 * 
 */
class DataTablesHelper
{
    private Model $model;
    public array $fillable;
    protected array $protected_columns = ['password', 'remember_token', 'email_verified_at'];
    private Request $request;
    private string $route;
    private string $method;
    public function __construct(Model $model, string $route = 'api/..', $method = 'GET')
    {
        $this->model = $model;
        $this->fillable =  ['id'] + array_diff($model->getFillable(), $this->protected_columns);
        $this->route = $route;
        $this->method = $method;
    }


    public function api(Request $request)
    {
        $this->request = $request;
        $draw = intval($request->get('draw'));
        $start = intval($request->get('start'));
        $length = intval($request->get('length'));
        $search = $request->get('search')['value'];
        $order = $request->get('order');

        $query = $this->model->query();
        if ($search) {
            foreach ($this->fillable as $column) {
                $query->orWhere($column, 'like', '%' . $search . '%');
            }
        }

        if (!empty($order)) {
            foreach ($order as $o) {
                $column = $this->fillable[$o['column']];
                $dir = $o['dir'];
                $query->orderBy($column, $dir);
            }
        }

        $data = $query->paginate($length, ['*'], 'page', ($start / $length) + 1);
        return [
            'draw' => $draw,
            'recordsTotal' => $query->count(),
            'recordsFiltered' => $query->count(),
            'data' => $data->items(),
        ];
    }

    public function create_table()
    {
        $columns = $this->fillable;
        $table = '<table class="table table-bordered table-striped" id="dataTable">';
        $table .= '<thead>';
        $table .= '<tr>';
        foreach ($columns as $column) {
            $table .= '<th>' . $column . '</th>';
        }
        $table .= '<th>İşlemler</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '</table>';
        return $table;
    }

    public function create_js()
    {
        $columns = $this->fillable;
        $js = '<script>window.onload = function() {
        $("#dataTable").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "' . $this->route . '",
        "columns": [';
        foreach ($columns as $column) {
            $js .= '{ 
                "data": "' . $column . '",
                "render": function (data, type, row) {
                    //eğer id satırı ise link yap
                    if (row.id == data) {
                        return "<a href=\'" + row.id + "\'>" + data + "</a>";
                    } else {
                        return data;
                    }
                }
             },';
        }
        $js .= '{
            "data": "id",
            "render": function (data, type, row) {
                return "<form action=\'" + row.id + "\' method=\'POST\' class=\'formajax_confirm d-inline\'><button type=\'submit\' class=\'btn btn-danger\'>Sil</button></form>";
            }
        }';
        $js .= ']});}</script>';
        return $js;
    }
}
