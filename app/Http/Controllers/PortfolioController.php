<?php namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Category;
use App\Models\Image;
use App\Models\Translation;
use App\Helpers\RImage;

class PortfolioController extends Controller
{
    public function getIndex()
    {
        $portfolios = Portfolio::orderBy('category_id')
            ->orderBy('name')
            ->paginate(20);

        return view('portfolios/view')->with('portfolios', $portfolios);
    }

    public function getCreate()
    {
        $categories = Category::where('active', true)
            ->where('category_id', 0)
            ->orWhere('category_id', null)
            ->orderBy('name')
            ->get();

        return view('portfolios/create')->with('categories', $categories);
    }

    public function getEdit($sid)
    {
        // Find the portfolio using the user id
        $portfolio = Portfolio::find($sid);

        if ($portfolio == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add(
                'editError',
                "The portfolio cannot be found because it does not exist or may have been deleted."
            );
            return redirect('admin/portfolios')->withErrors($errors);
        }

        $categories = Category::where('active', true)
            ->where('category_id', 0)
            ->orWhere('category_id', null)
            ->orderBy('name')
            ->get();

        $translated = array();
        foreach ($portfolio->translations as $translation) {
            $translated[$translation->lang] = json_decode($translation->content);
        }

        return view('portfolios/edit')
            ->with('portfolio', $portfolio)
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
            'image'             => 'mimes:jpg,jpeg,png,gif|max:500',
            'name'              => 'required',
            'short_description' => 'required',
            'category_id'       => 'required',
        );

        $validation = \Validator::make(\Input::all(), $rules);

        if ($validation->passes()) {
            $name               = \Input::get('name');
            $short_description  = \Input::get('short_description');
            $long_description   = \Input::get('long_description');
            $image              = \Input::file('image');
            $active             = (\Input::get('active') == '' ? false : true);
            $category_id        = \Input::get('category_id');

            $portfolio = (isset($sid) ? Portfolio::find($sid) : new Portfolio);
            
            if ($portfolio == null) {
                $errors = new \Illuminate\Support\MessageBag;
                $errors->add(
                    'editError',
                    "The portfolio cannot be found because it does not exist or may have been deleted."
                );
                return redirect('/admin/portfolios')->withErrors($errors);
            }

            $portfolio->name = $name;
            $portfolio->short_description = $short_description;
            $portfolio->long_description = $long_description;
            $portfolio->active = $active;
            $portfolio->category_id = $category_id;

            $portfolio->save();
            
            // Save translations
            $translations = \Config::get('translation');
            foreach ($translations as $translation) {
                $lang = $translation['lang'];
                if ($lang == 'en') {
                    continue;
                }

                $translated_content = array(
                    'name'                  => \Input::get($lang . '_name'),
                    'short_description'     => \Input::get($lang . '_short_description'),
                    'long_description'      => \Input::get($lang . '_long_description')
                );

                // Check if lang exist
                $translated_model = $portfolio->translations->where('lang', $lang)->first();
                if ($translated_model == null) {
                    $translated_model = new Translation;
                }

                $translated_model->lang = $lang;
                $translated_model->content = json_encode($translated_content);

                $portfolio->translations()->save($translated_model);
            }

            if (\Input::hasFile('image')) {
                //Upload the file
                $helper_image = new RImage;
                $filename = $helper_image->upload($image, 'portfolios/' . $portfolio->id, true);

                if ($filename) {
                    // create photo
                    $newimage = new Image;
                    $newimage->path = $filename;

                    // save photo to the loaded model
                    $portfolio->images()->save($newimage);
                }
            }
        //if it validate
        } else {
            if (isset($sid)) {
                return redirect('admin/portfolios/edit/' . $sid)->withErrors($validation)->withInput();
            } else {
                return redirect('admin/portfolios/create')->withErrors($validation)->withInput();
            }
        }

        return redirect('admin/portfolios');
    }

    public function getDelete($sid)
    {
        // Find the portfolio using the user id
        $portfolio = Portfolio::find($sid);

        if ($portfolio == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('deleteError', "The data cannot be deleted at this time.");
            return redirect('/admin/portfolios')->withErrors($errors);
        }
        
        // Delete the portfolio
        $portfolio->delete();

        return redirect('admin/portfolios');
    }

    public function getImgremove($sid)
    {
        $image = Image::find($sid);

        if ($image == null) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('deleteError', "The image cannot be deleted at this time.");
            return redirect('/admin/portfolios')->withErrors($errors);
        }

        $portfolio_id = $image->imageable_id;

        $image->delete();

        return redirect('admin/portfolios/edit/' . $portfolio_id);
    }
}
