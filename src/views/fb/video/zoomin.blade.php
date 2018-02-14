@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe src="https://blackbird.zoomin.tv/players/.pla?pid=corporatefr&amp;id={!! $remote !!}&amp;w=655&amp;h=433"
    style="width:655px; height:433px; border:none; overflow:hidden;" frameborder="0" scrolling="no"
    allowtransparency="yes"></iframe>
@stop
