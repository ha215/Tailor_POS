<?php

namespace App\Http\Livewire\Admin\Customers;

use App\Models\CustomerMeasurement;
use App\Models\CustomerMeasurementDetail;
use App\Models\Measurement;
use App\Models\Customer;
use App\Models\MeasurementDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Auth;
use App\Models\Translation;

class CustomerListMeasurement extends Component
{
    public $Custattributes,$type='',$unit,$measurements,$userattributes,$customer_id,$measurement,$notes,$customer;
    public $measurementDetails;
    public $hasMorePages;
    
    //Render the page
    public function render()
    {
        return view('livewire.admin.customers.customer-list-measurement');
    }

    //Validation rules
    protected $rules = [
        'userattributes.*' => 'required',
        'type'  => 'required',
        'unit'  => 'required'
    ];

    //Load customer measurements
    public function mount($id)
    {
        $this->customer_id = $id;
        $this->measurements = Measurement::where('is_active',1)->get();
        if(Auth::user()->user_type==2) {
            $this->customer=Customer::find($id);
        }
       /* if the user is branch */
       if(Auth::user()->user_type==3) {
            $this->customer=Customer::where('created_by',Auth::user()->id)->where('id',$id)->first();
        }
        $this->measurementDetails = CustomerMeasurementDetail::where('customer_id',$id)
                                                             ->get();
        if(!$this->customer)
        {
            abort(404);
        }
    }

    
}