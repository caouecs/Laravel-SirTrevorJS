@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe frameborder="0" width="640" height="360" src="https://api.dmcloud.net/player/embed/{!! $remote !!}?exported=1">
  </iframe>
@stop
