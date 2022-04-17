@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe loading="lazy" src="https://video.nhl.com/videocenter/embed?playlist={!! $remote !!}" width="640" height="395" title="{!! $title !!}"></iframe>
@stop
