<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Receipt;
use App\Models\Step;
use App\Models\StepImage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ReceiptController extends Controller
{
    public function index(): View
    {
        $receipts = Receipt::all();

        return view('admin.receipt.index', compact('receipts'));
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $receipt = Receipt::with('categories', 'steps', 'steps.stepImages')->findOrFail($id);
            Log::info($receipt);
            return Response::json($receipt);
        }

        return abort(404);
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('admin.receipt.form', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required',
            'thumbnail' => 'required|image',
            'description' => 'required',
            'cal_total' => 'required',
            'est_price' => 'required',
            'steps' => 'required|array',
            'steps.*.title' => 'required',
            'steps.*.description' => 'required',
            'steps.*.images' => 'nullable|array',
            'steps.*.images.*' => 'nullable|image',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        // Get the selected category IDs
        $categoryIds = $request->input('categories', []);

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Store the thumbnail image
        $thumbnailPath = $request->file('thumbnail')->store('receipts', 'public');

        // Process the form data and store the receipt
        $receipt = new Receipt();
        $receipt->user_id = $userId;
        $receipt->title = $validatedData['name'];
        $receipt->thumbnail_image = $thumbnailPath;
        $receipt->description = $validatedData['description'];
        $receipt->cal_total = $validatedData['cal_total'];
        $receipt->est_price = $validatedData['est_price'];
        $receipt->save();

        // Store the step images
        foreach ($validatedData['steps'] as $stepData) {
            $step = new Step();
            $step->title = $stepData['title'];
            $step->description = $stepData['description'];
            $receipt->steps()->save($step);

            if (isset($stepData['images'])) {
                foreach ($stepData['images'] as $image) {
                    $imagePath = $image->store('steps', 'public');

                    $stepImage = new StepImage();
                    $stepImage->image = $imagePath;
                    $step->stepImages()->save($stepImage);
                }
            }
        }

        // Sync the categories
        if (isset($validatedData['categories'])) {
            // Attach the categories to the receipt
            $receipt->categories()->sync($categoryIds);
        }

        // Return a response or redirect to a success page
        return redirect()
            ->route('dashboard.receipt.index')
            ->with('status', 'Receipt created successfully.');
    }
}
