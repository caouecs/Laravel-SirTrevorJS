@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe width="640" height="480" src="https://www.metatube.com/en/videos/{!! $remote !!}/embed/"
    allowfullscreen title="{!! $title !!}" title="{!! $title !!}"></iframe>
@stop
