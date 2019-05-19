<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSlug($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return void
     */
    private function setSlug(): void
    {
        if (empty($this->name)) {
            throw new \DomainException('Empty name');
        }
        $this->slug = Str::slug($this->name);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $category) {
            $category->setSlug();
        });

        static::updating(function (self $category) {
            $category->setSlug();
        });
    }
}
