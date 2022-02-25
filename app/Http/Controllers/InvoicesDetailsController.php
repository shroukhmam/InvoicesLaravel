<?php

namespace App\Http\Controllers;
use App\Model\Invoice;
use App\Model\invoice_attachment;
use App\Model\invoice_detail;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Http\Request;

class InvoicesDetailsController extends Controller
{
    //
    public function edit($id,$notifyId=null)
    
    {
        if($notifyId!=null){
            auth()->user()
            ->unreadNotifications
            ->when($notifyId, function ($query) use ($notifyId) {
                return $query->where('id', $notifyId);
            })
            ->markAsRead();
        }
        $invoices = Invoice::where('id',$id)->first();
        $details  = invoice_detail::where('id_Invoice',$id)->get();
        $attachments  = invoice_attachment::where('invoice_id',$id)->get();

        return view('invoices.details_invoice',compact('invoices','details','attachments'));
    }
    public function get_file($invoice_number,$file_name)

    {
        $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download( $contents);
    }



    public function open_file($invoice_number,$file_name)

    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->file($files);
    }
    
    public function destroy(Request $request)
    {
        $invoices = invoice_attachment::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }
}
