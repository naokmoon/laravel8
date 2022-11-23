<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostImageController extends Controller
{
    public function destroy($postId, $imageId)
    {

        $post = BlogPost::findOrFail($postId);
        $image = Image::findOrFail($imageId);

        $this->authorize($image);

        try {

            Storage::delete($image->path); // Delete image from storage
            $image->delete(); // Delete image from DB

            session()->flash('status', 'Thumbnail was deleted!');

            return redirect()->back();
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
