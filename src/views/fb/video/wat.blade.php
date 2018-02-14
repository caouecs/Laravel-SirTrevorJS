@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe src="https://www.wat.tv/embedframe/{!! $remote !!}" frameborder="0" style="width:640px;height: 360px"></iframe>
@stop
