<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendRequest;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::where('id', '!=', auth()->id())->latest()->paginate(10);
            return view('users.index', compact('users'));
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to fetch user data. Please try again.');
        }
    }

    public function sendFriendRequest(User $user)
    {
        try {
            FriendRequest::updateOrCreate([
                'sender_id' => auth()->id(),
                'recipient_id' => $user->id
            ],['status' => FriendRequest::STATUS_PENDING]);
            return back()->with('success', 'Friend request sent successfully!');
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to send friend request. Please try again.');
        }
    }

    public function getReceivedRequestList()
    {
        try {
            $requests = FriendRequest::with('user')->where('recipient_id',auth()->id())->where('status',FriendRequest::STATUS_PENDING)->latest()->paginate(10);
            return view('users.received-request', compact('requests'));
        } catch (QueryException $e) {
            return back()->with('error', 'Failed to fetch request data. Please try again.');
        }
    }

    public function accept(FriendRequest $request)
    {
       try {
            $request->update(['status' => FriendRequest::STATUS_ACCEPTED]);
            return redirect()->back()->with('success', 'Friend request accepted!');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to accept friend request: ' . $e->getMessage());
        } 
    }

    public function reject(FriendRequest $request)
    {
        try {
            $request->update(['status' => FriendRequest::STATUS_REJECTED]);
            return redirect()->back()->with('success', 'Friend request rejected!');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to reject friend request: ' . $e->getMessage());
        } 
    }

    // public function chatWithUser(User $user)
    // {
    //     try {
    //         return view('users.chat', compact('user'));
    //     } catch (QueryException $e) {
    //         return back()->with('error', 'Failed to fetch request data. Please try again.');
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $categories = Category::all();
    //     return view('products.create', compact('categories'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|unique:products|max:255',
    //         'description' => 'required',
    //         'price' => 'required|numeric',
    //         'quantity' => 'required|numeric',
    //         'category_id' => 'required',
    //         'product_image' => 'image|mimes:jpeg,png,jpg|max:2048',
    //     ]);
    //     Product::create($request->all());
    //     return redirect()->route('products.index')->with('success', 'Product created successfully.');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $product = Product::with('category')->where('id',$id)->first();
    //     return view('products.show', compact('product'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $product = Product::where('id',$id)->first();
    //     $categories = Category::all();
    //     return view('products.edit', compact('product','categories'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $product = Product::where('id',$id)->first();
    //     $request->validate([
    //         'name' => 'required|unique:products,name,' . $product->id . '|max:255',
    //         'description' => 'required',
    //         'price' => 'required|numeric',
    //         'quantity' => 'required|numeric',
    //         'category_id' => 'required',
    //         'product_image' => 'image|mimes:jpeg,png,jpg|max:2048',
    //     ]);
    //     $product->update($request->all());
    //     return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $product = Product::where('id',$id)->first();
    //     $product->delete();
    //     return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    // }
}
