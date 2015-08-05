@extends('sirtrevorjs::video.base')

@section('video')
  <iframe width="580" height="320" src="//www.youtube.com/embed/{!! $remote !!}" frameborder="0" allowfullscreen>
  </iframe>
@stop
