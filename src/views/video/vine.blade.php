@extends('sirtrevorjs::video.base')

@section('video')
  <iframe class="vine-embed" src="//vine.co/v/{{ $remote }}/embed/simple" width="580" height="320" frameborder="0">
  </iframe>
@stop
