<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class EditCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Retrieve the current category being edited
                    $currentCategory = $this->route('category');

                         // Check if the name and ID are the same as the current category
                         if ($currentCategory->name === $value && $currentCategory->id === $this->route('category')->id) {
                            return; // If the same, pass validation
                        }

                    // Check if category status is deleted
                    if ($currentCategory->deleted === 0) {
                        $fail('Cannot edit a category that is not marked as deleted.');
                        return;
                    }

                    // Check if another category with the same name and deleted status exists
                    $existingCategory = Category::where('name', $value)
                                                ->where('deleted', 1)
                                                ->where('id', '!=', $currentCategory->id)
                                                ->first();

                    if ($existingCategory) {
                        $fail('The category name cannot be used as it is associated with a deleted category.');
                    }

               
                },
            ],
        ];
    }

    public function updateCategory(Category $category)
    {
        $category->update([
            'name' => $this->input('name'),
        ]);

        return $category;
    }
}
