<?php namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Image;
use App\Models\Translation;
use App\Helpers\RImage;

class PostController extends Controller
{
    public function getIndex()
    {
        $posts = Post::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('posts/view')->with('posts', $posts);
    }

    public function getCreate()
    {
        $categories = Category::where('active', true)
            ->where('category_id', 0)
            ->orWhere('category_id', null)
            ->orderBy('name')
            ->get();

        return view('posts/create')->with('categories', $categories);
    }

    public function getEdit($sid)
    {
        // Find the post using the user id
        $post = Post::find($sid);

        if ($post == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add(
                'editError',
                "The post cannot be found because it does not exist or may have been deleted."
            );
            return redirect('admin/posts')->withErrors($errors);
        }
        
        $translated = array();
        foreach ($post->translations as $translation) {
            $translated[$translation->lang] = json_decode($translation->content);
        }

        $categories = Category::where('active', true)
            ->where('category_id', 0)
            ->orWhere('category_id', null)
            ->orderBy('name')
            ->get();
        
        return view('posts/edit')
            ->with('post', $post)
            ->with('translated', $translated)
            ->with('imagine', new RImage)
            ->with('categories', $categories);
    }

    public function postStore()
    {
        $sid = \Input::get('id');

        /*
         * Validate
         */
        $rules = array(
            'image'         => 'mimes:jpg,jpeg,png,gif|max:500',
            'title'         => 'required|regex:/^[a-z,0-9 ._\(\)-?]+$/i',
            'slug'          => 'required|regex:/^[a-z,0-9 ._\(\)-?]+$/i',
            'content'       => 'required',
        );

        $validation = \Validator::make(\Input::all(), $rules);

        if ($validation->passes()) {
            $title              = \Input::get('title');
            $slug               = \Input::get('slug');
            $content            = \Input::get('content');
            $image              = \Input::file('image');
            $private            = (\Input::get('private') == '' ? false : true);
            $featured           = (\Input::get('featured') == '' ? false : true);
            $category_id        = \Input::get('category_id');
            
            $post = (isset($sid) ? Post::find($sid) : new Post);
            
            if ($post == null) {
                $errors = new \Illuminate\Support\MessageBag;
                $errors->add(
                    'editError',
                    "The post cannot be found because it does not exist or may have been deleted."
                );
                return redirect('/admin/posts')->withErrors($errors);
            }

            $post->title = $title;
            $post->slug = str_replace(' ', '_', $slug); // Replace all space with underscore
            $post->content = $content;
            $post->private = $private;
            $post->featured = $featured;
            if ($category_id) {
                $post->category_id = $category_id;
            }

            $post->save();
            
            // Save translations
            $translations = \Config::get('translation');
            foreach ($translations as $translation) {
                $lang = $translation['lang'];
                if ($lang == 'en') {
                    continue;
                }

                $translated_content = array(
                    'title'     => \Input::get($lang . '_title'),
                    'slug'      => str_replace(' ', '_', \Input::get($lang . '_slug')),
                    'content'   => \Input::get($lang . '_content')
                );

                // Check if lang exist
                $translated_model = $post->translations->where('lang', $lang)->first();
                if ($translated_model == null) {
                    $translated_model = new Translation;
                }

                $translated_model->lang = $lang;
                $translated_model->content = json_encode($translated_content);

                $post->translations()->save($translated_model);
            }

            if (\Input::hasFile('image')) {
                //Upload the file
                $helper_image = new RImage;
                $filename = $helper_image->upload($image, 'posts/' . $post->id, true);

                if ($filename) {
                    // create photo
                    $newimage = new Image;
                    $newimage->path = $filename;

                    // save photo to the loaded model
                    $post->images()->save($newimage);
                }
            }
        //if it validate
        } else {
            if (isset($sid)) {
                return redirect('admin/posts/edit/' . $sid)->withErrors($validation)->withInput();
            } else {
                return redirect('admin/posts/create')->withErrors($validation)->withInput();
            }
        }

        return redirect('admin/posts');
    }

    public function getDelete($sid)
    {
        // Find the post using the user id
        $post = Post::find($sid);

        if ($post == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('deleteError', "The data cannot be deleted at this time.");
            return redirect('/admin/posts')->withErrors($errors);
        }
        
        // Delete the post
        $post->delete();

        return redirect('admin/posts');
    }

    public function getImgremove($sid)
    {
        $image = Image::find($sid);

        if ($image == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('deleteError', "The image cannot be deleted at this time.");
            return redirect('/admin/posts')->withErrors($errors);
        }

        $post_id = $image->imageable_id;

        $image->delete();

        return redirect('admin/posts/edit/' . $post_id);
    }
}
