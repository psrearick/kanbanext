<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Spatie\DbDumper\Databases\MySql;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        $last = Column::where('active', true)->orderBy('rank', 'desc')->first();
        $rank = $last ? $last->rank + 100 : 100;
        $column = new Column([
            'name' => $request->input('name'),
            'rank' => $rank
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
        $cards = $column->cards;
        foreach ($cards as $card) {
            $card->active = false;
            $card->save();
        }
        $column->active = false;
        $column->save();
        return response()->json('Column deleted');
    }

    public function downloadDatabase(): BinaryFileResponse
    {
        $database = Config::get('database.connections.mysql');
        MySql::create()
            ->setDbName($database['database'])
            ->setUserName($database['username'])
            ->setPassword($database['password'])
            ->dumpToFile('dump.sql');
        $headers = [
            'Content-Type' => 'application/sql',
        ];
        return response()->download('dump.sql', 'db-dump.sql', $headers);

    }
}
