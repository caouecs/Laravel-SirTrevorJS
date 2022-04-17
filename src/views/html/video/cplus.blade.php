@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe loading="lazy" width="640" height="360"
  src="https://player.canalplus.fr/embed/?param=cplus&amp;vid={!! $remote !!}" title="{!! $title !!}"></iframe>
@stop
