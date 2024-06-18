<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class Invoices_Report extends Controller
{
    public function index()
    {
        return view('reports.invoices_report');
    }

    public function Search_invoices(Request $request)
    {
        $rdio = $request->rdio;
        if ($rdio == 1) {
       
            if($request->type && $request->start_at == '' && $request->end_at == ''){
                $invoices = Invoices::where('Status', $request->type)->get();
                return view('reports.invoices_report')->withDetails($invoices);
            }

            else{
                 $start_at = date($request->start_at);
                 $end_at = date($request->end_at);
                 $type = $request->type;

                $invoices = Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status', $request->type)->get();
                return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails($invoices);             
            }
        }
        else{
            $invoiceNumber = $request->invoice_number;
            $invoices = invoices::where('invoice_number',$invoiceNumber)->get();
            return view('reports.invoices_report')->withDetails($invoices);
        }
    }


}

