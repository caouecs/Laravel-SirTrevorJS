@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe frameborder="0" width="580" height="320" src="https://www.dailymotion.com/embed/video/{!! $remote !!}"></iframe>
@stop
