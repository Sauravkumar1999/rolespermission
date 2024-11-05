@extends('errors::minimal')

@section('title', __('Not Found'))
@section('url', '404')
@section('code', '404')
@section('message', $exception->getMessage() != '' ? $exception->getMessage() : __('Not Found'))
