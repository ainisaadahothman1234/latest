@props(['url'])
<tr>
<td class="header">
<!--<a href="{{ $url }}" style="display: inline-block;">-->
@if (trim($slot) === 'Laravel')
<!--<img src="{{ asset('images/logo.PNG') }}" class="logo" alt="KPJ Logo">-->
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
