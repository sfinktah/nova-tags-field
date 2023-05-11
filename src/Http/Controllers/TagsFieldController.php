<?php

namespace Spatie\TagsField\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Tags\Tag;

class TagsFieldController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = resolve(config('tags.tag_model', Tag::class))->query();

        if ($request->input('filter.containing') !== null) {
            $query->containing($request['filter']['containing']);
        }

        if ($request->has('filter.type')) {
            $query->where('type', $request['filter']['type']);
        }

        if ($request->has('limit')) {
            $query->limit($request['limit']);
        }

        $sorted = $query->get()->sortBy(fn (Tag $tag) => strtolower($tag->name))->values();

        return $sorted->map(fn (Tag $tag) => $tag->name);
    }

    public function update(NovaRequest $request)
    {
//        dd($request);
//        +request: Symfony\Component\HttpFoundation\InputBag {#1658
//        #parameters: array:3 [
//        "id" => 43
//        "attribute" => "tags"
//        "tag" => "cadillac"
        $resourceClass = $request->resource();
        $resourceValidationRules = $resourceClass::rulesForUpdate($request);
        $fieldValidationRules = $resourceValidationRules[$request->attribute] ?? [];

        if (!empty($fieldValidationRules)) {
            $validatedData = $request->validate([
                'value' => $fieldValidationRules,
            ]);
        }

        $model = $request->model()->find($request->id);
        $model->removeTags([$request->tag]);
//        $model->{$request->attribute} = $request->value;
//        $model->save();
    }
}
