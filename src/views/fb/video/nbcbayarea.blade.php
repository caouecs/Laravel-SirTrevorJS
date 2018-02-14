@extends('sirtrevorjs::html.video.base')

@section('video')
  <script type="text/javascript" charset="UTF-8" src="https://www.nbcbayarea.com/portableplayer/?cmsID={!! $remote !!}
    &amp;origin=nbcbayarea.com&amp;sec=news&amp;subsec=sports&amp;width=600&amp;height=360"></script>
@stop
