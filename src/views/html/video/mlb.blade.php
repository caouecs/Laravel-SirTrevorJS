@extends('sirtrevorjs::html.video.base')

@section('video')
  <?php
  $remote = explode('-', $remote);
  ?>

  <iframe loading="lazy" src='https://m.mlb.com/shared/video/embed/embed.html?content_id={!! $remote[0] !!}&amp;topic_id={!! $remote[1] !!}&amp;width=640&amp;height=300&amp;property=mlb' width='640' height='300'>Your browser does not support iframes.</iframe>
@stop
