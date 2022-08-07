<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

function decodedRequest(array $data)
{
    array_walk($data, function (&$value, $key) {
        if ($value === '""') $value = null;
        else if (!Str::contains($key, ['image', 'photo', 'file', 'video', 'logo']) && !is_array($value)) $value = json_decode($value, true);
    });
    return $data;
}

function uploadFile(string $path, $file, $name = ""): string
{
    if (!File::exists(public_path($path))) {
        File::makeDirectory(public_path($path));
    }

    $file_name = ($name ?: md5(uniqid(rand(), true))) . '.' . $file->getClientOriginalExtension();
    $file->move(public_path($path), $file_name);
    return "$path/" . $file_name;
}

function deleteFile(?string $path = null)
{
    if ($path && file_exists(public_path($path))) {
        @unlink(public_path($path));
    }
}
