<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CardController
 * @package App\Http\Controllers
 *
 * @mixin Builder
 */
class CardController extends Controller
{
    /**
     * return all cards
     *
     * @return array
     */
//    public function index(): array
    public function index(): array
    {
        $cards = Card::where(['active' => true])->get()->toArray();
        return $cards > 1 ? $cards : [$cards];
    }

    /**
     * add card
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $columnId = $request->input('column_id');
        $last = Card::where(['column_id' => $columnId, 'active' => true])->orderBy('rank', 'desc')->first();
        $rank = $last ? $last->rank + 100 : 100;
        $card = new Card([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'column_id' => $columnId,
            'rank' => $rank
        ]);
        $card->save();

        return response()->json('Card added');
    }

    /**
     * edit card view
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit(int $id): JsonResponse
    {
        $card = Card::find($id);
        return response()->json($card);
    }

    /**
     * Update card
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $card = Card::find($id);
        $card->update($request->all());
        return response()->json('Card updated');
    }

    /**
     * Delete card
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $card = Card::find($id);
        $card->active = false;
        $card->save();
        return response()->json('Card deleted');
    }

}
