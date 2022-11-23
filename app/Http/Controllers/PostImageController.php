<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostImageController extends Controller
{
    public function destroy($postId, $imageId)
    {
        $post = BlogPost::findOrFail($postId);
        $image = Image::findOrFail($imageId);

        try {
            File::delete($image->path);
            $image->delete();
            session()->flash('status', 'Thumbnail was deleted!');
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
