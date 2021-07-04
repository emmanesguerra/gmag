<form id="submitForm" action="{{ env('PYNMCS_MERCH_ENDPOINT_PAYIN') }}" method="POST">
    <input type="hidden" name="paymentrequest" value="{{ $data['paymentrequest'] }}">
</form>

<script>
    document.forms["submitForm"].submit();
</script>