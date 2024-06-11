<?php

namespace App\Http\Livewire\Admin\Invoice;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\InvoicePayment;
use App\Models\Material;
use App\Models\Product;
use App\Models\Translation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\CustomerMeasurementDetail;

class Invoices extends Component
{
    public $products,$materials,$salesmen,$customers,$customer_results,$inv_id;
    public $material_query,$customer_query,$product_search;
    public $date,$invoice_number,$selected_customer,$selected_material,$selected_salesman,$discount,$notes,$paid_amount,$pay_mode,$reference;
    public $inputs,$prices=[],$cart_items=[],$material_items=[],$inputi,$rate=[],$quantity,$material_price=[],$mati,$matqty=[],$matrate=[];
    public $tax,$tax_type;
    public $material_rate,$material_qty;
    public $taxable,$taxamount,$sub_total,$total;
    public $file_number,$first_name,$second_name,$family_name,$phone_number_1,$phone_number_2,$address,$customer_group_id;
    public $notes_c,$created_by,$opening_balance,$is_active=1,$email,$discount_type;
    public $selling_price=[],$editkey,$stop=false,$delivery_date;
    public $Custattributes,$unit,$measurements,$userattributes;
    

    //render the page
    public function render()
    {
        $product_query = Product::where('is_active',1);
        if($this->product_search != '')
        {
            $product_query->where('name','like','%'.$this->product_search.'%');
        }
        $this->products  = $product_query->get();
        return view('livewire.admin.invoice.invoices');
    }

    // Initialization and setup logic for the component.
    public function mount()
    {
        /* if financial year id is null */
        if(getFinancialYearID() == null)
        {
            abort(403);
        }
        $this->invoice_number = generateInvoiceNumber();
        $this->date = Carbon::now()->toDateString();
        if(Auth::user()->user_type==2) {
            $query = User::whereIn('user_type',[4,5,6])->latest();
            $this->salesmen = User::where('user_type',4)->where('created_by',Auth::user()->id)->where('is_active',1)->get();
        }
        /* if the user is branch */
        if(Auth::user()->user_type==3) {
            $this->salesmen = User::where('user_type',4)->where('created_by',Auth::user()->id)->where('is_active',1)->get();
        }
        /* if the user is salesman */
        if(Auth::user()->user_type==4) {
            $this->salesmen = Auth::user();
        }
        $this->tax = getTaxPercentage();
        $this->discount_type = getDiscountType();
    }
    
    // Handle changes in the customer query input.
    public function updatedCustomerQuery($value)
    {
        if($value != '')
        {
            $query2 = Customer::latest();
            $query2->where('created_by',Auth::user()->id);
            $query2->where(function($query) use ($value){
                $query->orwhere('name','like','%'.$value.'%');
                $query->orWhere('phone_number_1','like',$value.'%');
                $query->orWhere('phone_number_2','like',$value.'%');
               
            });
            $this->customer_results = $query2->where('is_active',1)->reorder()->orderby('name','ASC')->limit(8)->get();
        }
        else{
            $this->customer_results = null;
        }
    }

    // Handle changes in the material query input.
    public function updatedmaterialQuery($value)
    {
        if($value != '')
        {
            $this->materials = Material::where(function($query) use ($value){
                $query->where('name','like','%'.$value.'%');
            })
            ->where('is_active',1)->get();
        }
        else{
            $this->materials = null;
        }
    }

    // Select a customer based on the provided ID.
    public function selectCustomer($id)
    {
        $this->selected_customer = Customer::where('is_active',1)->where('id',$id)->first();
        $this->customer_query = '';
        $this->customer_results = null;
    }

    // Add a product to the shopping cart.
    public function addToCart($id)
    {
        $product = Product::find($id);
        $this->addLocal($this->inputi);
        $this->cart_items[$this->inputi] = array([
            'product' => $id,
        ]);
        $tax_type = getTaxType();
        $this->selling_price[$this->inputi] = $product->stitching_cost;
        $this->prices[$this->inputi] = $product->stitching_cost;
        $this->quantity[$this->inputi]  = 1;
        $this->calculateTotal();
    }

    // Increase the global index of products.
    public function addLocal($i)
    {
        $this->inputi = $i + 1;
        $this->inputs[$this->inputi] = 1;
        $this->cart_items[$this->inputi] = '';
        $this->quantity[$this->inputi]  = 1;
    }

    // Increase the global index of materials.
    public function addLocalM($i)
    {
        $this->mati = $i + 1;
    }

    /* increase the count */
    public function increase($key)
    {
        /* if quantity of key is exist */
        if(isset($this->quantity[$key] ))
        {
            $this->quantity[$key]++;
        }
        $this->calculateTotal();
    }

    /* decrease the count */
    public function decrease($key)
    {
        /* is quantity of key is exist */
        if(isset($this->quantity[$key] ))
        {
        if($this->quantity[$key] > 1)
        {
            /* if quantity of key is >1 */
            $this->quantity[$key]--;
        }
        }
        $this->calculateTotal();
    }

    // Remove an item from the cart.
    public function removeItem($key)
    {
        unset($this->quantity[$key]);
        unset($this->prices[$key]);
        unset($this->cart_items[$key]);
        $this->calculateTotal();
    }

    // Remove a material item.
    public function removeMat($key)
    {
        unset($this->matqty[$key]);
        unset($this->matrate[$key]);
        unset($this->material_items[$key]);
        $this->calculateTotal();
    }

    // Select a material based on the provided ID.
    public function selectMaterial($id)
    {
        $this->selected_material = Material::find($id);
        $this->materials = null;
        $this->material_query = '';
        $this->material_rate = $this->selected_material->price;
        $this->material_qty = 1;
    }

    // Add a material item to the cart.
    public function addMatToCart()
    {
        if(!$this->selected_material || $this->selected_material == null)
        {
            $this->addError('mat_error','Select A Material!');
            return false;
        }
        $this->validate([
            'material_rate' => 'required|numeric',
            'material_qty'  => 'required|numeric'
        ]);
        $this->addLocalM($this->mati);
        $this->matrate[$this->mati] = $this->material_rate;
        $this->material_items[$this->mati] = array([
            'product' => $this->selected_material->id,
        ]);
        $tax_type = getTaxType();
        $itemtotallocal = 0;
        $this->matrate[$this->mati] = $this->material_rate ;
        $this->matqty[$this->mati]  = $this->material_qty;
        $this->selected_material = null;
        $this->material_rate = null;
        $this->material_qty = null;
        $this->emit('closemodal');
        $this->calculateTotal();
    }

    // Calculate the total, subtotal, tax amount, and more.
    public function calculateTotal()
    {
        $this->total = 0;
        $this->sub_total =0;
        $this->taxamount = 0;
        $this->taxable = 0;
        $unitprice =0;
        $itemtotal = 0;
        $itemtaxtotal2 = 0;
        $sub_total =0;
        $tax_type = getTaxType();
        foreach($this->cart_items as $key => $item)
        {
            $itemtaxtotal = 0;
            $product = \App\Models\Product::find($item[0]['product']);
            $itemtotallocal =  ($this->selling_price[$key] * $this->quantity[$key]);
            $itemtaxtotal += $itemtotallocal;
            $itemtotal += $itemtotallocal;
            $itemtaxtotal2 += $itemtotallocal;
            $this->taxable += $itemtotallocal;
        }
        foreach($this->material_items as $key => $item)
        {
            $itemtaxtotal = 0;
            $material = \App\Models\Material::find($item[0]['product']);
            $itemtotallocal =  ($this->matqty[$key] * $this->matrate[$key]);
            $itemtaxtotal += $itemtotallocal;
            $itemtotal += $itemtotallocal;
            $itemtaxtotal2 += $itemtotallocal;
            $this->taxable += $itemtotallocal;
        }
        if($this->discount_type == 1)
        {
            $this->sub_total = $this->taxable;
            $this->taxable = $itemtotal -  $this->discount;
            $unittax = $this->taxable * $this->tax/100;
            $this->taxamount = $unittax;
            $this->total = $this->taxable ;
            return 1;
        }
        else{
            $this->sub_total = $this->taxable;
            $this->taxable = $itemtotal;
            $unittax = $this->taxable * $this->tax/100;
            $this->taxamount = $unittax;
            $this->total = ($this->taxable + $unittax) - $this->discount;
            $this->sub_total = $sub_total;
            return 1;
        }
        $this->taxamount = $itemtaxtotal2;
        $this->total = $this->taxable + $this->taxamount;
        if($this->discount_type == 2)
        {
            $this->total = $this->total - $this->discount;
        }
        $this->total = $this->total - $this->discount;
    }
    /* process while update element */
    public function updated($name,$value)
    { 
        /* if updated value is empty set the value as null */
        if ( $value == '' ) data_set($this, $name, null);
        $this->resetErrorBag();
        if($name == 'discount' || strpos($name,'selling_price') !== false || strpos($name,'quantity') !== false)
        {
            $this->calculateTotal();
        }
    }

    // Save the invoice with specified type.
    public function save($type)
    {
        if($this->stop == true)
        {
            return 1;
        }
        $this->calculateTotal();
        $this->resetErrorBag();
        if($this->paid_amount != '' && $this->pay_mode == '')
        {
            $this->addError('pay_mode','Payment Mode Must Be Selected!');
            return 0;
        }
        if($this->paid_amount > $this->total)
        {
            $this->addError('paid_amount','Paid Amount cannot be greater than total!');
            return 0;
        }
        $userId = Auth::id();
        $invoice = Invoice::create([
            'date' => Carbon::now(),
            'invoice_number'    => generateInvoiceNumber(),
            'customer_name' => $this->selected_customer->name,
            'customer_phone'    => $this->selected_customer->phone_number_1,
            'customer_address'  => $this->selected_customer->address,
            'customer_id'   => $this->selected_customer->id,
            'salesman_id'   => $userId,
            'discount'  => $this->discount ?? 0,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'notes' => $this->notes,
            'created_by'    => Auth::user()->id,
            'financial_year_id' => getFinancialYearID(),
            'branch_id' => Auth::user()->id,
            'status' => 2,
            'delivery_date' => $this->delivery_date
        ]);
        $qtycount =0;
        foreach($this->cart_items as $key => $item)
        {
            $itemtaxtotal = 0;
            $product = \App\Models\Product::find($item[0]['product']);
            $itemtotal = 0;
            $qtycount ++;
            $itemtotallocal=0;
            $itemrate = 0;
            $itemtotallocal =  ($this->selling_price[$key] * $this->quantity[$key]);
            $itemrate = $this->selling_price[$key];
            $itemtaxtotal += $itemtotallocal * $this->tax/100;
            $itemtotal += $itemtotallocal;
            InvoiceDetail::create([
                'invoice_id'    => $invoice->id,
                'type'  => 1,
                'quantity'  => $this->quantity[$key],
                'item_id' => $product->id,
                'item_name'=>$product->name,
                'rate' => $itemrate,
                'total' => $itemtotal,
            ]);
        }
        foreach($this->material_items as $key => $item)
        {
            $itemtotal = 0;
            $qtycount ++;
            $itemtaxtotal = 0;
            $material = \App\Models\Material::find($item[0]['product']);
            $itemrate = 0;
            $itemtotallocal =  ($this->matqty[$key] * $this->matrate[$key]);
            $itemrate =  $this->matrate[$key];
            $itemtaxtotal += $itemtotallocal * $this->tax/100;
            $itemtotal += $itemtotallocal;
            InvoiceDetail::create([
                'invoice_id'    => $invoice->id,
                'type'  => 2,
                'quantity'  => $this->matqty[$key],
                'item_id' => $material->id,
                'item_name'=>$material->name,
                'rate' => $itemrate,
                'total' => $itemtotal,
                'unit_type' => $material->unit,
            ]);
        }
        if($this->paid_amount )
        {
            InvoicePayment::create([
                'date' => Carbon::now(),
                'invoice_id'    => $invoice->id,
                'customer_name' => $this->selected_customer->name,
                'customer_id'   => $this->selected_customer->id,
                'created_by'    => Auth::user()->id,
                'financial_year_id' => getFinancialYearID(),
                'branch_id' => Auth::user()->id,
                'payment_mode'  => $this->pay_mode,
                'paid_amount'   => $this->paid_amount,
                'note'  => $this->reference,
                
            ]);
        }
        $invoice->total_quantity = $qtycount;
        $invoice->save();
        $this->stop = true;
        if($type==1) {
            $this->emit('savemessage',['type' => 'success','title' => 'Success','message' => 'Invoice Created Successfully!']);
        
            $this->emit('reloadpage');
        } 
        if($type==2)
        {
            $this->inv_id=$invoice->id;
            $this->emit('printWindow');
        }
        
    }

    // Create a new customer.
    public function customerCreate()
    {
        $this->validate([
            'first_name' => 'required',
            'phone_number_1' => 'required',
            
        ]);
        $hasError= false;
        if(empty($this->userattributes)){
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'warning',  'message' => 'Please Select Unit and Measurements!']); 
            return;
        }else{
            foreach ($this->userattributes as $key => $value) {
                if (!empty($value)) {
                    if (empty($this->unit[$key])) {
                        $hasError = true;
                        $this->addError('unit.' . $key, 'The unit field is required when attribute value is provided.');
                    }
                }
            }
        }
        $user = Auth::user();
        $customer = Customer::create([
            'date' =>  Carbon::today(),
            'name' => $this->first_name,
            'phone_number_1' => $this->phone_number_1,
            'phone_number_2' => $this->phone_number_2,
            'is_active' => $this->is_active??0,
            'address' => $this->address,
            'created_by' => Auth::user()->id,
        ]);
        if ($hasError) {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'warning',  'message' => 'Please Select Unit!']);
        }else{
            foreach($this->userattributes as $key => $value)
            {
                $unit = $this->unit[$key];
                 CustomerMeasurementDetail::create([
                        'customer_id'   => $customer->id,
                        'attribute_id'  => $key,
                        'value' => $value,
                        'unit'  => $unit
                    ]);
                
                
            }
        }
        $this->dispatchBrowserEvent('alert',['type' => 'success','title' => 'Success','message' => 'Customer Created Successfully!']);
        $this->selected_customer = $customer;
        $this->customer_query = '';
        $this->customer_results = null;
        $this->emit('closemodal');
    }

    // Automatically fill the paid amount with the total.
    public function magicFill()
    {
        $this->calculateTotal();
        $this->paid_amount = $this->total;
    }

    // Continue the invoicing process with validation.
    public function continue()
    {
        $this->calculateTotal();
       
        if(!$this->selected_customer)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Customer is not selected!']);
            return 1;   
        }
        if(!$this->delivery_date)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Preferred Delivery Date is not selected!']);
            return 1;   
        }
        
        if(count($this->cart_items) == 0 && count($this->material_items)  == 0)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'No items are selected!']);
            return 1; 
        }
        if($this->total < 0)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Total Cannot be less than 0!']);
            return 1;   
        }
        $this->emit('openmodal');
        return true;
    }

    // Change the quantity for a material item.
    public function changeqty($key)
    {
        $this->editkey = null;
        $this->editkey = $key;
        $this->material_qty = $this->matqty[$key];
    }

    // Save changes to a material item's quantity.
    public function saveChanges()
    {
        $this->validate([
            'material_qty'  => 'required|numeric'
        ]);

        $this->matqty[ $this->editkey] = $this->material_qty;
        $this->emit('closemodal');
        $this->calculateTotal();
    }
}