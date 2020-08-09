@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe loading="lazy" width="575" height="324" src="https://cache.vevo.com/m/html/embed.html?video={!! $remote !!}"
    allowfullscreen title="{!! $title !!}"></iframe>
@stop
