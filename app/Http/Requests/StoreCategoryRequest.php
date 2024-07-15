<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class StoreCategoryRequest extends FormRequest
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
                    $existingCategory = Category::where('name', $value)->where('deleted', 0)->first();

                    if ($existingCategory) {
                        $fail('The category name is already taken. Please choose a different name.');
                    }
                },
            ],
        ];
    }

    public function createCategory()
    {
        $name = $this->name;
        
        // Check gharne same name ko category exists garcha ani deleted status 1 chaina
        $existingCategory = Category::where('name', $name)->where('deleted', 1)->first();
        
        if ($existingCategory) {
            // If the category exists and is soft deleted, restore it
            $existingCategory->update(['deleted' => 0]);
            return $existingCategory;
        } else {
            // Create a new category
            return Category::create(['name' => $name, 'deleted' => 0]);
        }
    }
}
