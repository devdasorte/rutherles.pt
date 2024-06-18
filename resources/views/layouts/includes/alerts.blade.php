<script>
    function show_toastr(title, message, type) {
        var o, i;
        var icon = "";
        var cls = "";
        var toster_pos = "right";
        if (type == "success") {
            icon = "fas fa-check-circle";
            cls = "success";
        } else if (type == "warning") {
            icon = "fas fa-check-circle";
            cls = "warning";
        } else if (type == "info") {
            icon = "fas fa-check-circle";
            cls = "info";
        } else {
            icon = "fas fa-times-circle";
            cls = "danger";
        }

        $.notify({
            icon: icon,
            title: " " + title,
            message: message,
            url: ""
        }, {
            element: "body",
            type: cls,
            allow_dismiss: !0,
            placement: {
                from: "top",
                align: toster_pos,
            },
            offset: {
                x: 15,
                y: 15
            },
            spacing: 10,
            z_index: 1080,
            delay: 2500,
            timer: 2000,
            url_target: "_blank",
            mouse_over: !1,
            animate: {
                enter: o,
                exit: i
            },
            template: '<div class="toast text-white bg-' +
                cls +
                ' fade show" role="alert" aria-live="assertive" aria-atomic="true">' +
                '<div class="d-flex">' +
                '<div class="toast-body"> ' +
                message +
                " </div>" +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                "</div>" +
                "</div>",
        });
    }
</script>
<script>
    @if (session('failed'))
        show_toastr('Falied!', '{{ session('failed') }}', 'failed');
    @endif
    @if ($errors = session('errors'))
        @if (is_object($errors))
            @foreach ($errors->all() as $error)
                show_toastr('Error!', '{{ $error }}', 'danger');
            @endforeach
        @else
            show_toastr('Error!', '{{ session('errors') }}', 'danger');
        @endif
    @endif
    @if (session('successful'))
        show_toastr('Successfully!', '{{ session('successful') }}', 'success');
    @endif
    @if (session('success'))
        show_toastr('Success!', '{{ session('success') }}', 'success');
    @endif
    @if (session('warning'))
        show_toastr('Warning!', '{{ session('warning') }}', 'warning');
    @endif
    @if (session('status'))
        show_toastr('Great!', '{{ session('status') }}', 'info');
    @endif
</script>
