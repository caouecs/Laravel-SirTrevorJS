@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe width="640" height="392" src="https://www.ustream.tv/embed/{!! $remote !!}?v=3&amp;wmode=direct"
    style="border: 0 none transparent" title="{!! $title !!}"></iframe>
@stop
