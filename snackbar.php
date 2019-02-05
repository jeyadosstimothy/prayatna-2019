<div class="mdc-snackbar">
  <div class="mdc-snackbar__surface">
    <div class="mdc-snackbar__label" role="status" aria-live="polite">

    </div>
    <div class="mdc-snackbar__actions">
      <button class="mdc-icon-button mdc-snackbar__dismiss material-icons" title="Dismiss">close</button>
    </div>
  </div>
</div>
<script type="text/javascript">
  var snackbar = new mdc.snackbar.MDCSnackbar(document.querySelector('.mdc-snackbar'));
  function showSnackbar(text){
    snackbar.labelText = text;
    snackbar.open();
  }
</script>
