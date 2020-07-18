@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe width="580" height="320" src="https://www.dailymotion.com/embed/video/{!! $remote !!}" title="{!! $title !!}"></iframe>
@stop
