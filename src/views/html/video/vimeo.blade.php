@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe loading="lazy" src="https://player.vimeo.com/video/{!! $remote !!}?title=0&amp;byline=0" width="580" height="320"
    webkitallowfullscreen mozallowfullscreen allowfullscreen title="{!! $title !!}"></iframe>
@stop
