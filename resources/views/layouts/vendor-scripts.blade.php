<script>
window.userPermissions = @json(session('userContext')['permissoes'] ?? []);
</script>

<!-- LIBS -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ asset('assets/libs/node-waves/node-waves.min.js')}}"></script>
<script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-mask/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Sistema -->
<script src="{{ asset('assets/js/masks.js') }}"></script>
<script src="{{ asset('assets/js/functions.js')}}"></script>
<script src="{{ asset('assets/js/cruds_functions.js')}}"></script>
<script src="{{ asset('assets/js/cruds.js')}}"></script>

@yield('script')

@yield('script-bottom')

<script src="{{ asset('assets/js/skote.min.js')}}"></script>
