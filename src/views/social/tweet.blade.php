<blockquote class="twitter-tweet tw-align-center">
  <p>{{ $data['data']['text'] }}</p>
  &mdash; {{ $data['data']['user']['name'] }} (@{{ $data['data']['user']['screen_name'] }})
  <a href="{{ $data['data']['status_url'] }}" data-datetime="{{ $data['data']['created_at'] }}">
    {{ $data['data']['created_at'] }}
  </a>
</blockquote>
