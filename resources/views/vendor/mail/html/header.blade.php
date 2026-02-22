@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'SmartParking')
<img src="{{ asset('images/smart_icon.png') }}" class="logo" alt="SmartParking">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>