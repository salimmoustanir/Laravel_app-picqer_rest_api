<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Validator;
use Picqer\Api\Client;
use App\Models\Product;

class Products extends Controller
{
    
   public function getProductsAPI(){ 
       $subDomain = 'fairweb';
       $apiKey = 'lhxORib7i45X27mj2rO8PnT3uh9ei9BGzS28t41r3GRGZRsC';
       $apiClient = new Client($subDomain, $apiKey);
       $apiClient->enableRetryOnRateLimitHit();
       $apiClient->setUseragent('picqer.com/api - support@picqer.com');
       $products= $apiClient->getProducts();
       //return response()->json($products["data"]);
       foreach($products["data"] as $product) {
       $myProduct = new Product();
       $myProduct->idproduct = $product["idproduct"];
       $myProduct->idvatgroup = $product["idvatgroup"];
       $myProduct->name = $product["name"];
       $myProduct->price = $product["price"];
       $myProduct->fixedstockprice = $product["fixedstockprice"];
       $myProduct->productcode_supplier = $product["productcode_supplier"];
       $myProduct->productcode = $product["productcode"];
       $myProduct->deliverytime = $product["deliverytime"];
       $myProduct->description = $product["description"];
       $myProduct->barcode = $product["barcode"];
       $myProduct->unlimitedstock = $product["unlimitedstock"];
       $myProduct->weight = $product["weight"];
       $myProduct->length = $product["length"]; 
       $myProduct->width = $product["width"]; 
       $myProduct->height = $product["height"];
       $myProduct->country_of_origin = $product["country_of_origin"]; 
       $myProduct->hs_code = $product["hs_code"]; 
       $myProduct->active = $product["active"]; 
       $myProduct->minimum_purchase_quantity = $product["minimum_purchase_quantity"];
       $myProduct->purchase_in_quantities_of = $product["purchase_in_quantities_of"];

       $myProduct->save();
           
       }
       return response()->json('create with success');

   }
   public function CreateProduct(Request $request){
    $rules = [
        "name" => "required",
        "price" => "required",
        "productcode" => "required",

    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json($validator);
    }
               $subDomain = 'fairweb';
       $apiKey = 'lhxORib7i45X27mj2rO8PnT3uh9ei9BGzS28t41r3GRGZRsC';
       $apiClient = new Client($subDomain, $apiKey);
       $apiClient->enableRetryOnRateLimitHit();
       $apiClient->setUseragent('picqer.com/api - support@picqer.com');
    // Retrieve VAT groups
$vatGroups = $apiClient->getVatgroups();

// Add a new product to Picqer account
$product = [
    'productcode' => $request->productcode,
    'productcode_supplier' => $request->productcode,
    'name' => $request->name,
    'price' =>$request->price,
    'fixedstockprice' =>$request->fixedstockprice,
    'weight' => $request->weight,
    'barcode' => $request->barcode,
    'idvatgroup' => $vatGroups['data'][0]['idvatgroup'] // First VAT group in Picqer
];
$result = $apiClient->addProduct($product);
//return response()->json($result);
    Product::create([
        'idproduct'=>$result["data"]["idproduct"],
        'idvatgroup' =>$vatGroups['data'][0]['idvatgroup'],
        'name' =>$request->name,
        'price' =>$request->price,
        'fixedstockprice' =>$request->fixedstockprice,
        'productcode' =>$request->productcode,
        'deliverytime' =>$request->deliverytime,
        'description' =>$request->description,
        'barcode' =>$request->barcode,
        'unlimitedstock' =>$request->unlimitedstock,
        'weight' =>$request->weight,
        'height' =>$request->height,
        'country_of_origin' =>$request->country_of_origin,
        'hs_code' =>$request->hs_code,
        'active' =>$request->active,
        'minimum_purchase_quantity' =>$request->minimum_purchase_quantity,
        'purchase_in_quantities_of' =>$request->purchase_in_quantities_of,
    ]);


    return response()->json('create with success');
   }
      public function updateProduct(Request $request){
    $rules = [
        "name" => "required",
        "price" => "required",
        "productcode" => "required",

    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json($validator);
    }
               $subDomain = 'fairweb';
       $apiKey = 'lhxORib7i45X27mj2rO8PnT3uh9ei9BGzS28t41r3GRGZRsC';
       $apiClient = new Client($subDomain, $apiKey);
       $apiClient->enableRetryOnRateLimitHit();
       $apiClient->setUseragent('picqer.com/api - support@picqer.com');
 $product = $apiClient->getProductByProductcode($request->productcode);

// Compose the put data
// Note: if one would like to change a product field
//      This can be done with the following syntax:
//      $data = ['productfields' => [['idproductfield' => 1, 'value' => 1], ['idproductfield' => 2, 'value' => 2]]];

//return response()->json($product);
$apiClient->updateProduct($product['data']['idproduct'], $request->all());

    $prod=Product::where('idproduct', $product['data']['idproduct'])->update($request->all());
    return response()->json('updated successfully');
   }
   public function GetProducts(Request $request){
    
$Products=Product::all();
    return response()->json($Products);
   }
         public function inactivateProduct(Request $request){
    $rules = [
        "idproduct" => "required",
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json($validator);
    }
       $subDomain = 'fairweb';
       $apiKey = 'lhxORib7i45X27mj2rO8PnT3uh9ei9BGzS28t41r3GRGZRsC';
       $apiClient = new Client($subDomain, $apiKey);
       $apiClient->enableRetryOnRateLimitHit();
       $apiClient->setUseragent('picqer.com/api - support@picqer.com');
 $apiClient->inactivateProduct($request->idproduct);

// Compose the put data
// Note: if one would like to change a product field
//      This can be done with the following syntax:
//      $data = ['productfields' => [['idproductfield' => 1, 'value' => 1], ['idproductfield' => 2, 'value' => 2]]];

//return response()->json($product);

    $prod=Product::where('idproduct', $request->idproduct)->delete();
    return response()->json('inactivated successfully');
   }
   
   // 3rd question
   public function GetstockProduct(Request $request){
           $rules = [
        "idproduct" => "required",
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json($validator);
    }
       $subDomain = 'fairweb';
       $apiKey = 'lhxORib7i45X27mj2rO8PnT3uh9ei9BGzS28t41r3GRGZRsC';
       $apiClient = new Client($subDomain, $apiKey);
       $apiClient->enableRetryOnRateLimitHit();
       $apiClient->setUseragent('picqer.com/api - support@picqer.com');
       $stock= $apiClient->getProductStock($request->idproduct);
       
       return response()->json($stock);
   }
      public function UpdateStockProduct(Request $request){
           $rules = [
        "idproduct" => "required",
        "idwarehouse" => "required",
        "amount" => "required",
        "reason" => "required",
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json($validator);
    }
       $subDomain = 'fairweb';
       $apiKey = 'lhxORib7i45X27mj2rO8PnT3uh9ei9BGzS28t41r3GRGZRsC';
       $apiClient = new Client($subDomain, $apiKey);
       $apiClient->enableRetryOnRateLimitHit();
       $apiClient->setUseragent('picqer.com/api - support@picqer.com');
       
       $data = [
    'amount' => $request->amount,
    'reason' => $request->reason
];
       $stock= $apiClient->updateProductStockForWarehouse($request->idproduct,$request->idwarehouse,$data);
       
       return response()->json($stock);
   }
   
         public function DeleteStockProduct(Request $request){
           $rules = [
        "idproduct" => "required",
        "idwarehouse" => "required",
        "value" => 'required',
        "reason" => "required",
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json($validator);
    }
       $subDomain = 'fairweb';
       $apiKey = 'lhxORib7i45X27mj2rO8PnT3uh9ei9BGzS28t41r3GRGZRsC';
       $apiClient = new Client($subDomain, $apiKey);
       $apiClient->enableRetryOnRateLimitHit();
       $apiClient->setUseragent('picqer.com/api - support@picqer.com');
       
       $data = [
    'change' => $request->value,
    'reason' => $request->reason
];
       $stock= $apiClient->updateProductStockForWarehouse($request->idproduct,$request->idwarehouse,$data);
       
       return response()->json($stock);
   }
            public function AddStockProduct(Request $request){
           $rules = [
        "idproduct" => "required",
        "idwarehouse" => "required",
        "value" => 'required',
        "reason" => "required",
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return response()->json($validator);
    }
       $subDomain = 'fairweb';
       $apiKey = 'lhxORib7i45X27mj2rO8PnT3uh9ei9BGzS28t41r3GRGZRsC';
       $apiClient = new Client($subDomain, $apiKey);
       $apiClient->enableRetryOnRateLimitHit();
       $apiClient->setUseragent('picqer.com/api - support@picqer.com');
       
       $data = [
    'change' => $request->value,
    'reason' => $request->reason
];
       $stock= $apiClient->updateProductStockForWarehouse($request->idproduct,$request->idwarehouse,$data);
       
       return response()->json($stock);
   }
   
}
