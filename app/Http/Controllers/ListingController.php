<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // display all listings
    public function index(Request $request){
        //dd($request);
        //dd(request());
        //with the filter on the listing model
        // 'listings' => Listing::latest()->filter(request(['tag','search']))->get()
        return view('listings.index', [        
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(4)
        ]);

    }
    
    # show single listings
    public function show(Listing $listing){
        return view('listings.show',[
            'listing' => $listing
          ]);

    }
    
    // Create form for listings
    public function create(){
        return view('listings.create');

    }

    // Store listings

    public function store(Request $request){
       // dd($request->file('logo'));

        $formFields = $request->validate(
            [
                'title' => 'required',
                'company' => ['required', Rule::unique('Listings')],
                'location'=> 'required',
                'email' => ['required', 'email'],
                'website' => 'required',
                'tags' => 'required',
                'description' => 'required'

            ]);
            
            $formFields['user_id'] = auth()->id();
            //dd($formFields);
            //check if there is file
            if($request->hasFile('logo')){
                $formFields['logo'] = $request->file('logo')->store('logos','public');
            }

            Listing::create($formFields);
            return redirect('/')->with('message','Listing created successfully');
        //return view('listing.index');

    }
      
    // Edit listing form
    public function edit(Listing $listing){
        //dd($listing);
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }
        return view('listings.edit', ['listing'=> $listing]);
    }

    public function update(Request $request, Listing $listing){
        // dd($request->file('logo'));

        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }
 
         $formFields = $request->validate(
             [
                 'title' => 'required',
                 'company' => 'required',
                 'location'=> 'required',
                 'email' => ['required', 'email'],
                 'website' => 'required',
                 'tags' => 'required',
                 'description' => 'required'
 
             ]);
 
             //dd($formFields);
             //check if there is file
             if($request->hasFile('logo')){
                 $formFields['logo'] = $request->file('logo')->store('logos','public');
             }
 
             $listing->update($formFields);
             return back()->with('message','Listing updated successfully');
         //return view('listing.index');
 
     }
    
      // Delete Lisiting
     public function destroy(Listing $listing){
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }
 
        $listing->delete();
        //dd($listing);
        return redirect('/')->with('message','Lisiting deleted successfully');
    }


    public function manage(){
        //dd();
        return view('listings.manage',['listings' => auth()->user()->listings()->get()]);
    }
     
}
