<?php

namespace App\Http\Livewire\Admin\Inventory;


use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Image;
use Auth;
use App\Models\Translation;
use App\Models\Measurement;
use Illuminate\Http\Request;

class Products extends Component
{
    use WithFileUploads;
    public $image,$name,$stitching_cost,$is_active=1,$search,$products,$product,$is_featured = 0,$description;
    public $editMode = false,$i=1,$item_code;
    public $product_id,$selected_attributes,$pdtEdit = false;

    //render the page
    public function render()
    {
        /* if the user is not admin and not branch */
        if((Auth::user()->user_type!=2) && (Auth::user()->user_type!=3)) {
            abort(404);
        }
        $query = Product::latest();
        if($this->search != '')
        {
            $query->where('name','like','%'.$this->search.'%');
        }
        $this->products = $query->get();
        return view('livewire.admin.inventory.products');
    }
    public function save(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image',
            'name' => 'required',
            'stitching_cost' => 'required|numeric',
        ]);

        $imageurl = null;
        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $destinationPath = public_path('uploads/product');

            // Ensure the destination directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the uploaded file to the destination directory
            $request->file('image')->move($destinationPath, $filename);

            // Generate the URL for the stored image
            $imageurl = '/uploads/product/' . $filename;
        }

        $pdtCount = Product::count();
        $itemNum = str_pad($pdtCount + 1, 3, '0', STR_PAD_LEFT);
        Product::create([
            'name' => $request->get('name'),
            'stitching_cost' => $request->get('stitching_cost'),
            'is_active' => $request->get('is_active') ? 1 : 0,
            'is_featured' => $request->get('is_featured') ? 1 : 0,
            'image' => $imageurl,
            'description' => $request->get('description'),
            'created_by' => Auth::user()->id,
            'item_code' => $itemNum
        ]);

        return redirect()->back()->with('success', 'Product Created Successfully!');
    }
    public function update(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image',
            'name' => 'required',
            'stitching_cost' => 'required|numeric',
        ]);

        $product = Product::find($request->input('editId'));

        $imageurl = $product->image;
        if ($request->hasFile('image')) {
            if (file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $destinationPath = public_path('uploads/product');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $request->file('image')->move($destinationPath, $filename);

            $imageurl = '/uploads/product/' . $filename;
        }

        $product->update([
            'name' => $request->input('name'),
            'stitching_cost' => $request->input('stitching_cost'),
            'is_active' => $request->input('is_active') ? 1 : 0,
            'is_featured' => $request->input('is_featured') ? 1 : 0,
            'image' => $imageurl,
            'description' => $request->input('description'),
            'item_code' => $request->input('item_code')
        ]);

        return redirect()->back()->with('success', 'Product Updated Successfully!');
    }

  
    //Reset Input Fields
    public function resetInputFields()
    {
        $this->name = '';
        $this->stitching_cost= '';
        $this->i= $this->i+1;
        $this->image="";
        $this->description="";
        $this->is_active = 1;
        $this->is_featured = 0;
        $this->item_code = null;
        $this->resetErrorBag();
        $this->editMode = false;
        $this->product=null;
    }
    public function pdtedit($id)
    {
        $product = Product::find($id);

        return response()->json($product);
    }

    //If product clicked on the edit button get item id and initialize input variables with it.
    public function edit($id)
    {
        $this->editMode = true;
        $this->resetErrorBag();
        $this->product = Product::find($id);
        $this->name = $this->product->name;
        $this->stitching_cost = $this->product->stitching_cost;
        $this->is_active = $this->product->is_active;
        $this->is_featured = $this->product->is_featured;
        $this->description = $this->product->description;
        $this->item_code = $this->product->item_code;
    }
    
    //Toggle product active status
    public function toggle($id)
    {
        $product = Product::find($id);
        $product->is_active = !($product->is_active);
        $product->save();
    }
    

}