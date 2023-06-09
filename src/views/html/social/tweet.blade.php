<blockquote class="twitter-tweet tw-align-center" data-lang="fr">
@if (! empty($data['text']))
  <p lang="en" dir="ltr">{!! $data['text'] !!}</p>
  &mdash; {!! $data['user']['name'] !!} (&#64;{!! $data['user']['screen_name'] !!})
@endif
  <a href="{!! $data['status_url'] !!}" data-datetime="{!! $data['created_at'] ?? '' !!}">
    {!! $data['created_at'] ?? '' !!}
  </a>
</blockquote>
