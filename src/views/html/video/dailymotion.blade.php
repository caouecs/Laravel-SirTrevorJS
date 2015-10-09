@extends('sirtrevorjs::video.base')

@section('video')
  <iframe frameborder="0" width="580" height="320" src="//www.dailymotion.com/embed/video/{!! $remote !!}"></iframe>
@stop
