@extends("backend.layouts.app")

<?php
$defaults = [
        'name' => '',
        'unit_price' => '',
        'teaching_since' => '',
        'description' => '',
        'levels' => [],
        'labels' => [],
];
?>

@section("content")
    @include("backend.admins.teachers._form", compact('defaults'))
@endsection

@section("js")
    @include('backend.admins.teachers._formJs')
@endsection