@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe src="https://globalnews.ca/video/embed/{!! $remote !!}/" width="670" height="437" frameborder="0" allowfullscreen></iframe>
@stop
