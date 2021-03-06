<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActResource;
use App\Http\Resources\UserResource;
use App\Models\Act;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ActController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->isAdmin()) {
            $acts = Act::whereHas('client')->paginate(10);
        } else {
            $acts = Act::whereHas('client')->where('user_id', $user->id)->paginate(10);
        }
        return ActResource::collection($acts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'acts' => 'required|array'
        ]);

        $act = Act::create([
            'user_id' => Auth::user()->id
        ]);

        Order::whereIn('id', $request->input('acts'))->update([
            'act_id' => $act->id
        ]);

        return response()->json(['success']);
    }

    public function destroy(Act $act)
    {
        Order::where('act_id', $act->id)->update([
            'act_id' => null
        ]);

        return $act->delete();
    }

    public function download(Act $act)
    {
        $data = [
            'title' => 'Акт приема-передачи товаров',
            'date' => Carbon::now()->translatedFormat('\"d\" F Y'),
            'act' => new ActResource($act),
        ];

        $pdf = PDF::loadView('pdf.act', $data);

        return $pdf->download('act_' . $act->id . '_' . $act->created_at->format('d.m.Y') . '.pdf');
    }
}
