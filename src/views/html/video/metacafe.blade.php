@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe loading="lazy" src="https://www.metacafe.com/embed/{!! $remote !!}/" width="540" height="304" allowFullScreen title="{!! $title !!}">
  </iframe>
@stop
