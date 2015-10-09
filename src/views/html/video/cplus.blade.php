@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe width="640" height="360" frameborder="0" scrolling="no"
  src="http://player.canalplus.fr/embed/?param=cplus&amp;vid={!! $remote !!}"></iframe>
@stop
