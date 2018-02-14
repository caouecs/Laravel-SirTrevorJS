@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe src="https://embed.redtube.com/?id={!! $remote !!}&amp;bgcolor=000000" frameborder="0" width="434" height="344"
  scrolling="no"></iframe>
@stop
