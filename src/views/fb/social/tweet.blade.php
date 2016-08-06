<figure class="op-interactive">
  <iframe>
    <p>{!! $data['text'] !!}</p>
    &mdash; {!! $data['user']['name'] !!} (&#64;{!! $data['user']['screen_name'] !!})
    <a href="{!! $data['status_url'] !!}" data-datetime="{!! $data['created_at'] !!}">
      {!! $data['created_at'] !!}
    </a>
  </iframe>
</figure>
