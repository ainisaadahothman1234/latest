<!--This is the interface when call 'success' message-->
@if (session()-> has('success'))
<div x-data="{show: true}" x-int="setTimeout(()-> show = false,4000)" x-show="show" class="fixed bg-blue-500 text-white py-2 px-4 rounded-xl bottom-3 right-3 text-sm">
    <p>{{session('success')}}</p>
</div>
@endif

<!--This is the interface when call 'error' message-->
@if (session()-> has('error'))
<div x-data="{show: true}" x-int="setTimeout(()-> show = false,4000)" x-show="show" class="fixed bg-blue-500 text-white py-2 px-4 rounded-xl bottom-3 right-3 text-sm">
    <p>{{session('error')}}</p>
</div>
@endif
