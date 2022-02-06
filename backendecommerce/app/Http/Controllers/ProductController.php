<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //ajouter un produit
  /*  public function add(Request $req){
        $validator=Validator::make($req->all(),[
            'name'=>'required',
            'category'=>'required',
            'desc'=>'required',
            'brand'=>'required',
            'image'=>'required|image',
            'price'=>'required',
        ]);
        if($validator->fails()){
            return  response()->json(['error'=>$validator->errors()->all()], 409);
        }
        $p=new product();
        $p->name=$req->name;
        $p->category=$req->category;
        $p->desc=$req->desc;
        $p->price=$req->price;
        $p->brand=$req->brand;
        $p->image=$req->image;
        $p->save();

        $url="http://localhost:8000/storage/";
        $file=$req->file('image');
        $extension=$file->getClientOriginalExtension();
        $path=$req->file('image')->storeAs('proimages/',$p->id.'.'.$extension);
        $p->image=$path;
        $p->imgpath=$url.$path;
        $p->save();


    }
*/
  //modifier un produit
  public function update(Request $req,$id){
    $p=product::find($id);
    if(is_null($p)){
        return response()->json(['message'=>'produit non trouvve'], 404);
    }
    $p->update($req->all());
return response()->json(['message'=>'Produit modifie avec succes'], 200);
}

 

public function getproductbyid($id){
    $product=product::find($id);
    if(is_null($product)){
        return response()->json(['message'=>'produit non trouvve'], 404);
    }
    return response()->json($product, 200);
}

public function delete(Request $req,$id){

    $product=product::find($id);
    if(is_null($product)){
        return response()->json( ['message'=>"produit non trouvee"],404);
    }
    $product->delete();
    return response(null,200);
}



public function show(Request $req){
    session(['keys'=>$req->keys]);
    $products=product::where(function($q){
    $q->where('products.id','LIKE','%'.session('keys').'%')
    ->orwhere('products.name','LIKE','%'.session('keys').'%')
    ->orwhere('products.price','LIKE','%'.session('keys').'%') 
    ->orwhere('products.category','LIKE','%'.session('keys').'%')    
    ->orwhere('products.brand','LIKE','%'.session('keys').'%'); 
})->select('products.*')->get();
return response()->json(['products'=>$products]);
}

 public function getProduct(){
        return response()->json(Product::all(),200);
    }

    public function file(Request $req){
        $validator=Validator::make($req->all(),[
            'name'=>'required',
            'category'=>'required',
            'desc'=>'required',
            'brand'=>'required',
            'image'=>'required|image',
            'price'=>'required',
        ]);
        if($validator->fails()){
            return  response()->json(['error'=>$validator->errors()->all()], 409);
        }
            $product=new product();
            $completFileName=$req->file('image')->getClientOriginalName();
            $fileNamelOnly=pathinfo($completFileName,PATHINFO_FILENAME);
            $extension=$req->file('image')->getClientOriginalExtension();
            //$comPic=str_replace('','_', $fileNamelOnly).'_'.rand().'_'.time().'.'.$extension;
            $path=$req->file('image')->storeAs('public/posts',$completFileName);
            $product->image=$completFileName;
            $product->name=$req->name;
            $product->category=$req->category;
            $product->desc=$req->desc;
            $product->price=$req->price;
            $product->brand=$req->brand;
            $product->save();

    }
}
