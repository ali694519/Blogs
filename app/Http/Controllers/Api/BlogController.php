<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BlogController extends Controller
{
    public function index() {
        $blogs = Blog::all();
        return response()->json(BlogResource::collection($blogs), 200);
    }

    public function store(BlogRequest $request) {
       $data = $request->except('image');
       $data['image'] = $this->UploadImage($request);
       $blogs = Blog::create($data);
       return response()->json([
        new BlogResource($blogs),
        'message' => 'The blog has been successfully created.',
        ], 201);
    }

    public function update(BlogRequest $request,$id) {
        $Blogs = Blog::findOrFail($id);
        $old_image = $Blogs->image;
        $data = $request->except('image');

        $new_image = $this->UploadImage($request);
        if($new_image) {
            $data['image'] = $new_image;
        }

        $Blogs->update($data);
        // $category->fill($request->all())->save();
        if($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }
        return response()->json([
        'message' => 'The blog has been successfully updated.',
        ], 200);

    }

    public function delete(Blog $blog) {

        $blog->delete();
        return response()->json([
        'message' => 'The blog has been successfully deleted.',
        ], 200);
    }

    protected function UploadImage(Request $request) {
        if(!$request->hasFile('image')) {
        return;
        }
        $file = $request->file('image'); // UploadedFile Object
        $path = $file->store('uploads','public');
        $data['image'] = $path;
        return $path;
    }

    public function trash() {
    $Subscribers = Blog::onlyTrashed()->paginate();
    return response()->json(['Subscribers' => $Subscribers]);
    }


    public function restore($id) {
     try {
        $subscriber = Blog::onlyTrashed()->findOrFail($id);
        $subscriber->restore();
        return response()->json(['message' => 'Subscriber restored!']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Subscriber not found'], 404);
        }
    }

    public function forceDelete($id) {
     try {
        $subscriber = Blog::onlyTrashed()->findOrFail($id);
        $subscriber->forceDelete();
        return response()->json(['message' => 'Subscriber deleted!']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Subscriber not found'], 404);
        }
    }
}
