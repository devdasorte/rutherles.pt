<form id="paymentForm" action="{{ $payuUrl }}" method="post">
    @foreach ($paymentData as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach
</form>

<script>
    document.getElementById("paymentForm").submit();
</script>
