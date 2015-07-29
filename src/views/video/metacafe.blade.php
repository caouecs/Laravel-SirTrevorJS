@extends('sirtrevorjs::video.base')

@section('video')
  <iframe src="http://www.metacafe.com/embed/{!! $remote !!}/" width="540" height="304" allowFullScreen frameborder=0>
  </iframe>
@stop
