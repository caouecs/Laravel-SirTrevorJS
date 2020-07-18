@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe src="https://www.wat.tv/embedframe/{!! $remote !!}" style="width:640px;height: 360px" title="{!! $title !!}"></iframe>
@stop
