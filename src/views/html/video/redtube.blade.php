@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe src="https://embed.redtube.com/?id={!! $remote !!}&amp;bgcolor=000000" width="434" height="344"
  title="{!! $title !!}"></iframe>
@stop
