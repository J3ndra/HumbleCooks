<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Receipt;
use App\Models\Step;
use App\Models\StepImage;
use App\Models\Tool;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        // $item = $request->search;
        // $ingr = Ingredient::where('name','LIKE',"%$item%")->get();
        $search = $request->input('search');

        $query = Receipt::query();

        if ($search) {
            $query->where('receipts.title', 'like', '%' . $search . '%');
        }

        $receipts = $query->paginate(5);

        return view('home', [
            'receipts' => $receipts
        ]);
    }

    public function receipt_detail($id): View
    {
        $receipt = Receipt::findOrFail($id);

        return view('user.receipt.detail', compact('receipt'));
    }

    public function my_receipt(): View
    {
        $receipts = Receipt::where('user_id', Auth::id())->paginate(5);

        return view('user.receipt.index', compact('receipts'));
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $receipt = Receipt::with('categories', 'ingredients', 'tools', 'steps', 'steps.stepImages')->findOrFail($id);
            Log::info($receipt);
            return Response::json($receipt);
        }

        return abort(404);
    }

    public function create_receipt_view(): View
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        $tools = Tool::all();

        return view('user.receipt.form', compact('categories', 'ingredients', 'tools'));
    }

    public function store_receipt(Request $request): RedirectResponse
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
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'exists:ingredients,id',
            'tools' => 'nullable|array',
            'tools.*' => 'exists:tools,id',
        ]);

        // Get the selected category IDs
        $categoryIds = $request->input('categories', []);

        // Get the selected ingredients IDs
        $ingredientIds = $request->input('ingredients', []);

        // Get the selected tools IDs
        $toolIds = $request->input('tools', []);

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

        // Sync the ingredients
        if (isset($validatedData['ingredients'])) {
            // Attach the ingredients to the receipt
            $receipt->ingredients()->sync($ingredientIds);
        }

        // Sync the equipments
        if (isset($validatedData['tools'])) {
            // Attach the tools to the receipt
            $receipt->tools()->sync($toolIds);
        }

        // Return a response or redirect to a success page
        return redirect()
            ->route('home')
            ->with('status', 'Receipt created successfully.');
    }
}
