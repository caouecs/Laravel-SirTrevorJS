@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe loading="lazy" width="640" height="360" title="{!! $title !!}"
  src="https://player.canalplus.fr/embed/?param=cplus&amp;vid={!! $remote !!}"></iframe>
@stop
