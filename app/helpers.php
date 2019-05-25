<?php


if (! function_exists('active')) {

    function active($route)
    {   
        return request()->fullUrlIs($route)?'active':'';
    }
}