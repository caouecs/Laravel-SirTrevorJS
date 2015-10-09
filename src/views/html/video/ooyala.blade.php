@extends('sirtrevorjs::html.video.base')

@section('video')
  <script height="349px" width="620px" src="http://player.ooyala.com/iframe.js#pbid={!! $remote !!}"></script>
@stop
