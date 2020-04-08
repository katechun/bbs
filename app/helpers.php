<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function category_nav_active($category_id){
    return active_class((if_route('categories.show') && if_route_param('category',$category_id)));
}


function make_excerpt($value,$length = 200){
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/',' ',strip_tags($value)));
    return Str::limit($excerpt,$length);
}


function model_admin_link($title,$model){
    return model_link($title,$model,'admin');
}


function model_link($title,$model,$prefix=''){
    //获取数据模型的复数蛇形名称
    $model_name = model_plural_name($model);

    //初始化前缀
    $prefix = $prefix ? "/$prefix/":'/';

    //使用站点URl凭借全量URL
    $url = config('app.url').$prefix.$model_name.'/'.$model->id;

    //拼接HTML A标签，并返回
    return '<a href="'.$url.'" target="_blank">'.$title.'</a>';
}

function model_plural_name($model){
    //从实体中获取完整类名称，例如：App\Models\User
    $full_class_name = get_class($model);

    //获取基础雷鸣，例如：传参 App\Models\User 会得到 User
    $class_name = class_basename($full_class_name);

    //蛇形命名，例如：传参 User 会得到 user，FooBar会得到foo_bar
    $snake_case_name = Str::snake($class_name);

    //获取子串的附属形式，例如：传参user会得到users
    return Str::plural($snake_case_name);

}




























