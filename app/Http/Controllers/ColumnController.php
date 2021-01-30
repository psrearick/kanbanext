<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ColumnController
 * @package App\Http\Controllers
 *
 * @mixin Builder
 */
class ColumnController extends Controller
{
    /**
     * get all columns
     *
     * @return array
     */
    public function index(): array
    {
        return Column::where(['active' => true])->get()->toArray();
    }

    /**
     * add column
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $column = new Column([
            'name' => $request->input('name')
        ]);
        $column->save();

        return response()->json('Column Added');
    }

    /**
     * edit column view
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit(int $id): JsonResponse
    {
        $column = Column::find($id);
        return response()->json($column);
    }

    /**
     * update column
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $column = Column::find($id);
        $column->update($request->all());
        return response()->json('Column updated');
    }

    /**
     * delete column
     *
     * @param int $id
     * @return JsonResponse
     *
     */
    public function delete(int $id): JsonResponse
    {
        $column = Column::find($id);
        $column->active = false;
        $column->save();
        return response()->json('Column deleted');
    }
}
