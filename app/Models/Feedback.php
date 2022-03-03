<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Contact
 * @package App\Models
 * @property string $subject
 * @property string $message
 */
class Feedback extends Model
{
    /**
     * @var string $table
     */
    public $table = 'contacts';

    protected $fillable = [
        'subject', 'message', 'user_id'
    ];

    /**
     * @param string $subject
     * @param string $message
     * @param integer $user_id
     * @return mixed
     */
    public static function newMessage($subject, $message, $user_id)
    {
        return static::create([
            'subject' => $subject,
            'message' => $message,
            'user_id' => $user_id
        ]);
    }

    /**
     * @return belongsToMany
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
