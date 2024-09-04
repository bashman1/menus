<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function createMenu(Request $request)
    {
        try {
            // Insert data into the 'menus' table
            $menu=Menu::insert($request->all());
            return $this->genericResponse(true, 'Menu created successfully', 201, $menu);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }



    public function getMenu(){
        try {
            // Fetch all menu items ordered by hierarchy and id, and group by hierarchy
            $menus = Menu::orderBy('hierarchy')->orderBy('id', 'asc')->get()->groupBy('hierarchy');

            // Function to build hierarchy recursively
            $buildHierarchy = function ($level, $parentId = null) use (&$buildHierarchy, $menus) {
                if (!isset($menus[$level])) {
                    return [];
                }

                return $menus[$level]->filter(function ($menu) use ($parentId) {
                    return $menu->parent_id == $parentId;
                })->map(function ($menu) use ($level, $buildHierarchy) {
                    // Recursively build children and order them by id as well
                    $menu['children'] = $buildHierarchy($level + 1, $menu['id']);
                    return $menu;
                })->values()->toArray();  // Ensure proper ordering in the collection
            };

            // Start building hierarchy from level 0
            $menuHierarchy = $buildHierarchy(0);

            return $this->genericResponse(true, "Menu data fetched successfully", 200, $menuHierarchy);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }
}
