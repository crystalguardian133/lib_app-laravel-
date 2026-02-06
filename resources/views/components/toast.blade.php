{{-- Toast Notification Component --}}
{{-- Include this component in your layout or view to enable toast notifications --}}

{{-- Toast Container (required) --}}
<div id="toast-container" class="toast-container"></div>

{{-- Toast CSS (include in head or before closing body) --}}
<link rel="stylesheet" href="{{ asset('css/toast.css') }}">

{{-- Toast JavaScript (include before closing body) --}}
<script src="{{ asset('js/toast.js') }}"></script>

{{-- Show session flash toast if exists --}}
@if(session('toast_type') && session('toast_message'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('reload_after'))
        // Show toast and reload after specified time
        if (typeof toast !== 'undefined') {
            toast.show({
                title: '{{ session('toast_title', 'Notice') }}',
                message: '{{ session('toast_message') }}',
                type: '{{ session('toast_type', 'info') }}',
                duration: {{ session('toast_duration', 3000) }},
                reloadAfter: {{ session('reload_after', session('toast_duration', 3000)) }}
            });
        } else {
            setTimeout(function() {
                window.location.reload();
            }, {{ session('reload_after', session('toast_duration', 3000)) }});
        }
    @else
        // Show toast without reload
        if (typeof toast !== 'undefined') {
            toast.show({
                title: '{{ session('toast_title', 'Notice') }}',
                message: '{{ session('toast_message') }}',
                type: '{{ session('toast_type', 'info') }}',
                duration: {{ session('toast_duration', 4000) }}
            });
        }
    @endif
});
</script>
@endif
