<?php
namespace App\Models;

/**
 * App\Models\Country.
 *
 * @property int $id
 * @property string $title
 * @property string $level
 * @property string $content
 * @property string $file_id
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\File $file
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country wherelevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereFileId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TextBook whereLevel($value)
 */
class TextBook extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'text_books';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'level',
        'file_id',
        'content',
        'order',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\TextBookPresenter::class;

    // Relations
    public function file()
    {
        return $this->belongsTo(\App\Models\File::class, 'file_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'level'   => $this->level,
            'file_id' => $this->file_id,
            'content' => $this->content,
            'order'   => $this->order,
        ];
    }
}
