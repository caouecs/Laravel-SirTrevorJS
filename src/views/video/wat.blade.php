@extends('sirtrevorjs::video.base')

@section('video')
  <iframe src="http://www.wat.tv/embedframe/{{ $remote }}" frameborder="0" style="width:640px;height: 360px"></iframe>
@stop
