@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe class="vine-embed" src="https://vine.co/v/{!! $remote !!}/embed/simple" width="580" height="320" frameborder="0">
  </iframe>
@stop
