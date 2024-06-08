<?php

namespace App\Http\Livewire\Admin\Payments;

use App\Models\Invoice;
use App\Models\InvoicePayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Translation;
use Illuminate\Http\Request;

class Payments extends Component
{
    public $payments,$payment,$search='',$pay_mode,$paid_amount,$reference;
    public $reference_number,$amount,$date,$payment_mode,$status;
    public $Totpaid_amount,$balance,$invoice;
    //render the page and get payments
    public function render()
    {
        /* if the user is admin */
        // if(Auth::user()->user_type==2) {
        //     $query = Invoice::latest();
        // }
        // /* if the user is branch */
        // if(Auth::user()->user_type==3) {
        //     $query = InvoicePayment::where('created_by',Auth::user()->id)->latest();
        // }
        $query = Invoice::latest();
        if($this->search != '')
        {
            $search = $this->search;
            $query->where(function($query2) use ($search){
                $query2->where('customer_name','like','%'.$search.'%');
                $query2->orwhere('invoice_number','like','%'.$search.'%');
                $query2->orwhere('customer_phone','like',$search.'%');
                
            });
        }
        $this->payments = $query->orderBy('customer_name','asc')->get();
        return view('livewire.admin.payments.payments');
    }

    //prepare payment for new
    public function edit($id)
    {
        $this->payment = Invoice::where('id',$id)->first();
        $this->Totpaid_amount = InvoicePayment::where('invoice_id',$id)->sum('paid_amount');
        $this->paid_amount = $this->payment->total - $this->Totpaid_amount;
        $this->balance =  $this->payment->total - $this->Totpaid_amount;
        $this->resetErrorBag();
    }
    
    //load payment for delete confirmation
    public function deleteConfirm($id)
    {
        $this->payment = Invoice::find($id);
    }

    //delete payments
    public function delete()
    {
        if($this->payment)
        {
            $this->payment->status = 3; //ready to deliver
            $this->payment->save();
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'success',  'message' => 'Status Updated!']);
            $this->emit('closemodal');
        }
    }

    //update payment
    public function update(Request $request)
    {
        $this->validate([
            'paid_amount'   => 'required',
            'pay_mode'  => 'required'
        ]);
        $Inpaid_amount = InvoicePayment::where('invoice_id',$this->payment->id)->sum('paid_amount');
        $balance = $this->payment->total - $Inpaid_amount;
        if($balance < $this->paid_amount){
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'warning',  'message' => 'Amount cannot be greater than remaining amount!']);
        }else{
            InvoicePayment::create([
                'date' => Carbon::parse($this->date)->setTimeFrom(Carbon::now()),
                'invoice_id'    => $this->payment->id,
                'customer_name' => $this->payment->customer_name,
                'customer_id'   => $this->payment->customer_id,
                'created_by'    => Auth::user()->id,
                'financial_year_id' => getFinancialYearID(),
                'branch_id' => Auth::user()->id,
                'payment_mode'  => $this->pay_mode,
                'paid_amount'   => $this->paid_amount,
                'note'  => $this->reference,
                'payment_type'  => 1
            ]);
            $invoiceDeatis = Invoice::find($this->payment->id);
            $invoiceDeatis->status = $this->status;
            $invoiceDeatis->save();
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'success',  'message' => 'Payment Was Updated!']);
            $this->emit('closemodal');
            $this->payment = null;
        }
    
    }
}