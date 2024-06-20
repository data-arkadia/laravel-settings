<?php

namespace DataArkadia\LaravelSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DataArkadia\LaravelSettings\Events\SluggableSaving;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'for_settingable',
        'name',
        'slug',
        'description',
        'data_type',
        'required',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saving' => SluggableSaving::class,
    ];

    /**
     * Define an inverse one-to-many
     * relationship to a SettingCategory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting_category(): BelongsTo
    {
        return $this->belongsTo(SettingCategory::class);
    }

    /**
     * One-to-one relationship with SettingValue
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function setting_value(): HasOne
    {
        return $this->hasOne(SettingValue::class);
    }
}
