<?php

namespace DataArkadia\LaravelSettings\Nova\Resources;

use App\Models\Color;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Select;
use App\Nova\Resources\Resource;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Textarea;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Http\Requests\NovaRequest;
use DataArkadia\LaravelSettings\Enums\DataType;
use DataArkadia\LaravelSettings\Models\SettingValue;

class Setting extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \DataArkadia\LaravelSettings\Models\Setting::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'description',
    ];

    /**
     * The click action to use when clicking on the resource in the table.
     * Can be one of: 'detail' (default), 'edit', 'select', 'preview', or 'ignore'.
     *
     * @var string
     */
    public static $clickAction = 'edit';

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = [
        'setting_category',
        'setting_value',
    ];

    /**
     * The column by which this resource should
     * be ordered by and in which direction.
     *
     * @var array
     */
    public static $orderBy = ['id' => 'asc'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(),
            Text::make('Category', null, function () {
                    if ($this->resource->setting_category) {
                        return $this->resource->setting_category->name;
                    }

                    return '';
                })
                ->readonly(),
            Text::make('Name')
                ->readonly(),
            Text::make('Slug', function () {
                    return $this->setting_category->slug.'.'.$this->slug;
                })
                ->canSee(function () {
                    return config('app.env') == 'local';
                })
                ->copyable()
                ->readonly(),
            Text::make('Description')
                ->onlyOnDetail(),
            Textarea::make('Description')
                ->readonly()
                ->onlyOnForms()
                ->rows(3),

            $this->determineValueFieldOnIndex(),
            ...$this->determineValueFieldOnForms(),

            new Panel('Dev Fields', $this->fieldsForDevs()),
        ];
    }

    protected function determineValueFieldOnIndex()
    {
        $value = $this->resource->setting_value;

        if ($value AND strlen($value->value) == 0) {
            $value = null;
        }

        if ($value == null and $this->resource->required == true) {
            return Badge::make('Value', null, function () {
                    return 'REQUIRED';
                })
                ->map([
                    'REQUIRED' => 'danger',
                ])
                ->textAlign('left')
                ->onlyOnIndex();
        }

        switch ($this->resource->data_type) {
            case 'boolean':
                $field = Text::make('Value', null, function () {
                    if ($this->resource->setting_value) {
                        $value = $this->resource->setting_value->value;

                        if ((bool) $value) {
                            return 'Yes';
                        }

                        return 'No';
                    }

                    return '';
                });
                break;

            default:
                $field = Text::make('Value', null, function () {
                    if ($this->resource->setting_value) {
                        $value = $this->resource->setting_value->value;

                        if (strlen($value) > 50) {
                            $value = substr($value, 0, 47).'...';
                        }

                        return $value;
                    }

                    return '';
                });
                break;
        }

        return $field->exceptOnForms();
    }

    protected function determineValueFieldOnForms()
    {
        $fillUsing = function ($request, $model, $attribute, $requestAttribute) {
            $model->setting_value()
                ->firstOrCreate()
                ->update([
                    'value' => $request->input('setting_value_value'),
                ]);
        };

        switch ($this->resource->data_type) {
            case 'string':
                $fields = [Textarea::make('Value', 'setting_value.value')
                    ->onlyOnForms()
                    ->fillUsing($fillUsing)];
                break;

            case 'boolean':
                $fields = [Select::make('Value', 'setting_value.value')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])
                    ->displayUsingLabels()
                    ->onlyOnForms()
                    ->fillUsing($fillUsing)];
                break;

            case 'tw-color':
                $colors = Color::colors();
                $dependsOn = [];

                foreach ($colors as $colorName => $color) {
                    $dependsOn[] = $colorName;
                }

                foreach ($colors as $colorName => $palette) {
                    $palette = view('admin.colors')
                        ->with('role', $this->resource->slug)
                        ->with('colorName', $colorName)
                        ->with('palette', $palette)
                        ->render();

                    $dependsOnForThisField = array_diff($dependsOn, [$colorName]);

                    $fields[] = Text::make(ucfirst($colorName), 'colorValue[]')
                        ->dependsOn(
                            $dependsOnForThisField,
                            function (Text $field, NovaRequest $request, FormData $formData) {
                                $field->setValue('');
                            }
                        )
                        ->fillUsing(function ($request, $model, $attribute, $requestAttribute) use ($colors) {
                            $chosenColor = array_filter($request->input('colorValue'), 'strlen');

                            $chosenColorKey = key($chosenColor);
                            $chosenColorName = $colors->keys()->toArray()[$chosenColorKey];
                            $chosenColorValue = $chosenColor[$chosenColorKey];
                            $settingValue = sprintf('tw_%s_%s', $chosenColorName, $chosenColorValue);

                            if ($settingValue) {
                                $settingValueDBRecord = DB::table('setting_values')
                                    ->where('setting_id', $model->id)
                                    ->first();

                                if ($settingValueDBRecord) {
                                    DB::table('setting_values')
                                        ->where('setting_id', $model->id)
                                        ->update([
                                            'value' => $settingValue,
                                        ]);
                                } else {
                                    DB::table('setting_values')->insert([
                                        'setting_id' => $model->id,
                                        'value' => $settingValue,
                                    ]);
                                }

                                $settingValueModel = SettingValue::where('setting_id', $model->id)
                                    ->first();
                                $settingValueModel->storeInCache();
                            }
                        })
                        ->nullable()
                        ->onlyOnForms()
                        ->help($palette);
                }
                break;

            default:
                $fields = [];
                break;
        }

        return $fields;
    }

    protected function fieldsForDevs()
    {
        if (config('laravel-settings.nova.settingsShowAllFields') == false) {
            return [];
        }

        return [
            Select::make('Data type', 'data_type')
                ->readonly()
                ->options(DataType::forDropdown())
                ->resolveUsing(function ($active) {
                    $activeKey = DataType::tryFrom($active);

                    return $activeKey->name;
                }),
        ];
    }

    /**
     * Return the location to redirect the user after update.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \App\Nova\Resource $resource
     * @return string
     */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/' . static::uriKey();
    }
}
