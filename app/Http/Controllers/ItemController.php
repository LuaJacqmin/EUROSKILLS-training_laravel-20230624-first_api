<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function getItems(){
        $items = DB::table('items')->get();
        return $items ? $items : abort(404);
    }

    public function getItem($id){
        $item = DB::table('items')->where('id', $id)->first();
        return $item ? $item : abort(404);
    }

    public function getItemByQueryParameters(Request $request){
        $queryParams = $request->query();
        if($queryParams){
            // GET BY ID
            if(count($queryParams) == 1 && isset($queryParams['user_id'])){
                $user_id =  $queryParams['user_id'];

                $items =  DB::table('items')->where('user_id', '=', $user_id)->get();
                return $items;
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function newItem(Request $request){
        $newItem = new Item();

        $newItem->name = $request->name;

        $user = DB::table('users')->where('id', $request->user_id)->first();
        $itemClass = DB::table('item_classes')->where('id', $request->class_id)->first();

        #TODO check user_id and catch error if user does not exist properly
        if($user){
            $newItem->user_id = $request->user_id ? $request->user_id : null;
        } else {
            abort(403, sprintf('Error. User %s does not exist. Can\'t assign item to inexistant user', $request->user_id));
        }

        if($itemClass){
            $newItem->class_id = $request->class_id ? $request->class_id : null;
        } else {
            abort(403, sprintf('Error. Class %s does not exist. Can\'t assign item to inexistant class', $request->user_id));
        }


        $newItem->save();

        return $newItem;
    }

    public function updateItem(Request $request, int $id){
        $updatedItem = Item::findOrFail($id);

        //TODO : deny update if user id or class id leads to inexistant entity
        $updatedItem->update($request->all());

        return response()->json(["data" => $updatedItem, "Message"=>sprintf('Item %s has been updated', $id)]);
    }

    public function deleteItem(int $id){
        Item::findOrFail($id)->delete();

        return response()->json(["Message"=>sprintf('Item %s has been deleted', $id)]);
    }
}
