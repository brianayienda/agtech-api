<?php
namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;

class CropController extends Controller
{
    // Admin: see all; Farmer: see own
    public function index(Request $r)
    {
        $u = $r->user();
        $q = Crop::with('farmer:id,name,email');
        if ($u->role === 'farmer') {
            $q->where('user_id', $u->id);
        }

        return $q->latest()->paginate(20);
    }
    public function store(Request $r)
    {
        $data    = $r->validate(['name' => 'required', 'type' => 'required', 'quantity' => 'required|integer|min:0', 'user_id' => 'nullable|integer']);
        $u       = $r->user();
        $ownerId = $u->role === 'admin' ? ($data['user_id'] ?? $u->id) : $u->id;
        return Crop::create([ ...$data, 'user_id' => $ownerId]);
    }
    public function update(Request $r, Crop $crop)
    {
        $u = $r->user();
        if ($u->role === 'farmer' && $crop->user_id !== $u->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $r->validate(['name' => 'sometimes', 'type' => 'sometimes', 'quantity' => 'sometimes|integer|min:0', 'user_id' => 'prohibited']);
        $crop->update($data);
        return $crop;
    }
    public function destroy(Request $r, Crop $crop)
    {
        $u = $r->user();
        if ($u->role === 'farmer' && $crop->user_id !== $u->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $crop->delete();
        return response()->noContent();
    }
}
