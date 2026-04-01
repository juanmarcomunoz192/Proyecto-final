@props([
    'icon' => session('swal.icon', 'info'),
    'title' => session('swal.title', 'Atención'),
    'text' => session('swal.text', session('swal', '')),
])

@if (session()->has('swal') || $attributes->has('trigger'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: "{{ $icon }}",
                title: "{{ $title }}",
                text: "{!! $text !!}",
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif
