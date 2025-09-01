<?php
namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return [
            'totalFarmers'   => User::where('role', 'farmer')->count(),
            'totalCrops'     => Crop::count(),
            'cropsPerFarmer' => User::where('role', 'farmer')
                ->withCount('crops') // define relation below
                ->get(['id', 'name', 'crops_count']),
        ];
    }
    public function farmer(Request $r)
    {
        $u = $r->user();
        return [
            'myTotalCrops' => Crop::where('user_id', $u->id)->count(),
            'byType'       => Crop::where('user_id', $u->id)
                ->selectRaw('type, COUNT(*) as count')
                ->groupBy('type')->get(),
            'profile'      => $u->only('name', 'email', 'phone'),
        ];
    }
}
