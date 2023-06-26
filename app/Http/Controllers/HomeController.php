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
use Illuminate\Support\Facades\Storage;

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

    public function create_receipt_view(): View
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        $tools = Tool::all();

        return view('user.receipt.form', compact('categories', 'ingredients', 'tools'));
    }

    public function edit_receipt($id): View
    {
        // Get user id
        $userId = Auth::id();

        // Abort when user is not authorized to edit the receipt
        if (Receipt::findOrFail($id)->user_id !== Auth::id()) {
            abort(403, 'Only user who created the receipt can edit it.');
        }

        $receipt = Receipt::findOrFail($id);
        $categories = Category::all();
        $ingredients = Ingredient::all();
        $tools = Tool::all();

        return view('user.receipt.form', compact('receipt', 'categories', 'ingredients', 'tools'));
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

    public function update_receipt(Request $request, $id)
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Get receipt
        $receipt = Receipt::with('categories', 'ingredients', 'tools', 'steps', 'steps.stepImages')->findOrFail($id);

        // Check if user is authorized to edit the receipt
        if ($receipt->user_id !== $userId) {
            return redirect()
                ->route('home')
                ->with('status', 'You are not authorized to edit this receipt.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'cal_total' => 'required|numeric',
            'est_price' => 'required|numeric',
            'categories' => 'array',
            'ingredients' => 'array',
            'tools' => 'array',
            'steps.*.title' => 'required|string',
            'steps.*.description' => 'required|string',
            'steps.*.images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update main receipt details
        $receipt->user_id = $userId;
        $receipt->title = $validatedData['name'];
        $receipt->description = $validatedData['description'];
        $receipt->cal_total = $validatedData['cal_total'];
        $receipt->est_price = $validatedData['est_price'];

        // Update thumbnail if provided
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailPath = $thumbnail->store('thumbnails', 'receipts');
            $receipt->thumbnail_image = $thumbnailPath;
        }

        // Update relationships (categories, ingredients, tools) if necessary
        if (isset($validatedData['categories'])) {
            $receipt->categories()->syncWithoutDetaching($validatedData['categories']);
        }

        if (isset($validatedData['ingredients'])) {
            $receipt->ingredients()->syncWithoutDetaching($validatedData['ingredients']);
        }

        if (isset($validatedData['tools'])) {
            $receipt->tools()->syncWithoutDetaching($validatedData['tools']);
        }

        // Update steps and their images
        foreach ($validatedData['steps'] as $stepIndex => $stepData) {
            $step = $receipt->steps->find($stepIndex);
            if ($step) {
                $step->title = $stepData['title'];
                $step->description = $stepData['description'];
                $step->save();

                // Update step images if provided
                if (isset($stepData['images'])) {
                    $stepImages = [];
                    foreach ($stepData['images'] as $image) {
                        $imagePath = $image->store('steps', 'receipts');
                        $stepImages[] = ['image' => $imagePath];
                    }
                    $step->stepImages()->createMany($stepImages);
                }
            }
        }

        $receipt->save();

        return redirect()
            ->route('home')
            ->with('status', 'Receipt updated successfully.');
    }

    public function delete_receipt($id)
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Check if user is authorized to delete the receipt
        if (Receipt::findOrFail($id)->user_id !== $userId) {
            return redirect()
                ->route('home')
                ->with('status', 'You are not authorized to delete this receipt.');
        }

        // Find the receipt by ID
        $receipt = Receipt::findOrFail($id);

        // Delete the associated step images
        foreach ($receipt->steps as $step) {
            foreach ($step->stepImages as $stepImage) {
                Storage::disk('public')->delete($stepImage->image);
                $stepImage->delete();
            }
        }

        // Delete the steps
        $receipt->steps()->delete();

        // Delete the thumbnail image if it exists
        if ($receipt->thumbnail_image) {
            Storage::disk('public')->delete($receipt->thumbnail_image);
        }

        // Detach the categories, ingredients, and tools
        $receipt->categories()->detach();
        $receipt->ingredients()->detach();
        $receipt->tools()->detach();

        // Delete the receipt
        $receipt->delete();

        // Return a response or redirect to a success page
        return redirect()
            ->route('home')
            ->with('status', 'Receipt deleted successfully.');
    }
}
