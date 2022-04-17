@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe loading="lazy" width="640" height="392" src="https://www.ustream.tv/embed/recorded/{!! $remote !!}?v=3&amp;wmode=direct"
    style="border: 0 none transparent" title="{!! $title !!}"></iframe>
@stop
