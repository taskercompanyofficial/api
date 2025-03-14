<?php

namespace App\Http\Controllers;

use App\Models\routes;
use Illuminate\Http\Request;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('path')) {
                $route = routes::where('path', $request->path)->first();
                return response()->json($route);
            }

            $routes = routes::with([
                'sub_routes' => function ($query) {
                    $query->where('status', 'active')
                        ->orderBy('sort_order');
                }
            ])
                ->whereNull('parent_route_id')
                ->where('status', 'active')
                ->orderBy('sort_order')
                ->get();
            return response()->json($routes);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:routes,key',
            'name' => 'nullable|string|unique:routes,name',
            'path' => 'nullable|string',
            'meta' => 'nullable|array',
            'status' => 'required|in:active,inactive',
            'parent_route_id' => 'nullable|exists:routes,id',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            $query = routes::query();
            if ($request->parent_route_id) {
                $query->where('parent_route_id', $request->parent_route_id);
            } else {
                $query->whereNull('parent_route_id');
            }
            $maxSort = $query->max('sort_order') ?? 0;
            if ($request->sort_order) {
                $maxSort = $request->sort_order;
            }
            $data = $request->all();
            $data['sort_order'] = $maxSort + 1;

            $route = routes::create($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Route created successfully',
                'data' => $route
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $route = routes::with('sub_routes')->find($id);
        return response()->json($route);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $route = routes::find($id);
        $route->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Route updated successfully' . $route->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(routes $routes)
    {
        $routes->delete();
        return response()->json(['status' => 'success', 'message' => 'Route deleted successfully']);
    }
}
