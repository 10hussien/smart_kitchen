<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\IngredientAlias;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class IngredientController extends Controller
{
    public function showallIng()
    {
        $ingredients = Ingredient::with('aliases')->select('id', 'name', 'image_url')->get();

        $data = $ingredients->map(function ($ingredient) {
            return [
                'id' => $ingredient->id,
                'name' => $ingredient->name,
                'image_url' => $ingredient->image_url,
                'aliases' => $ingredient->aliases->pluck('alias_name'), // جمع أسماء alias فقط
            ];
        });

        return response()->json($data);
    }


    // عرض مكون معين (تفاصيل + صورة مكبرة)
    public function showIng($id)
    {
        $ingredient = Ingredient::find($id);

        if (!$ingredient) {
            return response()->json(['message' => 'Ingredient not found.'], 404);
        }
        $ingredientAlis = $ingredient->aliases;

        return response()->json([
            'name' => $ingredient->name,
            'unit' => $ingredient->unit,
            'image_url' => $ingredient->image_url,
            'aliases' => $ingredientAlis
        ]);
    }

    public function searchIng(Request $request)
    {
        $query = Str::lower(trim($request->get('q')));
        $ingredients = Ingredient::with('aliases')->get();

        foreach ($ingredients as $ingredient) {
            $mainName = Str::lower($ingredient->name);
            if (Str::contains($mainName, $query) || similar_text($mainName, $query) > 70) {
                return response()->json([
                    'id' => $ingredient->id,
                    'name' => $ingredient->name,
                    'image_url' => $ingredient->image_url,
                    'matched_with' => 'الاسم الرئيسي',
                ]);
            }

            foreach ($ingredient->aliases as $alias) {
                $aliasName = Str::lower($alias->alias_name);
                if (Str::contains($aliasName, $query) || similar_text($aliasName, $query) > 70) {
                    return response()->json([
                        'id' => $ingredient->id,
                        'name' => $ingredient->name,
                        'image_url' => $ingredient->image_url,
                        'matched_with' => "الاسم البديل: " . $alias->alias_name,
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'لم يتم العثور على هذا المكون ، اضف هذا المكون اذا اردت استخدامه ',
        ], 404);
    }


    public function addIng(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'unit' => 'required|string',
            'image_url' => 'nullable|string|max:2048|mimes:png,jpg',
        ]);

        $inputName = Str::lower(trim($request->name));
        $ingredients = Ingredient::with('aliases')->get();

        foreach ($ingredients as $ingredient) {
            // التحقق من الاسم الرئيسي
            $mainName = Str::lower($ingredient->name);
            if (Str::contains($mainName, $inputName) || similar_text($mainName, $inputName) > 70) {
                return response()->json([
                    'message' => 'هذا المكون موجود مسبقًا بالاسم:',
                    'existing' => $ingredient->name,
                    'matched_with' => 'الاسم الرئيسي',
                ], 409);
            }

            // التحقق من أسماء alias
            foreach ($ingredient->aliases as $alias) {
                $aliasName = Str::lower($alias->alias_name);
                if (Str::contains($aliasName, $inputName) || similar_text($aliasName, $inputName) > 70) {
                    return response()->json([
                        'message' => 'هذا المكون موجود باسم مختلف:',
                        'existing' => $ingredient->name,
                        'matched_with' => "الاسم البديل: " . $alias->alias_name,
                    ], 409);
                }
            }
        }

        // إذا لم يوجد مشابه، أضف المكون
        $imageUrl = $request->image_url ?? asset('images/no-image.png');

        $ingredient = Ingredient::create([
            'name' => $request->name,
            'unit' => $request->unit,
            'image_url' => $imageUrl,
        ]);

        return response()->json([
            'message' => 'تمت إضافة المكون بنجاح.',
            'ingredient' => $ingredient
        ], 201);
    }

    public function updateIng(Request $request, $id)
    {
        $ingredient = Ingredient::findOrFail($id);

        // تحقق من القيم الموجودة فقط في الطلب
        $rules = [];

        if ($request->has('name')) {
            $rules['name'] = 'string|unique:ingredients,name,' . $ingredient->id;
        }

        if ($request->has('unit')) {
            $rules['unit'] = 'string';
        }

        if ($request->has('image_url')) {
            $rules['image_url'] = 'string|nullable';
        }

        $validatedData = $request->validate($rules);

        // تحديث القيم الموجودة فقط
        $ingredient->update($validatedData);

        return response()->json($ingredient);
    }

    // حذف مكون (للمشرف فقط)
    public function destroyIng($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->delete();

        return response()->json(['message' => 'تم حذف المكون بنجاح.']);
    }
    //اضافةalias
    public function addAlias(Request $request)
    {
        $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'alias_name' => 'required|string|unique:ingredient_aliases,alias_name',
        ]);

        $alias = IngredientAlias::create($request->only(['ingredient_id', 'alias_name']));

        return response()->json($alias, 201);
    }
}
