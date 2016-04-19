@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe width="580" height="320" src="https://www.youtube.com/embed/{!! $remote !!}" frameborder="0" allowfullscreen>
  </iframe>
@stop
