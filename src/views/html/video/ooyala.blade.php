@extends('sirtrevorjs::html.video.base')

@section('video')
  <script height="349px" width="620px" src="https://player.ooyala.com/iframe.js#pbid={!! $remote !!}"></script>
@stop
