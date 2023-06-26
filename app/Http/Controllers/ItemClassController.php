<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemClassController extends Controller
{
    public function getItemClasses(){
        $itemClasses = DB::table('item_classes')->get();
        return $itemClasses ? $itemClasses : abort(404);
    }

    public function getItemClass($id){
        $item = DB::table('item_classes')->where('id', $id)->first();
        return $item ? $item : abort(404);
    }

    public function newItemClass(Request $request){
        $newItemClass = new ItemClass();

        $newItemClass->name = $request->name;

        $newItemClass->save();

        return $newItemClass;
    }

    public function updateItemsClass(Request $request, int $id){
        $updatedItemClass = ItemClass::findOrFail($id);

        $updatedItemClass->update($request->all());

        return response()->json(["data" => $updatedItemClass, "Message"=>sprintf('Class %s has been updated', $id)]);
    }

    public function deleteItemsClass(int $id){
        ItemClass::findOrFail($id)->delete();

        DB::table('items')->where('class_id', $id)->update([
            'class_id' => null
        ]);

        return response()->json(["Message"=>sprintf('Items class %s has been deleted', $id)]);
    }
}
