@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe loading="lazy" src="https://globalnews.ca/video/embed/{!! $remote !!}/" width="670" height="437" allowfullscreen></iframe>
@stop
