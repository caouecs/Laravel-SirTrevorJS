@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe width="640" height="360" allowfullscreen="true" src="https://screen.yahoo.com/embed/{!! $remote !!}.html" mozallowfullscreen="true" webkitallowfullscreen="true" title="{!! $title !!}">
  </iframe>
@stop
