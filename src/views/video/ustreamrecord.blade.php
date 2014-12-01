@extends('sirtrevorjs::video.base')

@section('video')
  <iframe width="640" height="392" src="http://www.ustream.tv/embed/recorded/{{ $remote }}?v=3&amp;wmode=direct"
    scrolling="no" frameborder="0" style="border: 0 none transparent"></iframe>
@stop
