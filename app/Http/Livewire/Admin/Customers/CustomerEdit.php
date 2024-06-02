<?php

namespace App\Http\Livewire\Admin\Customers;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Auth;
use App\Models\Translation;

class CustomerEdit extends Component
{
    public $date, $first_name,$phone_number_1, $phone_number_2, $address, $edit_id;
    public $created_by,$is_active = 1;

    //Render the page
    public function render()
    {
        return view('livewire.admin.customers.customer-edit');
    }

    /* set value at the time of render */
    public function mount($id)
    {
        if (session()->has('selected_language')) {   /*if session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            /* if session has no selected language */
            $this->lang = Translation::where('default', 1)->first();
        }
        $this->date = \Carbon\Carbon::today()->toDateString();
        $customer = Customer::find($id);
        if(Auth::user()->id != $customer->created_by)
        {
            abort(404);
        }
        $this->first_name = $customer->name;
        $this->address = $customer->address;
        $this->phone_number_1 = $customer->phone_number_1;
        $this->phone_number_2 = $customer->phone_number_2;
        $this->is_active = $customer->is_active;
        $this->edit_id = $id;
    }

    /* save the customer details */
    public function save()
    {
        $this->validate([
            'first_name' => 'required',
            'phone_number_1' => 'required',
        ]);
        $customer = Customer::updateOrCreate(['id' => $this->edit_id], [
            'date' =>  $this->date,
            'name' => $this->first_name,
            'phone_number_1' => $this->phone_number_1,
            'phone_number_2' => $this->phone_number_2,
            'is_active' => $this->is_active ?? 0,
            'address' => $this->address,
        ]);
        $this->emit('savemessage', ['type' => 'success', 'title' => 'Success', 'message' => 'Customer Created Successfully!']);
        return redirect()->route('admin.customers');
    }
}