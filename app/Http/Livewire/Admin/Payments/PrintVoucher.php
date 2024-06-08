<?php

namespace App\Http\Livewire\Admin\Payments;

use Livewire\Component;
use App\Models\InvoicePayment;
use App\Models\Invoice;
use App\Models\MasterSetting;
use Auth;

class PrintVoucher extends Component
{
    public $bill;

    //render the page
    public function render()
    {
        return view('livewire.admin.payments.print-voucher')->extends('layouts.print-layout')
        ->section('content');
    }

    //load the bill
    public function mount($id){
        $settings = new MasterSetting();
        $site = $settings->siteData();
        $this->company_name = $site['company_name'] ?? 'Tailor POS';
        /* if the user is admin */
        if(Auth::user()->user_type==2) {
            $this->invoice = Invoice::where('id',$id)->first();
        }
        /* if the user is branch */
        if(Auth::user()->user_type==3) {
            $this->invoice = Invoice::where('id',$id)->where('created_by',Auth::user()->id)->first();
        }
        if(!$this->invoice){
            abort(404);
        }
    }
}