@extends('sirtrevorjs::video.base')

@section('video')
  <iframe width="640" height="360" scrolling="no" frameborder="0" allowfullscreen="true" allowtransparency="true"
    src="http://screen.yahoo.com/embed/{!! $remote !!}.html" mozallowfullscreen="true" webkitallowfullscreen="true" >
  </iframe>
@stop
