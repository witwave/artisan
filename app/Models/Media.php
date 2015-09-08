<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\RHelper;

/* Columns
 *
 * id               (increment)
 * name             (string, 255)
 * path             (string, 320)
 * sku              (string, 255, unique, nullable)
 * short_description (string, 255)
 * long_description (text, nullable)
 * featured         (boolean, default false)
 * active           (boolean, default true)
 * options          (text, nullable)
 * mimetype         (string, 255, default 'application/pdf')
 * category_id      (integer, unsigned)
 * created_at       (dateTime)
 * updated_at       (dateTime)
 *
 */

class Media extends Model
{
    protected $table = 'medias';
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
    
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }
    
    public function translations()
    {
        return $this->morphMany('App\Models\Translation', 'translatable');
    }
    
    public function delete()
    {
        // Remove all relationships
        $this->tags()->detach();
        
        // Delete all images
        foreach ($this->images as $image) {
            $image->delete();
        }
        
        // Delete all translations
        $this->translations()->delete();
        
        // Delete asset images folder
        $upload_dir = \Config::get('image.upload_dir');
        $deleteFolder = new Image;
        $url_path = RHelper::joinPaths($upload_dir, $this->table, $this->id);
        $deleteFolder->deleteFiles($url_path);
        
        // Delete all media files folder
        $url_path = RHelper::joinPaths(public_path(), 'assets/medias', $this->category_id, $this->id);
        $deleteFolder->deleteFiles($url_path);
        
        return parent::delete();
    }
}
