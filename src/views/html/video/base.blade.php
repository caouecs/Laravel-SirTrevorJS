<figure class="st-movie">
  @yield('video')

@if (!empty($caption))
  <figcaption>{!! $caption !!}</figcaption>
@endif
</figure>
