<?php


namespace App\Traits\ComposedValueType;


trait IsComposedValueType
{
    use ComposedValueTypeTrait;

    public static function bootIsComposedValueType()
    {
        static::saved(function ($model) {
            $model->createOrUpdateValueType();
        });
    }
}
