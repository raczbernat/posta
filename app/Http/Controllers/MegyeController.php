<?php

namespace App\Http\Controllers;

use App\Models\Megye;

class MegyeController extends Controller
{
    /**
     * @api {get} /megyek Megyék listája
     * @apiName MegyekIndex
     * @apiGroup Megyek
     * @apiVersion 1.0.0
     * @apiDescription Az összes megye név szerint rendezve (a szűréshez használható `megye_id`-kkal).
     *
     * @apiSuccessExample {json} Siker (200):
     *     HTTP/1.1 200 OK
     *     [
     *       {"id": 1, "nev": "Bács-Kiskun"},
     *       {"id": 2, "nev": "Baranya"}
     *     ]
     */
    public function index()
    {
        return Megye::orderBy('nev')->get();
    }
}
