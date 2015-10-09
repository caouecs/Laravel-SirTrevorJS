@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe src="http://video.nhl.com/videocenter/embed?playlist={!! $remote !!}" frameborder="0" width="640" height="395"></iframe>
@stop
