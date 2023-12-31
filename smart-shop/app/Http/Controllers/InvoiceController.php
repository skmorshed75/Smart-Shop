<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\DB;
use alert;

class InvoiceController extends Controller
{
    function InvoicePage():View{
        return view('pages.dashboard.invoice-page');
    }

    function SalePage():View{
        return view('pages.dashboard.sale-page');
    }

    function invoiceCreate(Request $request){
        DB::beginTransaction();

        try{
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');
            $customer_id = $request->input('customer_id');

            $invoice = Invoice::create([
                'total' => $total,
                'discount' => $discount,
                'vat' => $vat,
                'payable' => $payable,
                'user_id' => $user_id,
                'customer_id' => $customer_id
            ]);
            $invoiceID = $invoice->id;

            $products = $request->input('products');

            foreach($products as $EachProduct){
                InvoiceProduct::create([
                    'invoice_id' => $invoiceID,
                    'user_id' => $user_id,
                    'product_id' => $EachProduct['product_id'],
                    'qty' => $EachProduct['qty'],
                    'sale_price' => $EachProduct['sale_price']                    
                ]);
            }

            DB::commit();

            return 1;
            
        } catch(Exception $e) {
            DB::rollBack();
            return 0;
        }
    }


    function invoiceList(Request $request){
        $user_id = $request->header('id');
        return Invoice::where('user_id', $user_id)->with('customer')->get();
    }


    function invoiceDetails(Request $request){

        $user_id = $request->header('id');
        $customerId = $request->input('cus_id');
        $invoiceId = $request->input('inv_id');
        
        $customerDetails = Customer::where('user_id', $user_id)
                                ->where('id', $customerId)
                                ->first();

        $invoiceTotal = Invoice::where('user_id', $user_id)
                                ->where('id', $invoiceId)
                                ->first();

        $invoiceProduct = InvoiceProduct::join('products', 'invoice_products.product_id', '=', 'products.id')
                                    ->where('invoice_products.invoice_id',$invoiceId)
                                    ->where('invoice_products.user_id', $user_id)
                                    ->get();

        // return array(
        //     'customer' => $customerDetails,
        //     'invoice' => $invoiceTotal,
        //     'product' => $invoiceProduct
        // );

        return response()->json([
            'customer' => $customerDetails,
            'invoice' => $invoiceTotal,
            'product' => $invoiceProduct
        ]);
    }


    function invoiceDelete(Request $request){
        DB::beginTransaction();
        try{
            $user_id = $request->header('id');
            //echo $user_id . "  " . $request->input('inv_id');
            InvoiceProduct::where('invoice_id',$request->input('inv_id'))
                ->where('user_id',$user_id)
                ->delete();

            Invoice::where('id',$request->input('inv_id'))
                ->delete();
            
            DB::commit();
            return 1;
        }
        catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }
}
