<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\RHelper;

/* Columns
 *
 * id           (increment)
 * title        (string, 255)
 * content      (text)
 * private      (boolean, default true)
 * created_at   (dateTime)
 * updated_at   (dateTime)
 *
 */

class Announcement extends Model
{
    protected $table = 'announcements';
    
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
    
    public static function validate($input)
    {
        $rules = array(
            'title' => 'required|regex:/^[a-z,0-9 ._\(\)-?]+$/i',
            'image'             => 'mimes:jpg,jpeg,png,gif|max:500',
            'content'           => 'required'
        );

        return \Validator::make($input, $rules);
    }
    
    public function delete()
    {
        // Delete all images
        foreach ($this->images as $image) {
            $image->delete();
        }
        
        // Delete assets images folder
        $upload_dir = \Config::get('image.upload_dir');
        $deleteFolder = new Image;
        $url_path = RHelper::joinPaths($upload_dir, $this->table, $this->id);
        $deleteFolder->deleteFiles($url_path);
        
        return parent::delete();
    }
}
