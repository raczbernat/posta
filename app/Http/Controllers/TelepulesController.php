<?php

namespace App\Http\Controllers;

use App\Models\Telepules;
use Illuminate\Http\Request;

class TelepulesController extends Controller
{
    /**
     * @api {get} /telepulesek Települések listázása, keresés, megyeszűrés
     * @apiName TelepulesekIndex
     * @apiGroup Telepulesek
     * @apiVersion 1.0.0
     * @apiDescription Lapozott lista irányítószám szerint rendezve. A két szűrő együtt is használható.
     *
     * @apiQuery {String} [search] Keresés a település nevében vagy az irányítószám elején
     * @apiQuery {Number} [megye_id] Szűrés megye azonosító szerint
     *
     * @apiExample {curl} Példa:
     *     curl "http://localhost:8000/api/telepulesek?search=sze&megye_id=14"
     *
     * @apiSuccessExample {json} Siker (200):
     *     {
     *       "current_page": 1,
     *       "data": [
     *         {"id": 14, "irsz": "2000", "nev": "Szentendre", "megye_id": 14,
     *          "megye": {"id": 14, "nev": "Pest"}}
     *       ],
     *       "total": 1
     *     }
     */
    public function index(Request $request)
    {
        return Telepules::with('megye')
            ->when($request->search, fn ($q, $s) => $q->where(
                fn ($q) => $q->where('nev', 'like', "%{$s}%")->orWhere('irsz', 'like', "{$s}%")
            ))
            ->when($request->megye_id, fn ($q, $id) => $q->where('megye_id', $id))
            ->orderBy('irsz')
            ->paginate();
    }

    /**
     * @api {get} /telepulesek/:id Egy település lekérése
     * @apiName TelepulesShow
     * @apiGroup Telepulesek
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id Település azonosító
     *
     * @apiSuccessExample {json} Siker (200):
     *     {"id": 14, "irsz": "2000", "nev": "Szentendre", "megye_id": 14, "megye": {"id": 14, "nev": "Pest"}}
     * @apiError (404) NotFound Nincs ilyen település
     */
    public function show(Telepules $telepules)
    {
        return $telepules->load('megye');
    }

    /**
     * @api {post} /telepulesek Új település felvétele
     * @apiName TelepulesStore
     * @apiGroup Telepulesek
     * @apiVersion 1.0.0
     * @apiPermission token
     * @apiHeader {String} Authorization `Bearer <token>`
     *
     * @apiBody {String{4}} irsz Irányítószám (4 számjegy)
     * @apiBody {String} nev Település neve
     * @apiBody {Number} megye_id Létező megye azonosítója
     *
     * @apiSuccessExample {json} Siker (201):
     *     {"id": 21, "irsz": "2100", "nev": "Gödöllő", "megye_id": 14, "megye": {"id": 14, "nev": "Pest"}}
     * @apiError (401) Unauthenticated Hiányzó vagy érvénytelen token
     * @apiError (422) ValidationError Hibás mező
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'irsz' => 'required|digits:4',
            'nev' => 'required|string|max:255',
            'megye_id' => 'required|exists:megyek,id',
        ]);

        return response()->json(Telepules::create($data)->load('megye'), 201);
    }

    /**
     * @api {put} /telepulesek/:id Település módosítása
     * @apiName TelepulesUpdate
     * @apiGroup Telepulesek
     * @apiVersion 1.0.0
     * @apiPermission token
     * @apiHeader {String} Authorization `Bearer <token>`
     *
     * @apiParam {Number} id Település azonosító
     * @apiBody {String{4}} [irsz] Irányítószám
     * @apiBody {String} [nev] Település neve
     * @apiBody {Number} [megye_id] Megye azonosító
     *
     * @apiSuccessExample {json} Siker (200):
     *     {"id": 21, "irsz": "2100", "nev": "Gödöllő", "megye_id": 14, "megye": {"id": 14, "nev": "Pest"}}
     * @apiError (401) Unauthenticated Hiányzó vagy érvénytelen token
     * @apiError (404) NotFound Nincs ilyen település
     * @apiError (422) ValidationError Hibás mező
     */
    public function update(Request $request, Telepules $telepules)
    {
        $telepules->update($request->validate([
            'irsz' => 'sometimes|digits:4',
            'nev' => 'sometimes|string|max:255',
            'megye_id' => 'sometimes|exists:megyek,id',
        ]));

        return $telepules->load('megye');
    }

    /**
     * @api {delete} /telepulesek/:id Település törlése
     * @apiName TelepulesDestroy
     * @apiGroup Telepulesek
     * @apiVersion 1.0.0
     * @apiPermission token
     * @apiHeader {String} Authorization `Bearer <token>`
     *
     * @apiParam {Number} id Település azonosító
     * @apiSuccess (204) {null} - Sikeres törlés, nincs választörzs
     * @apiError (401) Unauthenticated Hiányzó vagy érvénytelen token
     * @apiError (404) NotFound Nincs ilyen település
     */
    public function destroy(Telepules $telepules)
    {
        $telepules->delete();

        return response()->noContent();
    }
}
