<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\ProductServiceInterface;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    protected $productService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ProductServiceInterface $productService)
    {
        $this->middleware('auth');
        $this->productService = $productService;
    }

    public function index()
    {
        $user = auth()->user();
        $notifications = Notification::where('receiver_id', $user->id)->paginate(7);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notifications = Notification::findOrFail($id);
        return view('notifications.show', compact('notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read' => true]);
        return redirect('notifications')->with('status', 'Marked as read');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->destroy($id);
        return redirect('notifications')->with('status', 'Deleted');
    }
}
