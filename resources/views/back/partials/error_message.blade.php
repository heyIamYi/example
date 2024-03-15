 {{-- 錯誤提示 --}}
 @if (session()->has('success'))
 <script>
     alert('{{ session()->get('message') }}');
     window.location.href = '/WebAdmin/list/{{ session()->get('path') }}';
 </script>
@endif

@if (session('message'))
 <script nonce="{{ $cspNonce ?? '' }}">
     let errorMessage = @json(session('message'));
     alert(errorMessage);
 </script>
@endif

@if ($errors->any())
 <script nonce="{{ $cspNonce ?? '' }}">
     let validationError = @json($errors->first());
     alert(validationError);
 </script>
@endif
