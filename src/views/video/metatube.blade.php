@extends('sirtrevorjs::video.base')

@section('video')
  <iframe width="640" height="480" src="http://www.metatube.com/en/videos/{{ $remote }}/embed/" frameborder="0"
    allowfullscreen></iframe>
@stop
