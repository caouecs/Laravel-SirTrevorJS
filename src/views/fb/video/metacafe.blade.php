@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe src="https://www.metacafe.com/embed/{!! $remote !!}/" width="540" height="304" allowFullScreen frameborder=0>
  </iframe>
@stop
